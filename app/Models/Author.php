<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 */
class Author extends Model
{
    use HasFactory;

    protected $guarded=[];

     //Date Mutators
    protected $dates=['dob'];

    // Accessors
    public function setDObAttribute($dob){
        $this->attributes['dob'] = Carbon::parse($dob);
    }


}
