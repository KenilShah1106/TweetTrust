<?php

namespace App\Http\Requests\Questions;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
        return array_merge(Question::UPDATE_RULES, ['title' => 'required|unique:questions,title,' . $this->question->id,
        ]);
    }
}
