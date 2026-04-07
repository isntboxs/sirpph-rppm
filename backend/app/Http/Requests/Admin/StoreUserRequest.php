<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:guru,kepala sekolah,orang tua'],
            'kelas' => ['nullable', 'required_if:role,guru', 'in:A,B'],
            'hp' => ['nullable', 'string', 'max:20'],
            'siswa_ids' => ['nullable', 'array'],
            'siswa_ids.*' => ['integer', 'exists:siswa,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'kelas.required_if' => 'Kelas wajib diisi untuk guru.',
        ];
    }
}
