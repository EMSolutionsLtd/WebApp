<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Models\Page;
use App\Models\TempFile;

class PageController extends Controller
{
    public function index(Request $request){
        $pages = Page::orderBy('created_at', 'DESC');

        if(!empty($request->keyword)) {
            $pages = $pages->where('name', 'like', '%'.$request->keyword.'%');
        }

        $data['pages'] = $pages->paginate(10);

        return view('admin.pages.list', $data);
    }

    public function create(){
        return view('admin.pages.create');
    }

    public function save(Request $request) {
        // This method will save the page into DB
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->passes()) {
            $page = new Page;
            $page->name = $request->name;
            $page->content = $request->content;
            $page->status = $request->status;
            $page->save();

            if($request->image_id > 0) {
                $tempImage = TempFile::where('id', $request->image_id)->first();
                $tempFilename = $tempImage->name;
                $imageArray = explode('.', $tempFilename);
                $ext = end($imageArray);

                $newFileName = 'page-'.$page->id.'.'.$ext;

                $sourcePath = './uploads/temp/'.$tempFilename;

                // Generate small Thumb
                $dPath = './uploads/pages/thumb/small/'.$newFileName;
                $img = Image::make($sourcePath);
                $img->fit(360, 220);
                $img->save($dPath);

                // Generate large Thumb
                $dPath = './uploads/pages/thumb/large/'.$newFileName;
                $img = Image::make($sourcePath);
                $img->resize(1150, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($dPath);

                $page->image = $newFileName;
                $page->save();

                File::delete($sourcePath);
            }

            $request->session()->flash('success', 'Page Created Successfully');

            return response()->json([
                'status' => 200
            ]);

        } else {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request) {
        $page = Page::where('id', $id)->first();

        if(empty($page)) {
            $request->session()->flash('error', 'Record Not Found in DB');
            return redirect()->route('pageList');
        }

        $data['page'] = $page;

        return view('admin.pages.edit', $data);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->passes()) {
            $page = Page::find($id);
            $page->name = $request->name;
            $page->content = $request->content;
            $page->status = $request->status;
            $page->save();

            $oldImageName = $page->image;

            if($request->image_id > 0) {
                $tempImage = TempFile::where('id', $request->image_id)->first();
                $tempFilename = $tempImage->name;
                $imageArray = explode('.', $tempFilename);
                $ext = end($imageArray);

                $newFileName = 'page-'.$page->id.'.'.$ext;

                $sourcePath = './uploads/temp/'.$tempFilename;

                // Generate small Thumb
                $dPath = './uploads/pages/thumb/small/'.$newFileName;
                $img = Image::make($sourcePath);
                $img->fit(360, 220);
                $img->save($dPath);

                // Delete old small thumbnail
                $sourcePathSmall = './uploads/pages/thumb/small/'.$oldImageName;
                File::delete($sourcePathSmall);

                // Generate large Thumb
                $dPath = './uploads/pages/thumb/large/'.$newFileName;
                $img = Image::make($sourcePath);
                $img->resize(1150, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($dPath);

                // Delete old large thumbnail
                $sourcePathLarge = './uploads/pages/thumb/large/'.$oldImageName;
                File::delete($sourcePathLarge);

                $page->image = $newFileName;
                $page->save();

                File::delete($sourcePath);
            }

            $request->session()->flash('success', 'Page Updated Successfully');

            return response()->json([
                'status' => 200
            ]);

        } else {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function delete($id, Request $request) {
        $page = Page::where('id', $id)->first();

        if(empty($page)) {

            $request->session()->flash('error', 'Record not found');

            return response()->json([
                'status' => 0
            ]);
        }

        $path = './uploads/pages/thumb/small/'.$page->image;
        File::delete($path);

        $path = './uploads/pages/thumb/large/'.$page->image;
        File::delete($path);

        $page->delete();

        $request->session()->flash('success', 'Page deleted successfully!');

        return response()->json([
            'status' => 200
        ]);
    }

    public function deleteImage(Request $request) {
        $page = Page::find($request->id);
        $oldImage = $page->image;

        $page->image = '';
        $page->save();

        File::delete('./uploads/pages/thumb/small/'.$oldImage);
        File::delete('./uploads/pages/thumb/large/'.$oldImage);

        return response()->json([
            'status' => 200
        ]);
    }
}
