<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasantriController extends Controller
{
    //
    public function index(Request $request) 
    {
        $cari = $request->get('cari');
        $mahasantri = [
            [
                "id" => 1,
                "nama" => "samsul"
            ],
            [
                "id" => 2,
                "nama" => "asep"
            ],
            [
                "id" => 3,
                "nama" => "bopak"
            ]
        ];
        // return "apa-apa";
        // (/) bisa diganti (.)
        return view('mahasantri/index',compact('mahasantri', 'cari'));
    }

    
    //
    public function  getid($id) 
    {
        $idd = $id;
        $data = [
            [
                "id" => 1,
                "nama" => "samsul"
            ],
            [
                "id" => 2,
                "nama" => "asep"
            ],
            [
                "id" => 3,
                "nama" => "bopak"
            ]
        ];
        // return "apa-apa";
        // (/) bisa diganti (.)
         // bisa menggunakan compact() atau menggunakan array
            // return view('mahasantri/edit',compact('idd'));
        return view('mahasantri/edit',compact('data','idd'));
    }
    
    public function cari(Request $request)
    {
        $cari = $request->get('cari');
        return view('mahasantri/cari', compact('cari'));
    }
}


