<?php

namespace App\Http\Controllers;

use App\Domain\ValuesObject\Bank;
use App\Domain\ValuesObject\ChequeStatus;
use App\Domain\ValuesObject\ChequeType;
use App\Enums\RoutesName;
use App\Http\Requests\ChequeRequest;
use App\Models\Cheque;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChequeController extends Controller
{

    public function getViewPath(): string
    {
        return 'Cheque';
    }

    public function index(Request $request)
    {

        $chequeStatus = ChequeStatus::options();

        $clientId   = $request->query('client');
        $id         = $request->query('id');
        $dateQuery  = $request->query('date');
        $orderBy    = $request->query('orderby');
        $staus      = $request->query('status');

        # Get cheque With owner
        $query = Cheque::query()
            ->with('owner');

        if (empty($orderBy)) {
            
            $query->orderBy('due_date', 'ASC');
        } else {

            $query->orderBy('updated_at', 'DESC');
        }

        $h1 = "لیست تمام چک‌ها";

        if ($clientId) {
            $query->where('owner', $clientId);

            $client = Client::findOrFail($clientId);
            if ($client) $h1 = "چک‌های موجود نزد " . $client->name;
        }

        if ($id) {
            $query->findOrFail($id);
        }

        if (!empty($dateQuery)) {
            $query->where('due_date', '>', Carbon::yesterday());
            $query->where('status', '!=', ChequeStatus::Cashed);
        }


        if (!empty($staus)) {
            $query->where('status', '!=', ChequeStatus::Cashed);
        }

        $cheques = $query->paginate(15)->withQueryString();

        return $this->render(
            'Index',
            [
                'cheques' => $cheques,
                'h1'      => $h1,
                'currentClientId' => $clientId,
                'chequeStatus'    => $chequeStatus,
            ]
        );
    }

    public function create()
    {
        return $this->render(
            'Create',
            [
                'sendUrl'       => RoutesName::CreateCheque->value,
                'msg'           => session('msg'),
                'banks'         => Bank::options(),
                'chequeType'    => ChequeType::options(),
            ]
        );
    }

    public function store(ChequeRequest $request)
    {
        $validated = $request->validated();

        $cheque = Cheque::create($validated);

        return  $this->back('با موفقیت ذخیره شد');
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
        if ($cheque->status == ChequeStatus::Cashed) {
            return $this->back('این چک قبلا نقد شده و قابل ویرایش نیست', false);
        }

        $validated = $request->validated();

        $cheque->update($validated);

        return $this->back('با موفقیت ویرایش شد.');
    }

    public function destroy(Cheque $cheque)
    {
        // $cheque->delete();

        return $this->back('امکان حذف غیر فعال شده', false);
    }
}
