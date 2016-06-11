<?php
namespace AgencyBoilerplate\Handlebars\Helpers;

use AgencyBoilerplate\Handlebars\Core;
use CoMa\Helper\Base;
use Handlebars\Context;
use Handlebars\StringWrapper;
use Handlebars\Template;

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
      self::setVar($data[$name], $path, $value);
    } else {
      if (!array_key_exists($name, $data) || !is_array($data[$name])) {
        $data[$name] = [];
      }
      $data[$name][] = $value;
    }

    return $data;

  }

  /**
   * @param Template $template
   * @param Context $context
   * @param array $args
   * @param string $source
   * @return mixed
   */
  public function execute(Template $template, Context $context, $args, $source)
  {

    $parsedNamedArgs = $template->parseNamedArguments($args);

    if (!array_key_exists('group', $parsedNamedArgs)) {
      $parsedNamedArgs['group'] = new StringWrapper(Base::TAB_CONTENT);
    }
    if ($parsedNamedArgs['group']->getString()) {
      self::setVar($GLOBALS[Core::getInstance()->getGlobalVarTemp()], [$parsedNamedArgs['group']->getString()], $parsedNamedArgs);
    } else {
      self::setVar($GLOBALS[Core::getInstance()->getGlobalVarTemp()], [Base::TAB_CONTENT], $parsedNamedArgs);
    }
    if (array_key_exists('title', $parsedNamedArgs)) {
      $parsedNamedArgs['title'] = $parsedNamedArgs['name'];
    }
    if (!array_key_exists('desc', $parsedNamedArgs)) {
      $parsedNamedArgs['desc'] = null;
    }
    if (array_key_exists('mixin', $parsedNamedArgs)) {
      return $parsedNamedArgs['value'];
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
