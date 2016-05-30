<?php
namespace AgencyBoilerplate\Handlebars\Helpers;

class VarHelper implements \Handlebars\Helper
{
  /**
   * @param \Handlebars\Template $template
   * @param \Handlebars\Context $context
   * @param array $args
   * @param string $source
   * @return mixed
   */
  public function execute(\Handlebars\Template $template, \Handlebars\Context $context, $args, $source)
  {
    $parsedArgs = $template->parseArguments($args);
    return $context->get((string)$parsedArgs[0]);
  }
}

?>