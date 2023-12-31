<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RequestBarangMasuk extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return Auth::check();
    // }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'vendor_guide_driver' => ['required'],
            'date_in' => ['required'],
            // 'total_qty' => ['required'],
            // 'grand_total' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi.',
        ];
    }
}
