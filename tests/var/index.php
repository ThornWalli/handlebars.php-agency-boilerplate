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

foreach ($core->getVarData('index') as $tabName => $tab) {
  ?>
  <h3><?php echo $tabName; ?></h3>
  <pre><?php
    echo $core->getEngine()->getPartialsLoader()->load($tabName);
    ?></pre>
  <h4>Properties</h4>
  <pre><?php
    foreach ($tab as $key => $var) {
      ?><?php echo sprintf('%s: %s', $key, $var); ?><br/><br/><?php
    }
    ?></pre><br/>
  <hr/><br/>
  <?php
}

?>

