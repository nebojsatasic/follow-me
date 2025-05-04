<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Intervention\Image\Laravel\Facades\Image;

/**
 * Class PostController
 *
 * @package \App\Http\Controllers;
 */
class PostController extends Controller
{
    /**
     * Display a listing of posts of users followed by the logged in user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /*
     * Display the specified post.
     *
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Post $post)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($post->user->id) : false;

        return view('posts.show', compact('post', 'follows'));
    }

    /**
     * Show the form for creating a post.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:20480']
        ]);

        $imagePath =request('image')->store('uploads', 'public');

        $image = Image::read(public_path('storage/' . $imagePath))->resize(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }
}
