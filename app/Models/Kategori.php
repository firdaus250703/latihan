<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;

class Kategori extends Model
{
    use HasFactory;

    //ngasih tahu silaravel table yang saya pake itu bukan kategoriies
    //tapi kategori
    protected $table = "kategori";

    //buat ngilangin created_at dan updated_at
    public $timestamps = false;

    //ngasih tau kalau primarykey nya bukan id tapi yang lain
    // protected $primaryKey = 'id_kategory';


    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id', 'id');
    }
}
