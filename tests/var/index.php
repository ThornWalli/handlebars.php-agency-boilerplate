<?php

require __DIR__ . '/../../vendor/autoload.php';
$core = \AgencyBoilerplate\Handlebars\Core::init([
  'partialDir' => [__DIR__ . '/tmpl/']
]);

$data = [

  'key-textfield' => 'textfield value',
  'key-textarea' => 'textarea value',
  'key-checkbox' => 'checkbox value',
  'key-radio' => 'radio value',
  'key-colorpicker' => 'colorpicker value',
  'key-image' => 'image value',
  'key-number' => 'number value',
  'key-dropdown' => 'dropdown value',
  'legend' => 'Legend ipsum',
  'mixin' => [
    'text' => 'Lorem ipsum...'
  ]
];

echo $core->getEngine()->render('index', $data);

?>

<h2>Partials</h2>

<?php

foreach ($core->getVarData('index') as $partialName => $data) {
  ?>
  <h3><?php echo $partialName; ?></h3>
  <pre><?php
    echo $core->getEngine()->getPartialsLoader()->load($partialName);
    ?></pre>
  <h4>Properties</h4>
  <pre><?php
    foreach ($data as $key => $var) {
      ?><?php echo sprintf('%s: %s', $key, $var); ?><br/><br/><?php
    }
    ?></pre><br/>
  <hr/><br/>
  <?php
}

?>

