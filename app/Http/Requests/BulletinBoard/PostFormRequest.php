<?php

namespace App\Http\Requests\BulletinBoard;

use Error;
use Illuminate\Foundation\Http\FormRequest;


class PostFormRequest extends FormRequest
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
     *  rules()の前に実行される
     *       $this->merge(['key' => $value])を実行すると、
     *       フォームで送信された(key, value)の他に任意の(key, value)の組み合わせをrules()に渡せる
     */
    public function getValidatorInstance()
    {

        // プルダウンで選択された値(= 配列)を取得
        // フォームから日付情報を取得
        $year = $this->input('old_year');
        $month = $this->input('old_month');
        $date = $this->input('old_day');

        $birth_day = [$year, $month, $date];

        // 日付を作成(ex. 2020-1-20)
        $birth_day = implode('-', $birth_day);
        // rules()に渡す値を追加でセット
        // これで、この場で作った変数にもバリデーションを設定できるようになる
        $this->merge([
            'birth_day' => $birth_day,
        ]);

        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            // 'post_title' => 'min:4|max:50',
            // 'post_body' => 'min:10|max:500',

            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|katakana|max:30',
            'under_name_kana' => 'required|string|katakana|max:30',
            'mail_address' => 'required|email|unique:users|max:100',
            'sex' => 'required|regex:/^[1-3]$/',
            'old_year' => 'valid_date_range',
            'birth_day' => [
                'date',
                'valid_date_range', // あなたの独自のカスタムバリデーションルール
            ],
            'role' => 'required|regex:/^[1-4]$/',
            'password' => 'required|min:8|max:30|same:password_confirmation'

        ];
    }

    public function messages()
    {
        return [
            // 'post_title.min' => 'タイトルは4文字以上入力してください。',
            // 'post_title.max' => 'タイトルは50文字以内で入力してください。',
            // 'post_body.min' => '内容は10文字以上入力してください。',
            // 'post_body.max' => '最大文字数は500文字です。',

            'required' => ':attributeは必ず入力してください。',
            'string' => ':attributeは文字列の型である必要があります。',
            'email' => ':attributeは有効なメールアドレスである必要があります。',
            'unique' => ':attributeは既に登録されています。',
            'katakana' => ':attributeはカタカナのみである必要があります。',
            'date' => ':attributeは正しい日付である必要があります。',
            'in' => ':attributeは:valuesのいずれかである必要があります。',
            'min' => ':attributeは:min文字以上である必要があります。',
            'max' => ':attributeは:max文字以下である必要があります。',
            'same' => ':attributeと:otherは同じである必要があります。',
            'integer' => ':attributeは整数を入力して下さい',
            'valid_date_range' => '2000年以前、もしくは日付が有効でない為、登録出来ません。'

        ];
    }
}
