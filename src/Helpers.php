<?php

namespace AgencyBoilerplate\Handlebars;

class Helpers extends \Handlebars\Helpers
{

  protected function addDefaultHelpers()
  {
    parent::addDefaultHelpers();

    $storage = new \JustBlackBird\HandlebarsHelpers\Layout\BlockStorage();
    $this->add('block', new \JustBlackBird\HandlebarsHelpers\Layout\BlockHelper($storage));
    $this->add('mixin', new \AgencyBoilerplate\Handlebars\Helpers\MixinHelper($storage));
    $this->add('with', new \AgencyBoilerplate\Handlebars\Helpers\WithHelper());
    $this->add('content', new \JustBlackBird\HandlebarsHelpers\Layout\OverrideHelper($storage));
    $this->add('stringify', function ($template, $context, $args) {
      $parsedArgs = $template->parseArguments($args);
      return json_encode($context->get(current($parsedArgs)));
    });
  }

}

?>
