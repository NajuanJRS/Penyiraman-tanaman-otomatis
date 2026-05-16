<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perkembangan extends Model
{
    protected $table = 'perkembangan';
    protected $primaryKey = 'id_perkembangan';
    public $timestamps = false;

    protected $fillable = [
        'id_perkembangan',
        'waktu',
        'kelembapan_tanah',
        'kelembapan_udara',
        'suhu',
    ];

    public function prediksi()
    {
        return $this->hasOne(Prediksi::class, 'id_perkembangan', 'id_perkembangan');
    }
}
