<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

trait AsList
{
    public static function getAsList($key = 'id', $value = 'name'){
        return static::latest()->owned()->pluck($value, $key);
    }
};

trait Boot
{
    public static function boot()
    {
        parent::boot();

        static::updating(function ($table) {
            $table->updated_by = Auth::user()->id;
        });

        static::creating(function ($table) {
            $table->created_by = Auth::user()->id;
            $table->updated_by = Auth::user()->id;
        });
    }
}