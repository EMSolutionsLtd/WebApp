<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempFile;

class TempImageController extends Controller
{
    public function upload(Request $request){
        $temp = new TempFile;
        $temp->name = 'Temp Value';
        $temp->save();

        $image = $request->file('file');

        $destinationPath = './uploads/temp/';

        $extension = $image->getClientOriginalExtension();
        $newFileName = $temp->id.'.'.$extension;
        $image->move($destinationPath, $newFileName);

        $temp->name = $newFileName;
        $temp->save();

        return response()->json([
            'status' => 200,
            'id' => $temp->id,
            'name' => $newFileName
        ]);
    }
}
