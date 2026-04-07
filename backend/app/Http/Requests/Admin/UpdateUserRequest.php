<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'username' => ['sometimes', 'string', 'max:50', 'unique:users,username,' . $userId],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['sometimes', 'in:guru,kepala sekolah,orang tua'],
            'kelas' => ['nullable', 'in:A,B'],
            'hp' => ['nullable', 'string', 'max:20'],
            'siswa_ids' => ['nullable', 'array'],
            'siswa_ids.*' => ['integer', 'exists:siswa,id'],
        ];
    }
}
