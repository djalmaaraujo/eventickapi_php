# Eventick API PHP LIbrary
Use this API to integrate your app with eventick.com.br service. This is not a official library.

## Example
```php
require_once 'vendor/autoload.php';
use Eventick\Lib\EventickAPI;

$api = new EventickAPI;
$api->setCredentials('your-email', 'your-password');

$api->auth(); // Authenticates you
$events = $api->events(); // Grab events
...
```

## 

## Tests
To run your tests, first insert your Eventick credentials in ```test/testCredentials.php```. That's required because the library is not using Mocks or Stubs, just because PHP tests are trash. =)

After setup your credentials, run ```phpunit```. 

## Documentation

## MIT License
Copyright (c) 2013 Djalma Araújo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
