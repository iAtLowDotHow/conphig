<?php namespace Core;

interface Subject
{
	public function attach( Observer $observer );
	public function detach( $index );
	public function notify();
}