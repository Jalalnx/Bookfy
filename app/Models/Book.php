<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method static first()
 */
class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path()
    {
        return '/books/' . $this->id;
    }

    public function check_out(User $User)
    {
        if(is_null($User->id)){
            throw  new \Exception();
        }
        $this->reservation()->create([
            'User_id' => $User->id,
            'check_out_at' => now(),
        ]);

    }

    public function check_in(User $User)
    {
        $reservation = $this->reservation()->where('User_id', $User->id)
            ->whereNotNull('check_out_at')
            ->whereNull('check_in_at')
            ->first();
        if(is_null($reservation)){
            throw  new \Exception();
        }
        $reservation->update([
            'check_in_at' => now()
        ]);

    }


    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => $author,
        ])->id;
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
}
