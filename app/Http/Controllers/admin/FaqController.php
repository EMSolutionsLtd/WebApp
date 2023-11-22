<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(Request $request) {
        $faqs = Faq::orderBy('created_at', 'DESC');

        if(!empty($request->keyword)) {
            $faqs = $faqs->where('question', 'like', '%'.$request->keyword.'%');
        }
        $faqs = $faqs->paginate(10);

        $data['faqs'] = $faqs;

        return view('admin.faq.list', $data);
    }

    public function create(Request $request) {
        return view('admin.faq.create');
    }

    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'question' => 'required'
        ]);

        if($validator->passes()) {

            Faq::insert([
                'question' => $request->question,
                'answer' => $request->answer,
                'status' => $request->status
            ]);

            $request->session()->flash('success', 'Faq Created Successfully');

            return response()->json([
                'status' => 200,
                'message' => 'Faq Created Successfully'
            ]);

        } else {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request) {

        $faq = Faq::where('id', $id)->first();
        if($faq == null) {
            $request->session()->flash('error', 'Faq Not Found');
            return redirect()->route('faqList');
        }

        $data['faq'] = $faq;

        return view('admin.faq.edit', $data);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'question' => 'required'
        ]);

        if($validator->passes()) {

            $faq = Faq::where('id', $id)->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'status' => $request->status
            ]);

            $request->session()->flash('success', 'Faq Updated Successfully');

            return response()->json([
                'status' => 200,
                'message' => 'Faq Updated Successfully'
            ]);

        } else {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function delete($id, Request $request) {
        Faq::where('id', $id)->delete();

        $request->session()->flash('success', 'Faq Deleted Successfully');

        return response()->json([
            'status' => 200,
        ]);
    }
}
