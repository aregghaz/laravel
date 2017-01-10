<?php
namespace App\Http\Controllers;

use App\Like;
use App\Post;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class PostController extends Controller
{
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
        $message = 'sxal ka';
        return response()->json(['new_body' => $post->body, 'message' => $message], 200);
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

            $message = 'Your post successfully add';
        }
        return redirect()->route('post.Create.User')->with(['message' => $message, 'userId' => $userId]);

    }


    public function postCreatePostUser(Request $request)
    {
        if (!empty($request['userEmail'])) {
            $userId = $request['userEmail'];
        } else if (Session::get('userId')) {
            $userId = Session::get('userId');
        } else {
            $userId = Auth::user()->email;
        }

        $friends = DB::table('freands')->where('my_email', Auth::user()->email)->lists('freand_email');
        $usersFriend = DB::table('users')->whereIn('email', $friends)->get();

        $users = DB::table('users')->get();
        $posts = DB::table('users')->where('email', $userId)->get();

        $po = Post::where('email', $userId)->get();
        if (Session::get('images')) {
            $images = Session::get('images');
            return view('users', ['users' => $users, 'po' => $po, 'posts' => $posts, 'images' => $images, 'friend' => $usersFriend]);
        }
        return view('users', ['users' => $users, 'po' => $po, 'posts' => $posts, 'friend' => $usersFriend]);
    }

    public function userAllImage(Request $request)
    {
        $userEmail = $request['email'];
        $posts = DB::table('table_image')->where('email', $userEmail)->get();
        return redirect()->route('post.Create.User')->with(['userId' => $userEmail, 'images' => $posts]);
    }

    public function profileImage(Request $request)
    {
        $imageName = $request['imageName'];
        $imageNAme2 = DB::table('table_image')->where('name', $imageName)->value('name');
        DB::table('users')->where('email', Auth::user()->email)->update(['profileImage' => $imageNAme2]);
        return redirect()->route('post.Create.User');
    }

    public function addFriend(Request $request)
    {
        $userEmail = $request['friendEmail'];
        DB::table('freands')->insert(['freand_email' => $userEmail, 'my_email' => Auth::user()->email]);
        DB::table('freands')->insert(['my_email' => $userEmail, 'freand_email' => Auth::user()->email]);
        return redirect()->route('post.Create.User');
    }

    public function sendMessage(Request $request)
    {
        $message = $request['messageText'];
        $toUserID = $request['userId'];
        $fromUserId = Auth::user()->id;
        $created_at = strftime("%F %T");
        DB::table('messages')->insert(['from_id' => $fromUserId, 'to_id' => $toUserID, 'message' => $message, 'created_at' => $created_at]);
        return redirect()->route('post.Create.User');
    }

    public function inbox()
    {

        $friends = DB::table('freands')->where(['my_email' => Auth::user()->email])->lists('freand_email');
        $friend = DB::table('users')->whereIn('email', $friends)->get();
        if (Session::get('message')) {
            $message = Session::get('message');
            $user = Session::get('user');
            $userId = Session::get('userId');

            return view('includes.inbox_message', ['friends' => $friend, 'message' => $message, 'user' => $user, 'userId' => $userId]);
        } else {
            return view('includes.inbox_message', ['friends' => $friend]);
        }
    }


    public function showMessage(Request $request)
    {
        $userId = $request['userId'];
        $user = DB::table('users')->where('id', $userId)->get();
        $message = DB::table('messages')->where(['from_id' => Auth::user()->id, 'to_id' => $request['userId']])->orWhere(['from_id' => $request['userId'], 'to_id' => Auth::user()->id])->get();
        return redirect()->route('inbox')->with(['message' => $message, 'user' => $user, 'userId' => $userId]);
    }

    public function message(Request $request)
    {
        $message = $request['messageText'];
        $toUserID = $request['userId'];
        $fromUserId = Auth::user()->id;
        $created_at = strftime("%F %T");
        DB::table('messages')->insert(['from_id' => $fromUserId, 'to_id' => $toUserID, 'message' => $message, 'created_at' => $created_at]);
        return redirect()->route('inbox');
    }

    public function like(Request $request)
    {
        $postId = $request['postId'];
        $isLike = $request['isLike'] === 'true';
        $update = false;
        $post = Post::find($postId);
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        $like = $user->likes()->where('post_id', $postId)->first();


        if ($like) {
            $already_like = $like->like;
            $update = true;

            if ($already_like == $isLike) {

                $like->delete();
                return null;
            }
        }else {
            $like = new Like();
        }
        $like->like = $isLike;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }

        return null;
    }
}
