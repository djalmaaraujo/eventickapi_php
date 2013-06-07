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

## Tests
To run your tests, first insert your Eventick credentials in ```test/testCredentials.php```. That's required because the library is not using Mocks or Stubs, just because PHP tests are trash. =)

After setup your credentials, run ```phpunit```.

## Documentation

### auth()
This method request a token from eventick API and set the ```EventickAPI::loggedIn``` public attribute to true.

### events()
Return all events from your logged account.

### event($eventId)
Return information about a specific event.

##### $eventId

*Type: `Integer` Required: `true`*


### attendees($eventId, $checkedAfter)
Return all attendees from specific event.
You can pass at the second parameter the ```$checkedAfter``` to return all attendees checked after a specific date.

##### $eventId

*Type: `Integer` Required: `true`*

##### $checkedAfter

*Type: `String` Required: `false` Default: `null` Format: `2012-10-17T16:54:35-03:00 (ISO 8601)`*

### attendee($eventId, $id)
Return information about a specific attendee in a event

##### $eventId

*Type: `Integer` Required: `true`*

##### $id

*Type: `Integer` Required: `true`*

### attendeeCheckin($eventId, $code, $checkedAt)
Allows you to mark one attendee as checked (check-in done) into an event.

##### For single check-in:
##### $eventId

*Type: `Integer` Required: `true`*

##### $code
*Type: `String` Required: `true`*

##### $checkedAt
*Type: `String` Required: `true` Format: `2012-10-17T16:54:35-03:00 (ISO 8601)`*


### attendeesCheckin()
Allows you to mark multiples attendees as checked (check-in done) into an event.

##### $eventId

*Type: `Integer` Required: `true`*

##### $params
*Type: `Array` Required: `true`*

*Expected array:*

```php
$params = array(
  array('id' => 1, 'checked_at' => '2012-10-17T16:54:35-03:00'),
  array('id' => 2, 'checked_at' => '2012-10-17T16:54:35-03:00'),
  array('id' => 3, 'checked_at' => '2012-10-17T16:54:35-03:00'),
  array('id' => 4, 'checked_at' => '2012-10-17T16:54:35-03:00'),
  array('id' => 5, 'checked_at' => '2012-10-17T16:54:35-03:00'),
);
```
* id is the attendee ID
* checked_at must be in ISO 8601 format.

## Eventick
All Eventick API is available at: [http://developer.eventick.com.br/](http://developer.eventick.com.br/)
This library was built on top of Eventick API v1.

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
