<?php

namespace LaraSnap\LaravelAdmin\Requests;

use LaraSnap\LaravelAdmin\Models\Screen;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use LaraSnap\LaravelAdmin\Rules\CheckRouteName;

class ScreenRequest extends FormRequest
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
            'name' => [
                'required', Rule::unique((new Screen)->getTable())->ignore($this->route()->screen ?? null), new CheckRouteName
            ],
			'label' => [
                'required', 'alpha_spaces'
            ],
            'module_id' => [
                'required'
            ],
        ];
    }
    
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'module_id.required' => 'The module field is required. Please select valid module from the auto-complete list.',
        ];
    }
}
