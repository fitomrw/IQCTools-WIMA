<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataPartIncoming extends Model
{
    use HasFactory;

    // protected $primaryKey = 'kode_part';

    public $table = "tbl_part_in";

    protected $guarded = ['id_part_supply'];

    protected $primaryKey = 'id_part_supply';

    public function part()
    {
        return $this->belongsTo(Part::class, 'kode_part','kode_part');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id','id_supplier');
    }

    public function kategoriPart()
    {
        return $this->belongsTo(kategoriPart::class, 'kategori_id', 'id_kategori');
    }
    
}
