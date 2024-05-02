<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarPerPartModel extends Model
{
    use HasFactory;
    protected $table = 'standar_part';
    protected $guarded = [];

    public function standar()
    {
        return $this->belongsTo(StandarModel::class, 'id_standar', 'id_standar');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'kode_part', 'kode_part');
    }

}
