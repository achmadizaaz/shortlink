<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
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
            'title' => $this->title ? 'string': '',
            'destination' => ['required', 'string', 'regex:/^\S*$/'],
            'custom_link' => $this->custom_link ? ['string', 'regex:/^\S*$/'] : '',
        ];
    }
}
