<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

use App\StoryModel;
use App\ImageModel;

class ImageController extends Controller
{
    function upload(Request $request)
    {
    	$this->validate($request, [
    		'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:100000',
    	]);
    	$id = Auth::id();
    	$image = $request->file('image');
    	$chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
	    $filename = $id.time().str_replace($chrc, '', $image->getClientOriginalName());

	    //saving to database
	    $data = ['image' => $filename, 'id' => $id];
	    ImageModel::AddImage($data);

	    //saving image to server
	    $destination = public_path('story/images/');
	    $image->move($destination, $filename);

	    echo $filename;
	}
	function publish(Request $request)
    {
    	$id = Auth::id();
    	$cover = $request['cover'];
    	$content = $request['content'];
    	$adult = 0;
    	$commenting = 0;

    	//setting cover
    	$this->validate($request, [
    		'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
    	]);
    	$image = $request->file('cover');
    	$chrc = array('[',']','@',' ','+','-','#','*','<','>','_','(',')',';',',','&','%','$','!','`','~','=','{','}','/',':','?','"',"'",'^');
	    $filename = $id.time().str_replace($chrc, '', $image->getClientOriginalName());

	    //create thumbnail
	    $destination = public_path('story/thumbnails/'.$filename);
	    $img = Image::make($image->getRealPath());
	    $img->resize(400, 400, function ($constraint) {
	    	$constraint->aspectRatio();
	    })->save($destination);

	    //create image real
	    $destination = public_path('story/covers/');
	    $image->move($destination, $filename);

    	$data = array(
    		'description' => $content,
    		'cover' => $filename,
    		'id' => $id
    	);

    	$rest = StoryModel::AddStory($data);
    	if ($rest) {
    		$dt = StoryModel::GetID();
            $this->mentions($request['tags'], $dt);
    		echo $dt;
    	} else {
    		echo "failed";
    	}
    }
}
