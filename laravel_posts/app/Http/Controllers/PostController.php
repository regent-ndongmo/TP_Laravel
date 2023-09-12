<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
// On importe la classe Storage pour pouvoir utiliser la methode delete($post->picture)
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //On recupere tous les post
        $posts = Post::latest()->get();

        //On transmet les posts a la vue
        return view("posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Ici on retourne juste la vue d'edition de la page
        return view("posts.edit");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Permet d'enregistrer une nouvelle ressource
        // 1. La validation
        $this->validate($request, [
            'title' => 'bail|required|string|max:255',
            "picture" => 'bail|required|image|max:5120',
            "content" => 'bail|required',
        ]);
        // 2.on upload l'image dans "/storage/app/public/posts"
        $chemin_image = $request->picture->store("posts");

        // 3.On enregistre les information du post
        Post::create([
            "title" => $request->title,
            "picture" => $chemin_image,
            "content" => $request->content,
        ]);
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        return view("posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view("posts.edit", compact("post"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // 1.La validation
        // les regle de validation pour "title" et pour "content"
        $rules = [
            'title' => 'bail|required|string|max:255',
            "content" => 'bail|required',
        ];
        // Si une nouvelle image est envoye:
        if ($request->has("picture")){
            $rules["picture"] = 'bail|required|image|max:5120';
        }
        $this->validate($request, $rules);

        // 2.On upload l'image dans "/storage/app/public/posts"
        if ($request->has("picture")){
            // On supprime l'ancienne image
            Storage::delete($post->picture);
            $chemin_image = $request->picture->store("posts");
        }

        // 3.On met a jour les informations du Post
        $post->update([
            "title" => $request->title,
            "picture" => isset($chemin_image) ? $chemin_image : $post->picture,
            "content" => $request->content,
        ]);

        // 4.On affiche le Post modifie : route("posts.show")
        return redirect(route("posts.show", $post));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //On supprime l'image existant
        Storage::delete($post->picture);

        // On supprime les informations du $post de la table "posts" 
        $post->delete();

        // Redirection route "posts.index"
        return redirect(route('posts.index'));
    }
}
