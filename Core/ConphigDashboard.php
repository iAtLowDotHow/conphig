<?php namespace Core;
use Core\Observer as Observer;
use Core\Loader as Loader;

class Main implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{
    $this->loader
		->add_action('admin_menu', $this, 'conphig_dashboard_menu');

		return $this;
	}

  public function conphig_dashboard_menu() {
    add_menu_page(
      'Conphig',
      'Conphig',
      'manage_options',
      'conphig_dashboard',
      'conphig_dashboard_page',
      "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNTEuNCAzNTEuNCI+PHBhdGggZD0iTTE3NS43LDBBMTc1LjcsMTc1LjcsMCwxLDAsMzUxLjQsMTc1LjcsMTc1LjcsMTc1LjcsMCwwLDAsMTc1LjcsMFptOTMuNDUsMjYzLjMzcS0zNS4yNSwzNi4yOS05MCwzNi4yOFExMjQsMjk5LjYxLDg5LDI2My40OVQ1My44OCwxNzQuMzVxMC01MywzNS4wOC04OS4xNSwzMS42Ny0zMi42LDc5LjY3LTM1LjczYzIuOTIsMjkuNjQsMTcuMzIsNTIuODcsNDIuMTEsNjcuNzgsMzMuNDMsMjAuMTIsNjEuMzEsOSw4Ny44OCwyNSwuODcuNTMsMS43MSwxLjA4LDIuNTMsMS42NWExMzguNzgsMTM4Ljc4LDAsMCwxLDMuMjYsMzAuNDJRMzA0LjQxLDIyNy4wNiwyNjkuMTUsMjYzLjMzWiIgc3R5bGU9ImZpbGw6IzIzMWYyMCIvPjxlbGxpcHNlIGN4PSIyMjQuOTQiIGN5PSIxNzQuMDkiIHJ4PSIyMi45NiIgcnk9IjIyLjE0IiBzdHlsZT0iZmlsbDojMjMxZjIwIi8+PC9zdmc+"
    );
  }

  function conphig_dashboard_page() {
    echo 'hello world';
  }

}