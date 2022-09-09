<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
Use App\Lib\Helper;

class UploadFotoController extends Controller
{
    public function uploadFoto(Request $request){
        $model_name = $request->model_name;
        $id         = $request->id;
        $root       = $request->root;
        $foto       = $request->foto;
        $filename   = $request->filename;
        
        $data = $model_name::find($id);

        $path = base_path().'/public/storage/'.$root.'/';
        $file = Helper::uploadPhoto($foto,$path,1000,$filename);

        return response()->json($file);
    }
}
