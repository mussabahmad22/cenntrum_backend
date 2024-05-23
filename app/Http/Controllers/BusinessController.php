<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Point;
use App\Models\Register;
use App\Models\Coin_pkg;
use App\Models\Incentive;
use App\Models\Business;
use App\Models\Subscription;
use App\Models\Buy_incentive;
use App\Models\Setting;
use App\Models\GiftCard;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Session;

class BusinessController extends Controller
{
    public function login(Request $request)
    {
        // dd('okay login');
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            Session::flash('error', $message);
            return redirect('login');
        } else {
            $user = Business::where('username', $request->email)->orWhere('email', $request->email)->where('password', $request->password)->first();

            if ($user) {
                Session::flash('login_message', 'Login Successfully!');
                Session::put('business_id', $user->id);
                Session::put('name', $user->name);
                Session::put('login', 'success');

                return redirect('dashboard');
            } else {
                Session::flash('error', 'Wrong Credentials!');
                return redirect('login');
                return redirect('login');
            }
        }
    }


    public function dashboard()
    {
        $bid = Session::get('business_id');
        $data['cards'] = Incentive::where('business_id', $bid)->where('type', 1)->count();

        $data['sold'] = GiftCard::where('business_id', $bid)
            ->join('incentives', 'incentives.id', 'gift_cards.inc_id')
            ->where('incentives.business_id', $bid)
            ->where('gift_cards.used', 0)
            ->count();
        $data['redeemed'] = GiftCard::where('business_id', $bid)
            ->join('incentives', 'incentives.id', 'gift_cards.inc_id')
            ->where('incentives.business_id', $bid)
            ->where('gift_cards.used', 1)
            ->count();
        $data['total'] = Incentive::where('business_id', $bid)->where('type', 1)->sum('quantity') - $data['sold'] - $data['redeemed'];
        return view('dashboard', compact('data'));
    }

    public function used(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'incentive_id' => 'required'

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {
            $id = $request->incentive_id;
            $pkg = GiftCard::find($id);
            $pkg->used = 1;
            $pkg->redeemed_date = date('Y-m-d h:m:i');
            $pkg->save();

            $list = $pkg;
            $status = true;
            $message = "Incentive Updated";
            $data = $list;
            return redirect('giftcards/' . $pkg->inc_id);
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return redirect('giftcards');
        # code...
    }
    public function redeem(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required'

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            Session::flash('error', $message);
        } else {
            $id = $request->code;
            $bid = Session::get('business_id');
            $pkg = GiftCard::where('giftcode', $id)->where('used', 0)->first();
            if ($pkg) {
                $pkg->used = 1;
                $pkg->redeemed_date = date('d-m-Y h:m:i');

                $pkg->save();
                Session::flash('update_message', 'success');
            } else {
                $message = GiftCard::where('giftcode', $id)->where('used', 1)->first();

                if ($message) {

                    Session::flash('error', 'This giftcard code has been redeemed!');
                } else {

                    Session::flash('error', 'Redeem Code is Invalid!');
                }
            }
        }

        return redirect('giftcards');
        # code...
    }




    public function business_list(Request $request)
    {
        $bid = Session::get('business_id');
        $business = Business::find($bid);
        $data = Incentive::where('type', 1)->where('business_id', $bid)->get();
        $status = true;
        $data = Incentive::select('incentives.*', 'users.firstname', 'users.lastname', 'buy_incentives.incent_id')->where('business_id', $bid)
            ->leftJoin('buy_incentives', 'buy_incentives.incent_id', 'incentives.id')
            ->leftJoin('users', 'buy_incentives.user_id', 'users.id')
            ->where('type', '1')->get();
        $data = Incentive::where('business_id', $bid)->where('type', 1)->get();
        foreach ($data as $dd) {
            $dd->used = GiftCard::where('inc_id', $dd->id)->count();
        }
        //  return $data;
        $message = "Incentive List";
        return view('users', compact('data', 'business'));
    }

    public function giftcards_list($id)
    {

        $card = Incentive::find($id);

        $data = GiftCard::select('gift_cards.*', 'users.firstname', 'users.lastname')
            ->where('inc_id', $id)
            ->leftJoin('users', 'gift_cards.user_id', 'users.id')
            ->get();

        //  return $data;
        $message = "Incentive List";
        return view('giftcards', compact('data', 'card'));
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }





    public function send_mail(Request $request)
    {
        //         Mail::send(['text'=>'mail'], $data, function($message) {
        //      $message->to($request->email)->subject
        //         ($request->subject);
        //      $message->from('no-reply@cenntrum.codecoyapps.com','cenntrum');
        //   });
        $str['status'] = true;
        $str['message'] = 'Mail Sent Successfully';
        $str['data'] = $request->all();
        return $str;
    }
}
