<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Template extends Model
{
    protected $fillable = [
        'name',
        'content',
    ];

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
