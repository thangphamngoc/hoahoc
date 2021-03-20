<?php

namespace App\Http\Controllers;

use App\Model\ExPostImage;
use App\Model\ImageSpa;
use App\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $postList = DB::table('posts')
            ->where('posts.del_active', true)
            ->orderBy('posts.created_at', 'desc')
            ->get();
        return response($postList);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $post = Post::create([
            'create_by' => Auth::user()->name,
            'id_create' => Auth::user()->id,
            'user_id' => Auth::user()->id,
            'content' => $request->content,
            'title' => $request->title,
        ]);
        // $files = $request->file('photos');
        // dd($files);
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                if ($file instanceof UploadedFile) {
                    $nameUrl = time() . '_' . $file->getClientOriginalName();


                    $uploadPath = public_path('upload');
                    $file->move($uploadPath, $nameUrl);
                    $filename = "upload/".$nameUrl;

                    // $filename = $file->storePublicly('images', [
                    //     'disk' => 'public'
                    // ], $nameUrl);



                    $image = ImageSpa::create([
                        'filename' => $filename,
                    ]);
                    ExPostImage::create([
                        'image_spas_id' => $image->id,
                        'post_id' => $post->id,
                    ]);
                }
            }
        }
        return response()->json(['success' => 'You have successfully create daytotal.']);
    }


    public function update(Request $request)
    {
        $postOld = Post::find($request->route('id'));
        $postOld->title =  $request->title;
        $postOld->content = $request->content;
        $postOld->save();
    }
    public function deletePost(Request $request)
    {
        $nickOld = Post::find($request->route('id'));
        $nickOld->del_active = false;
        $nickOld->save();
    }
}
