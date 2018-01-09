<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use Boot;
    use AsList;
    use CreatedUpdated;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'content',
    ];

    public function campaigns(){
        return $this->hasMany(Campaign::class);
    }

    public function scopeOwned($query){
        return $query->where('created_by', Auth::user()->id);
    }
}
