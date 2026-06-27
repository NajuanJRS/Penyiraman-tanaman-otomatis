<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontroller extends Model
{
    protected $table = 'kontroller';
    protected $primaryKey = 'id_kontroller';
    public $timestamps = false;

    protected $fillable = [
        'mode_otomatis',
        'mode_manual',
    ];
}
