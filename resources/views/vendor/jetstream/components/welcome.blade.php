<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::to('css/main.css') }}">
  </head>
  <body>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{  URL::to('js/main.js') }}"></script>
    
</body>
</html>

<section>


<div class="p-6 sm:px-20 bg-white border-b border-gray-200" style="padding-top: 55px; padding-bottom: 55px">
    
    <h2 style="text-align: center">
        Welcome to your SurfBored social network!
    </h2>

    <div class="mt-6 text-gray-500" style="text-align: center">
        This social network provides a beautiful environment to share personal projects, posts, pictures, and personal achievements. 
        Delve into the website and share away!
    </div>
</div>


<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
     <div>@include('include.message-block')</div>
    <div class="mt-8 text-2xl">
        <h3>Posts</h3>
    </div>

<section class="row new-post">
    <div style="margin: auto; width: 50%" class="col-md-6 col-md-offset-3">
        <form action="{{ URL('/createpost') }}" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <textarea class="form-control" name="body" id="new-post" rows="1" placeholder="What's on your mind?"></textarea>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary" style="background-color: #1E90FF; margin-left: 40%">Create Post</button>
        <input type="hidden" value="{{ Session::token() }}" name="_token">
        </form>
</div>
</section>
<section class="row posts">
    <div name ="entire-post" style="margin: auto; width: 50%;" class="col-md-6 col-md-offset-3">
        <header style="padding-top: 50px;"><h3>Feed</h3></header>
        @foreach($posts as $post)
        <div name="entire-post" style="padding-top: 55px;">
        <article class="post" data-postid="{{ $post->id }}">
            <h5>{{ $post->body }}</h5>
            <img src="{{ asset('/images/'.$post->image) }}" alt="" title="">
            <div class="info">
                Posted by {{ $post->user->name}} {{ $post->created_at->diffForHumans() }}
            </div>
            <div class="interaction">
                <a href="#" class="like" color="#90c0d8">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? 
                    Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'Liked' : 'Like' :'Like' }}</a>
                |
                <!--<a href="#" class="comment" id="commentClick" data-toggle="modal" data-target="#comment-modal" value="{{$post->id}}">Comment</a>-->
                @if(Auth::user() == $post->user)
                |
                <a href="#" class="edit" id="editClick">Edit</a>
                |
                <a href="{{ route('delete-post', ['post_id' => $post->id]) }}">Delete</a>
                @endif
            </div>
    
            
        </article>
        @foreach($post->comments as $comment)
            @if($post->id === $comment->post_id)
            <div class="comments-wrap">
                <h6 style="padding-left: 20px;">{{ $comment->user['name']}}: {{ $comment->body }}</h6>
            </div>
            @endif
        @endforeach
        <section class="comment-section">
            <form action="{{ URL('/comment') }}" method="post">
                <div class="input-group mb-3"> 
                    <input type="text" class="form-control" name="comment-text" id="comment-text" placeholder="write a comment...">
                        <div class="input-group-append">
                        <button class="input-group-text" id="basic-addon2">Post</button>
                    </div>
                </div>
            <input type="hidden" name="post_id" id="post_id" value="{{ $post->id}}">
            <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>
        </section>

        @endforeach
      </div>
    </div>
</endsection>

<div class="modal" tabindex="-1" role="dialog" id="edit-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="form-group">
            <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="edit-modal-save">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="comment-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Write a comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="form-group" id="commentForm">
          <textarea class="form-control" name="comment-text" id="body" rows="5"></textarea>
          <input type="hidden" name="post_id" id="post_id" value="commentClick">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="comment-modal-save">Post comment</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    var token = "{{ Session::token() }}";
    var urlEdit = "{{ URL('/edit') }}";
    var urlLike = "{{ URL('/like') }}";
</script>

</endsection>
    
