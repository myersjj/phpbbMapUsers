<?php

/**
 *
 * Map Forum Users. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, James Myers, myersware.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
namespace myersware\mapusers\cron\task;

/**
 * Map Forum Users cron task.
 */
class mapusers extends \phpbb\cron\task\base {
	/**
	 * How often we run the cron (in seconds).
	 * 
	 * @var int
	 */
	protected $cron_frequency = 86400;
	
	/** @var \phpbb\config\config */
	protected $config;
	
	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config $config
	 *        	Config object
	 */
	public function __construct(\phpbb\config\config $config) {
		$this->config = $config;
	}
	
	/**
	 * Runs this cron task.
	 *
	 * @return void
	 */
	public function run() {
		// Run your cron actions here...
		
		// Update the cron task run time here if it hasn't
		// already been done by your cron actions.
		$this->config->set ( 'myersware_cron_last_run', time (), false );
	}
	
	/**
	 * Returns whether this cron task can run, given current board configuration.
	 *
	 * For example, a cron task that prunes forums can only run when
	 * forum pruning is enabled.
	 *
	 * @return bool
	 */
	public function is_runnable() {
		return true;
	}
	
	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run.
	 *
	 * @return bool
	 */
	public function should_run() {
		return $this->config ['myersware_cron_last_run'] < time () - $this->cron_frequency;
	}
}
