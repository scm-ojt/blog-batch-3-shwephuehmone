<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "user_id" => "required",
            "post_id" => "required",
            "body" => "required|max:200"
        ];
    }

    /**
     * Summary of messages
     * @return array<string>
     */
    public function messages()
    {
        return [
            'body.required' => 'Text is required',
            'body.max' => 'Your text must not be more than 50 characters.'
        ];
    }
}