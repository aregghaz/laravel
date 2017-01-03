<?php
namespace App\Http\Controllers;
use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Class UserController extends Controller
{

    public function registration(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'password' => 'required|min:4'
        ]);

        $email = $request['email'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->password = $password;

        $user->save();

        Auth::login($user);
        return redirect()->route('signIn');
    }

    public function login(Request $request)
    {
        $email  = $request['email'];

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {

            return redirect()->route('post.Create.User')->with(['userId' => $request['email']]);
        }
        return redirect()->back();
    }

    public function getLogOut()
    {
        Auth::logout();
        return redirect()->route('home');
    }

}