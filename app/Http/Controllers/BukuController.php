<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BukuController extends Controller
{
    public $buku;
    public function __construct()
    {
        $this->buku = new Buku();
    }
    public function index()
    {
        $no = 1;
        $buku = Buku::all();
        return view('buku.buku', compact('buku','no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //ngambil seluruh data dari table kategori
        $kategori = Kategori::all();
        return view('buku.create', compact('kategori')) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all()); 
        $rules=[
            //format penulisan unique = unique:nama_table,field_table
            'sampul' => 'required|mimes:jpg,png|max:80'
            // 'judul' => 'required|max:3'
        ];
        //bikin pesan error
        $messages=[
            'required' => 'isilah woiiii !!!',
            'max' => ':ukuran terlalu besar jumlah tidak sesuai',
            'mimes' => ':ekstensi file tidak di dukung, silahkan gunakan (jpg/png)'
        ];

        $this->validate($request, $rules, $messages);


        
        $gambar = $request->sampul;

        //getClientOriginalExtension() = untuk mendapatkan ekstensi file
        //getClientOriginalName() = untuk mendapatkan nama asli file
        $namaFile = time() .rand(100, 900). "." .$gambar->getClientOriginalExtension();
        $this->buku->sampul = $namaFile;
        $this->buku->judul = $request->judul;
        $this->buku->penulis = $request->penulis;
        $this->buku->deskripsi = $request->deskripsi;
        $this->buku->kategori_id = $request->kategori;


        //pindahin gambar asli ke dalam folder publik
        $gambar->move(public_path(). '/upload', $namaFile);

        $this->buku->save();
        return redirect()->route('buku.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(  $buku)
    {
        $no = 1;
        $show = Buku::findOrFail($buku);
        return view('buku.show', compact('show'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($buku)
    {
        $data = Buku::findOrFail($buku);
        $kategori = Kategori::all();
        return view ('buku.edit', compact('data','kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $buku)
    {
        $update = Buku::findOrFail($buku);
        
        
        $rules=[
            //format penulisan unique = unique:nama_table,field_table
            'sampul' => 'mimes:jpg,png|max:80',
            'judul' => 'required|min:3'
        ];
        //bikin pesan error
        $messages=[
            'required' => 'isilah woiiii !!!',
            'max' => ':ukuran terlalu besar jumlah tidak sesuai',
            'min' => ':atribut terlalu pendek',
            'mimes' => ':ekstensi file tidak di dukung, silahkan gunakan (jpg/png)'
        ];

        $this->validate($request, $rules, $messages);

        if (!$request->sampul) {
            $update->judul = $request->judul;
            $update->penulis = $request->penulis;
            $update->deskripsi = $request->deskripsi;
            $update->kategori_id = $request->kategori;
            $update->save();

            return redirect()->route('buku.index');
        }
        //gimana kalau nama gambarnya sama, sedangkan gambarnya berbeda?
        //replace gambar

        // if ($request->sampul) {
        //     # code...
        // }

        $gambar = $request->sampul;
        $namaFile = time() .rand(100, 900). "." .$gambar->getClientOriginalExtension();
        $gambar->move(public_path(). '/upload', $namaFile);

        $update->sampul = $namaFile;
        $update->judul = $request->judul;
        $update->penulis = $request->penulis;
        $update->deskripsi = $request->deskripsi;
        $update->kategori_id = $request->kategori;
        $update->save();

        return redirect()->route('buku.index');
        // $gambar = $request->sampul;
        // $update->sampul;

    }


    public function destroy( $buku)
    {
                //ambil data sesuai dengan ID nya
                $destroy = Buku::findOrFail($buku);
                //fungsi buat ngapus data
                $path = 'upload/'. $destroy->sampul;
                //ini kalau gambarnya ada di folder upload
                if (File::exists($path)) {
                    File::delete($path);
                }

                $destroy->delete();
        
                Alert::success('Successfull', 'Data berhasil dihapus');
                return redirect()->route('buku.index');
    }
}
