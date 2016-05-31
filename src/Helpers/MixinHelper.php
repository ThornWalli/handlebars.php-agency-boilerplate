<?php

namespace AgencyBoilerplate\Handlebars\Helpers;

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
        if (is_array($context->get($parsedArgs[$i]))) {
          $scope = array_merge($scope, $context->get($parsedArgs[$i]));
        }
      }
    }
    foreach ($parsedNamedArgs as $key => $arg) {
      $scope[$key] = $context->get($arg);
    }
    if (count($scope) > 0) {
      $context = $scope;
    } else {
      $core = \AgencyBoilerplate\Handlebars\Core::getInstance();
      // preload for forced yaml exclude and saved temp.
      $core->getEngine()->getPartialsLoader()->load($partialName);
      $context->push($core->getDefaultPartialData($partialName));
    }


    $buffer = null;
    if ($source) {
      $template->render($context);
      $this->level++;
      $buffer = $template->getEngine()->render($partialName, $context);
      $this->level--;
      if ($this->level == 0) {
        $this->blocksStorage->clear();
      }
    } else {
      $buffer = $template->getEngine()->render($partialName, $context);
    }
    return $buffer;
  }

}
