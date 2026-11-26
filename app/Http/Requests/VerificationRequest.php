<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $action = $this->input('action');

        return [
            'action' => ['required', Rule::in(['approve', 'reject', 'revision'])],
            'notes' => [
                Rule::when(in_array($action, ['reject', 'revision']), ['required', 'string', 'min:10', 'max:1000']),
                Rule::when($action === 'approve', ['nullable', 'string', 'max:1000']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'action.required' => 'Aksi verifikasi wajib dipilih.',
            'notes.required' => 'Catatan wajib diisi untuk aksi penolakan atau permintaan revisi.',
            'notes.min' => 'Catatan minimal 10 karakter.',
        ];
    }
}
