<?php

namespace LaraSnap\LaravelAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'site_name' => [
                'required'
            ],
            'site_logo' => [
                'nullable','mimes:jpg,jpeg,png','max:1024'
            ],
            'admin_email' => [
                'required', 'email'
            ],
            'date_format' => [
                'required'
            ],
            'entries_per_page' => [
                'required'
            ],
        ];
    }
}
