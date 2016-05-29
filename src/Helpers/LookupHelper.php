<?php
namespace AgencyBoilerplate\Handlebars\Helpers;

class LookupHelper implements \Handlebars\Helper
{
  /**
   * Override "with" helper for remove buffer output, when arguments empty.
   * @param \Handlebars\Template $template
   * @param \Handlebars\Context $context
   * @param array $args
   * @param string $source
   * @return mixed
   */
  public function execute(\Handlebars\Template $template, \Handlebars\Context $context, $args, $source)
  {
    $parsedArgs = $template->parseArguments($args);
    $data = $context->get($parsedArgs[0]);
    if ($data) {
      return array_key_exists($parsedArgs[1]->getString(), $data);
    }
    return false;
  }
}

?>