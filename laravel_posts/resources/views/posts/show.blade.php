@extends("layouts.app")

@section("title", $post->title)
@section("content")

    <h1>{{ $post->title }}</h1>

    <img src="{{ asset('storage/'.$post->picture) }}" alt="Image de couverture" style="max-width: 300px;">

    <div>{{ $post->content }}</div>

    <p><a href="{{ route('posts.index') }}" title="Retourner aux articles">Retourner aux posts</a></p>

@endsection