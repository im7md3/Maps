<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'name'=>'required | min:5',
            'email'=>'required | email',
            'place_url'=>'required '
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم فارغ',
            'email.required' => 'حقل البريد الإلكتروني فارغ',
            'place_url.required' => 'حقل الرابط فارغ',
            'name.min' => 'محتوى الاسم قصير جدًا',
            'email.email' => 'البريد الإلكتروني المدخل غير صحيح',
        ];
    }
}
