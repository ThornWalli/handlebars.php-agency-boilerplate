<?php

namespace AgencyBoilerplate\Handlebars\Helpers;

use Handlebars\Context;
use Handlebars\StringWrapper;

class MixinHelper extends \JustBlackBird\HandlebarsHelpers\Layout\AbstractBlockHelper implements \Handlebars\Helper
{

  protected $level = 0;

  public function execute(\Handlebars\Template $template, \Handlebars\Context $context, $args, $source)
  {

    /** @var $template \Handlebars\Template */
    $parsedArgs = $template->parseArguments($args);
    $partialName = $context->get(array_shift($parsedArgs));
    $parsedNamedArgs = $template->parseNamedArguments($args);
    $scope = [];

    if (count($parsedArgs) > 0) {
      for ($i = 0; $i < count($parsedArgs); $i++) {
        if (is_array($context->get(str_replace('this.', '../', $parsedArgs[$i])))) {
          $scope = array_merge($scope, $context->get(str_replace('this.', '../', $parsedArgs[$i])));
        }
      }
    }
    foreach ($parsedNamedArgs as $key => $arg) {
      $scope[$key] = $context->get($arg);
    };

    if (count($scope) < 1) {
      $core = \AgencyBoilerplate\Handlebars\Core::getInstance();
      // preload for forced yaml exclude and saved temp.
      $core->getEngine()->getPartialsLoader()->load($partialName);
      $context->push($core->getDefaultPartialData($partialName));
    } else {
      $context->push($scope);
    }

    $buffer = null;
    if ($source) {
      $name = explode('/', $partialName);
      $name = end($name);
      array_push($GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalMixinPath()], $name);

      $template->render($context);
      $this->level++;
      $buffer = $template->getEngine()->render($partialName, $context);
      $this->level--;
      if ($this->level == 0) {
        $this->blocksStorage->clear();
      }
      array_pop($GLOBALS[\AgencyBoilerplate\Handlebars\Core::getInstance()->getGlobalMixinPath()]);
    } else {
      $buffer = $template->getEngine()->render($partialName, $context);
    }
    $context->pop();

    return $buffer;
  }

}
