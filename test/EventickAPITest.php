<?php
use Eventick\Lib\EventickAPI;

class EventickAPITest extends PHPUnit_Framework_TestCase {

  public $username = 'someusername';
  public $password = 'somepassword';

  public function testAuthentication() {
    $api = $this->returnInstance();

    $api->auth();

    $this->assertTrue($api->isLogged);
  }

  public function testToken() {
    $api = $this->returnInstance();

    $api->auth();

    $this->assertTrue($api->isLogged);
  }

  public function testListEvents() {
    $api = $this->returnInstance();

    $events = $api->auth()->events();

    $this->assertGreaterThan(1, $events[0]->id);
  }

  public function testEventInfo() {
    $api = $this->returnInstance();
    $api->auth();

    $events = $api->events();

    $firstEvent = $events[0];

    $event = $api->event($firstEvent->id);

    $this->assertEquals($firstEvent->id, $event->id);
  }

  # Private
  private function returnInstance() {
    $api = new EventickAPI;
    $api->setCredentials($this->username, $this->password);

    return $api;
  }
}