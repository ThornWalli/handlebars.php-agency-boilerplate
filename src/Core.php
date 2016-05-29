<?php

namespace AgencyBoilerplate\Handlebars;


class Core
{

  protected static $instance = null;

  /**
   * @var \Handlebars\Handlebars
   */
  protected $engine;

  public static function getInstance()
  {
    self::hasInstance();
    return self::$instance;
  }

  public function __construct($engine)
  {
    $this->engine = $engine;
  }

  public static function init($options)
  {
    if (is_array($options)) {
      $options = array_merge([
        'partialDir' => '.',
        'extension' => '.hbs',
        'prefix' => ''
      ], $options);
    }
    $baseDir = $options['partialDir'];
    self::$instance = new self(new \Handlebars\Handlebars(array(
      'helpers' => new Helpers(),
      'loader' => new \AgencyBoilerplate\Handlebars\Loader\FilesystemLoader($baseDir, $options),
      'partials_loader' => new \AgencyBoilerplate\Handlebars\Loader\FilesystemLoader($baseDir, $options)
    )));
    return self::$instance;
  }

  public static function hasInstance()
  {
    if (!self::$instance) {
      throw new \InvalidArgumentException(
        'init core and get instance from core.'
      );
    }
  }

  /**
   * @return \Handlebars\Handlebars
   */
  public function getEngine()
  {
    self::hasInstance();
    return $this->engine;
  }

}

?>
