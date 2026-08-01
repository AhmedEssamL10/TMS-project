<?php

namespace App\Http\Requests;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $rules = [
            'description' => ['nullable', 'string'],
            'status' => ['nullable', new Enum(ProjectStatus::class)],
        ];
        if ($this->isMethod('post')) {
            $rules['name'] = ['required', 'string', 'max:255'];
        } else {
            $rules['name'] = ['sometimes', 'required', 'string', 'max:255'];
        }
        return $rules;
    }
}
