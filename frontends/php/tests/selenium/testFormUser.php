<?php
/*
** Zabbix
** Copyright (C) 2001-2019 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/

require_once dirname(__FILE__) . '/../include/CLegacyWebTest.php';

/**
 * @backup users
 */
class testFormUser extends CLegacyWebTest {

	public function getCreateData() {
		return [
			// Alias is already taken by another user.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Admin',
						'Groups' => 'Zabbix administrators',
						'Password' => '123',
						'Password (once again)' => '123'
					],
					'error_details' => 'User with alias "Admin" already exists.'
				]
			],
			// Empty 'Alias' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => '',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'error_title' => 'Page received incorrect data',
					'error_details' => 'Incorrect value for field "Alias": cannot be empty.'
				]
			],
			// Space as 'Alias' field value.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => '   ',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'error_title' => 'Page received incorrect data',
					'error_details' => 'Incorrect value for field "Alias": cannot be empty.'
				]
			],
			// Empty 'Group' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'error_details' => 'Invalid parameter "/1/usrgrps": cannot be empty.'
				]
			],
			// 'Password' fields not specified.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators'
					],
					'error_details' => 'Incorrect value for field "passwd": cannot be empty.'
				]
			],
			// Empty 'Password (one again)' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix'
					],
					'error_title' => 'Cannot add user. Both passwords must be equal.'
				]
			],
			// Empty 'Password' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password (once again)' => 'zabbix'
					],
					'error_title' => 'Cannot add user. Both passwords must be equal.'
				]
			],
			// 'Password' and 'Password (once again)' do not match.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'PaSSwOrD',
						'Password (once again)' => 'password'
					],
					'error_title' => 'Cannot add user. Both passwords must be equal.'
				]
			],
			// Empty 'Refresh' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Refresh' => ''
					],
					'error_details' => 'Invalid parameter "/1/refresh": cannot be empty.'
				]
			],
			// Digits in value of the 'Refresh' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Refresh' => '123abc'
					],
					'error_details' => 'Invalid parameter "/1/refresh": a time unit is expected.'
				]
			],
			// Value of the 'Refresh' field too large.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Refresh' => '3601'
					],
					'error_details' => 'Invalid parameter "/1/refresh": value must be one of 0-3600.'
				]
			],
			// Non-time unit value in 'Refresh' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Refresh' => '00000000000001'
					],
					'error_details' => 'Invalid parameter "/1/refresh": a time unit is expected.'
				]
			],
			// 'Rows per page' field equal to '0'.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Rows per page' => '0'
					],
					'error_title' => 'Page received incorrect data',
					'error_details' => 'Incorrect value "0" for "Rows per page" field: must be between 1 and 999999.'
				]
			],
			// Non-numeric value of 'Rows per page' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Rows per page' => 'abc123'
					],
					'error_title' => 'Page received incorrect data',
					'error_details' => 'Incorrect value "0" for "Rows per page" field: must be between 1 and 999999.'
				]
			],
			// 'Autologout' below minimal value.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'auto_logout' => [
						'checked' => true,
						'value' => '89'
					],
					'error_details' => 'Invalid parameter "/1/autologout": value must be one of 0, 90-86400.'
				]
			],
			// 'Autologout' above maximal value.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'auto_logout' => [
						'checked' => true,
						'value' => '86401'
					],
					'error_details' => 'Invalid parameter "/1/autologout": value must be one of 0, 90-86400.'
				]
			],
			// 'Autologout' with a non-numeric value.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'auto_logout' => [
						'checked' => true,
						'value' => 'ninety'
					],
					'error_details' => 'Invalid parameter "/1/autologout": a time unit is expected.'
				]
			],
			// 'Autologout' with an empty value.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'auto_logout' => [
						'checked' => true,
						'value' => ''
					],
					'error_details' => 'Invalid parameter "/1/autologout": cannot be empty.'
				]
			],
			// URL with a space in the middle.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'URL (after login)' => 'www.goo gle.com'
					],
					'error_details' => 'Invalid parameter "/1/url": unacceptible URL.'
				]
			],
			// External URL without protocol.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'URL (after login)' => 'google.com'
					],
					'error_details' => 'Invalid parameter "/1/url": unacceptible URL.'
				]
			],
			// Internal URL without extention.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'URL (after login)' => 'screenconf'
					],
					'error_details' => 'Invalid parameter "/1/url": unacceptible URL.'
				]
			],
			// Incorrect URL protocol.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Alias' => 'Negative_Test',
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'URL (after login)' => 'snmp://google.com'
					],
					'error_details' => 'Invalid parameter "/1/url": unacceptible URL.'
				]
			],
			// Creating user by specifying only mandatory parameters.
			[
				[
					'expected' => TEST_GOOD,
					'fields' => [
						'Alias' => 'Mandatory_user',
						'Groups' => 'Guests',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					]
				]
			],
			// Creating a user with optional parameters specified (including autologout) using Cyrillic charatcers.
			[
				[
					'expected' => TEST_GOOD,
					'fields' => [
						'Alias' => 'Оверлорд',
						'Name' => 'Антон Антонович',
						'Surname' => 'Антонов',
						'Groups' => 'Zabbix administrators',
						'Password' => '123',
						'Password (once again)' => '123',
						'Language' => 'Russian (ru_RU)',
						'Theme' => 'High-contrast dark',
						'Auto-login' => false,
						'Refresh' => '10m',
						'Rows per page' => '999999',
						'URL (after login)' => 'https://google.com'
					]
				]
			],
			// Creating a user with punctuation symbols in password and optional parameters specified.
			[
				[
					'expected' => TEST_GOOD,
					'fields' => [
						'Alias' => 'Detailed user',
						'Name' => 'Bugs',
						'Surname' => 'Bunny',
						'Groups' => [
							'Selenium user group',
							'Zabbix administrators'
						],
						'Password' => '!@#$%^&*()_+',
						'Password (once again)' => '!@#$%^&*()_+',
						'Language' => 'English (en_US)',
						'Theme' => 'Dark',
						'Auto-login' => true,
						'Refresh' => '10s',
						'Rows per page' => '5',
						'URL (after login)' => 'screenconf.php'
					],
					'check_user' => true,
					'auto_logout' => [
						'checked' => true,
						'value' => '10m'
					]
				]
			],
			// Verification that field password is not mandatory for users with LDAP authentification.
			[
				[
					'expected' => TEST_GOOD,
					'fields' => [
						'Alias' => 'LDAP_user',
						'Groups' => 'LDAP user group'
					]
				]
			],
			// Verification that field password is not mandatory for users with no access to frontend.
			[
				[
					'expected' => TEST_GOOD,
					'fields' => [
						'Alias' => 'No_frontend_user',
						'Groups' => 'No access to the frontend'
					]
				]
			]
		];
	}

	/**
	 * @dataProvider getCreateData
	 */
	public function testFormUser_Create($data) {
		$good_title = 'User added';
		$bad_title = 'Cannot add user';
		$this->page->login()->open('users.php?form=create');
		$form = $this->query('name:userForm')->asForm()->waitUntilVisible()->one();
		$form->fill($data['fields']);

		if (array_key_exists('auto_logout', $data)) {
			$auto_logout = $form->getFieldElements('Auto-logout');
			$auto_logout->get(0)->asCheckbox()->set($data['auto_logout']['checked']);
			if (array_key_exists('value', $data['auto_logout'])) {
				$auto_logout->get(3)->overwrite($data['auto_logout']['value']);
			}
			//verify that Auto-login is unchecked after setting Auto-logout
			$this->assertTrue($form->getField('Auto-login')->isChecked(false));
		}
		$form->submit();
		$this->page->waitUntilReady();
		$message = CMessageElement::find()->one();
		// Verify that the user was created.
		$this->assertUserMessage($data, $message, $good_title, $bad_title);
		if (array_key_exists('check_user', $data)) {
			// Check that the parameters were actually updated.
			$this->assertUserParameters($data);
		}
	}

	private function assertUserParameters($data) {
		// Verify that fields are updated.
		$userid = CDBHelper::getValue('SELECT userid FROM users WHERE alias =' . zbx_dbstr($data['fields']['Alias']));
		$this->page->open('users.php?form=update&userid=' . $userid);
		$form_update = $this->query('name:userForm')->asForm()->waitUntilVisible()->one();
		$this->assertEquals($data['fields']['Alias'], $form_update->getField('Alias')->getValue());
		$this->assertEquals($data['fields']['Name'], $form_update->getField('Name')->getValue());
		$this->assertEquals($data['fields']['Surname'], $form_update->getField('Surname')->getValue());
		$this->assertEquals($data['fields']['Language'], $form_update->getField('Language')->getValue());
		$this->assertEquals($data['fields']['Refresh'], $form_update->getField('Refresh')->getValue());
		$groups = $form_update->getField('Groups')->asMultiselect()->getSelected();
		$this->assertEquals($data['fields']['Groups'], $groups);
		if (array_key_exists('auto_logout', $data)) {
			$this->assertFalse($form_update->getField('Auto-login')->isChecked($data['fields']['Auto-login']));
		}
		else {
			$this->assertTrue($form_update->getField('Auto-login')->isChecked($data['fields']['Auto-login']));
		}
		// Log in with the created user
		$this->query('class:top-nav-signout')->one()->click();
		$this->webDriver->manage()->deleteAllCookies();
		$this->query('id:name')->waitUntilVisible()->one()->fill($data['fields']['Alias']);
		if (array_key_exists('Password', $data['fields'])) {
			$this->query('id:password')->one()->fill($data['fields']['Password']);
		}
		else {
			$this->query('id:password')->one()->fill('zabbix');
		}
		$this->query('button:Sign in')->one()->click();

		// Verification of URL after login.
		$this->assertContains($data['fields']['URL (after login)'], $this->page->getCurrentURL());

		// Verification of the number of rows per page parameter.
		$rows = $this->query('name:screenForm')->asTable()->one()->getRows();
		$this->assertEquals($data['fields']['Rows per page'], $rows->count());

		// Verification of default theme.
		$sql_theme = 'SELECT theme FROM users WHERE alias =' . zbx_dbstr($data['fields']['Alias']);
		if ($data['fields']['URL (after login)'] === 'Dark') {
			$this->assertEquals('dark-theme', CDBHelper::getValue($sql_theme));
		}
		else if ($data['fields']['URL (after login)'] === 'High-contrast light') {
			$this->assertEquals('hc-light', CDBHelper::getValue($sql_theme));
		}
		$stylesheet = $this->query('xpath://link[@rel="stylesheet"]')->one();
		$file = explode('/', $stylesheet->getAttribute('href'));
		if (CDBHelper::getValue($sql_theme) === 'dark-theme') {
			$this->assertEquals('dark-theme.css', end($file));
			$body = $this->query('tag:body')->one();
			$this->assertEquals('rgba(14, 16, 18, 1)', $body->getCSSValue('background-color'));
		}
		else if (CDBHelper::getValue($sql_theme) === 'hc-light') {
			$this->assertEquals('hc-light.css', end($file));
			$body = $this->query('tag:body')->one();
			$this->assertEquals('rgba(255, 255, 255, 1)', $body->getCSSValue('background-color'));
		}
		// Set session to status active to execute remaining tests.
		DBexecute(
				'UPDATE sessions' .
				' SET status = ' . ZBX_SESSION_ACTIVE .
				' WHERE sessionid=' . zbx_dbstr('09e7d4286dfdca4ba7be15e0f3b2b55a')
		);
	}

	public function getUpdateData() {
		return [
			// Empty 'Group' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => '',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'error_details' => 'Invalid parameter "/1/usrgrps": cannot be empty.'
				]
			],
			// Empty 'Password (one again)' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix'
					],
					'error_title' => 'Cannot update user. Both passwords must be equal.'
				]
			],
			// Empty 'Password' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password (once again)' => 'zabbix'
					],
					'error_title' => 'Cannot update user. Both passwords must be equal.'
				]
			],
			// 'Password' and 'Password (once again)' do not match.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'PaSSwOrD',
						'Password (once again)' => 'password'
					],
					'error_title' => 'Cannot update user. Both passwords must be equal.'
				]
			],
			// Empty 'Refresh' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Refresh' => ''
					],
					'error_details' => 'Invalid parameter "/1/refresh": cannot be empty.'
				]
			],
			// Digits in value of the 'Refresh' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Refresh' => '123abc'
					],
					'error_details' => 'Invalid parameter "/1/refresh": a time unit is expected.'
				]
			],
			// Value of the 'Refresh' field too large.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Refresh' => '3601'
					],
					'error_details' => 'Invalid parameter "/1/refresh": value must be one of 0-3600.'
				]
			],
			// Non time unit value in 'Refresh' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Refresh' => '00000000000001'
					],
					'error_details' => 'Invalid parameter "/1/refresh": a time unit is expected.'
				]
			],
			//	'Rows per page' field equal to '0'.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Rows per page' => '0'
					],
					'error_title' => 'Page received incorrect data',
					'error_details' => 'Incorrect value "0" for "Rows per page" field: must be between 1 and 999999.'
				]
			],
			//	Non-numeric value of 'Rows per page' field.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'Rows per page' => 'abc123'
					],
					'error_title' => 'Page received incorrect data',
					'error_details' => 'Incorrect value "0" for "Rows per page" field: must be between 1 and 999999.'
				]
			],
			// 'Autologout' below minimal value.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'auto_logout' => [
						'checked' => true,
						'value' => '89'
					],
					'error_details' => 'Invalid parameter "/1/autologout": value must be one of 0, 90-86400.'
				]
			],
			// 'Autologout' above maximal value.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'auto_logout' => [
						'checked' => true,
						'value' => '86401'
					],
					'error_details' => 'Invalid parameter "/1/autologout": value must be one of 0, 90-86400.'
				]
			],
			// 'Autologout' with a non-numeric value.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'auto_logout' => [
						'checked' => true,
						'value' => 'ninety'
					],
					'error_details' => 'Invalid parameter "/1/autologout": a time unit is expected.'
				]
			],
			// 'Autologout' with an empty value.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'auto_logout' => [
						'checked' => true,
						'value' => ''
					],
					'error_details' => 'Invalid parameter "/1/autologout": cannot be empty.'
				]
			],
			// URL with a space in the middle.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'URL (after login)' => 'www.goo gle.com'
					],
					'error_details' => 'Invalid parameter "/1/url": unacceptible URL.'
				]
			],
			// External URL without protocol.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'URL (after login)' => 'google.com'
					],
					'error_details' => 'Invalid parameter "/1/url": unacceptible URL.'
				]
			],
			// Internal URL without extention.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'URL (after login)' => 'screenconf'
					],
					'error_details' => 'Invalid parameter "/1/url": unacceptible URL.'
				]
			],
			// Incorrect URL protocol.
			[
				[
					'expected' => TEST_BAD,
					'fields' => [
						'Groups' => 'Zabbix administrators',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix',
						'URL (after login)' => 'snmp://google.com'
					],
					'error_details' => 'Invalid parameter "/1/url": unacceptible URL.'
				]
			],
			// Updating all fields (except password) of an existing user.
			[
				[
					'expected' => TEST_GOOD,
					'fields' => [
						'Alias' => 'Updated_user',
						'Name' => 'Road',
						'Surname' => 'Runner',
						'Groups' => [
							'Selenium user group'
						],
						'Language' => 'English (en_US)',
						'Theme' => 'High-contrast light',
						'Auto-login' => true,
						'Refresh' => '60s',
						'Rows per page' => '2',
						'URL (after login)' => 'screenconf.php'
					],
					'check_user' => true
				]
			]
		];
	}

	/**
	 * @dataProvider getUpdateData
	 */
	public function testFormUser_Update($data) {
		$update_user = 'Tag-user';
		$good_title = 'User updated';
		$bad_title = 'Cannot update user';
		$this->page->login()->open('users.php?ddreset=1');
		$this->query('link', $update_user)->waitUntilVisible()->one()->click();
		// Update user parameters.
		$form = $this->query('name:userForm')->asForm()->one();
		$form->query('button:Change password')->one()->click();
		$form->fill($data['fields']);
		if (array_key_exists('auto_logout', $data)) {
			$auto_logout = $form->getFieldElements('Auto-logout');
			$auto_logout->get(0)->asCheckbox()->set($data['auto_logout']['checked']);
			if (array_key_exists('value', $data['auto_logout'])) {
				$auto_logout->get(3)->overwrite($data['auto_logout']['value']);
			}
		}
		$form->submit();
		$this->page->waitUntilReady();
		$message = CMessageElement::find()->one();
		// Verify if the user was updated.
		$this->assertUserMessage($data, $message, $good_title, $bad_title);
		if (array_key_exists('check_user', $data)) {
			// Check that the parameters were actually updated.
			$this->assertUserParameters($data);
		}
	}

	public function testFormUser_PasswordUpdate() {
		$data = [
			'alias' => 'user-zabbix',
			'old_password' => 'zabbix',
			'new_password' => 'zabbix_new',
			'error_message' => 'Login name or password is incorrect.',
			'attempt_message' => '1 failed login attempt logged. Last failed attempt was from'
		];
		$this->page->login()->open('users.php?ddreset=1');
		$this->query('link', $data['alias'])->waitUntilVisible()->one()->click();
		$form_update = $this->query('name:userForm')->asForm()->one();
		$form_update->query('button:Change password')->one()->click();

		// Change user password and log out.
		$form_update->fill([
			'Password' => $data['new_password'],
			'Password (once again)' => $data['new_password']
		]);
		$form_update->submit();
		$this->query('class:top-nav-signout')->one()->click();
		$this->webDriver->manage()->deleteAllCookies();

		// Atempt to sign in with old password.
		$this->query('id:name')->waitUntilVisible()->one()->fill($data['alias']);
		$this->query('id:password')->one()->fill($data['old_password']);
		$this->query('button:Sign in')->one()->click();
		$message = $this->query('class:red')->one()->getText();
		$this->assertEquals($message, $data['error_message']);

		// Sign in with new password.
		$this->query('id:name')->one()->fill($data['alias']);
		$this->query('id:password')->one()->fill($data['new_password']);
		$this->query('button:Sign in')->one()->click();
		$attempt_message = CMessageElement::find()->one();
		$this->assertTrue($attempt_message->hasLine($data['attempt_message']));

		// Set session to status active to execute remaining tests.
		DBexecute(
				'UPDATE sessions' .
				' SET status = ' . ZBX_SESSION_ACTIVE .
				' WHERE sessionid=' . zbx_dbstr('09e7d4286dfdca4ba7be15e0f3b2b55a')
		);
	}

	public function getDeleteData() {
		return [
			// User to be deleted from users view.
			[
				[
					'expected' => TEST_GOOD,
					'fields' => [
						'Alias' => 'User_2B_Deleted',
						'Groups' => 'Guests',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					],
					'delete_from_users_view' => true
				]
			],
			// User to be deleted from user update view.
			[
				[
					'expected' => TEST_GOOD,
					'fields' => [
						'Alias' => 'User_2B_Deleted',
						'Groups' => 'Guests',
						'Password' => 'zabbix',
						'Password (once again)' => 'zabbix'
					]
				]
			],
			// Attempt by Admin user to delete himself.
			[
				[
					'expected' => TEST_BAD,
					'username' => 'Admin',
					'self-deletion' => true,
					'error_details' => 'User is not allowed to delete himself.'
				]
			],
			// Attempt to delete internal user guest.
			[
				[
					'expected' => TEST_BAD,
					'username' => 'guest',
					'error_details' => 'Cannot delete Zabbix internal user "guest", try disabling that user.'
				]
			],
			// Attempt to delete a user that owns a map.
			[
				[
					'expected' => TEST_BAD,
					'username' => 'user-zabbix',
					'parameters' => [
						'DB_table' => 'sysmaps',
						'column' => 'name',
						'value' => 'Local network'
					],
					'error_details' => 'User "user-zabbix" is map "Local network" owner.'
				]
			],
			// Attempt to delete a user that owns a screen.
			[
				[
					'expected' => TEST_BAD,
					'username' => 'test-user',
					'parameters' => [
						'DB_table' => 'screens',
						'column' => 'name',
						'value' => 'Zabbix server'
					],
					'error_details' => 'User "test-user" is screen "Zabbix server" owner.'
				]
			],
			// Attempt to delete a user that owns a slide show.
			[
				[
					'expected' => TEST_BAD,
					'username' => 'admin-zabbix',
					'parameters' => [
						'DB_table' => 'slideshows',
						'column' => 'name',
						'value' => 'Test slide show 1'
					],
					'error_details' => 'User "admin-zabbix" is slide show "Test slide show 1" owner.'
				]
			],
			// Attempt to delete a user that is mentioned in an action.
			[
				[
					'expected' => TEST_BAD,
					'username' => 'user-for-blocking',
					'parameters' => [
						'DB_table' => 'opmessage_usr',
						'column' => 'operationid',
						'value' => '19'
					],
					'User "user-zabbix" is used in "Trigger action 4" action.'
				]
			]
		];
	}

	/**
	 * @dataProvider getDeleteData
	 */
	public function testFormUser_Delete($data) {
		$this->page->login()->open('users.php');
		// Create a user to delete.
		if (array_key_exists('fields', $data)) {
			$this->query('button:Create user')->one()->click();
			$form = $this->query('name:userForm')->asForm()->waitUntilVisible()->one();
			$form->fill($data['fields']);
			$form->submit();
		}
		// Defined required variables.
		$good_title = 'User deleted';
		$bad_title = 'Cannot delete user';
		if (array_key_exists('username', $data)) {
			$username = $data['username'];
		}
		else {
			$username = $data['fields']['Alias'];
		}
		$userid = CDBHelper::getValue('SELECT userid FROM users WHERE alias =' . zbx_dbstr($username));
		// Link user with map, screen, slideshow, action to validate user deletion.
		if (array_key_exists('parameters', $data)) {
			DBexecute(
					'UPDATE ' . $data['parameters']['DB_table'] .
					' SET userid = ' . zbx_dbstr($userid) .
					' WHERE ' . $data['parameters']['column'] . '=' . zbx_dbstr($data['parameters']['value'])
			);
		}
		// Attempt to delete the user from user update view and verify result.
		if (!array_key_exists('delete_from_users_view', $data)) {
			$this->query('link', $username)->one()->click();
			// Verify that delete button is disabled when user opens himself.
			if (array_key_exists('self-deletion', $data)) {
				$delete = $this->query('button:Delete')->one();
				$this->assertTrue($delete->isEnabled(false));
				$this->page->open('users.php');
			}
			else {
				$this->query('button:Delete')->one()->click();
				$this->webDriver->switchTo()->alert()->accept();
				$this->page->waitUntilReady();
				$message = CMessageElement::find()->one();
				// Validate if the user was deleted.
				$this->assertUserMessage($data, $message, $good_title, $bad_title);
			}
		}
		// Attempt to delete the user from users view.
		if (array_key_exists('delete_from_users_view', $data) || $data['expected'] === TEST_BAD) {
			$table = $this->query('class:list-table')->asTable()->one();
			$row = $table->findRow('Alias', $username)->select();
			$this->query('button:Delete')->one()->click();
			$this->webDriver->switchTo()->alert()->accept();
		}
		$this->page->waitUntilReady();
		$message = CMessageElement::find()->one();
		// Verify if user was deleted.
		$this->assertUserMessage($data, $message, $good_title, $bad_title);
		if ($data['expected'] === TEST_BAD) {
			$user_count = CDBHelper::getCount('SELECT userid FROM users WHERE alias =' . zbx_dbstr($username));
			$this->assertTrue($user_count === 1);
		}
	}

	public function testFormUser_Cancel() {
		$data = [
			'Alias' => 'user-cancel',
			'Password' => 'zabbix',
			'Password (once again)' => 'zabbix',
			'Groups' => 'Guests'
		];
		$sql_users = 'SELECT * FROM users ORDER BY userid';
		$user_hash = CDBHelper::getHash($sql_users);
		$this->page->login()->open('users.php?form=create');

		// Check cancellation when creating users.
		$form_create = $this->query('name:userForm')->asForm()->waitUntilVisible()->one();
		$form_create->fill($data);
		$this->query('button:Cancel')->one()->click();
		$cancel_url = $this->page->getCurrentURL();
		$this->assertContains('users.php?cancel=1', $cancel_url);
		$this->assertEquals($user_hash, CDBHelper::getHash($sql_users));

		//Check Cancellation when updating users.
		$this->page->open('users.php?form=update&userid=1');
		$this->query('id:name')->one()->fill('Boris');
		$this->query('button:Cancel')->one()->click();
		$this->assertEquals($user_hash, CDBHelper::getHash($sql_users));
	}

	private function assertUserMessage($data, $message, $good_title, $bad_title) {
		if ($data['expected'] === TEST_GOOD) {
			$this->assertTrue($message->isGood());
			$this->assertEquals($good_title, $message->getTitle());
			$user_count = CDBHelper::getCount('SELECT userid FROM users WHERE alias =' . zbx_dbstr($data['fields']['Alias']));
			if ($good_title === 'User deleted') {
				$this->assertTrue($user_count === 0);
			}
			else {
				$this->assertTrue($user_count === 1);
			}
		}
		else {
			$this->assertTrue($message->isBad());
			$this->assertEquals(CTestArrayHelper::get($data, 'error_title', $data['error_title'] = $bad_title), $message->getTitle());
			if (array_key_exists('error_details', $data)) {
				$this->assertTrue($message->hasLine($data['error_details']));
			}
		}
	}
}
