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
      if (!array_key_exists('partialDir', $options)) {
        $options['partialDir'] = [];
      }
      if (!array_key_exists('extension', $options)) {
        $options['extension'] = '.hbs';
      }
      if (!array_key_exists('prefix', $options)) {
        $options['prefix'] = '';
      }
    } else {
      $options = array_merge([
        'partialDir' => ['.']
      ], $options);
    }
    $baseDirs = $options['partialDir'];
    self::$instance = new self(new \Handlebars\Handlebars(array(
      'helpers' => new Helpers(),
      'loader' => new \AgencyBoilerplate\Handlebars\Loader\FilesystemLoader($baseDirs, $options),
      'partials_loader' => new \AgencyBoilerplate\Handlebars\Loader\FilesystemLoader($baseDirs, $options)
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
