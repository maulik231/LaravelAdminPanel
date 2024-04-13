<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function getLogin()
    {
        return view('admin.getlogin');
    }

    public function postLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if(auth()->guard('admin')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
                $user = auth()->guard('admin')->user();
                if($user->role == 'admin'){
                    return redirect()->route('adminDashboard')->with('success','You are Logged in sucessfully.');
                }
            } else {
                return back()->with('error','Whoops! invalid email and password.');
            }
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }

    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('adminLogin'));
    }

    public function dashboard(){
        $shopCount = Shop::count();
        $productCount = Product::count();
        return view('admin.dashboard',compact('shopCount','productCount'));
    }
}
