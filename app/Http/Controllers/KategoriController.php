<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class KategoriController extends Controller
{
    public $kategori;
    public function __construct()
    {
        $this->kategori = new kategori();
    }

    public function index(Request $request)
    {
        //menampilkan data dari tabel kategori
        //menggunakan sintaks eloquent
        // $data = Kategori::all();
        $cari = $request->get('search');

        //ini pake query builder, ada paginate ada simplePaginate
        $data = DB::table('kategori')
                ->where('kategori', 'LIKE', "%$cari%")
                // sintak ini dipakai kalau nyari data lebih dari 1 field 
                // ->orWhere('jumlah', 'LIKE', "%$cari%")
                ->paginate(5);

        //bikin angkanya di pagination ber urutan
        $no = 5 * ($data->currentPage() - 1);

        return view('master.kategori', compact('data','no','cari'));
    }

   
    public function create()
    {
        return view('master.create');
    }

  
    
    public function store(Request $request)
    {
        //tangkep dulu inputan user
        // dd($request->all()); 

        //validasi v.1
        // $validated = $request->validate([
        //     'nama_kategori' => 'required'
        // ]);

        //validasi v.2
        //aturan main
        $rules=[
            //format penulisan unique = unique:nama_table,field_table
            'nama_kategori' => 'required|min:3|max:20|unique:kategori,kategori'
        ];
        //bikin pesan error
        $messages=[
            'required' => ':attribut gak boleh kosong',
            'min' => ':attribute minimal harus 3 huruf',
            'max' => ':attribute maximal 20 huruf',
            'unique' => ':attribute sudah ada, silahkan gunakan nama yang ada'
        ];
        //eksekusi fungsinya
        $this->validate($request, $rules, $messages);

        //pasangkan ke field tabelnya dengan kiriman user , nama_kategori itu dari form
        //kategori pertama dari variable, yang kedua dari field
        $this->kategori->kategori = $request->nama_kategori;
        //lalu simpan ke database
        $this->kategori->save();
        Alert::success('Success Title', 'Success Message');

        //redirect
        //ini gak pakek sweetalert
        // return redirect()->route('kategori')->with('status','Successfull...! Data berhasil disimpan');
        // //ini yang pakek sweet alert
        return redirect()->route('kategori');
    }

   
    public function show(string $id)
    {
        //ngelihat data
        $kategori = Kategori::findOrFail($id);

        //buat ngecheck data
        // dd($kategori); 
        return view('master.show', compact('kategori'));
    }

    
    public function edit($id)
    {
        //redirect kehalaman edit
        $kategori = Kategori::findOrFail($id);

        return view('master.edit', compact('kategori'));
    }

   
    public function update(Request $request, $id)
    {
        //mengubah data
        $update = Kategori::findOrFail($id);

        //cek ada perubahan atau gak?
        //isDirty() buat ngecheck  field table ada perubahan atau gak

        $update->kategori = $request->nama_kategori;
        if ($update->isDirty()) {
            // echo 'ada perubahan';
            $rules=[
            'nama_kategori' => 'required|min:3|max:20'
        ];
        //bikin pesan error
        $messages=[
            'required' => ':attribut gak boleh kosong',
            'min' => ':attribute minimal harus 3 huruf',
            'max' => ':attribute maximal harus 20 huruf',
            'unique' => ':attribute sudah ada, silahkan gunakan nama yang ada'
        ];

        $this->validate($request, $rules, $messages);

        //pasangkan ke field tabelnya dengan kiriman user , nama_kategori itu dari form
        //kategori pertama dari variable, yang kedua dari field
        // $this->kategori->kategori = $request->nama_kategori;
        //lalu simpan ke database
        $update->kategori = $request->nama_kategori;

        $update->save();

        Alert::success('Success Title', 'Success Message');
        return redirect()->route('kategori');

        } else {
            return redirect()->route('kategori');
        }
        
    }

    
    public function destroy(string $id)
    {
        //ambil data sesuai dengan ID nya
        $kategori = Kategori::findOrFail($id);
        //fungsi buat ngapus data
        $kategori->delete();

        Alert::success('Successfull', 'Data berhasil dihapus');
        return redirect()->route('kategori');
    }

    public function history() {
        //
    }
}
