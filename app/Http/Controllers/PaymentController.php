<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
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
        // ruta crear agregar pagos a los prestamos
        // http://localhost:8000/api/payments
        // Postman: necesita "token" y datos por body
        public function store(Request $request)
    {
        //

        $user = auth()->user();

        if($user){

            $this->validate($request, [
          
                'date'=> 'required',
                'detail'=> 'required',
                'currency' => 'required',
                'amount'=> 'required',
                'account_id'=> 'required',
                'loan_id'=> 'required',


            ]);

            $payment = Payment::create([
                'date' => $request->date,
                'detail'=> $request->detail,
                'currency'=> $request->currency,
                'amount'=> $request->amount,
                'account_id'=> $request->account_id,
                'loan_id'=> $request->loan_id,
            ]);

            if (!$payment) {
                return response() ->json([
                    'success' => false,
                    'data' => 'No se ha podido procesar el pago'], 400);
            } else {
                return response() ->json([
                    'success' => true,
                    'data' => $payment,
                ], 200);
            }
        } else {

            return response() ->json([
                'success' => false,
                'message' => 'No se ha podido procesar el pago.',
            ], 400);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */

     // ruta para ver los pagos de un usuario
     // http://localhost:8000/api/payments/userid
     // necesita token del usuario que consulta
    public function show()
    {
        //

        $user = auth()->user();

                // generamos la query
        $usersPayments = DB::table('payments')
            ->join('accounts', 'payments.account_id', '=', 'accounts.id')
            ->select('*')
            ->where('accounts.user_id', '=', $user->id)
            ->get();

        if($user){

            return response() ->json([
                'success' => true,
                'data' => $usersPayments,
            ]);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'No tienes permiso para realizar esta acción.',
            ], 400);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
