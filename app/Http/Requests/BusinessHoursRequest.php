<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessHoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hours' => ['required', 'array'],
            'hours.*.is_closed' => ['nullable'],
            'hours.*.open_time' => ['nullable', 'date_format:H:i'],
            'hours.*.close_time' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'hours.*.open_time.date_format' => 'Format jam buka tidak valid (HH:MM).',
            'hours.*.close_time.date_format' => 'Format jam tutup tidak valid (HH:MM).',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Checkboxes don't send data when unchecked, so ensure is_closed defaults to false
        $hours = $this->input('hours', []);
        foreach ($hours as $key => $day) {
            if (!isset($day['is_closed'])) {
                $hours[$key]['is_closed'] = false;
            }
        }
        $this->merge(['hours' => $hours]);
    }
}
