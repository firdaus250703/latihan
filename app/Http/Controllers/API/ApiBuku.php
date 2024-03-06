<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Validator;

class ApiBuku extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getData()
    {
        $data = Buku::all();
        //ini yang membedakan dengan route web
        //kalau API salah satunya bisa dibikin JSON datanya
        return response()->json([
            'status' => 'Success',
            'kategori' => $data
        ], 200);
    }

    public function show( $id)
    {
        $data = Buku::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'kategori' => $data
        ], 404);
    }


    public function destroy( $id)
    {
        $data = Buku::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'Success',
            'kategori' => $data
        ], 200);
    }



    public function store(Request $request)
    {
    $validate = Validator::make($request->all(), [
        'judul' => 'required|min:3|max:20',
        'deskripsi' => 'required|min:10|max:255',
        'penulis' => 'required|min:3|max:50',
        'sampul' => 'required|image|mimes:jpg,png,jpeg|max:2048', // Add validation for image
        'kategori_id' => 'required|exists:kategori,id', // Ensure kategori_id exists
    ]);

    if ($validate->fails()) {
        return response()->json($validate->errors(), 422);
    }

    
    $fileName = uniqid() . '.' . $request->sampul->getClientOriginalExtension();

   
    $request->sampul->storeAs('public/sampul', $fileName);

    $buku = Buku::create([
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'penulis' => $request->penulis,
        'sampul' => $fileName, 
        'kategori_id' => $request->kategori_id,
    ]);

    return response()->json([
        'status' => 'Success',
        'buku' => $buku
    ], 201);
    }



    public function update(Request $request, string $id)
    {
                //ada validasi
                $validate = Validator::make($request->all(), [
                    'sampul' => 'required|mimes:jpg,png|max:80'
                ]);
        
                //cek kalau validasi nya bermasalah
                if ($validate->fails()) {
                    return response()->json([$validate->errors(), 422]);
                }
        
                $buku = Buku::findOrFail($id);
                //simpen data
                $buku->update([
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'penulis' => $request->penulis,
                    'sampul' => $request->sampul,
                    'kategori_id' => $request->kategori_id,
                ]);
        
                //return (created)
                return response()->json([
                    'status' => 'Success',
                    'kategori' => $buku
                ], 200);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    

    /**
     * Display the specified resource.
     */
   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
   
}
