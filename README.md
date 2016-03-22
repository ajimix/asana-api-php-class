# Asana API PHP class

A PHP class that acts as wrapper for Asana API.  
Lets make things easy! :)

It is licensed under the Apache 2 license and is Copyrighted 2015 Ajimix

## Installing

Choose your favorite flavour

- Download the php class from github.
- Or use [Packagist](https://packagist.org/packages/ajimix/asana-api-php-class) PHP package manager.

Finally require the asana.php file.

## Working with the class

Go To connection.php
you get this code....
```
require 'vendor/autoload.php';
require_once('asana.php');

$asana = new Asana(array(
'apiKey' => '*******************',
'client_id' => '***********************',
'client_secret' => '************************',
'redirect_uri' => '*******************************'
));
```

insert your Api key , client_id,client_secret,redirect_uri
save this with your credential and now go to 
Welcome.Asana.php  now your app is working..

#### Do more

There are a [lot more methods](https://github.com/ajimix/asana-api-php-class/blob/master/asana.php) to do multiple things with asana.

See the examples [inside examples folder](https://github.com/ajimix/asana-api-php-class/tree/master/examples), read the comments on the [class file]((https://github.com/ajimix/asana-api-php-class/blob/master/asana.php)) for class magic and read [Asana API documentation](http://developer.asana.com/documentation/) if you want to be a master :D

If a method returned some data, you can always retrieve it by calling.

## Author

**Twitter:** [@ajimix](http://twitter.com/ajimix)

**GitHub:** [github.com/ajimix](https://github.com/ajimix)

**Contributors:** [view contributors](https://github.com/ajimix/asana-api-php-class/graphs/contributors)


### Copyright and license

Copyright 2015 Ajimix

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this work except in compliance with the License.
You may obtain a copy of the License in the LICENSE file, or at:

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
