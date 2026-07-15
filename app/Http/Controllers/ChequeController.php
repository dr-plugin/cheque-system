<?php

namespace App\Http\Controllers;

use App\Domain\ValuesObject\Bank;
use App\Domain\ValuesObject\ChequeType;
use App\Enums\RoutesName;
use App\Http\Requests\ChequeRequest;
use App\Models\Cheque;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ChequeController extends Controller
{

    public function getViewPath(): string
    {
        return 'Cheque';
    }

    public function index(Request $request)
    {

        $clientTrans = [];
        $clientId = $request->query('client');

        # Get cheque With owner
        $query = Cheque::query()
            ->orderBy('due_date', 'DESC')
            ->with('owner');

        $h1 = "لیست تمام چک‌ها";


        if ($clientId) {
            $query->where('owner', $clientId);

            $client = Client::find($clientId);
            if ($client) $h1 = "چک‌های موجود نزد " . $client->name;

            $clientTrans =
                Transaction::with('payer', 'receiver')
                ->where('payer_id', $client->id)
                ->orWhere('receiver_id', $client->id)
                ->get();
        }

        $cheques = $query->paginate(10);

        return $this->render(
            'Index',
            [
                'cheques' => $cheques,
                'h1'      => $h1,
                'clientTrans'   => $clientTrans
            ]
        );
    }

    public function create()
    {
        return $this->render(
            'Create',
            [
                'sendUrl'       => RoutesName::CreateCheque->value,
                'msg'           => session('msg', null),
                'banks'         => Bank::options(),
                'chequeType'    => ChequeType::options(),
            ]
        );
    }

    public function store(ChequeRequest $request)
    {
        $validated = $request->validated();

        $cheque = Cheque::create($validated);

        return back()->with('msg', 'چک با موفقیت ذخیره شده');
    }

    public function edit(Cheque $cheque)
    {

        $cheque->load('owner');

        return $this->render(
            'Create',
            [
                'sendUrl'       => RoutesName::CreateCheque->value . '/' . $cheque->id,
                'msg'           => session('msg', null),
                'banks'         => Bank::options(),
                'chequeType'    => ChequeType::options(),
                'cheque'        => $cheque
            ]
        );
    }

    public function update(Cheque $cheque, ChequeRequest $request)
    {
        $validated = $request->validated();

        $cheque->update($validated);

        return back()->with('msg', 'چک با موفقیت ویرایش شد');
    }
}
