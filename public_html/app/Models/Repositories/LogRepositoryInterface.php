<?php
namespace App\Models\Repositories;

interface LogRepositoryInterface
{
    /**
     * Get All Records
     * @return array return all data
     */
    public function getAll();

    /**
     * Get Data
     * @return array data
     */
    public function getData();

    /**
     * Add data
     * @param  array $data
     * @return array
     */
    public function addLog($data);
}
