<?php

namespace App\Http\Controllers;

use App\Domain\ValuesObject\ClientType;
use App\Enums\RoutesName;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ClientController extends Controller
{
    public function getViewPath(): string
    {
        return 'Client';
    }

    public function index()
    {
        $clients = Client::with('cheques')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $this->render(
            'Index',
            [
                'clients' => $clients
            ]
        );
    }

    public function show(Client $client)
    {
        return $this->render(
            'show',
            [
                'client' => $client
            ]
        );
    }

    public function create(Request $request)
    {
        $clientType = ClientType::options();

        return $this->render(
            'Create',
            [
                'sendUrl'    => RoutesName::CreateClient->value,
                'clientType' => $clientType
            ]
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255', 'unique:clients,name'],
            'phone' => ['required', 'string', 'max:20', 'unique:clients,phone'],
            'type'  => ['nullable', new Enum(ClientType::class)],
        ]);

        $client = Client::create([
            'name'  => $validated['name'],
            'phone' => $validated['phone'],
            'type'  => $validated['type'],
        ]);

        return back()->with('msg', 'با موفقیت انجام شد');
    }

    # Search api
    public function search(Request $request)
    {
        $search = $request->input('search');

        $query = Product::query()
            ->select('id', 'name', 'phone');

        # If user insert id search by id
        if (is_numeric($search))
            $query->orWhere('phone', $search);
        else
            $query->where('name', 'LIKE', "%{$search}%");

        $data = $query->limit(20)->get();

        return response()->json($data);
    }
}
