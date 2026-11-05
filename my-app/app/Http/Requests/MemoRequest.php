<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MemoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $required = $this->isMethod('post') ? 'required' : 'sometimes';
        $rules = [
            'title' => [$required, 'required', 'string', 'max:255'],
            'meeting_date' => [$required, 'required', 'date_format:Y-m-d'],
            'meeting_time' => ['sometimes', 'nullable', 'date_format:H:i'],
            'meeting_end_time' => ['sometimes', 'nullable', 'date_format:H:i'],
            'agenda' => ['sometimes', 'nullable', 'string', 'max:20000'],
            'summary_text' => [$this->isMethod('post') ? 'prohibited' : 'sometimes', 'nullable', 'string', 'max:200000'],
            'letter' => ['sometimes', 'nullable', 'array:letter_number,subject,letter_date,recipient,opening_paragraph,signer_name,signer_position,signer_rank'],
            'letter.letter_date' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'letter.opening_paragraph' => ['sometimes', 'nullable', 'string', 'max:10000'],
            'attendees' => ['sometimes', 'array', 'max:200'],
            'attendees.*' => ['array:name,agency_or_position,source'],
            'attendees.*.name' => ['required', 'string', 'max:255'],
            'attendees.*.agency_or_position' => ['nullable', 'string', 'max:255'],
            'attendees.*.source' => ['sometimes', 'in:manual,sigap_sync'],
        ];
        foreach (['location', 'leader_name', 'notetaker_name'] as $field) {
            $rules[$field] = ['sometimes', 'nullable', 'string', 'max:255'];
        }
        foreach (['letter_number', 'subject', 'recipient', 'signer_name', 'signer_position', 'signer_rank'] as $field) {
            $rules['letter.'.$field] = ['sometimes', 'nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}
