<?php
namespace Conphig\Extensions;
use Conphig\Core as Core;

class Compiler {
  protected $loader;
  private $extensions_loader;
  public static $manager;


  public function __construct( Core\Loader $loader ) {
    $this->loader = $loader;
    self::$manager = array();
    $this->extensions_loader = new Core\ExtensionsLoader();
    $this->init_extensions();
  }

  public function init_extensions() {
    $this->extensions_loader
    ->attach(new ACF\Main($this->loader))
    ->attach(new Resets\Main($this->loader))
    ->attach(new SecurityResets\Main($this->loader))
    ->attach(new CustomAdmin\Main($this->loader))
    ->attach(new MenuOrganiser\Main($this->loader))
    ->attach(new UserSwitching\Main($this->loader))
    ->attach(new WPStatuses\Main($this->loader))
    ->load();

    $this->loader->run();
  }
}