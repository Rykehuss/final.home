<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Report extends Model
{
    use Boot;
    use AsList;
    use CreatedUpdated;

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }

    public function records() {
        return $this->hasMany(Record::class);
    }

    public function scopeOwned($query) {
        return $query->where('created_by', Auth::user()->id);
    }
}
