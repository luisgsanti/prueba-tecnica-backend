<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'user_type_id',
        'question_text',
        'order_number'
    ];

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}