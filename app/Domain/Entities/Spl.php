<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Spl.
 * @package App\Domain\Entities
 */
class Spl extends Entities
{

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'nama', 'jam_masuk', 'jam_keluar', 'pekerjaan', 'tanggal', 'penanggung_jawab', 'pin',
    ];

    protected $table ='spl';

}
