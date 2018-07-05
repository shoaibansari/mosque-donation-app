<?php
namespace App\Models\Repositories;

interface SiteSettingsRepositoryInterface
{
    /**
     * Get All Records
     * @return array return all data
     */
    public function getAll();

    /**
     * Get All Results
     * @param  array $inputs [description]
     * @return array         [description]
     */
    public function getAllResults($inputs);

    /**
     * Get Data
     * @return array data
     */
    public function getData();

    /**
     * Get data by ID
     * @param  integer $id data id
     * @return array data by id
     */
    public function getSiteSetting($id);

    /**
     * Get All Site Settings as an Array
     * @return array
     */
    public function getSiteSettings();

    /**
     * Get setting by name
     * @param  string $name setting name
     * @return array|string
     */
    public function getSiteSettingByName($name, $api = false);

    /**
     * Add data
     * @param array $data
     * @return array
     */
    public function addSiteSetting($data);

    /**
     * Update data by id
     * @param  integer $id data id
     * @param array $data
     * @return array
     */
    public function updateSiteSetting($id = 0, $data);

    /**
     * Delete SiteSetting by id
     * @param  integer $id data id
     * @return array data
     */
    public function deleteSiteSetting($id = 0);
}
