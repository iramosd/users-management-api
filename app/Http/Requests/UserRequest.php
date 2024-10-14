<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
            ] + ($this->isMethod('post') ? $this->store() : $this->update());
    }

    public function store(): array
    {
        return[
            'email' => ['required', 'string', 'email', 'unique:'.User::class],
            'password' => ['required', 'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()],
            'password_confirmation' => ['required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ];
    }

    public function update(): array
    {
        $user = $this->route('user');

        return[
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($user)
            ],
        ];
    }
}
