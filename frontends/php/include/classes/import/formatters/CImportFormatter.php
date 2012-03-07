<?php
/*
** Zabbix
** Copyright (C) 2000-2012 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


/**
 * Abstract class to extend for all import formatters.
 * For each different version of configuration import new formatter should be defined. All formatters must return
 * data in one format, so that further processing is independent from configuration import version.
 */
abstract class CImportFormatter {

	/**
	 * @var array configuration import data
	 */
	protected $data;

	/**
	 * Data property setter.
	 *
	 * @param array $data
	 */
	public function setData(array $data) {
		$this->data = $data;
	}

	/**
	 * Renames array elements keys according to given map.
	 *
	 * @param array $data
	 * @param array $fieldMap
	 *
	 * @return array
	 */
	protected function renameData(array $data, array $fieldMap) {
		foreach ($data as $key => $value) {
			if (isset($fieldMap[$key])) {
				$data[$fieldMap[$key]] = $value;
				unset($data[$key]);
			}
		}
		return $data;
	}

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getGroups();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getTemplates();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getHosts();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getApplications();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getItems();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getDiscoveryRules();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getGraphs();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getTriggers();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getImages();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getMaps();

	/**
	 * @abstract
	 * @return array
	 */
	abstract public function getScreens();
}
