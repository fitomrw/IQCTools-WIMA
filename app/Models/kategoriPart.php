<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoriPart extends Model
{
    use HasFactory;

    public $table = "kategori_part";

    protected $guarded = ['id_kategori'];

    protected $primaryKey = 'id_kategori';

    public function part()
    {
        return $this->hasOne(Part::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }

    public function dataPartIncoming()
    {
        return $this->hasMany(Laporan::class);
    }

}
