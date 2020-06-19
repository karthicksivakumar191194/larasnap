<?php

namespace LaraSnap\LaravelAdmin\Requests;

use LaraSnap\LaravelAdmin\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $parentCategory = Category::where([['id', '=', $this->route('p_category')], ['is_parent', '=', 1], ['status', '=', 1]])->withCount('childCategory')->first(); 
        $childCategoryCount  = $parentCategory->child_category_count;
        
        $positionMax = $this->route()->category ? 'max:'.$childCategoryCount : null;
        
        return [
            'name' => [
                'required', Rule::unique((new Category)->getTable())->ignore($this->route()->category ?? null)
            ],
			'label' => [
                'required'
            ],
            'is_parent' => [
                'required'
            ],
            'position' => [
                'required', 'min:1', $positionMax, 'numeric'
            ],
        ];
    }
    
    public function messages()
	{
		return [
			'is_parent.required'    => 'The parent catefory field is required.',		
		];
		
	}
    
}
