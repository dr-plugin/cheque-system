<?php

namespace App\Http\Controllers;

use App\Domain\ValuesObject\Bank;
use App\Domain\ValuesObject\ChequeType;
use App\Enums\RoutesName;
use App\Models\Cheque;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ChequeController extends Controller
{

    public function getViewPath(): string
    {
        return 'Cheque';
    }

    public function index(Request $request)
    {

        $clientId = $request->query('client');

        # Get cheque With owner
        $query = Cheque::query()->with('owner');

        $h1 = "لیست تمام چک‌ها";

        if ($clientId) {
            $query->where('owner', $clientId);

            $client = Client::find($clientId);
            if ($client)
                $h1 = "چک‌های موجود نزد " . $client->name;
        }

        $cheques = $query->paginate(10);

        return $this->render(
            'Index',
            [
                'cheques' => $cheques,
                'h1'      => $h1
            ]
        );
    }

    public function create()
    {
        return $this->render(
            'Create',
            [
                'sendUrl'       => RoutesName::CreateCheque->value,
                'banks'         => Bank::options(),
                'chequeType'    => ChequeType::options(),
            ]
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner'             => ['required', 'exists:clients,id'],
            'sayadi_number'     => ['required', 'string', 'max:100', 'unique:cheques,sayadi_number'],
            'type'              => ['required', new Enum(ChequeType::class)],

            #Checkbox
            'is_registered'     => ['sometimes', 'boolean'],
            
            'bank'              => ['nullable', new Enum(Bank::class)],
            'price'             => ['nullable', 'string', 'max:255'],
            'exporter'          => ['nullable', 'string', 'max:200'],
            'account_number'    => ['nullable', 'string', 'max:255'],
            'img_url'           => ['nullable', 'string', 'max:255'],
            'due_date'          => ['nullable', 'date'],
            'status'            => ['string']
        ]);

        $cheque = Cheque::create($validated);

        return back()->with('msg', 'چک با موفقیت ذخیره شده');
    }
}
