<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    public $table = "laporan";

    protected $guarded = ['id'];  
    

    public function kategori_part()
    {
        return $this->belongsTo(kategoriPart::class, 'model', 'id_kategori');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'part_code', 'kode_part');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id_supplier');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_person', 'id');
    }
}
