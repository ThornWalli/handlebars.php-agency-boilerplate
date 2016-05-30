<?php

namespace AgencyBoilerplate\Handlebars;


class Core
{

  protected static $instance = null;

  /**
   * @var \Handlebars\Handlebars
   */
  protected $engine;

  /**
   * @return \AgencyBoilerplate\Handlebars\Core
   */
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
      throw new \InvalidArgumentException(
        'empty options'
      );
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

  public function getVarData($partialName)
  {
    $core = \AgencyBoilerplate\Handlebars\Core::getInstance();
    $html = $core->getEngine()->getPartialsLoader()->load($partialName);
    preg_match_all("/{{[#]?var \"([^{]*)\" \"([^{}]*)\"}}|\\\\(var \"([^()]*)\" \"([^()]*)\\\\)\"/", $html, $matches);

    $total = array();
    $total[$partialName] = array_combine($matches[1], $matches[2]);

    $paths = $this->getPathsFromMixins($partialName);
    if (count($paths) > 0) {
      for ($i = 0; $i < count($paths); $i++) {
        $total = array_merge($total, $this->getVarData($paths[$i]));
      }
    }
    return $total;
  }

  public function getPathsFromMixins($partialName)
  {
    $core = \AgencyBoilerplate\Handlebars\Core::getInstance();
    $html = $core->getEngine()->getPartialsLoader()->load($partialName);
    preg_match_all("/{{[{#]mixin \\\"(.*)\\\"[^{}]*}}/", $html, $matches);
    return $matches[1];
  }

}

?>
