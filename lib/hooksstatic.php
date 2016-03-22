<?php

/**
 * ownCloud - Activity App
 *
 * @author Joas Schilling
 * @copyright 2014 Joas Schilling nickvergessen@owncloud.com
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace OCA\OobActivity;

use OCP\Util;

/**
 * The class to handle the filesystem hooks
 */
class HooksStatic {
	/**
	 * Registers the filesystem hooks for basic filesystem operations.
	 * All other events has to be triggered by the apps.
	 */
	public static function register() {
		Util::connectHook('OC_Filesystem', 'post_create', 'OCA\OobActivity\HooksStatic', 'fileCreate');
		Util::connectHook('OC_Filesystem', 'post_update', 'OCA\OobActivity\HooksStatic', 'fileUpdate');
		Util::connectHook('OC_Filesystem', 'delete', 'OCA\OobActivity\HooksStatic', 'fileDelete');
		Util::connectHook('\OCA\Files_Trashbin\Trashbin', 'post_restore', 'OCA\OobActivity\HooksStatic', 'fileRestore');
		Util::connectHook('OCP\Share', 'post_shared', 'OCA\OobActivity\HooksStatic', 'share');

		Util::connectHook('OC_User', 'post_deleteUser', 'OCA\OobActivity\HooksStatic', 'deleteUser');
	}

	/**
	 * @return Hooks
	 */
	static protected function getHooks() {
		$app = new AppInfo\Application();
		return $app->getContainer()->query('Hooks');
	}

	/**
	 * Store the create hook events
	 * @param array $params The hook params
	 */
	public static function fileCreate($params) {
		self::getHooks()->fileCreate($params);
	}

	/**
	 * Store the update hook events
	 * @param array $params The hook params
	 */
	public static function fileUpdate($params) {
		self::getHooks()->fileUpdate($params);
	}

	/**
	 * Store the delete hook events
	 * @param array $params The hook params
	 */
	public static function fileDelete($params) {
		self::getHooks()->fileDelete($params);
	}

	/**
	 * Store the restore hook events
	 * @param array $params The hook params
	 */
	public static function fileRestore($params) {
		self::getHooks()->fileRestore($params);
	}

	/**
	 * Manage sharing events
	 * @param array $params The hook params
	 */
	public static function share($params) {
		self::getHooks()->share($params);
	}

	/**
	 * Delete remaining activities and emails when a user is deleted
	 * @param array $params The hook params
	 */
	public static function deleteUser($params) {
		self::getHooks()->deleteUser($params);
	}
}
