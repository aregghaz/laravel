<?php
namespace App\Http\Controllers;


use App\Http\Controllers\post;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        return redirect()->route('post.Create.User')->with(['userId' => $request['email']]);
    }

    public function login(Request $request)
    {
        $email = $request['email'];

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

    /*       Account         */
    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    /*     Editing  Account         */
    public function editAccount(Request $request)
    {
        $first_name = $request['firstName'];
        $last_name = $request['lastName'];

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['first_name' => $first_name, 'last_name' => $last_name]);
        $file = $request->file('image');
        function random_word()
        {
            $symbols = "QWERTYUIOsdfghjklZXCVBNM";
            $i = 0;
            $word = "";
            while ($i < 15) {
                $word .= $symbols[mt_rand(0, strlen($symbols) - 1)];
                $i++;
            }
            return $word;
        }

        $fileName = random_word() . ".jpg";
        DB::table('table_image')->insert(
            array('email' => Auth::user()->email, 'name' => $fileName));
        if ($file) {
            Storage::disk('local')->put($fileName, File::get($file));
        }
        return redirect()->route('account');

    }
}