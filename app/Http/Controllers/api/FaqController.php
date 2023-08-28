<?php


namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index() {
        $faq = Faq::all();

        $data = FaqResource::collection($faq);

        if($data) {
            return response()->json([
                'message' => 'success',
                'faq' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function show(Faq $faq) {
        $data = new FaqResource($faq);

        if($data) {
            return response()->json([
                'message' => 'success',
                'faq' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'answer' => 'required',
        ]);

        $result = Faq::create($validatedData);
        $data = new FaqResource($result);

        if($data) {
            return response()->json([
                'message' => 'success',
                'faq' => $data 
            ], 200);
        }
        
        return response()->json([
            'message' => 'error',
        ], 500);
    }

    public function update(Request $request, Faq $faq)
    {
        $rules =[
            'title' => 'required',
            'slug' => 'required',
            'answer' => 'required',
        ];

        if($request->slug != $faq->slug) {
            $rules['slug'] = 'required';
        }

        $validatedData = $request->validate($rules);

        $result = Faq::where('id', $faq->id)
            ->update($validatedData);

        if($result !== 0) {
            return response()->json([
                "message" => "Update Faq Success"
            ], 200);
        } 

        return response()->json([
            "message" => "Update Faq Failed"
        ], 400);
    }

    public function destroy(Faq $faq)
    {
        $result = Faq::destroy($faq->id);

        if($result !== 0) {
            return response()->json([
                "message" => "Delete Faq Success"
            ], 200);
        } 

        return response()->json([
            "message" => "Delete Faq Failed"
        ], 400);
    }
}