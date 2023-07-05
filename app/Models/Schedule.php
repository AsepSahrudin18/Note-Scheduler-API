<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';
    protected $fillable = ['judul', 'start_et', 'end_at'];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = date('Y-m-d H:i:s', strtotime($value));
    }

    public function setEndAtAttribute($value)
    {
        $this->attributes['end_at'] = date('Y-m-d H:i:s', strtotime($value));
    }
}
