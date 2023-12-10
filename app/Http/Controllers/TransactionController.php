<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

use Illuminate\Http\Request;

class transactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get_transactions_history()
    {
        $user_role = auth()->user()->user_role;
        if ($user_role == 1) {

            $user_id = auth()->user()->id;

            $transactions = Transactions::all()
                ->where('user_id', $user_id)
                ->select('transactions.*')
                ->get();;
            return response()->json($transactions);
        }
    }
}
