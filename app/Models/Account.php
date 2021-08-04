<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'type',
        'currency',
        'user_id'
        
    ];

    // Define la relacion de una cuenta bancaria pertence a un usuario
    public function user (){
        return $this -> belongsTo(User::class);
    }

    // Define la relacion de una cuenta bancaria pertence a un payment
    public function payment (){
        return $this -> belongsTo(Payment::class);
    }
}
