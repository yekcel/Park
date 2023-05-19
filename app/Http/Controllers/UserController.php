<?php

namespace App\Http\Controllers;

use foo\bar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function index(Request $request)
    {
        if(Gate::allows('notAdmin')){
            Alert::error('خطای دسترسی');
            return redirect('/home');
        }

        $users=User::OrderBy('role','asc')->withTrashed()->paginate(20);
        //dd('hi');
        return view('auth.index',compact('users'));
    }
    //------------------------------------------------------------
    public function delete(User $user)
    {
        if(Gate::allows('notAdmin')){
            Alert::error('خطای دسترسی');
            return redirect('/home');
        }
        if(Gate::allows('isAdmin')){
            $user->status=1;
            $user->update();
            $user->delete();


            Alert::success('غیر فعال نمودن کاربر با موفقیت انجام شد');
            return back();
        }else{
            Alert::error('خطای دسترسی', 'شما اجازه غیر فعال نمودن کاربران را ندارید');
            return back();
        }

    }
//------------------------------------------------------------
    public function recycle($id)
    {
        if(Gate::allows('notAdmin')){
            Alert::error('خطای دسترسی');
            return redirect('/home');
        }
        $user=User::withTrashed()->find($id);
        $user->restore();
        $user->status=0;
        $user->update();



        Alert::success('فعال نمودن کاربر با موفقیت انجام شد', 'Success Message');
        return back();
    }
    //------------------------------------------------------------
    public function AddUser()
    {
        if(Gate::allows('notAdmin')){
            Alert::error('خطای دسترسی');
            return redirect('/home');
        }
        return view('auth.AddUser');
    }
    //------------------------------------------------------------
    public function NewUser(Request $request)
    {
        if(Gate::allows('notAdmin')){
            Alert::error('خطای دسترسی');
            return redirect('/home');
        }
        $this->validate($request, [
            'name'    => 'required',
            'email'    => 'required|email',
            'password'    => 'required|confirmed',
            'level'    => 'required',
        ], [
            'name.required'       => 'وارد نمودن نام کاربر الزامی است!',
            'email.required'           => 'وارد نمودن آدرس ایمیل الزامی است!',
            'email.email'           => 'اآدرس ایمیل وارد شده فرمت صحیح ندارد!',
            'password.required'           => 'وارد نمودن رمز عبور الزامی است!',
            'password.confirmed'           => 'تکرار رمزعبور صحیح نیست!',
            'level.required'           => 'انتخاب سطح دسترسی الزامی است!',
        ]);

        $user =new User();
        $user->name=$request->input('name');
        $user->role=$request->input('level');
        $user->email=$request->input('email');
        $user->password= Hash::make($request->input('password'));

        $user->status=0;
        $user->save();
        Alert::success('ثبت موفق', 'کاربر جدید با موفقیت ثبت شد');
        return redirect('/users');
    }
    //------------------------------------------------------------
    public function edit(User $user)
    {
        if(Gate::allows('notAdmin')){
            Alert::error('خطای دسترسی');
            return redirect('/home');
        }
        return view('auth.EditUser',compact('user'));
    }
    //------------------------------------------------------------
    public function EditUser(Request $request,User $user)
    {
        if(Gate::allows('notAdmin')){
            Alert::error('خطای دسترسی');
            return redirect('/home');
        }
        $this->validate($request, [
            'name'    => 'required',
            'email'    => 'required|email',
            'password'    => 'required|confirmed',
            'level'    => 'required',
        ], [
            'name.required'       => 'وارد نمودن نام کاربر الزامی است!',
            'email.required'           => 'وارد نمودن آدرس ایمیل الزامی است!',
            'email.email'           => 'اآدرس ایمیل وارد شده فرمت صحیح ندارد!',
            'password.required'           => 'وارد نمودن رمز عبور الزامی است!',
            'password.confirmed'           => 'تکرار رمزعبور صحیح نیست!',
            'level.required'           => 'انتخاب سطح دسترسی الزامی است!',
        ]);


        $user->name=$request->input('name');
        $user->role=$request->input('level');
        $user->email=$request->input('email');
        $user->password= Hash::make($request->input('password'));


        $user->update();
        Alert::success('ثبت موفق', 'کاربر با موفقیت ویرایش شد');
        return redirect('/users');
    }
}
