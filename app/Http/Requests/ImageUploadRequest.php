<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'images' => ['required', 'array', 'min:1', 'max:10'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Harap pilih minimal satu gambar.',
            'images.*.image' => 'File yang diunggah harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 5 MB.',
        ];
    }
}
