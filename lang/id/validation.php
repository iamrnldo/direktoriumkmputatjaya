<?php

return [
    'required' => ':attribute wajib diisi.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'string' => ':attribute harus berupa teks.',
    'min' => [
        'string' => ':attribute minimal harus :min karakter.',
    ],
    'max' => [
        'string' => ':attribute maksimal :max karakter.',
    ],
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'unique' => ':attribute sudah digunakan.',

    'attributes' => [
        'email' => 'Email',
        'password' => 'Password',
        'name' => 'Nama',
    ],
];
