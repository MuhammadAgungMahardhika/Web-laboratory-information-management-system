<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Blameable
{
    protected static function bootBlameable()
    {


        static::creating(function ($model) {
            // Jangan overwrite jika sudah diset (misalnya dari import)
            if (empty($model->created_by) && Auth::check()) {
                $model->created_by = Auth::user()->name;
            }
        });

        static::updating(function ($model) {
            // Jangan overwrite jika sudah diset (misalnya dari import)
            if (empty($model->updated_by) && Auth::check()) {
                $model->updated_by = Auth::user()->name;
            }
        });
    }
}
