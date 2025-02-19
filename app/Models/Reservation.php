<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'event_id',
        'user_name',
        'user_email',
        'seats'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
