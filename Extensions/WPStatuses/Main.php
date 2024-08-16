<?php namespace Conphig\Extensions\WPStatuses;

use Conphig\Core\Observer as Observer;
use Conphig\Core\Loader as Loader;


class Main implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{

		include_once 'plugin/wp-statuses/wp-statuses.php';

		return $this;
	}
}