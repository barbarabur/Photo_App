<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
            'image' => 'required|image|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id'
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'The image is required.',
            'image.image' => 'The file must be a valid image.',
            'title' => 'The title is required.',
            'description.' => 'The description is required.',
            'price' => 'The price is required and must be a number >0.',
            'tags.required' => 'Please select at least one tag.',
        ];
    }

}
