<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use Boot;
    use AsList;
    use CreatedUpdated;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'bunch_id',
        'template_id'
    ];

    public function bunch(){
        return $this->belongsTo(Bunch::class);
    }

    public function template(){
        return $this->belongsTo(Template::class);
    }

    public function scopeOwned($query){
        return $query->where('created_by', Auth::user()->id);
    }
}
