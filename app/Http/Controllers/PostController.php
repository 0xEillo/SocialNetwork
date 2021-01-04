<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotifyUser;

class PostController extends Controller{

    public function getDashboard() {
        $posts = Post::latest()->get();
        return view('dashboard', ['posts' => $posts]);
    }


    public function postCreatePost(Request $request) {
        //Validation
        $this->validate($request, [
            'body' => 'required|max:1000',
        ]);

        $post = new Post();
        $post->body = $request['body'];
        if($file = $request->file('image')) {
            $image = $file->getClientOriginalName();
            if($file->move('images', $image)) {
                $post->image = $image;
                $request->user()->posts()->save($post);
            }
        }
    
        $message = 'There was an error';
    
        if($request->user()->posts()->save($post)) {
            $message = 'Post created succesfully!';
        };
        return redirect()->route('dashboard')->with(['message'=>$message]);
    }

    public function getDeletePost($post_id) {
        $post = Post::where('id', $post_id)->first();
        if(Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->delete();
        return redirect()->route('dashboard')->with(['message'=>'Post successfully deleted!']);
    }

    public function postEditPost(Request $request) {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $post = Post::find($request['postId']);
        if(Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }

    public function postLikePost(Request $request) {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true';
        $update  = false;
        $post = Post::find($post_id);
        if(!$post) {
            return null;
        }
        $user  = Auth::user();
        $like = $user->likes()->where('post_id', $post_id)->first();
        if($like) {
            $already_like = $like->like;
            $update = true;
            if($already_like == $is_like) {
                $like->delete();
                return null;
            }
        } else {
            $like = new Like();
        }
    
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if($update) {
            $like->update();
        } else {
            $like->save();
        }
        return null;
    }

    public function postCreateComment(Request $request) {
        
        /*$this->validate($request, [
            'body' => 'required|max:250'
        ]);*/
        $post = Post::findOrFail($request->post_id);
        $message = 'Comment failed to post';
        $comment = Comment::create([
            'body' => $request['comment-text'],
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ]);
        
        if($request->user()->comments()->save($comment)) {
            $message = 'Comment posted succesfully';
        };
        return redirect()->route('dashboard')->with(['message' => $message]);
    }


}

