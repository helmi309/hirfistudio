<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Spl;
use App\Domain\Contracts\SplInterface;
use App\Domain\Contracts\Crudable;

/**
 * Class SplRepository.
 * @package App\Domain\Repositories
 */
class SplRepository extends AbstractRepository implements SplInterface, Crudable
{

    /**
     * @var Spl
     */
    protected $model;

    /**
     * Konstruktor SplRepository.
     *
     * @param Spl $spl
     */
    public function __construct(Spl $spl)
    {
        $this->model = $spl;
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
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('pekerjaan', 'like', '%' . $search . '%')
                    ->orWhere('tanggal', 'like', '%' . $search . '%');
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
        // dump($data); Digunakan untuk mengubah/mengekspor database ke dalam file SQL.
        // Mengeksekusi Create data ke dalam SQL.
        return parent::create([
            'nama'             => e($data['nama']),
            'jam_masuk'        => e($data['jam_masuk']),
            'jam_keluar'       => e($data['jam_keluar']),
            'pekerjaan'        => e($data['pekerjaan']),
            'tanggal'          => e($data['tanggal']),
            'penanggung_jawab' => e($data['penanggung_jawab']),
            'pin'              => e($data['pin'])
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
            'nama'             => e($data['nama']),
            'jam_masuk'        => e($data['jam_masuk']),
            'jam_keluar'       => e($data['jam_keluar']),
            'pekerjaan'        => e($data['pekerjaan']),
            'tanggal'          => e($data['tanggal']),
            'penanggung_jawab' => e($data['penanggung_jawab']),
            'pin'              => e($data['pin'])
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
