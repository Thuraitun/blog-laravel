@extends("layouts.app")

@section("content")
    <div class="container">

        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <div class="card mb-2 bg-secondary">
            <div class="card-body">
                <h5 class="card-title text-light">{{ $article->title }}</h5>

                <div class="card-subtitle mb-2 text-light small">
                    <b class="text-warning">{{$article->user->name}}</b>
                    Category: <b> {{ $article->category->name }}</b>,
                    {{ $article->created_at->diffForHumans() }}
                </div>
                
                <p class="card-text text-light">{{ $article->body }}</p>

                @auth

                    @can("article-delete", $article)
                        <a href="{{ url("/articles/edit/$article->id") }}" class="btn btn-sm btn-primary me-2">Upadate</a>
                    @endcan

                    @can("article-delete", $article)
                        <a href="{{ url("/articles/delete/$article->id") }}" class="btn btn-sm btn-danger">Delete</a>
                    @endcan

                @endauth

            </div>
        </div>
    
        <h5 class="mt-4 ms-1 text-primary">Comments ({{ count($article->comments) }})</h5>
        <ul class="list-group">
            @foreach($article->comments as $comment)
                <li class="list-group-item pe-2">
                    <b class="text-warning">{{$comment->user->name}}</b>

                    @auth 

                        @can("comment-delete", $comment)
                            <a href="{{ url("/comments/delete/$comment->id")}}" class="btn-close float-end"></a>
                        @endcan

                    @endauth

                    {{ $comment->content }}
                </li>
            @endforeach
        </ul>

        @auth 
                <form action="{{ url("/comments/add")}}" method="post">
                    @csrf 
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <textarea name="content" class="form-control my-1" placeholder="Your Comment"></textarea>
                    <button class="btn btn-primary">Add Comment</button>
                </form>
        @endauth

    </div>
@endsection