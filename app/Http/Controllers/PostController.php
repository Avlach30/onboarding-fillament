<?php

namespace App\Http\Controllers;

// Use Illuminate\Routing\Controller to extend the controller
use Illuminate\Http\Request;
// Use App\Models\Post to use the Post model
use App\Models\Post;
// Use Illuminate\View\View to return a view
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {   
        // Get all posts and paginate them
        $posts = Post::latest()->paginate(10);

        // Return the view with the posts
        return view('posts.index', compact('posts'));
    }

    public function getSingle(string $id): Post
    {
        // Find the post by the ID
        return Post::findOrFail($id);
    }

    public function show(string $id): View
    {
        // Find the post by the ID with the getSingle method
        $post = self::getSingle($id);

        return view('posts.show', compact('post'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {   
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:active,inactive',
            'tags' => 'nullable|array',
        ]);

        // Create a new post
        Post::create($request->all());

        // Redirect to the posts index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id): View
    {   
        // Find the post by the ID with the getSingle method
        $post = self::getSingle($id);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:active,inactive',
            'tags' => 'nullable|array',
        ]);

        // Update the post
        $post->update($request->all());

        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    public function destroy(string $id)
    {   
        // Find the post by the ID with the getSingle method
        $post = self::getSingle($id);

        // Delete the post
        $post->delete();

        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
