<?php

namespace App\Http\Requests\Replies;

use App\Models\Replies;
use Illuminate\Foundation\Http\FormRequest;

class CreateRepliesRequest extends FormRequest
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
        return Replies::CREATE_RULES;
    }
}
