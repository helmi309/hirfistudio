<?php

namespace App\Domain\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Entities extends Model
{

    /**
     * Method "booting" Model.
     *
     * @return void
     */
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }

}
