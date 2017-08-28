<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Home\BaseController;
use App\Entity\Member;
use App\Entity\MemberDetail;
use DB;
use Hash;
use Session;
class RegisterController extends BaseController
{
  public function register(Request $request) {
    $data = $request->all();
    $this->validate($request, [
        'phone' => 'phone|string|required|unique:member,phone,',
        'email' => 'email|string|required|unique:member,email,',
        'password' => 'confirmed|required|min:6|max:12|required',
      ], [
        'phone.phone' => '请输入正确输入的电话号码',
        'phone.unique' => '手机号已存在',
        'email.email' => '请输入正确的邮箱地址',
        'email.unique' => '邮箱已存在',
        'password.confirmed' => '输入的密码不一致'
      ]);
    if(session('img_code')!=$data['code']){
      return back()->with('error', '验证码错误')->withInput();
    }
    $data['password'] = bcrypt($data['password']);
    $data['nick_name'] = '米粉'.rand(0, 1000000);
    $data['status'] = '0';
    $data['last_ip'] = $request->getClientIp();
    DB::beginTransaction();
    if(Member::create($data)) {
      $arr = DB::table('member')->where('nick_name', '=', $data['nick_name'])->get()[0];
      $request->session()->put('user_deta', ['nick_name'=>$arr->nick_name, 'phone'=>$arr->phone, 'email'=>$arr->email, 'id'=>$arr->id]);
      $array['member_id'] = $arr->id;
      $array['sex'] = 0;
      $array['avator'] = '/uploads/avator/default.jpg';
      if(MemberDetail::create($array)) {
        DB::commit();
        return redirect('/');
      }
    }
    DB::rollBack();
    return back();
  }
}