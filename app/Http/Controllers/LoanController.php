<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

        // crear prestamo para un usuario - requiere token admin
        // POST http://localhost:8000/api/loans
    public function store(Request $request)
    {
        //

        $user = auth()->user();

        if($user->profile === "admin"){

            $this->validate($request, [
          
                'currency' => 'required',
                'amount_total'=> 'required',
                'amount_paid'=> 'required',
                'amount_due'=> 'required',
                'date_start'=> 'required',
                'loan_term_month'=> 'required',
                'interest_rate_month'=> 'required',
                'type' => 'required',
                'monthly_payments'=> 'required',
                'user_id' => 'required',

            ]);

            $loan = Loan::create([
                'currency' => $request->currency,
                'amount_total'=> $request->amount_total,
                'amount_paid'=> $request->amount_paid,
                'amount_due'=> $request->amount_due,
                'date_start'=> $request->date_start,
                'loan_term_month'=> $request->loan_term_month,
                'interest_rate_month'=> $request->interest_rate_month,
                'type' => $request->type,
                'monthly_payments'=> $request->monthly_payments,
                'user_id' => $request->user_id,
            ]);

            if (!$loan) {
                return response() ->json([
                    'success' => false,
                    'data' => 'It has not been possible to create a current account for this user.'], 400);
            } else {
                return response() ->json([
                    'success' => true,
                    'data' => $loan,
                ], 200);
            }
        } else {

            return response() ->json([
                'success' => false,
                'message' => 'Only the administrator can create a bank account for a user.',
            ], 400);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
        // ver los prestamos de un usuario, solo necesita token del usuario
        // GET http://localhost:8000/api/loans/userid
     public function show(Request $request)
     {
         $user = auth()->user();
 
         if($user){
 
             $loan = Loan::where('user_id', '=', $user->id)->get();
 
             if(!$loan){
                 return response() ->json([
                     'success' => false,
                     'message' => 'No tiene ninguna cuenta.',
                 ], 400);
     
             } elseif ($loan->isEmpty()) {
                 return response() ->json([
                     'success' => false,
                     'message' => 'No se encontró ninguna cuenta.',
                     ], 400);
             } else {    
             return response() ->json([
                 'success' => true,
                 'data' => $loan,
             ], 200);
             }
     
         } else {
     
             return response() ->json([
                 'success' => false,
                 'message' => 'Necesitas ser el usuario creador para realizar esta acción.',
 
             ], 400);
     
         }
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
