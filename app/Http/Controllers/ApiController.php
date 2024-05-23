<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Point;
use Illuminate\Http\Request;
use App\Models\User_activity;
use App\Models\User_friend;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetMail;
use Storage;
use App\Models\Coin_pkg;
use App\Models\Incentive;
use App\Models\Subscription;
use App\Models\Buy_incentive;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\Business;
use App\Models\GiftCard;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class ApiController extends Controller
{
    // public function register(Request $request)
    // {
    //     if ($request->file('pic') == null) {
    //         $image_name = "";
    //     } else {
    //         $path_title = $request->file('pic')->store('public/images');

    //         $image_name = basename($path_title);
    //     }

    //     $validator = Validator::make($request->all(), [
    //         // 'firstname' => 'required',
    //         // 'lastname' => 'required',
    //         'email' => 'required|email:rfc,dns|unique:users,email',
    //         // 'dob' => 'required',
    //         // 'gender' => 'required',
    //         // 'phone' => 'required',
    //         // 'password' => 'required|min:6',
    //         // 'country' => 'required',


    //     ]);

    //     if ($validator->fails()) {

    //         $user = User::select('id')->where('email', $request->email)->first();

    //         if($user){

    //             $message = $validator->errors()->first();
    //             $status = false;
    //             $data =  $this->user_detail($user->id);

    //         } else {

    //             $message = $validator->errors()->first();
    //             $status = false;
    //             $data =  $request->all();
    //         }



    //     } else {
    //         $user = new User;
    //         $user->firstname = $request->firstname;
    //         $user->lastname = $request->lastname;
    //         $user->email = $request->email;
    //         $user->dob = $request->dob;
    //         $user->gender = $request->gender;
    //         $user->phone = $request->phone;
    //         $user->country = $request->country;
    //         $user->password = $request->password;
    //         $user->device_token = "";
    //         $user->lat = "";
    //         $user->lng = "";
    //         $user->pic = "images/" . $image_name;
    //         // $user->pic = $request->pic;
    //         $user->save();
    //         $status = true;
    //         $message = "User Registered";
    //         $data = $this->user_detail($user->id);
    //     }

    //     $str['status'] = $status;
    //     $str['message'] = $message;
    //     $str['data'] = $data;
    //     return $str;
    // }

    public function register(Request $request)
    {
        if ($request->file('pic') == null) {
            $image_name = "";
        } else {
            $path_title = $request->file('pic')->store('public/images');

            $image_name = basename($path_title);
        }

        $rules = [

            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',



        ];

        $validator = FacadesValidator::make($request->all(), $rules);
        if ($validator->fails()) {
            $err = $validator->errors()->getMessages();
            $msg = array_values($err)[0][0];
            $user = User::select('id')->where('email', $request->email)->first();
            if ($user) {

                $users = User::where('email', $request->email)->first();
                $users->device_token = $request->device_token;
                $users->password = $request->password;

                $users->save();

                $res['status'] = false;
                $res['message'] = $msg;
                $res['data'] =  $this->user_detail($user->id);
            } else {

                $res['status'] = false;
                $res['message'] = $msg;
                $res['data'] =  $request->all();
            }

            return response()->json($res);
        }

        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->password = $request->password;
        $user->device_token = $request->device_token;
        $user->lat = "";
        $user->lng = "";
        $user->pic = "images/" . $image_name;
        $user->save();


        $res['status'] = true;
        $res['message'] = "User Insert Sucessfully";
        $res['data'] =  $this->user_detail($user->id);
        return response()->json($res);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|exists:users,email',
            'password' => 'required|min:6',
            'device_token' => 'required',


        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = $request->all();
        } else {
            $user = User::select('id')->where('email', $request->email)->where('password', $request->password)->first();
            if ($user) {
                $status = true;
                $message = "User Login";
                $token = $request->device_token;
                $user->device_token = $request->device_token;
                $user->lang = $request->lang;
                // $user->lat=$request->lat;
                // $user->lng=$request->lng;
                $user->save();
                $data = $this->user_detail($user->id);
            } else {
                $status = false;
                $message = "Invalid Password";
                $data = $request->all();
            }
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
        # code...
    }

    public function ios_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'device_token' => 'required',
            'lat' => 'required',
            'lng' => 'required',

        ]);
    
        if ($validator->fails()) {
            return [
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => $request->all(),
            ];
        }
    
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            $user->device_token = $request->device_token;
        } else {
            $user = new User();
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->device_token = $request->device_token;
            $user->lat = $request->lat;
            $user->lng = $request->lng;

        }
    
        $user->save();
    
        return [
            'status' => true,
            'message' => "User Login",
            'data' => $this->user_detail($user->id),
        ];
    }

    public function apple_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'email' => 'required',
            'device_token' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'apple_id' => 'required',

        ]);
    
        if ($validator->fails()) {
            return [
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => $request->all(),
            ];
        }
    
        $user = User::where('apple_id', $request->apple_id)->first();
    
        if ($user) {
            $user->device_token = $request->device_token;
        } else {
            $user = new User();
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->device_token = $request->device_token;
            $user->lat = $request->lat;
            $user->lng = $request->lng;
            $user->apple_id = $request->apple_id;


        }
    
        $user->save();
    
        return [
            'status' => true,
            'message' => "User Login",
            'data' => $this->user_detail($user->id),
        ];
    }

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'firstname' => 'required',
            // 'lastname' => 'required',
            // 'user_id' => 'required',
            // 'dob' => 'required',
            // 'gender' => 'required',
            // 'phone' => 'required', 
            // 'country' => 'required'

        ]);

        //    $token =  $this->get_token($request->user_id);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = $request->all();
        } else {
            $user = User::find($request->user_id);
            if ($user) {

                if ($request->file('pic') == null) {
                    if ($user->pic) {
                        $image_name = $user->pic;
                    } else {
                        $image_name = "";
                    }
                } else {

                    $path_title = $request->file('pic')->store('public/images');

                    $image_name = "images/" .  basename($path_title);
                }

                $user->firstname = $request->firstname;
                $user->lastname = $request->lastname;
                $user->dob = $request->dob;
                $user->gender = $request->gender;
                $user->phone = $request->phone;
                $user->country = $request->country;
                $user->pic = $image_name;
                // if($request->pic){
                //     $user->pic = $request->pic;
                // } 

                $user->save();
                $status = true;
                $message = "User Updated";
                $data = $this->user_detail($user->id);
            } else {
                $status = false;
                $message = "User Id not found";
                $data = $this->user_detail($user->id);
            }
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        // $str['token'] = $token;
        return $str;
    }
    public function user_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $str['status'] = false;
            $str['message'] = $message;
            return $str;
        } else {
            $status = true;
            $uid = $request->user_id;
            $data = $this->user_detail($uid);
            $message = 'Homepage Detail';
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }
    public function user_detail($id)
    {
        $setting = Setting::find(1);

        $user = User::find($id);
        $subs = Subscription::find($user->user_subscription);
        if ($subs) {
            $user->earning_point = $setting->default_coins * $subs->points;
        } else {
            $user->earning_point = $setting->default_coins;
        }

        //     return $rank=DB::select(DB::raw("select * from ( select @rownum: = @rownum + 1 as num ,total_points,id from users ) as a ;"));



        $user->user_rank = $this->get_rank($id);
        $user->point_time = strval($setting->default_time);
        $user->business_radius = intval($setting->business_radius);
        $user->max_time = intval($setting->earning_poin_time);
        $user->max_driving_time = intval($setting->earning_point_driving);
        $champ_u = USER::orderBy('total_points', 'desc')->first();
        $champ['user_name'] = $champ_u->firstname . ' ' . $champ_u->lastname;
        $champ['country'] = $champ_u->country;
        $champ['points'] = $champ_u->total_points;
        $user->champion_detail = $champ;
        return $user;
    }
    public function start_activity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'type' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',

        ]);


        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = $request->all();
        } else {


            $user_act = new User_activity;
            $user_act->user_id = $request->user_id;
            $user_act->type = $request->type;
            $user_act->start_time = $request->start_time;
            $user_act->end_time = $request->end_time;
            $user_act->save();

            $status = true;
            $message = 'Time Added';
            $data = $user_act;

            // $token =  $this->get_token($request->user_id);

        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        // $str['token'] = $token;
        return $str;
    }
    public function get_rank($id)
    {
        DB::statement(DB::raw('SET @rownum=0'));
        $results =
            DB::select(
                DB::raw("
          SELECT *
          FROM (
            SELECT 
                     @rownum := @rownum+1
                AS rank,
                id
            FROM users  AS random_ads
            ORDER BY total_points desc
          ) AS ads_ranked
          where id=$id
        ;
        ")
            );
        return $results[0]->rank;
    }
    public function add_point(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'type' => 'required',
            'points' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = $request->all();
        } else {

            $user = User::find($request->user_id);

            if ($user->device_token == $request->device_token) {

                $user_act = new Point;
                $user_act->user_id = $request->user_id;
                $user_act->type = $request->type;
                $user_act->start_time = $request->start_time;
                $user_act->end_time = $request->end_time;
                $user_act->points = $request->points;
                $user_act->save();

                $user_act = new User_activity;
                $user_act->user_id = $request->user_id;
                $user_act->type = $request->type;
                $user_act->start_time = $request->start_time;
                $user_act->end_time = $request->end_time;
                $user_act->save();

                $user = User::find($request->user_id);
                $user->total_points = $user->total_points + $request->points;
                $user->save();

                $status = true;
                $message = 'Points Added';
                $data = $this->user_detail($request->user_id);

                $str['status'] = $status;
                $str['message'] = $message;
                $str['data'] = $data;
                return $str;
            } else {

                $str['status'] = false;
                $str['message'] = 'Device Token Changed';
                return $str;
            }
        }
    }

    public function add_friend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'f_id' => 'required|exists:users,id',

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = User_friend::where('user_id', $request->user_id)->get();
        } else {

            $friend = User_friend::where('user_id', $request->user_id)->where('f_id', $request->f_id)->get();
            if (count($friend) == 0) {
                $add_fr = new User_friend;
                $add_fr->user_id = $request->user_id;
                $add_fr->f_id = $request->f_id;
                $add_fr->save();
                $status = true;
                $message = 'Friend Added';
                $data = User_friend::where('user_id', $request->user_id)->get();
            } else {
                $status = false;
                $message = 'Already Added';
                $data = User_friend::where('user_id', $request->user_id)->get();
            }
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }
    public function users_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
        } else {
            $uid = $request->user_id;
            $status = true;
            $message = 'Users List';
            $data = User::select('id', 'pic', 'firstname', 'lastname', 'email', 'dob', 'gender', 'phone', 'country', 'device_token')->where('id', '!=', $uid)->whereNotIn('id', [DB::RAW("SELECT if(user_id=$uid,f_id,user_id) FROM user_friends where user_id=$uid OR f_id=$uid")])->get();
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }
    public function friend_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
        } else {
            $uid = $request->user_id;
            $status = true;
            $message = 'Friends List';
            $data0 = User::select('id', 'pic', 'firstname', 'lastname', 'email', 'dob', 'gender', 'phone', 'country', 'device_token')->where('id', '!=', $uid)->whereIn('id', [DB::RAW("SELECT if(user_id=$uid,f_id,user_id) FROM user_friends where (user_id=$uid OR f_id=$uid) AND active=1")])
                ->get();
            $data = [];
            foreach ($data0 as $u) {
                $act = Point::where('user_id', $u->id)->orderBy('id', 'desc')->first();
                if ($act) {
                    $u->last_activity = $act->type;
                } else {
                    $u->last_activity = 0;
                }
                $data[] = $u;
            }
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }

    public function friend_req_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
        } else {
            $uid = $request->user_id;
            $status = true;
            $message = 'Friend Request List';
            $data = User::select('users.id', 'firstname', 'lastname', 'email', 'dob', 'gender', 'phone', 'country', 'device_token')->where('user_friends.f_id', $uid)->where('users.id', '!=', $uid)->Join('user_friends', 'users.id', 'user_friends.user_id')
                ->where('user_friends.active', '0')
                ->get();
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }

    public function rem_friend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'f_id' => 'required|exists:users,id',

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
        } else {

            $friend = User_friend::where('user_id', $request->user_id)->where('f_id', $request->f_id)->delete();
            $friend = User_friend::where('f_id', $request->user_id)->where('user_id', $request->f_id)->delete();
            $status = true;
            $message = 'Friend Removed';
            $data = $friend;
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }
    public function accept_friend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'f_id' => 'required|exists:users,id',

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = User_friend::where('user_id', $request->user_id)->get();
        } else {

            $friend = User_friend::where('f_id', $request->user_id)->where('user_id', $request->f_id)->first();
            if ($friend) {
                $friend->active = 1;
                $friend->save();
                $status = true;
                $message = 'Friend Accepted';
                $data = $friend;
            } else {
                $status = false;
                $message = 'Not Found!';
                $data = User_friend::where('user_id', $request->user_id)->get();
            }
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $data;
        return $str;
    }

    //insentive 

    public function incentive_list(Request $request)
    {


        // $validator = Validator::make($request->all(), [
        //     'user_id' => 'required|exists:users,id',
        //     'lat' => 'required',
        //     'lng' => 'required'

        // ]);
        // if ($validator->fails()) {
        //     $message = $validator->errors()->first();
        //     $status = false;
        //     $str['status'] = $status;
        //     $str['message'] = $message;

        //     return $str;
        // }



        $uid = $request->user_id;
        // $list = Incentive::where('quantity', '>', '0')->get();
        $latitude = $request->lat;
        $longitude = $request->lng;

        // $list = DB::table('incentives')
        //     ->select(DB::raw('incentives.* ,SQRT(POW(69.1 * (lat - ' . $latitude . '), 2) + POW(69.1 * (' . $longitude . '-lng) * COS(lat / 57.3), 2)) AS distance'))
        //     ->havingRaw('distance < radius')
        //     ->where('quantity', '>', '0')
        //     ->where('type', 2)
        //     ->OrderBy('distance')
        //     ->get();

        // $list = DB::table('incentives')
        //     ->select(DB::raw('incentives.* ,SQRT(POW(69.1 * (lat - ' . $latitude . '), 2) + POW(69.1 * (' . $longitude . '-lng) * COS(lat / 57.3), 2)) AS distance'))
        //     ->where('quantity', '>', 0)
        //     ->where('type', 2)
        //     ->whereRaw('SQRT(POW(69.1 * (lat - ' . $latitude . '), 2) + POW(69.1 * (' . $longitude . '-lng) * COS(lat / 57.3), 2)) < radius')
        //     ->orderBy('distance')
        //     ->get();

        $list = DB::table('incentives')
            ->select(DB::raw('incentives.*, ROUND(SQRT(POW(69.1 * (lat - ' . $latitude . '), 2) + POW(69.1 * (' . $longitude . '-lng) * COS(lat / 57.3), 2)), 2) AS distance'))
            ->where('quantity', '>', 0)
            ->where('type', 2)
            ->whereRaw('SQRT(POW(69.1 * (lat - ' . $latitude . '), 2) + POW(69.1 * (' . $longitude . '-lng) * COS(lat / 57.3), 2)) < radius')
            ->orderBy('distance')
            ->get();

        // dd($list);


        $data = [];

        foreach ($list as $ll) {
            $wdata = Wallet::where('inc_id', $ll->id)->where('user_id', $uid)->first();
            if ($wdata) {
                $ll->inc_address = $wdata->address;
            } else {
                $ll->inc_address = '';
            }
            $ll->distance = 1;
            $data[] = $ll;
        }

        // dd($data);


        $radius = Setting::select('business_radius')->first();
        $rad = $radius->business_radius;


        // $gift = DB::table('incentives')
        // ->join('businesses', 'incentives.business_id', '=', 'businesses.id' )
        // ->select(DB::raw('incentives.* ,SQRT(POW(69.1 * (businesses.laat - '.$latitude.'), 2) + POW(69.1 * ('.$longitude.'-businesses.lang) * COS(businesses.laat / 57.3), 2)) AS distance' ), 'businesses.name as business_name', 'businesses.status')
        // ->havingRaw('distance <'.$rad)
        // ->where('incentives.quantity', '>', '0')
        // ->where('incentives.type', 1)
        // ->where('businesses.status', 0)
        // ->OrderBy('distance')
        // ->get();

        $gift = DB::table('incentives')
            ->join('businesses', 'incentives.business_id', '=', 'businesses.id')
            ->select(DB::raw('incentives.*, ROUND(SQRT(POW(69.1 * (businesses.laat - ' . $latitude . '), 2) + POW(69.1 * (' . $longitude . '-businesses.lang) * COS(businesses.laat / 57.3), 2)), 2) AS distance'), 'businesses.name as business_name', 'businesses.status')
            ->havingRaw('distance < ' . $rad)
            ->where('incentives.quantity', '>', '0')
            ->where('incentives.type', 1)
            ->where('businesses.status', 0)
            ->orderBy('distance')
            ->get();





        foreach ($gift as $ll) {
            $wdata = Wallet::where('inc_id', $ll->id)->where('user_id', $uid)->first();
            if ($wdata) {
                $ll->inc_address = $wdata->address;
            } else {
                $ll->inc_address = '';
            }
            // $ll->distance = round($ll->distance, 2);
            $ll->distance = 1;

            $data[] = $ll;
        }

        $gift_globel = DB::table('incentives')
            ->join('businesses', 'incentives.business_id', '=', 'businesses.id')
            ->select('incentives.*', 'businesses.name as business_name', 'businesses.status')
            ->where('incentives.quantity', '>', '0')
            ->where('incentives.type', 1)
            ->where('businesses.status', 1)
            ->get();



        foreach ($gift_globel as $ll) {
            $wdata = Wallet::where('inc_id', $ll->id)->where('user_id', $uid)->first();
            if ($wdata) {
                $ll->inc_address = $wdata->address;
            } else {
                $ll->inc_address = '';
            }
            $ll->distance = 1;

            $data[] = $ll;
        }



        $count = Incentive::where('quantity', '>', '0')->count();
        $status = true;
        $message = "Incentive List";

        $str['status'] = $status;
        $str['message'] = $message;
        $str['total'] = $count;
        $str['data'] = $data;

        // $str['gift-cards'] = $gift;

        return $str;
    }


    public function buy_incentive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'incent_id' => 'required|exists:incentives,id',
            // 'wallet_address' => 'required',
            'buy_time' => 'required',
            // 'crpto_quantity' => 'required',
            'lang' => 'required',



        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
        } else {
            $uid = $request->user_id;
            $iid = $request->incent_id;
            $user = User::find($uid);
            $user->lang = $request->lang;
            $user->save();
            $incent = Incentive::find($iid);

            if ($user->total_points < $incent->req_point) {
                $status = false;
                $message = 'Your points are less than required point';
            } else {

                if ($incent->type == 1) {
                    $buy = new GiftCard;
                    $buy->inc_id = $iid;
                    $buy->user_id = $uid;
                    $buy->date_time = time() * 1000;
                    if (empty($incent->single_code)) {
                        $buy->giftcode = $incent->cardcode . '-' . rand(111111, 999999);
                    }
                    $buy->save();
                } else {

                    $buy = new Buy_incentive;
                    $buy->user_id = $uid;
                    $buy->incent_id = $iid;
                    $buy->points = $incent->req_point;
                    $buy->date_time = time() * 1000;
                    $buy->crpto_quantity = $request->crpto_quantity;
                    $buy->save();
                }
                if ($buy) {
                    $user->total_points = $user->total_points - $incent->req_point;
                    $user->exchange_points = $user->exchange_points + $incent->req_point;
                    $user->save();
                    $incent->quantity--;
                    $incent->save();
                    $status = true;
                    $message = 'Success';
                    $user->crypto = $buy;

                    $incentives = Incentive::find($request->incent_id);
                    $incentives->buy_time = $request->buy_time;
                    $incentives->save();

                    $bussiness = Business::find($incentives->business_id);

                    // $wallet_address = Wallet::where('user_id', $request->user_id)->where('inc_id', $request->incent_id)->first();

                    $wallet_address = $request->wallet_address;


                    if ($incentives->type == 2) {

                        $this->send_crypto_mail($user, $incentives, $request->wallet_address,  $request->buy_time);
                    } else if ($incentives->type == 1) {

                        if (empty($incent->single_code)) {

                            $this->send_gift_mail($user, $incentives, $request->buy_time, $bussiness, $buy->giftcode);
                        } else {

                            $this->send_gift_mail($user, $incentives, $request->buy_time, $bussiness, $incent->single_code);
                        }
                    }
                } else {
                    $status = true;
                    $message = 'Techniqal Error';
                }
            }
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $uid = $request->user_id;
        $data = $this->user_detail($uid);
        $str['data'] = $data;
        if ($incent->type == 2) {
            $str['crypto_quantity'] = $buy->crpto_quantity;
        }
        return $str;
    }

    public function myreward(Request $request)
    {
        $id = $request->user_id;
        //  $user = User::find($id);
        //  if ($user) {
        $list = Buy_incentive::where('user_id', $id)->where('incentives.type', 2)
            ->join('incentives', 'incentives.id', 'buy_incentives.incent_id')
            ->select('buy_incentives.*', 'incentives.name as inc_name', 'incentives.img as inc_img',  'incentives.code_img as code_image', 'incentives.value as inc_value')
            ->orderBy('buy_incentives.id', 'desc')
            ->get();

        // $status = true;
        // $message = "Rewards List";
        // } else {
        //     $status = false;
        //     $message = "User Id not Found";

        // }

        $str['status'] = true;
        $str['message'] = "Rewards List";
        $str['data'] = $list;
        return $str;
    }
    public function mygiftcards(Request $request)
    {
        $id = $request->user_id;
        // $user = User::find($id);
        // if ($user) {
        $list = GiftCard::where('user_id', $id)
            ->join('incentives', 'incentives.id', 'gift_cards.inc_id')
            ->select('gift_cards.*', 'incentives.name as inc_name', 'incentives.img as inc_img', 'incentives.code_img as code_image',  'incentives.gift_value as inc_value', 'incentives.req_point as points', 'incentives.expiry_date as expiry_date', 'incentives.value')
            ->orderBy('gift_cards.id', 'desc')
            ->get();
        // $status = true;
        // $message = "Gift Cards List";
        // } else {
        //     $status = false;
        //     $message = "User Id not Found";

        // }

        $str['status'] = true;
        $str['message'] = "Gift Cards List";
        $str['data'] = $list;
        return $str;
    }

    //Coin

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
    public function buy_coins(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'pkg_id' => 'required|exists:coin_pkgs,id',

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
        } else {
            $uid = $request->user_id;
            $cid = $request->pkg_id;
            $user = User::find($uid);
            $coins = Coin_pkg::find($cid);


            $user->total_points = $user->total_points + $coins->coins;

            $user->save();

            $status = true;
            $message = 'Success';
        }

        $str['status'] = $status;
        $str['message'] = $message;
        return $str;
    }
    //subscription

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

    public function buy_subscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'pkg_id' => 'required|exists:subscriptions,id',

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
        } else {
            $uid = $request->user_id;
            $sid = $request->pkg_id;
            $user = User::find($uid);
            $subs = Subscription::find($sid);

            $user->user_subscription = $sid;
            $user->save();

            $status = true;
            $message = 'Success';
        }

        $str['status'] = $status;
        $str['message'] = $message;
        return $str;
    }
    public function my_points(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',



        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = $request->all();
            $tot = 0;
        } else {
            $user_id = $request->user_id;
            $user_points = Point::where('user_id', $user_id);
            if ($request->from != "") {
                $user_points->where('start_time', '>', $request->from);
            }
            if ($request->to != "") {
                $user_points->where('end_time', '<', $request->to);
            }
            $points = $user_points->orderBy('start_time', 'desc');

            $status = true;
            $message = 'Points List';
            $tot = $points->sum('points');
            $data = $user_points->get();
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['total_points'] = $tot;
        $str['data'] = $data;
        return $str;
    }

    public function my_focus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',

        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = $request->all();
        } else {
            $user_id = $request->user_id;
            $user_points = User_activity::where('user_id', $user_id);
            if ($request->from != "") {

                $user_points = $user_points->where('start_time', '>', $request->from)->where('end_time', '<', $request->to);
            }
            if ($request->to != "") {

                $user_points = $user_points->where('start_time', '>', $request->from)->where('end_time', '<', $request->to);
                // $user_points = $user_points->where('end_time', '<', $request->to);
            }
            $points = $user_points->selectRaw("type,sum(end_time-start_time) as tot_time")->groupBy('type')->get();


            // return $points;

            $tot = [0, 0, 0, 0, 0, 0, 0];
            $t = 0;

            foreach ($points as $p) {

                $tot[$p->type] = $p->tot_time;
                $t = $t + $p->tot_time;
            }
            // return $tot; 

            // for ($i = 1; $i < 7; $i++) {

            //     if ($t == 0) {
            //         $per[$i]['time'] = strval($tot[$i]);
            //         $per[$i]['per'] = "0";
            //     } else {
            //         $per[$i]['time'] = strval($tot[$i]);
            //         $per[$i]['per'] = number_format(($tot[$i] * 100) / $t, 2);
            //     }
            // }

            if ($t > 0) {

                $per[1]['time'] = strval($tot[1]);
                $per[1]['per'] = strval(number_format(($tot[1] / $t) * 100, 2));


                $per[2]['time'] = strval($tot[2]);
                $per[2]['per'] = strval(number_format(($tot[2] / $t) * 100, 2));

                $per[3]['time'] = strval($tot[3]);
                $per[3]['per'] = strval(number_format(($tot[3] / $t) * 100, 2));

                $per[4]['time'] = strval($tot[4]);
                $per[4]['per'] = strval(number_format(($tot[4] / $t) * 100, 2));

                $per[5]['time'] = strval($tot[5]);
                $per[5]['per'] = strval(number_format(($tot[5] / $t) * 100, 2));

                $per[6]['time'] = strval($tot[6]);
                $per[6]['per'] = strval(number_format(($tot[6] / $t) * 100, 2));
            } else {

                $per[1]['time'] = "0";
                $per[1]['per'] = "0";


                $per[2]['time'] = "0";
                $per[2]['per'] = "0";

                $per[3]['time'] = "0";
                $per[3]['per'] = "0";

                $per[4]['time'] = "0";
                $per[4]['per'] = "0";

                $per[5]['time'] = "0";
                $per[5]['per'] = "0";

                $per[6]['time'] = "0";
                $per[6]['per'] = "0";
            }








            $status = true;
            $message = 'Points List';
            $data['per'] = $per;
        }

        $str['status'] = $status;
        $str['message'] = $message;
        $str['data'] = $per;
        return $str;
    }

    public function wallet_address(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'inc_id' => 'required'

        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            $status = false;
            $data = $request->all();
        } else {

            $wallet = Wallet::where('user_id', $request->user_id)
                ->where('inc_id', $request->inc_id)
                ->first();

            if ($wallet) {

                $res['status'] = true;
                $res['message'] = "wallet address!!";
                $res['response'] = $wallet;
                return response()->json($res);
            } else {


                $res['status'] = false;
                $res['message'] = "Wallet Address Can't Exist!!";
                return response()->json($res);
            }
        }
    }


    public function wallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'wallet' => 'required'

        ]);


        if ($validator->fails()) {
            //  $message = $validator->errors()->first();
            //   $status = false;
        } else {
            // $uid = $request->user_id;
            // $wallets = $request->wallet;
            // foreach ($wallets as $wallet) {

            //     $iid = $wallet['inc_id'];
            //     $adr = $wallet['address'];
            //     $wid = Wallet::where(
            //         ['user_id' => $uid, 'inc_id' => $iid]
            //     )->first();
            //     if ($wid) {
            //         $wid->address = $adr;
            //         $wid->save();
            //     } else {
            //         $w = new Wallet;
            //         $w->user_id = $uid;
            //         $w->inc_id = $iid;
            //         $w->address = $adr;
            //         $w->save();
            //     }
            // }
            // $status = true;
            // $message = "Successfully Added";
        }

        $wallets = $request->wallet;
        if ($request->filled('wallet')) {

            $uid = $request->user_id;

            foreach ($wallets as $wallet) {

                $iid = $wallet['inc_id'];
                $adr = $wallet['address'];
                $wid = Wallet::where(
                    ['user_id' => $uid, 'inc_id' => $iid]
                )->first();
                if ($wid) {
                    $wid->address = $adr;
                    $wid->save();
                } else {
                    $w = new Wallet;
                    $w->user_id = $uid;
                    $w->inc_id = $iid;
                    $w->address = $adr;
                    $w->save();
                }
            }


            $message = "Successfully Added";
        } else {


            $message = "Wallet Address";
        }


        $str['status'] = true;
        $str['message'] = $message;
        $str['data'] = Wallet::where('user_id', $request->user_id)->get();

        return $str;
    }

    public function forgot_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required'

        ]);
        if ($validator->fails()) {
            $msg = $validator->errors()->first();
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $update_pass = User::where('email', $request->email)->first();
        // return $update_pass;
        if (is_null($update_pass)) {

            $res['status'] = false;
            $res['message'] = "User Can't Exist";
            return response()->json($res);
        } else {

            $code = random_int(1000, 9999);

            $lang = $update_pass->lang;

            if ($this->sendmail($request->email, $code, $lang)) {

                //    $hashed_random_password = Hash::make($code);
                // return $hashed_random_password;

                $update_pass = User::where('email',  $request->email)->first();
                $update_pass->otp = $code;
                $update_pass->save();

                $res['status'] = true;
                $res['message'] = "Otp Sent to your email";
                return response()->json($res);
            } else {
                $res['status'] = false;
                $res['message'] = "Techniqal Error!";
                return response()->json($res);
            }
        }
    }
    public function check_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:4',
            'email' => 'required|email',

        ]);

        if ($validator->fails()) {
            $msg = $validator->errors()->first();
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
        if ($user) {
            $res['status'] = true;
            $res['message'] = 'OTP Matched';
        } else {
            $res['status'] = false;
            $res['message'] = 'Invalid OTP';
        }

        return response()->json($res);
    }
    public function reset_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            $msg = $validator->errors()->first();
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }


        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = $request->password;
            $user->save();
        }
        $res['status'] = true;
        $res['message'] = "Password Updated Sucessfully!!";
        return response()->json($res);
    }
    public function pass_update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $msg = $validator->errors()->first();
            $res['status'] = false;
            $res['message'] = $msg;

            return response()->json($res);
        }

        $password = User::find($request->user_id);
        if ($password->password == $request->password) {

            $password->password = $request->new_password;
            $password->save();

            $res['status'] = true;
            $res['message'] = "Password Updated Sucessfully!!";
            return response()->json($res);
        } else {

            $res['status'] = false;
            $res['message'] = 'Previous password not matched';

            return response()->json($res);
        }
    }

    public function sendmail($email, $password, $lang)
    {
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
            $mail->addAddress($email);
            // $mail->addCC($request->emailCc);
            // $mail->addBCC($request->emailBcc);

            // $mail->addReplyTo('sender@example.com', 'SenderReplyName');




            $mail->isHTML(true);                // Set email content format to HTML

            if ($lang == 'en') {

                $mail->Subject = 'Reset Password';
            } elseif ($lang == 'sp') {

                $mail->Subject = 'Restablecer la contrasena';
            } else {
                $mail->Subject = 'Reset Password';
            }


            $mail->Body    = view('email', compact('password', 'lang'))->render();

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public function send_crypto_mail($user, $incentives, $wallet_address, $buy_time)
    {
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
            $mail->addAddress($user->email);

            // $mail->addCC($request->emailCc);
            // $mail->addBCC($request->emailBcc);

            // $mail->addReplyTo('sender@example.com', 'SenderReplyName');




            $mail->isHTML(true);                // Set email content format to HTML

            if ($user->lang == 'en') {

                $mail->Subject = 'Points exchanged for Crypto';
            } elseif ($user->lang == 'sp') {

                $mail->Subject = 'Puntos canjeados por Cripto';
            } else {

                $mail->Subject = 'Points exchanged for Crypto';
            }



            $mail->Body    = view('cryptomail', compact('user', 'incentives', 'wallet_address', 'buy_time'))->render();

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function send_gift_mail($user, $incentives, $buy_time, $bussiness, $giftcode)
    {
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
            $mail->addAddress($user->email);

            // $mail->addCC($request->emailCc);
            // $mail->addBCC($request->emailBcc);

            // $mail->addReplyTo('sender@example.com', 'SenderReplyName');




            $mail->isHTML(true);                // Set email content format to HTML

            if ($user->lang == 'en') {

                $mail->Subject = 'Points exchanged for Gift Card';
            } elseif ($user->lang == 'sp') {

                $mail->Subject = 'Puntos canjeados por Tarjeta Regalo';
            } else {

                $mail->Subject = 'Points exchanged for Gift Card';
            }

            $mail->Body    = view('gift_mail', compact('user', 'incentives', 'buy_time', 'bussiness', 'giftcode'))->render();

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    //==============web function==============
    public function update_business(Request $request)
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

    public function get_token($user_id)
    {

        $user =  User::find($user_id);

        $token =  $user->device_token;

        return $token;
    }
}
