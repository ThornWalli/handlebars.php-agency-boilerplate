<?php
namespace AgencyBoilerplate\Handlebars\Helpers;

class VarStrHelper implements \Handlebars\Helper
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
    $parsedArgs = $template->parseNamedArguments($args);


    return "";
  }
}

?>
