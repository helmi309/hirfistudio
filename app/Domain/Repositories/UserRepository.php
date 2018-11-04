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
            'id'       => e($data['id']),
            'username' => e($data['username']),
            'email'    => e($data['email']),
            'password' => e($data['password']),
            'level'    => e($data['level']),
            'pin'      => e($data['pin'])
        ]);
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
            'id'       => e($data['id']),
            'username' => e($data['username']),
            'email'    => e($data['email']),
            'password' => e($data['password']),
            'level'    => e($data['level']),
            'pin'      => e($data['pin'])
        ]);
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
