<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterVoteRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            //
            'document_id' => ['required', 'exists:documents,id'],
            'session_id' => ['required', 'exists:sessions,id'],
            'user_id' => ['required', 'exists:users,id'],
            'vote_category_id' => ['required', 'exists:vote_categories,id'],
        ];
    }
}
