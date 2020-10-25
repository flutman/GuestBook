<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('welcome')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate date
        $this->validate($request, array(
            'post_text' => 'required|min:10',
        ));
        //store data
        $post = new Post;
        $post->text = $request->input('post_text');

        if (Auth::user() !== null) {
            $post->user_id = Auth::user()->id;
        }
        $post->save();

        $postResponse = array(
            "user" => Auth::user() !== null ? Auth::user()->name : "Аноним",
            "date" => date('M j, Y H:i', strtotime($post->updated_at)),
            "text" => $post->text,
            "post_id" => $post->id
        );

        return response(json_encode($postResponse))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $postResponse = array(
            "text" => $post->text,
            "post_id" => $post->id
        );
        return response(json_encode($postResponse))
            ->header('Content-Type', 'application/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->text = $request->input('post_text');;
        $post->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user() !== null && Post::find($id)->exists()) {
            Post::find($id)->delete();
            $postResponse = array("id" => $id);
            return response(json_encode($postResponse), 200)
                ->header('Content-Type', 'application/json');
        }
        return response(json_encode("post not found"), 404);
    }

}
