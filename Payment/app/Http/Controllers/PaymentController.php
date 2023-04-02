<?php

namespace App\Http\Controllers;

use App\Models\PaymentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $data = PaymentModel::all();
        
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
            'order_id' => 'required',
            'name'     => 'required',
            'bank'     => 'required',
            'price'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 500,
                'data' => $validator->errors(),
            ], 500);
        }

        DB::beginTransaction();
        try {
            PaymentModel::create([
                'order_id' => $request->order_id,
                'name'     => $request->name,
                'bank'     => $request->bank,
                'price'    => $request->price,
                'date'     => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            $response = [
                'code'    => 201,
                'message' => 'Success',
                'data'    => [],
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
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
        $getData = PaymentModel::find($id);

        if (empty($getData)) {
            return response()->json([
                'code'    => 404,
                'message' => 'Data not found',
            ], 404);
        }

        try {
            $response = [
                'code'    => 200,
                'message' => 'Success',
                'data'    => $getData,
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
            'order_id' => 'required',
            'name'     => 'required',
            'bank'     => 'required',
            'price'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 500,
                'data' => $validator->errors(),
            ], 500);
        }

        DB::beginTransaction();
        try {
            PaymentModel::where('id', $id)->update([
                'order_id' => $request->order_id,
                'name'     => $request->name,
                'bank'     => $request->bank,
                'price'    => $request->price,
                'date'     => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
            $response = [
                'code'    => 200,
                'message' => 'Success',
                'data'    => [],
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'code'    => 500,
                'message' => 'Failed',
                'data'    => $th->getMessage(),
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function delete(Request $request, $id)
    {
        $getData = PaymentModel::find($id)->first();
        if (empty($getData)) {
            return response()->json([
                'code'    => 404,
                'message' => 'Data not found',
            ], 404);
        }

        try {
            PaymentModel::find($id)->delete();
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
