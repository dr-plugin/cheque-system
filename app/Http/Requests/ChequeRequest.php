<?php

namespace App\Http\Requests;

use App\Domain\ValuesObject\Bank;
use App\Domain\ValuesObject\ChequeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ChequeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $cheque = $this->route('cheque');

        return [
            'owner' => ['required', 'exists:clients,id'],
            'sayadi_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('cheques', 'sayadi_number')->ignore($cheque?->id),
            ],
            'type' => ['required', new Enum(ChequeType::class)],
            'is_registered' => ['sometimes', 'boolean'],
            'bank' => ['nullable', new Enum(Bank::class)],
            'price' => ['nullable', 'integer'],
            'exporter' => ['nullable', 'string', 'max:200'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'img_url' => ['nullable', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
            'status' => ['required', 'string'],
        ];
    }
}
