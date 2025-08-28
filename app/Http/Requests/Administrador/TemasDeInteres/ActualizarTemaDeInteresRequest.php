<?php

namespace App\Http\Requests\Administrador\TemasDeInteres;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ActualizarTemaDeInteresRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tema' => [
                'required',
                'max:255',
                'min:5',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tema.required' => 'El campo tema es obligatorio.',
            'tema.max' => 'El campo tema no debe exceder los 255 caracteres.',
            'tema.min' => 'El campo tema debe tener al menos 5 caracteres.',
        ];
    }
}
