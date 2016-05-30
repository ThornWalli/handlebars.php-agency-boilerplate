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

function parseVarsfromTemplate($name)
{
  $core = \AgencyBoilerplate\Handlebars\Core::getInstance();
  $html = $core->getEngine()->getPartialsLoader()->load($name);
  preg_match_all("/{{[#]?var ([^{]*) ([^{}]*)}}|\\\\(var ([^()]*) ([^()]*)\\\\)/", $html, $matches);

  $total = array();
  $total[$name] = array_combine($matches[1], $matches[2]);

  $paths = getPathsFromMixins(null, $html);
  if (count($paths) > 0) {
    for ($i = 0; $i < count($paths); $i++) {
      $total = array_merge($total, parseVarsfromTemplate($paths[$i]));
    }
  }
  return $total;
}

function getPathsFromMixins($name, $html = null)
{
  $core = \AgencyBoilerplate\Handlebars\Core::getInstance();
  if ($html == null) {
    $html = $core->getEngine()->getPartialsLoader()->load($name);
  }
  preg_match_all("/{{[{#]mixin \\\"(.*)\\\"[^{}]*}}/", $html, $matches);
  return $matches[1];
}

?>

<h2>Partials</h2>

<?php

foreach (parseVarsfromTemplate('index') as $tabName => $tab) {
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

