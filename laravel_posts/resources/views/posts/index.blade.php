@extends("layouts.app")
@section("title", "Tous les articles")
@section("content")

    <h1>Tous les articles</h1>

    <p>
        <a href="{{ route('posts.create') }}" title="Creer un article">Creer un nouveau post</a>
    </p>

    <table border="1">
        <thead>
            <tr>
                <th>Titre</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>
                    <!-- Afficher un post -->
                    <a href="{{ route('posts.show', $post) }}" title="Lire un article">{{ $post->title }}</a>
                </td>
                <td>
                    <a href="{{ route('posts.edit', $post) }}" title="Modifier un article">Modifier</a>
                </td>
                <td>
                    <!-- formulaire pour supprimer un post : posts.destroy -->
                    <form action="{{ route('posts.destroy', $post) }}" method="post">
                        <!-- CSRF token -->
                        @csrf
                        @method("DELETE")
                        <input type="submit" value="Supprimer">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection