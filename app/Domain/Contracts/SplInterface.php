<?php

namespace App\Domain\Contracts;

/**
 * Interface SplInterface.
 * @package App\Domain\Contracts
 */
interface SplInterface {

    /**
     * @param int $limit
     * @param int $page
     * @param array $column
     * @param $field
     * @param string $search
     * @return mixed
     */
    public function paginate($limit = 10, $page = 1, array $column, $field, $search = '');

}
