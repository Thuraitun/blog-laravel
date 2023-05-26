<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article List</title>
</head>
<body>
    @extends("layouts.app")

    @section("content")
        <div class="container">

            @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif

            {{ $articles->links() }}

            @foreach($articles as $article)
                <div class="card mb-2 bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title text-light">{{ $article->title }}</h5>
                        <div class="card-subtitle mb-2 text-light small">
                            <b class="text-warning">{{$article->user->name}}</b>
                            Category: <b> {{ $article->category->name }}</b>,
                            Comments: <b> {{ count($article->comments) }}</b>,
                            {{ $article->created_at->diffForHumans() }}
                        </div>
                        <p class="card-text text-light">{{ $article->body }}</p>
                        <a href="{{ url("/articles/detail/$article->id") }}" class="card-link">
                            View Details &raquo;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endsection
</body>
</html>
