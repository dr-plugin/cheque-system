<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\ChequeLogs;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ChequeLogsController extends Controller
{

    public function getViewPath(): string
    {
        return 'ChequeLogs';
    }

    // public function index()
    // {
    //     return $this->render('Index');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cheque_id'    => ['required', 'exists:cheques,id'],
            'payer_id'     => ['required', 'exists:clients,id'],
            'receiver_id'  => ['required', 'exists:clients,id', 'different:payer_id'],
            'comment'      => ['nullable', 'string'],

            'trans_price'           => ['nullable', 'integer'],
            'trans_interest_rate'   => ['nullable', 'integer'],
            'trans_comment'         => ['nullable', 'string']
        ]);

        DB::transaction(function () use ($validated) {

            $cheque = Cheque::findOrFail($validated['cheque_id']);

            if ((int) $cheque->owner !== (int) $validated['payer_id']) {

                throw ValidationException::withMessages([
                    'payer_id' => 'پرداخت‌ کننده باید مالک فعلی چک باشد.',
                ]);
            }

            ChequeLogs::create([
                'cheque_id'   => $validated['cheque_id'],
                'payer_id'    => $validated['payer_id'],
                'receiver_id' => $validated['receiver_id'],
                'comment'     => $validated['comment'] ?? '',
            ]);

            Transaction::create([
                'price'           => $validated['trans_price'],
                'cheque_id'       => $cheque->id,

                'payer_id'        => $validated['receiver_id'], //payer received cheque and pay money
                'receiver_id'     => $validated['payer_id'],

                'comment'         => $validated['trans_comment'] ?? '',
            ]);

            $cheque->owner = $validated['receiver_id'];

            $cheque->save();
        });


        return back()->with('msg', 'انتقال چک با موفقیت ثبت شد.');
    }
}
