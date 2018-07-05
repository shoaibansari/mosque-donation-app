<?php

/**
 * @return \App\Classes\CToolBox\CToolBox
 */
function toolbox() {
	return \App\Classes\CToolBox\CToolBox::instance();
}

/**
 * @param null $key
 * @param string $column
 * @return \App\Models\Repositories\Eloquent\SettingRepository|mixed|null
 */
function settings( $key=null, $column='value' ) {
	return \App\Models\Repositories\Eloquent\SettingRepository::instance( $key, $column);
}

/**
 * A global helper to access repositories
 *
 * @return \App\Classes\AppRepo
 */
function repo() {
	return \App\Classes\AppRepo::instance();
}
