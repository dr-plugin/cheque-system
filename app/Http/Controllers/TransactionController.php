<?php

namespace App\Http\Controllers;

use App\Domain\ValuesObject\TransactionType;
use App\Enums\RoutesName;
use App\Http\Requests\TransactionRequest;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class TransactionController extends Controller
{
    public function getViewPath(): string
    {
        return 'Transaction';
    }

    public function index(Request $request)
    {
        $h1 = "لیست تمام تراکنش‌ها";

        $query = Transaction::query()
            ->with(['payer', 'receiver', 'cheque'])
            ->orderBy('created_at', 'DESC');

        $clientId = $request->get('client');

        if ($clientId) {

            $client = Client::findOrFail($clientId);
            if ($client) $h1 = "تراکنش‌های " . $client->name;

            $query->orWhere('payer_id', $clientId)
                ->orWhere('receiver_id', $clientId);
        }

        return $this->render(
            'Index',
            [
                'h1'                => $h1,
                'transactions'      => $query->paginate(10),
                'clientId'          => $clientId,
                'transactionType'   => TransactionType::options(),
                'msg'               => session('msg')
            ]
        );
    }

    public function create()
    {
        return $this->render(
            'Create',
            [
                'sendUrl'           => RoutesName::CreateTransaction->value,
                'msg'               => session('msg', null),
                'transactionType'   => TransactionType::options(),
            ]
        );
    }

    public function store(TransactionRequest $request)
    {
        $validated = $request->validated();

        $transaction = Transaction::create([
            'price'             => $validated['price'],
            'type'              => $validated['type'],
            'transaction_id'    => $validated['transaction_id'] ?? null,
            'cheque_id'         => $validated['cheque_id'] ?? null,
            'payer_id'          => $validated['payer_id'],
            'receiver_id'       => $validated['receiver_id'],
            'comment'           => $validated['comment'] ?? null,
        ]);

        return back()->with('msg', 'با موفقیت انجام شد');
    }

    public function update(Transaction $transaction, TransactionRequest $request)
    {
        $validated = $request->validated();

        $transaction->update($validated);

        return back()->with('msg', 'با موفقیت انجام شد');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return back()->with('msg', 'با موفقیت انجام شد');
    }
}
