<?php

/**
 *
 * Map Forum Users. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, James Myers, myersware.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
namespace myersware\mapusers\tests\functional;

/**
 * @group functional
 */
class demo_test extends \phpbb_functional_test_case {
	static protected function setup_extensions() {
		return array (
				'myersware/mapusers' 
		);
	}
	
	public function xxtest_login()
	{
		$this->login();
		// check for logout link
		$crawler = $this->request('GET', 'index.php', array(), false);
		$this->assertContains($this->lang('LOGOUT', 'admin'), $crawler->filter('.navbar')->text());
	}
	
	public function xxtest_login_other()
	{
		$this->create_user('anothertestuser');
		$this->login('anothertestuser');
		$crawler = $this->request('GET', 'index.php', array(), false);
		$this->assertContains('anothertestuser', $crawler->filter('#username_logged_in')->text());
	}
	
	public function xxtest_myersware_mapusers() {
		$this->create_user('anothertestuser');
		$this->login('anothertestuser');
		try
		{
			$crawler = $this->request ( 'GET', 'app.php/mapusers/showmap', array(), false );
			$this->fail('The expected \phpbb\exception\http_exception was not thrown');
		}
		catch (\phpbb\exception\http_exception $exception)
		{
			$this->assertEquals(403, $exception->getStatusCode());
			$this->assertEquals('NOT_AUTHORISED', $exception->getMessage());
		}
		
		/*
		$this->assertContains ( 'myersware', $crawler->filter ( 'h2' )->text () );
		$this->add_lang_ext ( 'myersware/mapusers', 'common' );
		$this->assertContains ( $this->lang ( 'MAPUSERS_HELLO', 'myersware' ), $crawler->filter ( 'h2' )->text () );
		$this->assertNotContains ( $this->lang ( 'MAPUSERS_GOODBYE', 'myersware' ), $crawler->filter ( 'h2' )->text () );
		
		$this->assertNotContainsLang ( 'ACP_MAPUSERS', $crawler->filter ( 'h2' )->text () );
		*/
	}
}
