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

    public function processInputTags(string $tagsInput): array
    {
        // Trim the tags input and explode it by comma
        return array_map('trim', explode(',', $tagsInput));
    }

    public function store(Request $request)
    {   

        $inputTags = $request->tags;

        // Check if the tags input is empty, assign a null value to the tags
        $tags = empty($inputTags) ? null : self::processInputTags($inputTags);

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        // Create a new post instance
        $newPost = new Post();
        $newPost->title = $request->title;
        $newPost->content = $request->content;
        $newPost->status = $request->status;
        $newPost->tags = $tags;

        // Save the post
        $newPost->save();

        // Redirect to the posts index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {   
        // Find the post by the ID with the getSingle method
        $post = self::getSingle($id);

        // Cast the tags array to a string with conditions if the tags are empty, return an empty string
        $post->tags = empty($post->tags) ? '' : implode(', ', $post->tags);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, string $id)
    {   
        // Find the post by the ID with the getSingle method
        $post = self::getSingle($id);
        // Process the tags input
        $inputTags = $request->tags;
        $tags = empty($inputTags) ? null : self::processInputTags($inputTags);

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->status = $request->status;
        $post->tags = $tags;

        // Update the post
        $post->update();

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
