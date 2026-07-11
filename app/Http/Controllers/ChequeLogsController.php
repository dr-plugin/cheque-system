<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\ChequeLogs;
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

            $cheque->owner = $validated['receiver_id'];

            $cheque->save();
        });


        return back()->with('msg', 'انتقال چک با موفقیت ثبت شد.');
    }
}
