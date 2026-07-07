<?php

namespace App\Http\Controllers;

use App\Enums\RoutesName;
use App\Models\Cheque;
use App\Models\Client;
use Illuminate\Http\Request;

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
                'sendUrl' => RoutesName::CreateCheque->value
            ]
        );
    }
}
