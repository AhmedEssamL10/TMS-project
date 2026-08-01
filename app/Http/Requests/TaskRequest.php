<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Common rules for both Create (POST) and Update (PUT/PATCH)
        $rules = [
            'description' => ['nullable', 'string'],
            'priority' => ['nullable', new Enum(TaskPriority::class)],
            'status' => ['nullable', new Enum(TaskStatus::class)],
            'due_date' => ['nullable', 'date'],
        ];
        if ($this->isMethod('post')) {
            $rules['title'] = ['required', 'string', 'max:255'];
        } else {
            $rules['title'] = ['sometimes', 'required', 'string', 'max:255'];
        }
        return $rules;
    }
}
