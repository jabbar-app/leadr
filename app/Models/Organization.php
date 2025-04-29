<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'username',
        'api_url',
        'email',
        'phone',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Relasi ke User
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
