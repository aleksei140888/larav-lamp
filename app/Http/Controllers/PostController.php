<?php

namespace App\Http\Controllers;
use Auth;
use App\Posts;
use App\User;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller {

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        // если пользователь может публиковать автор или администратор
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        $post = new Posts();
        $post->title = $request->input('title');
        $post->content = $request->input('body');
        $post->summary = str_limit($post->content, 100);
        $post->slug = str_slug($post->title);
        $post->user_id = Auth::user()->id;
        $post->save();
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug){
        $post = Posts::where('slug',$slug)->first();
        if(!$post){
            return redirect('/')->withErrors('запрошенная страница не найдена');
        }
        $comments = $post->comments;
        return view('posts.show')->withPost($post)->withComments($comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id){
        $post = Posts::where('id',$id)->first();
        if($post && ($request->user()->id == $post->user_id))
            return view('posts/edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $post_id = $request->input('post_id');
        $post = Posts::find($post_id);
        if($post && ($post->user_id == $request->user()->id)){
            $title = $request->input('title');
            $slug = str_slug($title);
            $duplicate = Posts::where('slug',$slug)->first();
            if($duplicate){
                if($duplicate->id != $post_id){
                    return redirect('edit/'.$post->slug)->withErrors('Title already exists.')->withInput();
                }
                else{
                    $post->slug = $slug;
                }
            }
            $post->title = $title;
            $post->body = $request->input('content');
            if($request->has('save'))
            {
                $post->active = 0;
                $message = 'Post saved successfully';
                $landing = 'edit/'.$post->slug;
            }
            else{
                $post->active = 1;
                $message = 'Post updated successfully';
                $landing = $post->slug;
            }
            $post->save();
            return redirect($landing)->withMessage($message);
        }
        else{
            return redirect('/')->withErrors('у вас нет достаточных прав');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
        $post = Posts::find($id);
        if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())){
            $post->delete();
            $data['message'] = 'Пост успешно удалён';
        }
        else {
            $data['errors'] = 'Неправильная операция. У вас нет достаточных прав';
        }
        return redirect('/')->with($data);
    }
}