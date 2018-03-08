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
    public function registration(Request $request, User $user)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'password' => 'required|min:4'
        ]);
        /*  creating Request  */
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
        /*  saving  */
//        $user->save();
//        $user = new User();
//        $user->store();
        Auth::login($user);
        return redirect()->route('post.Create.User')->with(['userId' => $request['email']]);
    }

    /*  login */
    public function login(Request $request)
    {
        /*  login  validation */
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        /*  checking   */
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {

            return redirect()->route('post.Create.User')->with(['userId' => $request['email']]);
        }
        return redirect()->back();
    }

    /*  logout */
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
        /*  creating  Request  */
        $first_name = $request['firstName'];
        $last_name = $request['lastName'];
        /*  updating  */
        User::where('id', Auth::user()->id)->update(['first_name' => $first_name, 'last_name' => $last_name]);
        $file = $request->file('image');
        /*  creating  random word for image */

        $fileName = $this->random_word() . ".jpg";
        /*  inserting name in to the table image */
        DB::table('table_image')->insert(
            array('email' => Auth::user()->email, 'name' => $fileName));
        /*  checking img and inserting in to the storage */
        if ($file) {
            Storage::disk('local')->put($fileName, File::get($file));
        }
        return redirect()->route('account');

    }

    private function random_word()
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
}