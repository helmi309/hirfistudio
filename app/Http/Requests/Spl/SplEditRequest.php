<?php

namespace App\Http\Requests\Spl;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class SplCreateRequest
 *
 * @package App\Http\Requests\Spl
 */
class SplEditRequest extends Request
{

    /**
     * Determine if the spl is authorized to make this request.
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
        'nama'             => 'Nama',
        'jam_masuk'        => 'Jam_masuk',
        'jam_keluar'       => 'Jam_keluar',
        'pekerjaan'        => 'Pekerjaan',
        'tanggal'          => 'Tanggal',
        'penanggung_jawab' => 'Penanggung_jawab',
        'pin'              => 'Pin'
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama'             => 'required|max:225',
            'jam_masuk'        => 'required|max:255',
            'jam_keluar'       => 'required|max:255',
            'pekerjaan'        => 'required|max:255',
            'tanggal'          => 'required|max:255',
            'penanggung_jawab' => 'required|max:255',
            'pin'              => 'required|max:2555'
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
                'nama'             => $message->first('nama'),
                'jam_masuk'        => $message->first('jam_masuk'),
                'jam_keluar'       => $message->first('jam_keluar'),
                'pekerjaan'        => $message->first('pekerjaan'),
                'tanggal'          => $message->first('tanggal'),
                'penanggung_jawab' => $message->first('penanggung_jawab'),
                'pin'              => $message->first('pin')
            ]
        ];
    }

}
