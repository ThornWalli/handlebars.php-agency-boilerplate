<?php

require __DIR__ . '/../../vendor/autoload.php';
$core = \AgencyBoilerplate\Handlebars\Core::init([
  'partialDir' => [__DIR__ . '/tmpl/']
]);

$data = [

  'condition' => true,
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
  <pre>

    <table>
      <tbody>

      <?php
      foreach ($data as $partialName_ => $data_) {
        ?>

        <tr>
          <th colspan="2"><?php echo $partialName_; ?></th>
        </tr>

        <?php
      foreach ($data_ as $var) {
      ?>

      <tr>
        <td><?php echo $var['name']; ?></td>
        <td><?php echo $var['type']; ?></td>
      </tr>

      <?php
      }
      }
      ?>

      </tbody>
    </table>

      </pre><br/>
  <hr/><br/>
  <?php
}

?>
