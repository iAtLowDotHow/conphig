<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://low.how
 * @since      1.0.0
 *
 * @package    Conphig
 * @subpackage Conphig/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Conphig
 * @subpackage Conphig/admin
 * @author     How <i@low.how>
 */
class Conphig_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $asset_file;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->asset_file = include CONPHIG_DIR . '/admin/build/index.asset.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Conphig_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Conphig_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/conphig-admin.css', array(), $this->version, 'all');

		wp_register_style(
			CONPHIG_SLUG . '-admin',
			CONPHIG_URL . '/admin/build/index.css',
			array(),
			$this->asset_file['version']
		);

		// generate if this page is "admin.php?page=conphig"
		if (isset($_GET['page']) && $_GET['page'] == 'conphig') {
			wp_enqueue_style(CONPHIG_SLUG . '-admin');
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Conphig_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Conphig_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/conphig-admin.js', array('jquery'), $this->version, false);
	}

	public function add_plugin_admin_menu()
	{
		$menu_slug = CONPHIG_MENU_SLUG;
		$menu_icon = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNTQuMzMgMzU0LjMzIj48cGF0aCBkPSJNMjcwLjI1LDIwOGE5MC4zNSw5MC4zNSwwLDEsMSwuMy02Ni4zN2w2MS44NC0yNC41M2ExNTYuODcsMTU2Ljg3LDAsMSwwLC4xNiwxMTUuMzRaIiBzdHlsZT0iZmlsbDojMjMxZjIwIi8+PHBhdGggZD0iTTE2Mi42LDIwMi42N2EyOS45MSwyOS45MSwwLDAsMS0yMS4xNS01MUEyOC43NiwyOC43NiwwLDAsMSwxNjIuNiwxNDNoNDkuNzZhMjkuOTEsMjkuOTEsMCwwLDEsMjEuMTYsNTEsMjguOCwyOC44LDAsMCwxLTIxLjE2LDguNzFabTAtOS45NWg0OS43NmExOS45MSwxOS45MSwwLDAsMCwwLTM5LjgySDE2Mi42YTE5LjkxLDE5LjkxLDAsMCwwLDAsMzkuODJabTQ5Ljc2LTVhMTQuODksMTQuODksMCwxLDAtMTAuNTctNC4zNkExNC4zOCwxNC4zOCwwLDAsMCwyMTIuMzYsMTg3Ljc0WiIgc3R5bGU9ImZpbGw6IzAxMDEwMSIvPjwvc3ZnPg==";
		add_menu_page(
			'Conphig',
			'Conphig',
			'manage_options',
			$menu_slug,
			array($this, 'conphig_dashboard_page'),
			$menu_icon

		);
	}

	public function conphig_dashboard_page()
	{
		// include ADDON_ReactTest_DIR . 'react_test/build/index.html';
		?>
		<div class="bg-white">
			<header class="absolute inset-x-0 top-0 z-50">
				<nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
					<div class="flex lg:flex-1">
						<a href="#" class="-m-1.5 p-1.5">
							<span class="sr-only">Your Company</span>
							<img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
						</a>
					</div>
					<div class="flex lg:hidden">
						<button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
							<span class="sr-only">Open main menu</span>
							<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
							</svg>
						</button>
					</div>
					<div class="hidden lg:flex lg:gap-x-12">
						<a href="#" class="text-sm font-semibold leading-6 text-gray-900">Product</a>
						<a href="#" class="text-sm font-semibold leading-6 text-gray-900">Features</a>
						<a href="#" class="text-sm font-semibold leading-6 text-gray-900">Marketplace</a>
						<a href="#" class="text-sm font-semibold leading-6 text-gray-900">Company</a>
					</div>
					<div class="hidden lg:flex lg:flex-1 lg:justify-end">
						<a href="#" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
					</div>
				</nav>
				<!-- Mobile menu, show/hide based on menu open state. -->
				<div class="lg:hidden" role="dialog" aria-modal="true">
					<!-- Background backdrop, show/hide based on slide-over state. -->
					<div class="fixed inset-0 z-50"></div>
					<div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
						<div class="flex items-center justify-between">
							<a href="#" class="-m-1.5 p-1.5">
								<span class="sr-only">Your Company</span>
								<img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
							</a>
							<button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
								<span class="sr-only">Close menu</span>
								<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
									<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
								</svg>
							</button>
						</div>
						<div class="mt-6 flow-root">
							<div class="-my-6 divide-y divide-gray-500/10">
								<div class="space-y-2 py-6">
									<a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Product</a>
									<a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Features</a>
									<a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Marketplace</a>
									<a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Company</a>
								</div>
								<div class="py-6">
									<a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="relative isolate px-6 pt-14 lg:px-8">
				<div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
					<div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
				</div>
				<div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
					<div class="hidden sm:mb-8 sm:flex sm:justify-center">
						<div class="relative rounded-full px-3 py-1 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
							Announcing our next round of funding. <a href="#" class="font-semibold text-indigo-600"><span class="absolute inset-0" aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
						</div>
					</div>
					<div class="text-center">
						<h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Data to enrich your online business</h1>
						<p class="mt-6 text-lg leading-8 text-gray-600">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>
						<div class="mt-10 flex items-center justify-center gap-x-6">
							<a href="#" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get started</a>
							<a href="#" class="text-sm font-semibold leading-6 text-gray-900">Learn more <span aria-hidden="true">→</span></a>
						</div>
					</div>
				</div>
				<div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
					<div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
				</div>
			</div>
		</div>
		<?php
	}
}
