<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->input('anonymous')) {
            return [
                'message' => 'string', // Сообщение Минимум 10 символов, максимум 200;
                'anonymous' => 'boolean', // Отправить анонимно, boolean.
            ];
        }
        return [
            'email' => 'email|unique:App\Models\Feedback,email', // обязательное, является валидным значением email;
            // 'phone' => 'regex:/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i', // обязательное, значение соответствует моб.номеру;
            'first_name' => 'string|max:15', // обязательное, длина максимум 15 символов;
            'last_name' => 'string|max:20', // Обязательное, если не заполнено Отчество, длина максимум 20 символов;
            'middle_name' => 'string', // Обязательное, если не заполнена Фамилия;
            'message' => 'string|min:10|max:200', // Сообщение Минимум 10 символов, максимум 200;
            'anonymous' => 'boolean', // Отправить анонимно, boolean.
        ];
    }
}
