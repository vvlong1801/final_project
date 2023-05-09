<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'image.filename' => 'required|exists:media,name',
            'image.path' => 'required|exists:media,path',
            'icon.filename' => 'exists:media,name',
            'icon.path' => 'exists:media,path',
            'description' => '',
        ];
    }
}
