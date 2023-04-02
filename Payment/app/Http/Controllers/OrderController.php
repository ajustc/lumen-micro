<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $data = OrderModel::all();
        
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
            'purchase_total' => 'required',
            'address'        => 'required',
            'status'         => 'required',
            'total_weight'   => 'required',
            'province'       => 'required',
            'district'       => 'required',
            'type'           => 'required',
            'postal_code'    => 'required',
            'courier'        => 'required',
            'package'        => 'required',
            'cost'           => 'required',
            'estimate'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 500,
                'data' => $validator->errors(),
            ], 500);
        }

        $token = $request->header('SUNTOKEN');
        $getUser = User::where('token', $token)->first();

        DB::beginTransaction();
        try {
            OrderModel::create([
                'user_id'          => $getUser->id,
                'purchase_total'   => $request->purchase_total,
                'address'          => $request->address,
                'status'           => $request->status,
                'delivery_receipt' => null,
                'total_weight'     => $request->total_weight,
                'province'         => $request->province,
                'district'         => $request->district,
                'type'             => $request->type,
                'postal_code'      => $request->postal_code,
                'courier'          => $request->courier,
                'package'          => $request->package,
                'cost'             => $request->cost,
                'estimate'         => $request->estimate,
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
        $getData = OrderModel::find($id);

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
            'purchase_total' => 'required',
            'address'        => 'required',
            'status'         => 'required',
            'total_weight'   => 'required',
            'province'       => 'required',
            'district'       => 'required',
            'type'           => 'required',
            'postal_code'    => 'required',
            'courier'        => 'required',
            'package'        => 'required',
            'cost'           => 'required',
            'estimate'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 500,
                'data' => $validator->errors(),
            ], 500);
        }

        $token = $request->header('SUNTOKEN');
        $getUser = User::where('token', $token)->first();

        DB::beginTransaction();
        try {
            OrderModel::where('id', $id)->update([
                'user_id'          => $getUser->id,
                'purchase_total'   => $request->purchase_total,
                'address'          => $request->address,
                'status'           => $request->status,
                'delivery_receipt' => null,
                'total_weight'     => $request->total_weight,
                'province'         => $request->province,
                'district'         => $request->district,
                'type'             => $request->type,
                'postal_code'      => $request->postal_code,
                'courier'          => $request->courier,
                'package'          => $request->package,
                'cost'             => $request->cost,
                'estimate'         => $request->estimate,
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
        $getData = OrderModel::find($id)->first();
        if (empty($getData)) {
            return response()->json([
                'code'    => 404,
                'message' => 'Data not found',
            ], 404);
        }

        try {
            OrderModel::find($id)->delete();
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
