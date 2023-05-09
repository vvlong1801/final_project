<?php

namespace App\Http\Requests\Admin;

use App\Models\Exercise;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreExerciseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (($id = $this->route('id')) !== null) {
            try {
                $exercise = Exercise::findOrFail($id);
                return $this->user()->can('update', $exercise);
            } catch (\Throwable $th) {
                abort(404, 'cannot found this exercise');
            }
        }
        return $this->user()->can('create', Exercise::class);
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
            'level' => 'required',
            'type' => '',
            'evaluate_method' => 'required',
            'equipment_id' => '',
            'group_tags' => 'array',
            'muscles' => 'required',
            'description' => '',
            'gif.filename' => 'required|exists:media,name',
            'gif.path' => 'required|exists:media,path',
            'image.filename' => 'required|exists:media,name',
            'image.path' => 'required|exists:media,path',
            'video' => '',
        ];
    }
}
