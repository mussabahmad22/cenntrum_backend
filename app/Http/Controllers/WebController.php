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
use Illuminate\Support\Facades\DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class WebController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|exists:registers,email',
            'password' => 'required|min:6'

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {
            $user = Register::where('email', $request->email)->where('password', $request->password)->first();
            if ($user) {
                $status = true;
                $message = "Admin Login";

                $str['data'] = $user;
            } else {
                $status = false;
                $message = "Invalid Password";
                $data = [];
            }
        }

        $str['status'] = $status;
        $str['message'] = $message;
        if ($status) {
            return $str;
        } else {
            return response($str, 404);
        }

        # code...
    }
    public function update_profile(Request $request)
    {



        $user = Register::find(1);
        if ($request->username) {
            $user->username = $request->username;
        }
        if ($request->password) {
            $user->password = $request->password;
        }
        if ($request->dob) {
            $user->dob = $request->dob;
        }
        if ($request->pic) {
            $user->pic = $request->pic;
        }
        if ($request->gender) {
            $user->gender = $request->gender;
        }
        if ($request->phone) {
            $user->phone = $request->phone;
        }
        $user->save();

        $status = true;
        $message = "Successfully Updated";
        $data = $user;




        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...   
    }
    public function update_app(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'default_time' => 'required',
            'default_coins' => 'required',




        ]);
        if ($validator->fails() && false) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {

            $user = Setting::find(1);
            if (isset($request->default_time)) {
                $user->default_time = $request->default_time;
            }
            if (isset($request->default_coins)) {
                $user->default_coins = $request->default_coins;
            }
            if (isset($request->earning_point_driving)) {
                $user->earning_point_driving = $request->earning_point_driving;
            }
            if (isset($request->earning_poin_time)) {
                $user->earning_poin_time = $request->earning_poin_time;
            }
            if (isset($request->business_radius)) {
                $user->business_radius = $request->business_radius;
            }
            $user->save();

            $status = true;
            $message = "Successfully Updated";
            $data = $user;
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...   
    }
    public function get_app(Request $request)
    {

        $user = Setting::find(1);


        $status = true;
        $message = "Successfully Updated";
        $data = $user;


        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...   
    }

    public function users_list(Request $request)
    {

        $data = User::all();

        $str['status'] = true;
        $str['message'] = 'Users List';
        $str['data'] = $data;
        return $str;
    }
    public function delete_user($id)
    {
        if ($id) {

            $user = User::find($id);
            if ($user) {
                $user->delete();

                $str['status'] = true;
                $str['message'] = 'User Deleted Successfully!';

                return $str;
            }
        }


        $str['status'] = false;
        $str['message'] = 'Id not found!';

        return $str;
    }

    public function add_coins_pkg(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:coin_pkgs,title',
            'price' => 'required'

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {


            $pkg = new Coin_pkg;
            $pkg->title = $request->title;
            $pkg->price = $request->price;
            $pkg->coins = $request->coins;
            $pkg->color = $request->color;
            $pkg->save();

            $list = $pkg;
            $status = true;
            $message = "Coins Package Added";
            $data = $list;
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...
    }

    public function update_coins_pkg(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required'

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {


            $pkg = Coin_pkg::find($id);
            $pkg->title = $request->title;

            $pkg->coins = $request->coins;

            $pkg->save();

            $list = $pkg;
            $status = true;
            $message = "Coins Package Added";
            $data = $list;
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...
    }

    public function coins_pkg_list(Request $request)
    {


        $list = Coin_pkg::all();
        $status = true;
        $message = "Coins Package List";
        $data = $list;
        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }
    public function delete_coins_pkg($id)
    {

        if ($id) {
            $pkg = Coin_pkg::find($id);
            if ($pkg) {
                $pkg->delete();

                $status = true;
                $message = "Coins Package Deleted";

                $str['status'] = $status;
                $str['message'] = $message;

                return $str;
            }
        }

        $str['status'] = false;
        $str['message'] = "Id not found";

        return $str;
    }

    public function add_subs_pkg(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:subscriptions,title',
            'price' => 'required'

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {


            $pkg = new Subscription;
            $pkg->title = $request->title;
            $pkg->price = $request->price;
            $pkg->points = $request->points;
            $pkg->color = $request->color;
            $pkg->save();

            $list = $pkg;
            $status = true;
            $message = "Subscription Package Added";
            $data = $list;
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...
    }

    public function update_subs_pkg(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required'


        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {


            $pkg = Subscription::find($id);
            $pkg->title = $request->title;

            $pkg->points = $request->points;

            $pkg->save();

            $list = $pkg;
            $status = true;
            $message = "Subscription Package Added";
            $data = $list;
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...
    }

    public function subs_pkg_list(Request $request)
    {


        $list = Subscription::all();
        $status = true;
        $message = "Subscription Package List";
        $data = $list;

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }
    public function delete_subs_pkg($id)
    {

        if ($id) {
            $pkg = Subscription::find($id);
            if ($pkg) {
                $pkg->delete();

                $status = true;
                $message = "Subscription Package Deleted";

                $str['status'] = $status;
                $str['message'] = $message;

                return $str;
            }
        }

        $str['status'] = false;
        $str['message'] = "Id not found";

        return $str;
    }

    //insentive module

    public function add_insentive(Request $request)
    {

        if ($request->file('img') == null) {
            $image_name = "";
        } else {
            $path_title = $request->file('img')->store('public/images');

            $image_name = basename($path_title);
        }

        if ($request->file('code_img') == null) {
            $image_code = "";
        } else {
            $path_title = $request->file('code_img')->store('public/images');

            $image_code = basename($path_title);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'value' => 'required',
            // 'quantity' => 'required',


        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {

            // return response(['error' => true, 'error-msg' =>$request->all()], 404);
            $pkg = new Incentive;
            $pkg->name = $request->name;
            $pkg->value = $request->value;
            $pkg->gift_value = $request->gift_value;
            $pkg->quantity = $request->quantity;
            $pkg->tot_quantity = $request->quantity;
            $pkg->req_point = $request->req_point;
            $pkg->expiry_date = $request->expiry_date;
            $pkg->img = "images/" .  $image_name;
            $pkg->code_img = "images/" .  $image_code;
            $pkg->single_code = $request->single_code;


            // $pkg->img = $request->img;


            if (!isset($request->type)) {
                $type = 1;
            } else {

                $type = $request->type;
            }
            $pkg->type = $type;

            if ($type == 1) {
                $pkg->cardcode = $request->cardcode;
                if ($request->business_id) {
                    $pkg->business_id = $request->business_id;
                } else {
                    $b = Business::first();
                    $pkg->business_id = $b->id;
                }
            } else {

                $pkg->lat = $request->laat;
                $pkg->lng = $request->lang;
                $pkg->radius = $request->radius;
            }
            if (isset($request->description)) {
                $pkg->description = $request->description;
            } else {
                $pkg->description = "";
            }
            $pkg->save();

            $list = $pkg;
            $status = true;
            $message = "Incentive Added";
            $data = $list;
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...
    }

    public function add_business(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'laat' => 'required',
            'lang' => 'required'


        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {
            $pkg = new Business;
            $pkg->name = $request->name;
            $pkg->phone = $request->phone;
            $pkg->description = $request->description;
            $pkg->email = $request->email;
            $pkg->username = $request->username;
            $pkg->password = $request->password;
            $pkg->laat = $request->laat;
            $pkg->lang = $request->lang;
            $pkg->status = $request->status;
            $pkg->save();

            $list = $pkg;
            $status = true;
            $message = "Business Added";
            $data = $list;
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...
    }

    // public function update_business(Request $request, $id)
    // {


    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'username' => 'required',
    //         'password' => 'required'

    //     ]);
    //     if ($validator->fails()) {
    //         $message = $validator->errors()->first();
    //         $status = false;
    //         $data = [];
    //     } else {
    //         $pkg = Business::find($id);
    //         $pkg->name = $request->name;
    //         $pkg->phone = $request->phone;
    //         $pkg->description = $request->description;
    //         $pkg->email = $request->email;
    //         $pkg->username = $request->username;
    //         $pkg->password = $request->password;

    //         $pkg->save();

    //         $list = $pkg;
    //         $status = true;
    //         $message = "Business Updated";
    //         $data = $list;
    //     }



    //     $str['status'] = $status;
    //     $str['message'] = $message;
    //     $str['data'] = $data;
    //     return $str;
    //     # code...
    // }

    public function update_business_new(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'business_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'description' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'laat' => 'required',
            'lang' => 'required'

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {
            $pkg = Business::find($request->business_id);
            $pkg->name = $request->name;
            $pkg->phone = $request->phone;
            $pkg->description = $request->description;
            $pkg->email = $request->email;
            $pkg->username = $request->username;
            $pkg->password = $request->password;
            $pkg->laat = $request->laat;
            $pkg->lang = $request->lang;
            $pkg->status = $request->status;


            $pkg->save();

            $list = $pkg;
            $status = true;
            $message = "Business Updated";
            $data = $list;
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...
    }

    public function update_insentive(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'value' => 'required',
            // 'quantity' => 'required'

        ]);
        if ($validator->fails()) {

            $message = $validator->errors()->first();
            $status = false;
            $data = [];
        } else {


            $pkg = Incentive::find($id);

            if ($request->hasFile('img')) {

                $path_title = $request->file('img')->store('public/images');

                $image_name = "images/" .  basename($path_title);
            } else {

                $image_name = $pkg->img;
            }

            if ($request->hasFile('code_img')) {

                $path_title = $request->file('code_img')->store('public/images');

                $image_code = "images/" .  basename($path_title);
            } else {

                $image_code = $pkg->code_img;
            }

            $pkg->name = $request->name;
            $pkg->value = $request->value;
            $pkg->quantity = $request->quantity;
            $pkg->req_point = $request->req_point;
            $pkg->img =  $image_name;
            $pkg->code_img = $image_code;

            $pkg->lat = $request->laat;
            $pkg->lng = $request->lang;
            $pkg->radius = $request->radius;
            $pkg->single_code = $request->single_code;

            $pkg->save();

            $list = $pkg;
            $status = true;
            $message = "Incentive Updated";
            $data = $list;
        }



        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...
    }

    public function insentive_list(Request $request)
    {


        $list = Incentive::all();
        $default_radius = Setting::select('business_radius')->first();
        $status = true;
        $message = "Incentive List";
        $data = $list;

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        $str['default_radius'] = $default_radius;

        return $str;
    }

    public function business_detail($id)
    {


        $list = Incentive::select('incentives.*')->where('business_id', $id)->where('type', '1')->get();
        $data = Incentive::where('type', 1)->where('business_id', $id)->get();
        $status = true;
        $data = Incentive::select('incentives.*', 'users.firstname', 'users.lastname', 'buy_incentives.incent_id')->where('business_id', $id)
            ->leftJoin('buy_incentives', 'buy_incentives.incent_id', 'incentives.id')
            ->leftJoin('users', 'buy_incentives.user_id', 'users.id')
            ->where('type', '1')->get();
        $data = Incentive::where('business_id', $id)->where('type', 1)->get();
        foreach ($data as $dd) {
            $dd->used = $dd->quantity - GiftCard::where('inc_id', $dd->id)->count();
            $dd->dateTime = $dd->created_at->format('Y-m-d h:m:i');
        }
        $status = true;
        $message = "Incentive List";

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }

    public function business_list(Request $request)
    {


        $list = Business::all();
        $status = true;
        $message = "Business List";
        $data = $list;

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }

    public function delete_insentive($id)
    {

        if ($id) {
            $pkg = Incentive::find($id);
            if ($pkg) {

                $gift_cards = GiftCard::where('inc_id', $id)->get();

                if ($gift_cards) {

                    foreach ($gift_cards as $post) {
                        $post->delete();
                    }
                }

                $buy_incentive = Buy_incentive::where('incent_id', $id)->get();
                if ($buy_incentive) {
                    foreach ($buy_incentive as $post) {
                        $post->delete();
                    }
                }

                $pkg->delete();

                $status = true;
                $message = "Incentive Deleted";

                $str['status'] = $status;
                $str['message'] = $message;

                return $str;
            }
        }

        $str['status'] = false;
        $str['message'] = "Id not found";
        return $str;
    }

    public function delete_business($id)
    {

        if ($id) {
            $pkg = Business::find($id);
            if ($pkg) {
                $pkg->delete();

                $status = true;
                $message = "Business Deleted";

                $str['status'] = $status;
                $str['message'] = $message;

                return $str;
            }
        }

        $str['status'] = false;
        $str['message'] = "Id not found";

        return $str;
    }

    public function earn_points(Request $request)
    {


        $user_points = Point::join('users', 'points.user_id', 'users.id')->select('users.email', 'points.*')->orderBy('start_time', 'desc');
        if ($request->from != "") {
            $from = strtotime($request->from);
            $user_points->where('start_time', '>', $from);
        }
        if ($request->to != "") {
            $to = strtotime($request->to);
            $user_points->where('end_time', '<', $to);
        }
        $points = $user_points;

        $status = true;
        $message = 'Points List';

        $data = $user_points->get();

        if (count($data) == 0) {
            $str['status'] = false;
            $str['message'] = 'no points found';
            $str['from'] = $request->from;
            $str['to'] = $request->to;
            $str['data'] = [];

            return $str;
        } else {
            $str['status'] = $status;
            $str['message'] = $message;

            $str['data'] = $data;
            return $str;
        }
    }

    public function filter_earn_points(Request $request)
    {

        $request->validate([
            'from' => 'required',
            'to' => 'required',
        ]);




        $startTimestamp = $request->from; // Start timestamp in milliseconds
        $endTimestamp = $request->to; // End timestamp in milliseconds

        $startDate = date('Y-m-d H:i:s', $startTimestamp / 1000); // Convert start timestamp to a readable date and time
        $endDate = date('Y-m-d H:i:s', $endTimestamp / 1000); // Convert end timestamp to a readable date and time




        $user_points = Point::join('users', 'points.user_id', 'users.id')->select('users.email', 'points.*')->whereBetween('points.created_at', [$startDate, $endDate])->orderBy('start_time', 'desc')->get();


        $status = true;
        $message = "Filter Earned points";

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $user_points;
        return $str;
    }

    public function exchange_points(Request $request)
    {

        $request->validate([
            'type' => 'required',
        ]);


        // $list = Buy_incentive::join('users', 'buy_incentives.user_id', 'users.id')->join('incentives', 'incentives.id', 'buy_incentives.incent_id')->join('wallets', 'buy_incentives.incent_id', 'wallets.inc_id' && 'wallets', 'buy_incentives.user_id', 'wallets.user_id')->select('users.email', 'buy_incentives.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'wallets.address')->where('incentives.type', $request->type)->get();

        if ($request->type == 2) {


            $list = Buy_incentive::join('users', 'buy_incentives.user_id', '=', 'users.id')
                ->join('incentives', 'incentives.id', '=', 'buy_incentives.incent_id')
                ->join('wallets', function ($join) {
                    $join->on('buy_incentives.incent_id', '=', 'wallets.inc_id')
                        ->on('buy_incentives.user_id', '=', 'wallets.user_id');
                })
                ->select('users.email', 'buy_incentives.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'wallets.address')
                // ->where('incentives.type', $request->type)
                ->get();

            $status = true;
            $message = "Crpto Rewards List";

            $str['status'] = $status;
            $str['message'] = $message;
            $str['data'] = $list;
            return $str;
        } else {


            $list = GiftCard::join('users', 'gift_cards.user_id', '=', 'users.id')
                ->join('incentives', 'incentives.id', '=', 'gift_cards.inc_id')
                ->join('businesses', 'incentives.business_id', '=', 'businesses.id')
                ->select('users.email', 'gift_cards.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'businesses.name')
                // ->where('incentives.type', $request->type)
                ->get();

            $status = true;
            $message = "Gift Card Reward List";

            $str['status'] = $status;
            $str['message'] = $message;
            $str['data'] = $list;
            return $str;
        }
    }


    public function filter_exchange_points(Request $request)
    {

        $request->validate([
            'type' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);



        if ($request->type == 2) {

            $startTimestamp = $request->from; // Start timestamp in milliseconds
            $endTimestamp = $request->to; // End timestamp in milliseconds

            $startDate = date('Y-m-d H:i:s', $startTimestamp / 1000); // Convert start timestamp to a readable date and time
            $endDate = date('Y-m-d H:i:s', $endTimestamp / 1000); // Convert end timestamp to a readable date and time

            // $filteredRecords = DB::table('your_table')
            //     ->whereBetween('created_at', [$startDate, $endDate])
            //     ->get();


            $list = Buy_incentive::join('users', 'buy_incentives.user_id', '=', 'users.id')
                ->join('incentives', 'incentives.id', '=', 'buy_incentives.incent_id')
                ->join('wallets', function ($join) {
                    $join->on('buy_incentives.incent_id', '=', 'wallets.inc_id')
                        ->on('buy_incentives.user_id', '=', 'wallets.user_id');
                })
                ->select('users.email', 'buy_incentives.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'wallets.address')
                ->whereBetween('buy_incentives.created_at', [$startDate, $endDate])
                ->orWhereDate('buy_incentives.created_at', $startDate)
                ->get();

            $status = true;
            $message = "Crpto Rewards List";

            $str['status'] = $status;
            $str['message'] = $message;
            $str['data'] = $list;
            return $str;
        } else {

            $startTimestamp = $request->from; // Start timestamp in milliseconds
            $endTimestamp = $request->to; // End timestamp in milliseconds

            $startDate = date('Y-m-d H:i:s', $startTimestamp / 1000); // Convert start timestamp to a readable date and time
            $endDate = date('Y-m-d H:i:s', $endTimestamp / 1000); // Convert end timestamp to a readable date and time

            $list = GiftCard::join('users', 'gift_cards.user_id', '=', 'users.id')
                ->join('incentives', 'incentives.id', '=', 'gift_cards.inc_id')
                ->join('businesses', 'incentives.business_id', '=', 'businesses.id')
                ->select('users.email', 'gift_cards.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'businesses.name')
                ->whereBetween('gift_cards.created_at', [$startDate, $endDate])
                ->orWhereDate('buy_incentives.created_at', $startDate)
                ->get();

            $status = true;
            $message = "Gift Card Reward List";

            $str['status'] = $status;
            $str['message'] = $message;
            $str['data'] = $list;
            return $str;
        }
    }

    public function send_mail(Request $request)
    {

        $request->validate([
            'exchange_id' => 'required',
        ]);

        // dd($request);

        // $data = array('name'=>"Cenntrum Data");
        //         Mail::send(['text'=>'send_cryptomail'], $request->all(), function($message) {
        //      $message->to('mussabahmad1@gmail.com')->subject
        //         ('My Subject Email');
        //      $message->from('no-reply@cenntrum.codecoyapps.com','cenntrum');
        //   });
        // $str['status'] = true;
        // $str['message'] = 'Mail Sent Successfully';
        // return $str;

        $exchng = Buy_incentive::find($request->exchange_id);
        $exchng->buying_status = 1;
        $exchng->save();

        $data = $request->all();

        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'cenntrum.codecoyapps.com ';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@cenntrum.codecoyapps.com';   //  sender username
            $mail->Password = 'User@432100';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom('no-reply@cenntrum.codecoyapps.com', 'Cenntrum');
            $mail->addAddress($request->email);

            // $mail->addCC($request->emailCc);
            // $mail->addBCC($request->emailBcc);

            // $mail->addReplyTo('sender@example.com', 'SenderReplyName');




            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = 'Send Crypto';

            $mail->Body    = view('send_cryptomail', compact('data'))->render();

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                return false;
            } else {
                $str['status'] = true;
                $str['message'] = 'Mail Sent Successfully';
                return $str;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function exchange_points_user(Request $request)
    {

        $request->validate([
            'type' => 'required',
            'user_id' => 'required',

        ]);


        // $list = Buy_incentive::join('users', 'buy_incentives.user_id', 'users.id')->join('incentives', 'incentives.id', 'buy_incentives.incent_id')->join('wallets', 'buy_incentives.incent_id', 'wallets.inc_id' && 'wallets', 'buy_incentives.user_id', 'wallets.user_id')->select('users.email', 'buy_incentives.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'wallets.address')->where('incentives.type', $request->type)->get();

        if ($request->type == 2) {


            $list = Buy_incentive::join('users', 'buy_incentives.user_id', '=', 'users.id')
                ->join('incentives', 'incentives.id', '=', 'buy_incentives.incent_id')
                ->join('wallets', function ($join) {
                    $join->on('buy_incentives.incent_id', '=', 'wallets.inc_id')
                        ->on('buy_incentives.user_id', '=', 'wallets.user_id');
                })
                ->select('users.email', 'buy_incentives.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'wallets.address')
                ->where('users.id', $request->user_id)
                ->get();

            $status = true;
            $message = "Crpto Rewards List";

            $str['status'] = $status;
            $str['message'] = $message;
            $str['data'] = $list;
            return $str;
        } else {


            $list = GiftCard::join('users', 'gift_cards.user_id', '=', 'users.id')
                ->join('incentives', 'incentives.id', '=', 'gift_cards.inc_id')
                ->join('businesses', 'incentives.business_id', '=', 'businesses.id')
                ->select('users.email', 'gift_cards.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'businesses.name')
                ->where('users.id', $request->user_id)
                ->get();

            $status = true;
            $message = "Gift Card Reward List";

            $str['status'] = $status;
            $str['message'] = $message;
            $str['data'] = $list;
            return $str;
        }
    }

    public function filter_exchange_points_user(Request $request)
    {

        $request->validate([
            'type' => 'required',
            'user_id' => 'required',

        ]);

        // $list = Buy_incentive::join('users', 'buy_incentives.user_id', 'users.id')->join('incentives', 'incentives.id', 'buy_incentives.incent_id')->join('wallets', 'buy_incentives.incent_id', 'wallets.inc_id' && 'wallets', 'buy_incentives.user_id', 'wallets.user_id')->select('users.email', 'buy_incentives.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'wallets.address')->where('incentives.type', $request->type)->get();

        if ($request->type == 2) {

            $startTimestamp = $request->from; // Start timestamp in milliseconds
            $endTimestamp = $request->to; // End timestamp in milliseconds

            $startDate = date('Y-m-d H:i:s', $startTimestamp / 1000); // Convert start timestamp to a readable date and time
            $endDate = date('Y-m-d H:i:s', $endTimestamp / 1000); // Convert end timestamp to a readable date and time


            $list = Buy_incentive::join('users', 'buy_incentives.user_id', '=', 'users.id')
                ->join('incentives', 'incentives.id', '=', 'buy_incentives.incent_id')
                ->join('wallets', function ($join) {
                    $join->on('buy_incentives.incent_id', '=', 'wallets.inc_id')
                        ->on('buy_incentives.user_id', '=', 'wallets.user_id');
                })
                ->select('users.email', 'buy_incentives.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'wallets.address')
                ->where('users.id', $request->user_id)
                ->whereBetween('buy_incentives.created_at', [$startDate, $endDate])
                ->get();

            $status = true;
            $message = "Crpto Rewards List";

            $str['status'] = $status;
            $str['message'] = $message;
            $str['data'] = $list;
            return $str;
        } else {

            $startTimestamp = $request->from; // Start timestamp in milliseconds
            $endTimestamp = $request->to; // End timestamp in milliseconds

            $startDate = date('Y-m-d H:i:s', $startTimestamp / 1000); // Convert start timestamp to a readable date and time
            $endDate = date('Y-m-d H:i:s', $endTimestamp / 1000); // Convert end timestamp to a readable date and time

            $list = GiftCard::join('users', 'gift_cards.user_id', '=', 'users.id')
                ->join('incentives', 'incentives.id', '=', 'gift_cards.inc_id')
                ->join('businesses', 'incentives.business_id', '=', 'businesses.id')
                ->select('users.email', 'gift_cards.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.value as inc_value', 'businesses.name')
                ->where('users.id', $request->user_id)
                ->whereBetween('gift_cards.created_at', [$startDate, $endDate])
                ->get();

            $status = true;
            $message = "Gift Card Reward List";

            $str['status'] = $status;
            $str['message'] = $message;
            $str['data'] = $list;
            return $str;
        }
    }
}
