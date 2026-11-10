<?php

namespace App\Http\Requests;

class UpdateEventRequest extends StoreEventRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $event = $this->route('event');

        return $this->user()?->can('update', $event) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['starts_at'] = ['required', 'date'];
        $rules['featured'] = ['sometimes', 'boolean'];

        return $rules;
    }
}
