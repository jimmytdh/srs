<?php

namespace App\Http\Controllers\admin;

use App\Designation;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data = self::getData();
        $designation = Designation::orderBy('description','asc')->get();
        $section = Section::orderBy('description','asc')->get();

        return view('admin.user',[
            'title' => 'List of Users',
            'data' => $data,
            'menu' => 'users',
            'designation' => $designation,
            'section' => $section
        ]);
    }

    public function getData()
    {
        $data = User::where('level','standard')
            ->select('user.*','section.code as section_name','designation.code as designation_name')
            ->leftJoin('section','section.id','=','user.section')
            ->leftJoin('designation','designation.id','=','user.designation')
            ->orderBy('lname','asc')
            ->paginate(30);

        return $data;
    }

    public function save(Request $req)
    {
        $check = User::where('username',$req->username)->first();
        if($check){
            return redirect('admin/users')
                ->with('status',array(
                    'title' => 'Duplicate',
                    'msg' => "Username is already taken. Please try different username!",
                    'status' => 'error'
                ));
        }

        $data = array(
            'fname' => ucwords($req->fname),
            'lname' => ucwords($req->lname),
            'sex' => $req->sex,
            'dob' => $req->dob,
            'contact' => $req->contact,
            'email' => $req->email,
            'address' => $req->address,
            'section' => $req->section,
            'designation' => $req->designation,
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'picture' => 'default.png',//self::uploadPicture($_FILES['picture'],$req->username),
            'level' => 'standard',
            'status' => 1,
        );

        User::create($data);
        return redirect()->back()->with('status', array(
            'title' => 'Saved',
            'msg' => ucwords($req->fname)." ".ucwords($req->lname)." successfully added!",
            'status' => 'success'
        ));
    }

    function uploadPicture($file,$name)
    {
        $path = 'upload';
        $size = getimagesize($file['tmp_name']);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_name = $name.'.'.$ext;
        if($size==FALSE){
            $name = 'default.jpg';
        }else{
            //create thumb
            $src = $path.'/'.$new_name;
            $dest = $path.'/thumbs/'.$new_name;
            $desired_width = 250;

            //move uploaded file to a directory
            move_uploaded_file($file['tmp_name'],$path.'/'.$new_name);
            move_uploaded_file($file['tmp_name'],$path.'/thumbs/'.$new_name);
            //$this->make_thumb($src, $dest, $desired_width,$ext);


            $new_ext = self::resize($desired_width,$dest,$src);
            $name = $name.'.'.$new_ext;
        }
        return $name;
    }

    function resize($newWidth, $targetFile, $originalFile) {

        $info = getimagesize($originalFile);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                $new_name = $targetFile;
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                $new_name = $targetFile;
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                $new_name = $targetFile;
                break;

            default:
                throw new Exception('Unknown image type.');
        }

        $img = $image_create_func($originalFile);
        list($w, $h) = getimagesize($originalFile);
        $height = $newWidth;
        $width = $newWidth;

        if($w > $h) {
            $new_height =   $height;
            $new_width  =   floor($w * ($new_height / $h));
            $crop_x     =   ceil(($w - $h) / 2);
            $crop_y     =   0;
        }
        else {
            $new_width  =   $width;
            $new_height =   floor( $h * ( $new_width / $w ));
            $crop_x     =   0;
            $crop_y     =   ceil(($h - $w) / 2);
        }

        $tmp = imagecreatetruecolor($width, $height);
        imagecopyresampled($tmp, $img, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $w, $h);
        $image_save_func($tmp, "$new_name");


        return $new_image_ext;
    }

    public function edit($id)
    {
        $info = User::find($id);
        if(!$info){
            return redirect('admin/users')
                ->with('status',array(
                    'title' => 'Access Denied',
                    'msg' => "You don't have access to this user!",
                    'status' => 'error'
                ));
        }
        $data = self::getData();
        $designation = Designation::orderBy('description','asc')->get();
        $section = Section::orderBy('description','asc')->get();

        return view('admin.user',[
            'title' => "$info->fname $info->lname",
            'edit' => true,
            'info' => $info,
            'data' => $data,
            'menu' => 'users',
            'designation' => $designation,
            'section' => $section
        ]);
    }

    public function update(Request $req, $id)
    {
        $check = User::where('username',$req->username)
                ->where('id','<>',$id)
                ->first();
        if($check){
            return redirect('admin/users')
                ->with('status',array(
                    'title' => 'Duplicate',
                    'msg' => "Username is already taken. Please try different username!",
                    'status' => 'error'
                ));
        }

        $data = array(
            'fname' => ucwords($req->fname),
            'lname' => ucwords($req->lname),
            'sex' => $req->sex,
            'dob' => $req->dob,
            'contact' => $req->contact,
            'email' => $req->email,
            'address' => $req->address,
            'section' => $req->section,
            'designation' => $req->designation,
            'username' => $req->username,
            'level' => 'standard',
            'status' => 1,
        );

//        if($_FILES['picture']['name']){
//            $data['picture'] = self::uploadPicture($_FILES['picture'],$req->username);
//        }
        if($req->password){
            $data['password'] = bcrypt($req->password);
        }

        $user = User::find($id)
                    ->update($data);

        return redirect()->back()->with('status', array(
            'title' => 'Updated',
            'msg' => ucwords($req->fname)." ".ucwords($req->lname)." successfully updated!",
            'status' => 'success'
        ));
    }
}
