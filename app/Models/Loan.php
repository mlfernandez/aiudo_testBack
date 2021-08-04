<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'amount_total',
        'amount_paid',
        'amount_due',
        'date_start',
        'loan_term_month',
        'interest_rate_month',
        'type',
        'monthly_payments',
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