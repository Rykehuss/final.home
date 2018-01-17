<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function report() {
        return $this->belongsTo(Report::class);
    }

    public function scopeOwned($query) {
        return $query->where('created_by', Auth::user()->id);
    }
}
