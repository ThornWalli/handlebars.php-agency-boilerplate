<?php

require __DIR__ . '/../../vendor/autoload.php';
$core = \AgencyBoilerplate\Handlebars\Core::init([
  'partialDir' => __DIR__ . '/tmpl/'
]);

$data = [
    'the-arg' => 'Argument Test',
    'the-object' => [
        'key-1' => 'Object-Key-1 Test'
    ]
];

echo $core->getEngine()->render('index',$data);

?>
