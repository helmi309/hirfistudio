<?php
/**
 * Created by PhpStorm.
 * User: Dony
 * Date: 9/16/2015
 * Time: 9:24 AM
 */

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\Request;

/**
 * Class PassRequest
 * @package App\Http\Requests\Master
 */
class PasswordRequest extends Request
{
    /**
     * @var array
     */
    protected $attrs = [
        'old_password'              => 'Password',
        'new_password'              => 'Password baru',
        'new_password_confirmation' => 'Konfirmasi Password baru',

    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password'              => 'required',
            'new_password'              => 'between:6,25|confirmed',
            'new_password_confirmation' => 'between:6,25',
        ];
    }

    /**
     * @param $validator
     *
     * @return mixed
     */
    public function validator($validator)
    {
        return $validator->make($this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attrs);
    }

    /**
     * @param Validator $validator
     *
     * @return array
     *
     */
    protected function formatErrors(Validator $validator)
    {
        $message = $validator->errors();

        return [
            'success'    => false,
            'validation' => [
                'old_password'              => $message->first('old_password'),
                'new_password'              => $message->first('new_password'),
                'new_password_confirmation' => $message->first('new_password_confirmed'),
            ],
        ];
    }
}