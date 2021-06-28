<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//classe criada com o comando: php artisan make:request NomeRequest
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

    //validação do formulário para o usuário não enviar um form vazio
    //ou com menos de 3 caracteres
    public function rules()
    {
        return [
            'nome' => 'required|min:3'
        ];
    }

    public function messages()
    {
        //colocando a mensagem de aviso em português
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.min' => 'O campo nome precisa ter pelo menos 3 caracteres'
        ];
    }
}
