<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

        // Define la relacion de un usuario puede tener muchas cuentas
        public function bankaccount (){
            return $this -> hasMany(BankAccount::class);
        }

        // Define la relacion de un usuario puede tener muchos prestamos
        public function loan (){
            return $this -> hasMany(Loan::class);
        }


   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastName',
        'email',
        'password',
        'DNI',
        'dateBirth',
        'address',
        'city',
        'zipCode',
        'country',
        'movilPhone'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
}
