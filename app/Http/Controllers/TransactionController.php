<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'price'             => ['required', 'integer', 'min:0'],
            'transaction_id'    => ['nullable', 'string', 'max:100'],
            'cheque_id'         => ['nullable', 'exists:cheques,id'],
            'payer_id'          => ['required', 'exists:clients,id'],
            'receiver_id'       => ['required', 'exists:clients,id'],
            'comment'           => ['nullable', 'string'],
        ]);


        $transaction = Transaction::create([
            'price'             => $validated['price'],
            'transaction_id'    => $validated['transaction_id'] ?? null,
            'cheque_id'         => $validated['cheque_id'] ?? null,
            'payer_id'          => $validated['payer_id'],
            'receiver_id'       => $validated['receiver_id'],
            'comment'           => $validated['comment'] ?? null,
        ]);

        return back()->with('msg', 'با موفقیت انجام شد');
    }
}
