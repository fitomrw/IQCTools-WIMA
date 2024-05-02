<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public $table = 'part';
    
    protected $primaryKey = 'kode_part';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id_supplier');
    }

    public function kategori_part()
    {
        return $this->belongsTo(kategoriPart::class, 'kategori_id', 'id_kategori');
    }

    public function dataPartIncoming()
    {
        return $this->hasMany(dataPartIncoming::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }

    public function standarPerPart()
    {
        return $this->hasMany(StandarPerPartModel::class);
    }
}
