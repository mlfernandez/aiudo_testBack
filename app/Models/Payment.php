<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'detail',
        'currency',
        'amount',
        'account_id', 
        'loan_id',
        
    ];

    // Define la relacion de un payment pertenece a una cuenta bancaria
    public function backaccount (){
        return $this -> belongsTo(Account::class);
    }

    // Define la relacion de un payment pertenece a un prestamo
    public function loan (){
        return $this -> belongsTo(Loan::class);
    }
}