@extends("layouts.app")

@section("title", "Creer un post")
@section("content")

    

    <!-- si nous avons un post $post -->
    @if (isset($post))
    <h1>Editer un post</h1>
    <!-- le formulaire est gere par la route "posts.update" -->
    <form action="{{ route('posts.update', $post) }}" method="post" enctype="multipart/form-data">
        <!-- <input type="hidden" name="_method" value="PUT"> -->
        @method('PUT')

    @else

    <h1>Creer un post</h1>
    <!-- le formulaire est gere par la route "posts.store" -->
    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
    @endif
        @csrf
        <p>
            <label for="title">Titre</label><br>
            <input type="text" name="title" value="{{ old('title') }}" id="title" placeholder="Le titre du Post">

            <!-- message d'erreur pour "title" -->
            @error("title")
            <div>{{ $message }}</div>
            @enderror
        </p>
        <!-- S'il y a une image $post->picture, on l'affiche -->
        @if (isset($post->picture))
        <p>
            <span>Couverture actuelle</span><br>
            <img src="{{ asset('storage/'.$post->picture) }}" alt="Image de couverture actuelle" style="max-height: 200px;">
        </p>
        @endif
        <p>
            <label for="picture">Couverture</label><br>
            <input type="file" name="picture" id="picture">

            <!-- message d'erreur pour "picture" -->
            @error("picture")
            <div>{{ $message }}</div>
            @enderror
        </p>
        <p>
            <label for="content">Contenu</label><br>
            <textarea name="content" id="content" lang="fr" cols="30" rows="10" placeholder="Le contenu du post"></textarea>

            <!-- message d'erreur pour "content" -->
            @error("content")
            <div>{{ $message }}</div>
            @enderror
        </p>

        <input type="submit" value="Valider" name="valider">
    </form>

@endsection