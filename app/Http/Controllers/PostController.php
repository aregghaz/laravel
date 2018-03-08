<?php
namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\User;
use App\Friends;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class PostController extends Controller
{
    /* Creating users page and returning view users */
    public function postCreatePostUser(Request $request)
    {
        /* Checking */
        if (!empty($request['userEmail'])) {
            $userEmail = $request['userEmail'];
        } else if (Session::get('userId')) {
            $userEmail = Session::get('userId');
        } else {
            $userEmail = Auth::user()->email;
        }
        /* getting friends list  */
        $friends = Friends::where('my_email', Auth::user()->email)->lists('friend_email');
        $usersFriend = User::whereIn('email', $friends)->get();
        /* getting users list  */
        $users = User::all();
        /* getting users info */
        $userInfo = DB::table('users')->where('email', $userEmail)->get();
        /* getting posts likes  */
        $like = DB::table('likes')->where('email', $userEmail)->lists('post_id');
        /* getting post user  */
        $posts = Post::where('email', $userEmail)->get();
        /* getting images */
        $images = Session::get('images');

        return view('users', ['users' => $users, 'posts' => $posts, 'userInfo' => $userInfo, 'images' => $images, 'friend' => $usersFriend, 'like' => $like]);
    }


    /* deleting posts by id */

    /**
     *
     * @param $post_id
     * @return \Illuminate\Http\RedirectResponse
     */
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
    /* sending posts to data base */

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userSendId(Request $request)
    {
        /* validation */
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        /* error message  */
        $message = 'There was an error';
        /* creating Request post  */
        $objUser = Auth::user();
        $lastName =  $objUser->last_name;
        $firstName =  $objUser->first_name;
        $name = $firstName . " " . $lastName;
        $post = new Post();
        $post->body = $request['body'];
        $post->email = $request['idUser'];
        $userId = $request['idUser'];
        $post->name = $name;
        /* saving in data base and save successfully sending message */
        if ($request->user()->posts()->save($post)) {

            $message = 'Your post successfully add';
        }
        return redirect()->route('post.Create.User')->with(['message' => $message, 'userId' => $userId]);

    }
    /* editing  posts  */
    public function postEditPost(Request $request)
    {
        /* validations */
        $this->validate($request, [
            'body' => 'required'
        ]);
        /* finding post */
        $post = Post::find($request['postId']);
        /* checking  */
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        /* sending data base  */
        $post->body = $request['body'];
        $post->update();
        $message = 'sxal ka';
        return response()->json(['new_body' => $post->body, 'message' => $message], 200);
    }



    /* getting all image users */
    public function userAllImage(Request $request)
    {
        /* getting request */
        $userEmail = $request['email'];
        /* searching users image */
        $images = DB::table('table_image')->where('email', $userEmail)->get();
        return redirect()->route('post.Create.User')->with(['userId' => $userEmail, 'images' => $images]);
    }

    /* seting profile image */
    public function profileImage(Request $request)
    {
        /* getting request of image */
        $imageName = $request['imageName'];
        /* getting  image */
        $imageNAme2 = DB::table('table_image')->where('name', $imageName)->value('name');
        /* setting profile  image */
        DB::table('users')->where('email', Auth::user()->email)->update(['profileImage' => $imageNAme2]);
        return redirect()->route('post.Create.User');
    }

    /* add friends */
    public function addFriend(Request $request)
    {
        /* getting request of user */
        $userEmail = $request['friendEmail'];
        /* creating users table foreach */
        DB::table('friends')->insert(['friend_email' => $userEmail, 'my_email' => Auth::user()->email]);
        DB::table('friends')->insert(['my_email' => $userEmail, 'friend_email' => Auth::user()->email]);

        return redirect()->route('post.Create.User');
    }

    /* sending message to users in profile */
    public function sendMessage(Request $request)
    {
        /* getting message and users id */
        $message = $request['messageText'];
        $toUserID = $request['userId'];
        $fromUserId = Auth::user()->id;
        $created_at = date('Y-m-d');
        /* inserting in to the table  */
        $arrInsert = array(
            'from_id' => $fromUserId,
            'to_id' => $toUserID,
            'message' => $message,
        );
        $arrInsert['created_at'] = $created_at;

        DB::table('messages')->insert($arrInsert);
        return redirect()->route('post.Create.User');
    }


    /*creating inbox  */
    public function inbox(Request $request)
    {
        /* checking  */
        if (empty(Session::get('userId'))) {
            $userId = $request['userId'];
        } else {
            $userId = Session::get('userId');
        }
        /* getting friends  */
        $friends = DB::table('friends')->where(['my_email' => Auth::user()->email])->lists('friend_email');
        $friend = DB::table('users')->whereIn('email', $friends)->get();
        /* getting info which user will be send message  */
        $user = DB::table('users')->where('id', $userId)->get();
        /* getting  users  message  */
        $message = DB::table('messages')->where(['from_id' => Auth::user()->id, 'to_id' => $userId])->orWhere(['from_id' => $userId, 'to_id' => Auth::user()->id])->get();
        return view('includes.inbox_message', ['friends' => $friend, 'message' => $message, 'user' => $user, 'userId' => $userId]);
    }


    /* sending message to users in inbox  */
    public function message(Request $request)
    {
        /* getting  requests   */
        $message = $request['messageText'];
        $toUserID = $request['userId'];
        $fromUserId = Auth::user()->id;
        $created_at = date("Y-m-d H:i:s");
        /* inserting in to the table */
        DB::table('messages')->insert(['from_id' => $fromUserId, 'to_id' => $toUserID, 'message' => $message, 'created_at' => $created_at]);
        return redirect()->route('inbox')->with(['userId' => $toUserID]);
    }

    /* like or dislike  */
    public function like(Request $request)
    {
        /* getting  requests   */
        $postId = $request['postId'];
        $postEmail = $request['email'];
        $isLike = $request['isLike'] === 'true';
        $update = false;
        /* checking posts   */
        $post = Post::find($postId);
        if (!$post) {
            return null;
        }
        $user = Auth::user();
        /* checking if we already like this posts   */
        $like = $user->likes()->where('post_id', $postId)->first();
        /*  if we already like this posts   */
        if ($like) {
            $already_like = $like->like;
            $update = true;

            if ($already_like == $isLike) {

                $like->delete();
                return null;
            }
        }
        /*  creating new like requests   */
        else {
            $like = new Like();
        }
        $like->like = $isLike;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        $like->email = $postEmail;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }

        return null;
    }
}
