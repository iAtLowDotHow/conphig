<?php namespace Addons\Test;
use Core\Observer as Observer;
use Core\Loader as Loader;

class Main implements Observer
{
	private $loader;

	public function __construct( $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{
		return $this;
	}

}