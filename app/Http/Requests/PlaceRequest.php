<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
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
            'image'=>'required | mimes:jpeg,jpg,png,gif |max:10000',
            'category_id'=>'required',
            'overview'=>'required',
            'address'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم فارغ',
            'image.required' => 'حقل الصورة فارغ',
            'category_id.required' => 'حقل القسم فارغ',
            'address.required' => 'حقل العنوان فارغ',
            'overview.required' => 'حقل النبذة فارغ',
            'latitude.required' => 'حقل خط العرض فارغ',
            'longitude.required' => 'حقل خط الطول فارغ',
            'name.min' => 'محتوى الاسم قصير جدًا',
            'name.max' => 'عذرا حجم الصورة كبير جدا',
            'image.mimes' => 'يجب أن يكون نوع الصورة Jpeg أو jpg أو png أو gif',
        ];
    }
}
