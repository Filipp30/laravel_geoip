<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller{

    public function put(Request $request){
        $status = Storage::disk('sftp')->put('files',$request->file('file'));
        return response([
            'status'=>$status
        ],201);
    }


}
