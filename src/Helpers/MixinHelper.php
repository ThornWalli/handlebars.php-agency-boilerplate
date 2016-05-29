<?php

namespace AgencyBoilerplate\Handlebars\Helpers;

use AgencyBoilerplate\Handlebars\Core;
use Handlebars\Context;
use Handlebars\Helper as HelperInterface;
use Handlebars\Template;

class MixinHelper extends \JustBlackBird\HandlebarsHelpers\Layout\AbstractBlockHelper implements HelperInterface
{

  protected $level = 0;

  public function execute(Template $template, Context $context, $args, $source)
  {
    /** @var $template \Handlebars\Template */
    $parsedArgs = $template->parseArguments($args);
    $blockName = $context->get(array_shift($parsedArgs));
    $parsedNamedArgs = $template->parseNamedArguments($args);
    $scope = [];
    if (count($args) > 0) {
      for ($i = 0; $i < count($parsedArgs); $i++) {
        $scope = array_merge($scope, $context->get($parsedArgs[$i]));
      }
    }
    foreach ($parsedNamedArgs as $key => $arg) {
      $scope[$key] = $context->get($arg);
    }
    if (count($scope) > 0) {
      $context = $scope;
    }
    $buffer = $template->getEngine()->render($blockName, $context);
    if ($source) {
      // block element
      $template->render($context);
      $this->level++;
      $buffer = $template->getEngine()->render($blockName, $context);
      $this->level--;
      if ($this->level == 0) {
        $this->blocksStorage->clear();
      }
    }
    return $buffer;
  }

}
