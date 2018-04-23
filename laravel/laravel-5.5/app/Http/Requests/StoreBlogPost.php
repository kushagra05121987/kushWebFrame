<?php

namespace App\Http\Requests;

use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
            'email' => ['required', 'email'],
            'username' => ['required', new Uppercase, 'min:3', "max:10"],
            'file' => 'required|size:10'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required for me.',
            'username.required'  => 'Please supply username. Otherwise who are we supposed to map this account with.',
            'file.size' => 'Size uploaded by you is correct. Its just that we don\'t like your file.'
        ];
    }

    public function withValidator($validator)
    {
        echo "Running soon after my validator instance is created but just before evaluating it";

        $validator->after(function ($validator) {
            \Dumper::dump('Running after inside withValidator');
            \Dumper::dump($errors = $validator -> errors() -> add('Manualy added', "true"));
            \Dumper::dump($errors -> has('email'));

            dd("exiting");
        });
    }
}
