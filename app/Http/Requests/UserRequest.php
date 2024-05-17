<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return [
            'prefixname' => 'nullable|string|in:Mr,Mrs,Ms',
            'firstname' => 'required|string',
            'middlename' => 'nullable|string',
            'lastname' => 'required|string',
            'suffixname' => 'nullable|string',
            'username' => 'required|string|unique:users,username,' . $userId,
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => $this->isMethod('post') ? 'required|string|confirmed' : 'nullable|string|confirmed',
            'photo' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'prefixname.in' => 'The prefix name must be one of the following: Mr, Mrs, Ms.',
            'email.unique' => 'The email has already been taken.',
            'username.unique' => 'The username has already been taken.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
