<?php

namespace App\Http\Requests\Administrador\TemasDeInteres;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CrearTemaDeInteresRequest extends FormRequest
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
            'user_id' => [
                'required',
                'integer',
                'exists:users,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tema.required' => 'El campo tema es obligatorio.',
            'tema.max' => 'El campo tema no debe exceder los 255 caracteres.',
            'tema.min' => 'El campo tema debe tener al menos 5 caracteres.',
            'user_id.required' => 'El campo user_id es obligatorio.',
            'user_id.integer' => 'El campo user_id debe ser un número entero.',
            'user_id.exists' => 'El user_id proporcionado no existe en la tabla de usuarios.',
        ];
    }
}
