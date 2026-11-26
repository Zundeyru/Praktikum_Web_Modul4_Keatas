<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $media = $this->route('media');

        return [
            'progress' => 'required|integer|min:0|max:' . $media->getTotalUnits(),
        ];
    }

    public function messages(): array
    {
        $media = $this->route('media');

        return [
            'progress.required' => 'progress wajib diisi.',
            'progress.min'      => 'Progres tidak boleh negatif.',
            'progress.max'      => "Progres tidak valid (maks {$media->getTotalUnits()} {$media->getUnitLabel()}).",
        ];
    }
}
