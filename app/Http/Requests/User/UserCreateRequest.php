<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class UserCreateRequest
 *
 * @package App\Http\Requests\User
 */
class UserCreateRequest extends Request
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
     * Declaration an attributes
     *
     * @var array
     */
    protected $attrs = [
        'username'     => 'Username',
        'email'        => 'Email',
        'password'     => 'Password',
        'level'        => 'Level'
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'     => 'required|max:225',
            'email'        => 'required|max:255',
            'password'     => 'required|max:255',
            'level'        => 'required|max:255'
        ];
    }

    /**
     * Menampilkan Error (Validator).
     *
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
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        $message = $validator->errors();

        return [
            'success'    => false,
            'validation' => [
                'username'     => $message->first('username'),
                'email'        => $message->first('email'),
                'password'     => $message->first('password'),
                'level'        => $message->first('level')
            ]
        ];
    }

}
