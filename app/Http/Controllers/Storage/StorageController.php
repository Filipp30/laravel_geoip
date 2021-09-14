<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller{

    public function put(Request $request){
        $file_name = Storage::disk('sftp')->put('files',$request->file('file'));

        return response([
            'file_name'=>$file_name
        ],201);
    }

    public function delete($dir,$file_name){
        $file_path = $dir.'/'.$file_name;
        $res = Storage::disk('sftp')->delete($file_path);
        $exists = Storage::disk('sftp')->exists($file_path);
        $missing = Storage::disk('sftp')->missing($file_path);

        return response([
            'delete'=>$res,
            'exists'=>$exists,
            'missing'=>$missing,
            'dir_name'=>$dir,
            'file_name'=>$file_name
        ],201);
    }

    public function download($dir,$file_name){
        $file_path = $dir.'/'.$file_name;
        $exists = Storage::disk('sftp')->exists($file_path);

        if ($exists){
            return Storage::disk('sftp')->download($file_path);
        }else{
            return response([
                'exists'=>$exists,
                'dir_name'=>$dir,
                'file_name'=>$file_name
            ],201);
        }
    }

    public function exists($dir,$file_name){
        $file_path = $dir.'/'.$file_name;
        $exists = Storage::disk('sftp')->exists($file_path);
        $missing = Storage::disk('sftp')->missing($file_path);

        return response([
            'exists'=>$exists,
            'missing'=>$missing,
            'dir_name'=>$dir,
            'file_name'=>$file_name
        ],201);
    }

}
