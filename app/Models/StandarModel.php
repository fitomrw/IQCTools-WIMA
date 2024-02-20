<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarModel extends Model
{
    use HasFactory;
    protected $table = 'standar';
    protected $primaryKey = 'id_standar';
    protected $guarded = ['id_standar'];

    public function standar_part()
    {
        return $this->hasMany(StandarPerPartModel::class, 'id_standar', 'id_standar');
    }
}
