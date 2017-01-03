<?php
namespace App\Http\Controllers;

use App\Post;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

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
        $userId = DB::table('posts')->where('id', $post_id)->value('email');
        $post = Post::where('id', $post_id)->first();

        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('post.Create.User')->with(['message' => 'Succesfulle Delete', 'userId' => $userId]);
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
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $message = 'There was an error';
        $authName = Auth::user();
        $lastName = $authName->last_name;
        $firstName = $authName->first_name;
        $name = $firstName . " " . $lastName;
        $post = new Post();
        $post->body = $request['body'];
        $post->email = $request['idUser'];
        $userId = $request['idUser'];
        $post->name = $name;
        if ($request->user()->posts()->save($post)) {

            $message = 'message succesfully send';
        }
        return redirect()->route('post.Create.User')->with(['message' =>  $message,'userId' => $userId ]);

    }


    public function postCreatePostUser(Request $request)
    {

        if (!empty($request['userEmail'])) {
            $userId = $request['userEmail'];
        } else {
            $userId = Session::get('userId');
        }
        $users = DB::table('users')->get();
        $posts = DB::table('users')->where('email', $userId)->get();
        $po = Post::where('email', $userId)->get();
        return view('users', ['users' => $users, 'po' => $po, 'posts' => $posts]);

    }


}
