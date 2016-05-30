# handlebars.php-agency-boilerplate

Handlebar.php Helper for [agency-boilerplate](https://github.com/StephanGerbeth/agency-boilerplate).

`\AgencyBoilerplate\Handlebars\Core::init($options)`
```
[
  'partialDir' => '.',
  'extension' => '.hbs',
  'prefix' => ''
]
```
## Options
### partialDir

Type: `mixed|string`

Sets partial dirs for loading partial via mixin helper.


### extension

Type: `string`<br />
Default: `.handlebars`

### prefix

Type: `string`<br />
Default: `empty`

Sets prefix for template files.

##### Example:
> prefix: "_" -> filename: "_partial.hbs"

## Features

>yaml (in progress) https://hbs-php-agency-boilerplate.herokuapp.com/tests/yaml


### Helpers

#### lookup

https://hbs-php-agency-boilerplate.herokuapp.com/tests/lookup

#### mixin

https://hbs-php-agency-boilerplate.herokuapp.com/tests/mixin

#### stringfy

https://hbs-php-agency-boilerplate.herokuapp.com/tests/stringify

#### with

https://hbs-php-agency-boilerplate.herokuapp.com/tests/with

#### var

https://hbs-php-agency-boilerplate.herokuapp.com/tests/var

Return property value by name.

Pattern:

```mustache
{{{var name type}}}

Example: {{{var "fieldName"}}}
```
**in progress!**

##### name
Type: ```string```

Sets the Name from property.

##### type
Type: ```string```

Sets the type of propety.


## Use

### Handlebars index.hbs
```mustache
---
object: {}
array: []
---
<h1>stringify example</h1>

<h2>scope: this</h2>
<p>{{{stringify this}}}</p>

<h2>scope: object</h2>
<p>{{{stringify object}}}</p>

<h2>scope: array</h2>
<p>{{{stringify array}}}</p>
```
### PHP index.php

```php
<?php

// require via composer
require __DIR__ . '/../../vendor/autoload.php';

// init core
$core = \AgencyBoilerplate\Handlebars\Core::init([
  'partialDir' => __DIR__ . '/tmpl/'
]);

// defined data object
$data = [
  'object' => [
    'hello' => 'world'
  ],
  'array' => [
    0, 1, 2, 3
  ]
];

// render with engine
echo $core->getEngine()->render('index', $data);

?>
```

## TODOS

- [x] mixin helper with block and content
- [ ] var helper for parse properties from template
- [ ] yaml placeholder data
