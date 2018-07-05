<?php
namespace App\Models\Repositories;

interface PageRepositoryInterface {

	public function getBySlug( $slug );

}