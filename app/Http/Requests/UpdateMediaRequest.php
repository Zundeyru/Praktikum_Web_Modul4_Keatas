<?php

namespace App\Http\Requests;

use App\Models\Media;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $media = $this->route('media');
        $type = $this->input('type', $media->type);

        return [
            'title' => [
                'sometimes', 'required', 'string', 'max:255',
                Rule::unique('media', 'title')->where('type', $type)->ignore($media->id),
            ],
            'type'                => ['sometimes', 'required', Rule::in(Media::TYPES)],
            'release_year'        => 'sometimes|required|integer|min:1000|max:3000',
            'rating'              => 'sometimes|required|numeric|between:0,10',
            'genres'              => 'sometimes|nullable|array',
            'genres.*'            => 'string|max:50',
            'episodes'            => 'sometimes|nullable|integer|min:1',
            'minutes_per_episode' => 'sometimes|nullable|integer|min:1',
            'studio'              => 'sometimes|nullable|string|max:100',
            'country'             => 'sometimes|nullable|string|max:100',
            'author'              => 'sometimes|nullable|string|max:100',
            'chapters'            => 'sometimes|nullable|integer|min:1',
            'is_ongoing'          => 'sometimes|nullable|boolean',
            'volumes'             => 'sometimes|nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi.',
            'title.unique'   => 'Media dengan judul dan jenis yang sama sudah ada di library.',
            'rating.between' => 'Rating harus angka 0-10.',
        ];
    }
}
