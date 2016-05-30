<?php

namespace AgencyBoilerplate\Handlebars\Loader;

use AgencyBoilerplate\Handlebars\Core;

class FilesystemLoader extends \Handlebars\Loader\FilesystemLoader
{

  /**
   * Remove yaml from template content.
   * @param string $name template name
   * @return mixed|string
   */
  protected function loadFile($name)
  {
    $fileContent = parent::loadFile($name);
    // replace yaml
    $fileContent = preg_replace("/(---)[.\\s\\S]*(---)/", "", $fileContent);
    return $fileContent;
  }

}

?>
