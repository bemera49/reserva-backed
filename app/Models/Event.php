<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'location'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

