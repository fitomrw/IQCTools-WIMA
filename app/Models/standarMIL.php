<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class standarMIL extends Model
{
    use HasFactory;

    public $table = "mil_std_105_e";

    protected $guarded = ['id'];
}
