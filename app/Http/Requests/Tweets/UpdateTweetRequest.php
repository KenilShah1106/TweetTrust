<?php

namespace App\Http\Requests\Tweets;

use App\Models\Tweet;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTweetRequest extends FormRequest
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
        return array_merge(Tweet::UPDATE_RULES);
    }
}
