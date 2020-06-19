<?php

namespace LaraSnap\LaravelAdmin\Requests;

use LaraSnap\LaravelAdmin\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryParentRequest extends FormRequest
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
                'required', Rule::unique((new Category)->getTable())->ignore($this->route()->p_category ?? null)
            ],
			'label' => [
                'required'
            ],
        ];
    }
}
