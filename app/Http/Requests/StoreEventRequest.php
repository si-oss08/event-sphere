<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isOrganizer() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
            'venue' => ['required', 'string', 'max:160'],
            'city' => ['required', 'string', 'max:80'],
            'address' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date', 'after:now'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'capacity' => ['required', 'integer', 'min:1', 'max:100000'],
            'price' => ['required', 'numeric', 'min:0', 'max:100000000'],
            'status' => ['required', 'in:draft,published,cancelled'],
            'featured' => ['sometimes', 'boolean'],
            'poster' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'judul event',
            'category_id' => 'kategori',
            'description' => 'deskripsi',
            'venue' => 'lokasi',
            'city' => 'kota',
            'address' => 'alamat',
            'starts_at' => 'waktu mulai',
            'ends_at' => 'waktu selesai',
            'capacity' => 'kuota',
            'price' => 'harga tiket',
            'status' => 'status',
            'poster' => 'poster',
        ];
    }
}
