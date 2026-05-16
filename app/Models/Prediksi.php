<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    protected $table = 'prediksi';
    protected $primaryKey = 'id_prediksi';
    public $timestamps = false;

    protected $fillable = [
        'id_perkembangan',
        'decision',
    ];

    public function perkembangan()
    {
        return $this->belongsTo(Perkembangan::class, 'id_perkembangan');
    }
}
