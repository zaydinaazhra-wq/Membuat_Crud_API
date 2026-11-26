<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->get();
        return response()->json([
            'success' => true,      
            'message' => 'List Data Barang',
            'data'    => $barangs
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error.',
                'data'    => $validator->errors()
            ], 400);
        }

        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang Created Successfully.',
            'data'    => $barang
        ], 201);
    }

    public function show($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang Not Found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Barang',
            'data'    => $barang
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang Not Found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'deskripsi' => 'nullable',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error.',
                'data'    => $validator->errors()
            ], 400);
        }

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang Updated Successfully.',
            'data'    => $barang
        ], 200);
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang Not Found.',
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang Deleted Successfully.',
        ], 200);
    }
}
