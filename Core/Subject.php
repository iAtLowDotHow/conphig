<?php namespace Conphig\Core;

interface Subject
{
	public function attach( Observer $observer );
	public function detach( $index );
	public function notify();
}