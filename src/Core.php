<?php

namespace AgencyBoilerplate\Handlebars;


class Core
{

  /**
   * @var \Handlebars\Handlebars
   */
  private $engine;

  public function __construct($partialBaseDir, $options = array())
  {
    if (is_array($options)) {
      $options = array_merge([
        'extension' => '.hbs',
        'prefix' => ''
      ], $options);
    }
    $baseDir = $partialBaseDir;
    $this->engine = new \Handlebars\Handlebars(array(
      'helpers' => new Helpers(),
      'loader' => new \AgencyBoilerplate\Handlebars\Loader\FilesystemLoader($baseDir, $options),
      'partials_loader' => new \AgencyBoilerplate\Handlebars\Loader\FilesystemLoader($baseDir, $options)
    ));
  }

  /**
   * @return \Handlebars\Handlebars
   */
  public function getEngine()
  {
    return $this->engine;
  }

}

?>
