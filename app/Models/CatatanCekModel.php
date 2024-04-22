<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanCekModel extends Model
{
    use HasFactory;
    protected $table = 'catatan_cek';
    protected $guarded = [];
    public function partIncoming()
    {
        return $this->belongsTo(dataPartIncoming::class, 'id_part_supply', 'id_part_supply');
    }

    public function standarPart()
    {
        return $this->belongsTo(StandarPerPartModel::class, 'id_standar_part', 'id_standar_part');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'id_part', 'kode_part');
    }
}
