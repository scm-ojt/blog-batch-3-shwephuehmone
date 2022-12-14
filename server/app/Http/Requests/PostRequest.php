<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'image' => 'required',
            'title' => 'required|max50:',
            'body' => 'required|max:225',
        ];
    }

    /**
     * Summary of messages
     * @return array<string>
     */
    public function messages()
    {
        return [
            'image.required' => 'Image is required',
            'title.max' => 'Your text must not be more than 50 characters.',
            'title.required' => 'Post Title is required',
            'body.required' => 'Post body is required',
            'post.max' => 'Your text must not be more than 225 characters.',
        ];
    }
}