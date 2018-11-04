<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;
use App\Domain\Contracts\UserInterface;
use App\Domain\Contracts\Crudable;

/**
 * Class UserRepository.
 * @package App\Domain\Repositories
 */
class UserRepository extends AbstractRepository implements UserInterface, Crudable
{

    /**
     * @var User
     */
    protected $model;

    /**
     * Konstruktor UserRepository.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @param int $limit
     * @param int $page
     * @param array $column
     * @param string $field
     * @param string $search
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate($limit = 10, $page = 1, array $column = ['*'], $field, $search = '')
    {
    // Query Searching ke dalam SQL.
    $akun = $this->model
            ->where(function ($query) use ($search) {
                $query->where('pin', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
                })
        
            ->paginate($limit)
            ->toArray();
        return $akun;    
    }

    /**
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(array $data)
    {
        // Mengeksekusi Create data ke dalam SQL.
        return parent::create([
            'username' => e($data['username']),
            'email'    => e($data['email']),
            'password' => bcrypt($data['password']),
            'level'    => '0',
            'verifikasi'    => '0',
            'pin'      => e($data['pin'])
        ]);
    }
    public function createbylangdingpage(array $data)
    {
        try {
            $verifikasi =str_random(36);
            // Mengeksekusi Create data ke dalam SQL.
            $simpan =parent::create([
                'username' => e($data['username']),
                'email' => e($data['email']),
                'password' => bcrypt($data['password']),
                'level' => '0',
                'verifikasi' => $verifikasi,
                'pin' => e($data['pin'])
            ]);

        \Mail::send('emails/email', [

            'username' => $data['username'],
            'email' => $data['email'],
            'verivikasi' => $verifikasi,], function ($message) use ($data) {

            $message->to($data['email']);
            $message->subject('Info dari Hirfistudio');

        });
            session()->flash('auth_message', 'Data Berhasil Dibuat Silahkan Konfirmasi email.');

            return redirect('/sigup');
        }
        catch (\Exception $e) {
            // store errors to log
            \Log::error('class : ' . UserRepository::class . ' method : create | ' . $e);

            return $e;
        }
    }


    /**
     * @param $id
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id, array $data)
    {
        // Mengeksekusi Update data ke dalam SQL.
        return parent::update($id, [
            'username' => e($data['username']),
            'email'    => e($data['email']),
            'pin'      => e($data['pin'])
        ]);
    }

    public function updatePassword(array $data)
    {
        try {
            $user = $this->model->find(session('user_id'));
            if ($user) {
                $old_password = $user->password;

                if (\Hash::check($data['old_password'], $old_password)) {
                    // flush cache with tags

                    $user->password = bcrypt($data['new_password']);
                    $user->save();

                    return $this->updateSuccess($data);
                }

                return [
                    'success' => false,
                    'result'  => [
                        'message' => 'Password lama tidak cocok.',
                    ],
                ];
            }

            return [
                'success' => false,
                'result'  => [
                    'message' => 'Data tidak ditemukan',
                ],
            ];
        } catch (\Exception $e) {
            // store errors to log
            \Log::error('class : ' . UserRepository::class . ' method : put | ' . $e);

            return $this->createError();
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete($id)
    {
        // Mengeksekusi Delete data ke dalam SQL
        return parent::delete($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findById($id, array $columns = ['*'])
    {
        return parent::find($id, $columns);
    }

}
