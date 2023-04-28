<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreChallengeRequest extends FormRequest
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
            'description' => '',
            'type' => 'required',
            'image' => 'required',
            'max_member' => 'required',
            'commit_point' => 'required|numeric',
            'participant' => 'required',
            'required_approve' => 'required',
            'member_censorship' => 'required',
            'result_censorship' => 'required',
            'released_at' => 'required',
            'finished_at' => '',
            'phases' => 'array',
        ];
    }
}
