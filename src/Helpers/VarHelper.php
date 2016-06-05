<?php
namespace AgencyBoilerplate\Handlebars\Helpers;

class VarHelper extends VarStrHelper
{
  private static function setVar(&$data, $path, $value)
  {
if (!$data) {
  $data = [];
}
    $path = array_merge([], $path);

    $name = array_shift($path);
    if (!array_key_exists($name, $data) || !is_array($data[$name])) {
      $data[$name] = [];
    }
    if (count($path) > 0) {
      $data[$name] = self::setVar($data[$name], $path, $value);
    } else {
      if (!array_key_exists($name, $data) || !is_array($data[$name])) {
        $data[$name] = [];
      }
      $data[$name][] = $value;
    }

    return $data;

  }

  /**
   * @param \Handlebars\Template $template
   * @param \Handlebars\Context $context
   * @param array $args
   * @param string $source
   * @return mixed
   */
  public function execute(\Handlebars\Template $template, \Handlebars\Context $context, $args, $source)
  {

    $parsedNamedArgs = $template->parseNamedArguments($args);
//    echo $GLOBALS['test'] . ' - ' . $parsedNamedArgs['name'];
//    self::setVar($GLOBALS['test'],$GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalVarTemp()])

    if (array_key_exists(\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalMixinPath(), $GLOBALS) && $GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalMixinPath()]) {

//      echo '[' . implode(' / ', $GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalMixinPath()]) . ']<br><br>';

      self::setVar($GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalVarTemp()], $GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalMixinPath()], $parsedNamedArgs);
//      echo '<pre>';
//      print_r($GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalVarTemp()]);
//      echo '</pre>';
//      $GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalVarTemp()]


    } else {
      self::setVar($GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalVarTemp()], ['content'], $parsedNamedArgs);
    }


    if (array_key_exists('mixin', $parsedNamedArgs)) {
      return $parsedNamedArgs['name'];
    } else {
      return $context->get($parsedNamedArgs['value']);
    }
  }

  private static function bool($var)
  {
    switch (strtolower($var)) {
      case ("true"):
        return true;
        break;
      case ("false"):
        return false;
        break;
      default:
        return $var;
    }
  }

}

?>
