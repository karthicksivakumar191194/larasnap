<?php

namespace LaraSnap\LaravelAdmin\Requests;

use LaraSnap\LaravelAdmin\Models\Module;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
            'label' => [
                'required', Rule::unique((new Module)->getTable())->ignore($this->route()->module ?? null)
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
        return [];
    }
}
