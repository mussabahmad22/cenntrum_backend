<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\WebController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// }); old code

Route::post('register',[ApiController::class,'register']);
Route::post('login',[ApiController::class,'login']);
Route::post('ios_login',[ApiController::class,'ios_login']);
Route::post('apple_login',[ApiController::class,'apple_login']);
Route::post('start_activity',[ApiController::class,'start_activity']);
Route::post('add_point',[ApiController::class,'add_point']);
Route::post('add_friend',[ApiController::class,'add_friend']);
Route::post('rem_friend',[ApiController::class,'rem_friend']);
Route::post('accept_friend',[ApiController::class,'accept_friend']);
Route::get('friend_list',[ApiController::class,'friend_list']);
Route::get('friend_req_list',[ApiController::class,'friend_req_list']);
Route::get('users_list',[ApiController::class,'users_list']);
Route::get('user_detail',[ApiController::class,'user_details']);
Route::post('update_profile',[ApiController::class,'update_profile']);
Route::post('incentive_list',[ApiController::class,'incentive_list']);
Route::post('incentive_list_gift_cards',[ApiController::class,'incentive_list_gift_cards']);
Route::post('buy_incentive',[ApiController::class,'buy_incentive']);
Route::get('my_rewards',[ApiController::class,'myreward']);
Route::get('my_giftcards',[ApiController::class,'mygiftcards']);
Route::get('coins_list',[ApiController::class,'coins_pkg_list']);
Route::post('buy_coins',[ApiController::class,'buy_coins']);
Route::get('subs_list',[ApiController::class,'subs_pkg_list']);
Route::post('buy_subscription',[ApiController::class,'buy_subscription']);
Route::post('my_points',[ApiController::class,'my_points']);
Route::post('my_focus',[ApiController::class,'my_focus']);
Route::post('add_wallet',[ApiController::class,'wallet']);
Route::get('wallet_address',[ApiController::class,'wallet_address']);

Route::post('forgot_password',[ApiController::class,'forgot_password']);
Route::post('reset_password',[ApiController::class,'pass_update']);
Route::post('update_password',[ApiController::class,'reset_password']);
Route::post('check_otp',[ApiController::class,'check_otp']);

// web route
Route::post('web_login',[WebController::class,'login']);
Route::get('web_users_list',[WebController::class,'users_list']);
Route::post('add_coins_pkg',[WebController::class,'add_coins_pkg']);
Route::post('update_coins_pkg/{id}',[WebController::class,'update_coins_pkg']);
Route::get('coins_pkg_list',[WebController::class,'coins_pkg_list']);
Route::post('add_subs_pkg',[WebController::class,'add_subs_pkg']);
Route::post('update_subs_pkg/{id}',[WebController::class,'update_subs_pkg']);
Route::get('subs_pkg_list',[WebController::class,'subs_pkg_list']);
Route::get('delete_subs_pkg/{id}',[WebController::class,'delete_subs_pkg']);
Route::get('delete_coins_pkg/{id}',[WebController::class,'delete_coins_pkg']);
Route::get('delete_user/{id}',[WebController::class,'delete_user']);
Route::get('insentive_list',[WebController::class,'insentive_list']);
Route::post('add_insentive',[WebController::class,'add_insentive']);
Route::post('update_incentive/{id}',[WebController::class,'update_insentive']);
Route::get('delete_incentive/{id}',[WebController::class,'delete_insentive']);
Route::get('business_list',[WebController::class,'business_list']);
Route::post('add_business',[WebController::class,'add_business']);
Route::get('business_detail/{id}',[WebController::class,'business_detail']);
// Route::post('update_business/{id}',[WebController::class,'update_business']);


Route::get('delete_business/{id}',[WebController::class,'delete_business']);
Route::get('earned_points',[WebController::class,'earn_points']);
Route::get('exchange_points',[WebController::class,'exchange_points']);
Route::post('update_admin',[WebController::class,'update_profile']);
Route::get('get_admin',[WebController::class,'update_profile']);
Route::post('update_app',[WebController::class,'update_app']);
Route::get('get_setting',[WebController::class,'get_app']);
Route::post('send_mail',[WebController::class,'send_mail']);
Route::post('update_business_details',[WebController::class,'update_business_new']);
Route::get('exchange_points_user',[WebController::class,'exchange_points_user']);
Route::get('filter_exchange_points',[WebController::class,'filter_exchange_points']);
Route::get('filter_exchange_points_user',[WebController::class,'filter_exchange_points_user']);
Route::get('filter_earn_points',[WebController::class,'filter_earn_points']);








