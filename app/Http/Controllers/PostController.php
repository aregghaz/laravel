<?php
namespace App\Http\Controllers;

use App\Post;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getSignIn()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        $users = DB::table('users')->get();

        return view('signIn', ['posts' => $posts], ['users' => $users]);
    }

    public function postCreatePost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $post = new Post();
        $post->body = $request['body'];
        //$post->email =
        $message = 'There was an error';
        if ($request->user()->posts()->save($post)) {

            $message = 'message succesfully send';
        }
        return redirect()->route('signIn')->with(['message' => $message]);


    }

    public function getDeletePost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('userSend')->with(['message' => 'Succesfulle Delete']);
    }

    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $post = Post::find($request['postId']);
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->body = $request['body'];

        $post->update();

        return response()->json(['new_body' => $post->body], 200);
    }


    public function userSendId(Request $request)
    {

        $userId = $request['userId'];
        $posts = DB::table('users')->where('id', $userId)->get();
        $userEmail = $request['userEmail'];

        $po = DB::table('posts')->where('email', $userEmail)->get();
        $users = DB::table('users')->get();

        return view('users', ['posts' => $posts, 'users' => $users, 'po'=> $po]);
    }


    public function postCreatePostUser(Request $request)
    {



        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $message = 'There was an error';
        $authName = Auth::user();
        $lastName = $authName ->last_name;
        $firstName = $authName ->first_name;
        $name =$firstName." ".$lastName;
        $post = new Post();
        $post->body = $request['body'];
        $post->email = $request['idUser'];
        $post->name = $name;
        $userId = $request['idUser'];



        $users = DB::table('users')->get();
        $posts = DB::table('users')->where('email', $userId)->get();
        if ($request->user()->posts()->save($post)) {

            $message = 'message succesfully send';
        }
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }

        $po = Post::where('email', $userId)->get();

        return view('users', ['post' => $post, 'users' => $users, 'message' => $message, 'po' => $po, 'posts'=> $posts]);

    }




}
