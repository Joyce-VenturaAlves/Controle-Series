<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => ['required', 'min:3'],
            'capa' => [
                //pegar todos arquivos imagens
                 "image",
                //tipos de arquivo aceito:
                "mimes:png,jpg,jpeg,gif"
                ]
        ];
    }
}
