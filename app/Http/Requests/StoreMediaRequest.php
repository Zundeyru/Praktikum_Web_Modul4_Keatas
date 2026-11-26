<?php

namespace App\Http\Requests;

use App\Models\Media;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('media', 'title')->where('type', $this->input('type')),
            ],
            'type'         => ['required', Rule::in(Media::TYPES)],
            'release_year' => 'required|integer|min:1000|max:3000',
            'rating'       => 'required|numeric|between:0,10',
            'genres'       => 'nullable|array',
            'genres.*'     => 'string|max:50',

            'episodes'            => 'required_if:type,anime,drama|nullable|integer|min:1',
            'minutes_per_episode' => 'nullable|integer|min:1',
            'studio'              => 'required_if:type,anime|nullable|string|max:100',
            'country'             => 'required_if:type,drama|nullable|string|max:100',

            'author'     => 'required_if:type,manga,light_novel|nullable|string|max:100',
            'chapters'   => 'required_if:type,manga,light_novel|nullable|integer|min:1',
            'is_ongoing' => 'nullable|boolean',
            'volumes'    => 'required_if:type,light_novel|nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi.',
            'title.unique'   => 'Media dengan judul dan jenis yang sama sudah ada di library.',
            'type.required'  => 'Jenis media wajib diisi.',
            'type.in'        => 'Jenis media harus: anime, drama, manga, atau light_novel.',
            'rating.between' => 'Rating harus angka 0-10.',
            'required_if'    => ':attribute wajib diisi untuk jenis media ini.',
        ];
    }
}
