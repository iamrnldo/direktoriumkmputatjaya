<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UmkmProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:umkm_categories,id'],
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_nik' => ['nullable', 'digits:16'],
            'owner_rt' => ['nullable', 'regex:/^\\d{1,3}$/'],
            'owner_rw' => ['nullable', 'regex:/^\\d{1,3}$/'],
            'business_description' => ['nullable', 'string', 'max:2000'],
            'address' => ['required', 'string', 'max:500'],
            'village' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'whatsapp_number' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'business_email' => ['nullable', 'email', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'tiktok_url' => ['nullable', 'url', 'max:500'],
            'shopee_url' => ['nullable', 'url', 'max:500'],
            'tokopedia_url' => ['nullable', 'url', 'max:500'],
            'marketplace_url' => ['nullable', 'url', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'images' => ['sometimes', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama usaha wajib diisi.',
            'name.max' => 'Nama usaha maksimal 255 karakter.',
            'category_id.required' => 'Kategori usaha wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'owner_name.required' => 'Nama pemilik wajib diisi.',
            'owner_nik.digits' => 'NIK pemilik harus tepat 16 digit angka.',
            'owner_rt.regex' => 'RT harus berisi 1 sampai 3 digit angka.',
            'owner_rw.regex' => 'RW harus berisi 1 sampai 3 digit angka.',
            'address.required' => 'Alamat usaha wajib diisi.',
            'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp_number.regex' => 'Format nomor WhatsApp tidak valid.',
            'business_email.email' => 'Format email tidak valid.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
            'images.max' => 'Maksimal 10 foto dapat diunggah sekaligus.',
            'images.*.image' => 'File galeri harus berupa gambar yang valid.',
            'images.*.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'images.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
        ];
    }
}
