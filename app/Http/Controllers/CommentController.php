<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Photo;

use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string',
            'content' => 'required|string',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'content' => $request->content,
        ]);
        return redirect()->route('photos.show', $request->commentable_id)->with('success', 'Comentario agregado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $photo = Photo::findOrFail($comment);  // O también puedes cargar un usuario con su ID si es necesario

        // Obtener los comentarios relacionados con la foto (o el usuario si es necesario)
        $comments = $photo->comments()->with('user')->latest()->get();
    
        return view('comments.index', compact('comments', 'photo'));    
    }

    public function showUserComments($userId)
    {
        $user = User::findOrFail($userId);

        // Obtener los comentarios del usuario
        $comments = $user->comments()->latest()->get();

        return view('comments.index', compact('comments', 'user'));
    }

        /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('comments.index')->with('success', 'Comentario actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('comments.index')->with('success', 'Comentario eliminado.');
    }
}
