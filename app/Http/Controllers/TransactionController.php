<?php

namespace App\Http\Controllers;

use App\Domain\ValuesObject\TransactionType;
use App\Enums\RoutesName;
use App\Http\Requests\TransactionRequest;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class TransactionController extends Controller
{
    public function getViewPath(): string
    {
        return 'Transaction';
    }

    public function index(Request $request)
    {
        $h1 = "لیست تمام تراکنش‌ها";

        $financialSummary = [
            'outbound' => 0,
            'inbound'  => 0,
            'balance'  => 0,
        ];

        $query = Transaction::query()
            ->with(['payer', 'receiver', 'cheque'])
            ->orderBy('created_at', 'DESC');

        $clientId = $request->get('client');

        if ($clientId) {

            $client = Client::findOrFail($clientId);

            $h1 = "تراکنش‌های " . $client->name;

            $query->orWhere('payer_id', $clientId)
                ->orWhere('receiver_id', $clientId);

            $financialSummary = $this->calculateClientBalance($clientId);

            $clientBalance = $financialSummary['balance'];

            $transPaginated = $query->paginate(self::$PAGINATECOUT)->withQueryString();

            $this->addRowBalance($transPaginated, $clientId, $clientBalance);
        } else {

            $transPaginated = $query->paginate(self::$PAGINATECOUT)->withQueryString();
        }


        return $this->render(
            'Index',
            [
                'h1'                => $h1,
                'transactions'      => $transPaginated,
                'clientId'          => $clientId,
                'transactionType'   => TransactionType::options(),
                'financialSummary'  => $financialSummary,
            ]
        );
    }

    /**
     * Calc user trans
     *
     * @param int $clientId
     * @return array
     */
    private function calculateClientBalance(int $clientId): array
    {
        $outbound   = Transaction::where('payer_id', $clientId)->sum('price');
        $inbound    = Transaction::where('receiver_id', $clientId)->sum('price');

        return [
            'outbound' => (float) $outbound,
            'inbound'  => (float) $inbound,
            'balance'  => (float) ($outbound - $inbound),
        ];
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

        return $this->back('با موفقیت انجام شد');
    }

    public function update(Transaction $transaction, TransactionRequest $request)
    {
        $validated = $request->validated();

        $transaction->update($validated);

        return $this->back('با موفقیت انجام شد');
    }

    public function addRowBalance(LengthAwarePaginator &$transPaginated, int $clientId, int $clientBalance)
    {

        # Add running_balance in each row
        $transPaginated->getCollection()->transform(function ($transaction) use ($clientId, &$clientBalance, &$isFristRow) {

            # Add row balance
            $transaction->row_balance = $clientBalance;

            # Effect in row balance
            if ($transaction->receiver_id == $clientId) {

                $clientBalance += $transaction->price;
            } elseif ($transaction->payer_id == $clientId) {

                $clientBalance -= $transaction->price;
            }

            return $transaction;
        });
    }

    public function destroy(Transaction $transaction)
    {
        //$transaction->delete();
        return $this->back('امکان حذف غیر فعال شده است', false);
    }
}
