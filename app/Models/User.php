<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'user_type_id',
        'name',
        'last_name',
        'business_name',
        'nit',
        'document_type',
        'document_number',
        'email',
        'phone',
        'city',
        'accepted_terms',
        'status'
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }
}