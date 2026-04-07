<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['sometimes', 'string', 'max:255'],
            'kelas' => ['sometimes', 'in:A,B'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['sometimes', 'in:L,P'],
        ];
    }
}
