<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AccountController extends Controller
{
    public function registration()
    {
        return view("front.account.registration");
    }

    // ----------------------------------> Registration Process With Ajax
    public function registrationProcess(Request $request)
    {
        $validater = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required | same:confirm_password',
            'confirm_password' => 'required'
        ]);

        if ($validater->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'User Successfully Register !!');
            return response()->json([
                'status' => true,
                'error' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validater->errors()
            ]);
        }
    }

    public function login()
    {
        return view("front.account.login");
    }

    // ----------------------------------> Login Process With Ajax
    public function authenticate(Request $request)
    {
        $validater = Validator::make($request->all(), [
            'email' => 'required  | email',
            'password' => 'required'
        ]);

        if ($validater->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication successful, you can redirect to the desired page
                return redirect()->route('account.profile');
            } else {
                // Authentication failed, add error message
                return redirect()->route('account.login')->with('error', 'Invalid Details !!');
            }
        } else {
            return redirect()->route('account.login')->withErrors($validater)->withInput();
        }
    }
    //----------------------------------------->Logout User
    public function logout()
    {
        auth::logout();
        return redirect()->route('account.login');
    }

    //----------------------------------------->Dashbord
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('front.account.profile', [
            'user' => $user
        ]);
    }

    //------------------------------------------->UpdateUser
    public function updateUser(Request $request)
    {
        $id = Auth::user()->id;
        $validater = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            // 'mobile' => 'required|max:10',
            // 'designation' => 'required'
        ]);

        if ($validater->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'User Update Successfully !!');
            return response()->json([
                'status' => true,
                'error' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validater->errors()
            ]);
        }
    }

    //--------------------------------->Update Profile Pic
    public function updateprofilepic(Request $request)
    {
        $id=Auth::user()->id;
        $validater = validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validater->passes()) {
        

            // If yes, delete the old image from the folder
            $user = User::find($id);
            if ($user->image) {    
                $oldImagePath = public_path('/profile_pic/') . $user->image;
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $image->move(public_path('/profile_pic/'),$filename);

            User::where('id',$id)->update(['image'=>$filename]);

            session()->flash('success', 'Profile Pic Update Successfully !!');
            return response()->json([
                'status' => true,
                'error' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validater->errors()
            ]);
        }
    }
}