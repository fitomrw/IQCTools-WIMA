<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public $table = "supplier";

    protected $guarded = ['id_supplier'];

    protected $primaryKey = 'id_supplier';

    public function part()
    {
        return $this->hasMany(Part::class);
    }

    public function dataPartIncoming()
    {
        return $this->hasMany(dataPartIncoming::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }

}
