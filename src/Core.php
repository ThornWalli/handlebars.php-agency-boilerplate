<?php

namespace AgencyBoilerplate\Handlebars;


class Core
{


  protected static $instance = null;

  /**
   * @var \Handlebars\Handlebars
   */
  protected $engine;
  private $partialsDefaultData = [];

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
    $fileContent = $core->getEngine()->getPartialsLoader()->load($partialName);
    if (preg_match_all("/{{[#]?var \"([^{\"]*)\" \"([^{}\"]*)\"[ ]?([^{}]*)?}}|\\(var \"([^()\"]*)\" \"([^()\"]*)\"[ ]?([^()]*)?}\\)/", $fileContent, $matches)) {

      $properties = [
        $partialName=>[]
      ];

      for ($i = 0; $i < count($matches[1]); $i++) {
        $properties[$partialName][] = [
          'name' => $matches[1][$i],
          'type' => $matches[2][$i],
          'default' => $matches[3][$i]
        ];
      }

      $paths = $this->getPathsFromMixins($partialName);
      if (count($paths) > 0) {
        for ($i = 0; $i < count($paths); $i++) {
          $properties = array_merge($properties, $this->getVarData($paths[$i]));
        }
      }
      return $properties;
    }
    return null;
  }


  public function getPathsFromMixins($partialName)
  {
    $core = \AgencyBoilerplate\Handlebars\Core::getInstance();
    $fileContent = $core->getEngine()->getPartialsLoader()->load($partialName);
    preg_match_all("/{{[{#]mixin \\\"(.*)\\\"[^{}]*}}/", $fileContent, $matches);
    return $matches[1];
  }

  public function getDefaultPartialData($partialPath)
  {
    if (array_key_exists($partialPath, $this->partialsDefaultData)) {
      return $this->partialsDefaultData[$partialPath];
    }
    return [];
  }

  public function registerDefaultPartialData($partialPath, $data)
  {
    $this->partialsDefaultData[$partialPath] = $data;
  }

}

?>
