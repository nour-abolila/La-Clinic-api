<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = ['user_id', 'specialization', 'years_of_experience', 'bio' , 'session_price' , 'start_time' , 'end_time' , 'working_days' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $casts = [
    'working_days' => 'array',
];

}
