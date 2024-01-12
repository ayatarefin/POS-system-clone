<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'admin_role', 'role_name');
    }

    use Notifiable;
    protected $fillable = [
        'name', // Add 'name' to the fillable attributes
        'email',
        'password',
        'admin_key',
        'admin_role',
        // ... other attributes
    ];
}
