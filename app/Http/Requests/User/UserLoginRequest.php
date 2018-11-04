<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;


/**
 * Class ProvinsiCreateRequest
 * @package App\Http\Requests\Provinsi
 */
class UserLoginRequest extends Request
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
        'email'     => 'email',
        'password'  => 'password',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
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
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        $message = $validator->errors();
        return [
            'success'    => false,
            'validation' => [
                'email'     => $message->first('email'),
                'password'  => $message->first('password'),
            ]
        ];
    }
}
