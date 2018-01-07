<?php

/**
 *
 * Map Forum Users. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, James Myers, myersware.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
namespace myersware\mapusers\tests\controller;

class main_test extends \phpbb_test_case {
	public function handle_data() {
		return array (
				array (
						200,
						'mapusers_body.html' 
				) 
		);
	}
	
	/**
	 * @dataProvider handle_data
	 */
	public function test_handle($status_code, $page_content) {
		// Mocks are dummy implementations that provide the API of components we depend on //
		/** @var \phpbb\template\template $template Mock the template class */
		$template = $this->getMockBuilder ( '\phpbb\template\template' )->disableOriginalConstructor ()->getMock ();
		
		/** @var \phpbb\user $user Mock the user class */
		$user = $this->getMockBuilder ( '\phpbb\user' )->disableOriginalConstructor ()->getMock ();
		
		// Set user->lang() to return any arguments sent to it
		$user->expects ( $this->any () )->method ( 'lang' )->will ( $this->returnArgument ( 0 ) );
		
		/** @var \phpbb\controller\helper $controller_helper Mock the controller helper class */
		$controller_helper = $this->getMockBuilder ( '\phpbb\controller\helper' )->disableOriginalConstructor ()->getMock ();
		
		/** @var \phpbb\auth $auth Mock the auth class */
		$auth = $this->getMock('auth');
		$acl_get_map = array(
				array('u_mapusers_view', 23, true),
				array('u_mapusers_view', '23', true),// Called without int cast
		);
		
		// Set the expected output of the controller_helper->render() method
		$controller_helper->expects ( $this->any () )->method ( 'render' )->willReturnCallback ( function ($template_file, $page_title = '', $status_code = 200, $display_online_list = false) {
			return new \Symfony\Component\HttpFoundation\Response ( $template_file, $status_code );
		} );
		
		// Instantiate the map users controller
		$controller = new \myersware\mapusers\controller\main ( new \phpbb\config\config ( array () ), $controller_helper, $template, $user, $auth );
		
		$response = $controller->handle ( 'test' );
		$this->assertInstanceOf ( '\Symfony\Component\HttpFoundation\Response', $response );
		$this->assertEquals ( $status_code, $response->getStatusCode () );
		$this->assertEquals ( $page_content, $response->getContent () );
	}
}