<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' =>  ['required', 'string', 'max:10'],
            'over_name_kana' => ['max:1', 'regex:/^[男|女]+$/u'],
            'under_name_kana' => ['required', 'string', 'regex:/^[ァ-ヶー]+$/u', 'max:30'],
            'mail_address' => ['required', 'email', 'max:100', 'unique:users'],
            'sex' => ['required', 'integer', 'in:1,2,3'],
            'birth_day' => ['required', 'date', 'after_or_equal:1900-01-01', Rule::beforeOrEqual(now()->toDateString())],
            'role' => ['required', 'integer', 'in:1,2,3,4'],
            'password' => ['required','min:8', 'max:30', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required','min:8', 'max:30','same:password'],
        ];
    }

    public function messages()
    {
        return [
            'over_name_kana.regex' => '名前にはカタカナのみを入力してください。',
            'under_name_kana.regex' => '名前にはカタカナのみを入力してください。',
            'over_name_kana.max' => 'ユーザー名は30文字以下です。',
            'under_name_kana.max' => 'ユーザー名は30文字以下です。',
            'email.email' => '※メール形式で入力してください。',
            'email.max' => 'メールアドレスは100文字以下です。',
            'sex.required' => '性別は男性、女性、その他のいずれかを選択してください。',
            'sex.in:1,2,3' => '男性、女性、その他は以外無効です。',
            'birth_day.required' => '※生年月日が未入力です。',
            'role.in:1,2,3,4' =>  '役職は「講師(国語)」、「講師(数学)」、「教師(英語)」、「生徒」のいずれかを選択してください。',
            'password.min' => 'パスワードは8文字以上です。',
            'password.max' => 'パスワードは30文字以下です。',
        ];
}


    public function postValidates(PostRequest $request) {
        return view('register.register',['msg'=>'OK']);
}

}
