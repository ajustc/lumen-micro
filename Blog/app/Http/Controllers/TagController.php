<?php

namespace App\Http\Controllers;

use App\Models\TagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function index()
    {
        $data = TagModel::all();
        
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
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 500,
                'data' => $validator->errors(),
            ], 500);
        }

        $check = TagModel::where('title', $request->title)->first();
        if (!empty($check)) {
            return response()->json([
                'code'    => 500,
                'message' => 'Title already exist',
            ], 500);
        }

        try {
            TagModel::create([
                'title' => $request->title,
                'slug' => \Illuminate\Support\Str::slug($request->title),
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
                'data'    => [],
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function show(Request $request, $id)
    {
        $getTag = TagModel::find($id);

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
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 500,
                'data' => $validator->errors(),
            ], 500);
        }

        $check = TagModel::where('title', $request->title)->where('id', '!=', $id)->first();
        if (!empty($check)) {
            return response()->json([
                'code'    => 500,
                'message' => 'Title already exist',
            ], 500);
        }

        try {
            TagModel::where('id', $id)->update([
                'title' => $request->title,
                'slug' => \Illuminate\Support\Str::slug($request->title),
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
        $getTag = TagModel::find($id)->first();
        if (empty($getTag)) {
            return response()->json([
                'code'    => 404,
                'message' => 'Data not found',
            ], 404);
        }

        try {
            TagModel::find($id)->delete();
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
