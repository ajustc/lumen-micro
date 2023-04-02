<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function index()
    {
        $data = PostModel::all();
        
        try {
            $response = [
                'code' => 200,
                'data' => $data,
            ];
        } catch (\Throwable $th) {
            $response = [
                'code' => 404,
                'data' => $th->getMessage(),
            ];
        }

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories_id' => 'required',
            'tag_id'        => 'required',
            'title'         => 'required',
            'description'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 500,
                'data' => $validator->errors(),
            ], 500);
        }

        $check = PostModel::where('title', $request->title)->first();
        if (!empty($check)) {
            return response()->json([
                'code'    => 500,
                'message' => 'Title already exist',
            ], 500);
        }

        try {
            PostModel::create([
                'categories_id' => $request->categories_id,
                'tag_id'        => $request->tag_id,
                'title'         => $request->title,
                'slug'          => \Illuminate\Support\Str::slug($request->title),
                'description'   => $request->description,
            ]);
            $response = [
                'code'    => 201,
                'message' => 'Success',
                'data'    => [],
            ];
        } catch (\Throwable $th) {
            $response = [
                'code'    => 500,
                'message' => 'Failed',
                'data'    => $th->getMessage(),
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function show(Request $request, $id)
    {
        $getTag = PostModel::find($id);

        if (empty($getTag)) {
            return response()->json([
                'code'    => 404,
                'message' => 'Data not found',
            ], 404);
        }

        try {
            $response = [
                'code'    => 200,
                'message' => 'Success',
                'data'    => $getTag,
            ];
        } catch (\Throwable $th) {
            $response = [
                'code'    => 500,
                'message' => 'Failed',
                'data'    => [],
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'categories_id' => 'required',
            'tag_id'        => 'required',
            'title'         => 'required',
            'description'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 500,
                'data' => $validator->errors(),
            ], 500);
        }

        $check = PostModel::where('title', $request->title)->where('id', '!=', $id)->first();
        if (!empty($check)) {
            return response()->json([
                'code'    => 500,
                'message' => 'Title already exist',
            ], 500);
        }

        try {
            PostModel::where('id', $id)->update([
                'categories_id' => $request->categories_id,
                'tag_id'        => $request->tag_id,
                'title'         => $request->title,
                'slug'          => \Illuminate\Support\Str::slug($request->title),
                'description'   => $request->description,
            ]);
            $response = [
                'code'    => 200,
                'message' => 'Success',
                'data'    => [],
            ];
        } catch (\Throwable $th) {
            $response = [
                'code'    => 500,
                'message' => 'Failed',
                'data'    => [],
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function delete(Request $request, $id)
    {
        $getTag = PostModel::find($id)->first();
        if (empty($getTag)) {
            return response()->json([
                'code'    => 404,
                'message' => 'Data not found',
            ], 404);
        }

        try {
            PostModel::find($id)->delete();
            $response = [
                'code'    => 200,
                'message' => 'Success',
                'data'    => [],
            ];
        } catch (\Throwable $th) {
            $response = [
                'code'    => 500,
                'message' => 'Failed',
                'data'    => [],
            ];
        }

        return response()->json($response, $response['code']);
    }
}
