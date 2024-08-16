<?php namespace Conphig\Extensions\SecurityResets\Modules;

class DisablePluginEditor
{
  private static $instance;
  private function __construct()
  {
  }
  private function __clone()
  {
  }
  public function __wakeup()
  {
  }

  public static function get_instance()
  {
    if (!self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Disabled or ebable the plugin editor
   *
   * @param boolean 'true' to disable the plugin editor, 'false' to enable it
   * @return void
   */
  public function set_disabled( bool $value = true )
  {
    define('DISALLOW_FILE_EDIT', $value);
  }
}



