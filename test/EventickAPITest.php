<?php
date_default_timezone_set('America/Recife');

use Eventick\Lib\EventickAPI;

class EventickAPITest extends PHPUnit_Framework_TestCase {
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

  public function testListAttendees() {
    $api = $this->returnInstance();
    $api->auth();

    $events = $api->events();

    $firstEvent = $events[0];

    $attendees = $api->attendees($firstEvent->id, '2012-10-17T16:54:35-03:00');

    $this->assertNotNull($attendees[0]->id, 'Attendees checked_after 2012-10-17T16:54:35-03:00');
  }

  public function testAttendeeInfo() {
    $api = $this->returnInstance();
    $api->auth();

    $events = $api->events();

    $firstEvent = $events[0];

    $attendees = $api->attendees($firstEvent->id);

    $attendee = $api->attendee($firstEvent->id, $attendees[0]->id);

    $this->assertNotNull($attendee->id);
  }

  public function testAttendeeSingleCheckin() {
    $api = $this->returnInstance();
    $api->auth();

    $events = $api->events();
    $firstEvent = $events[0];
    $attendees = $api->attendees($firstEvent->id);
    $attendee = $attendees[0];
    $now = $this->now();

    $api->attendeeCheckin($firstEvent->id, $attendee->code, $now);

    $checkAttendee = $api->attendee($firstEvent->id, $attendee->id);

    $this->assertEquals($checkAttendee->checked_at, $now);
  }

  # Private
  private function returnInstance() {
    require_once 'testCredentials.php';

    $api = new EventickAPI;
    $api->setCredentials(TEST_CREDENTIALS_USERNAME, TEST_CREDENTIALS_PASSWORD);

    return $api;
  }

  private function now() {
    return date('Y-m-d\TH:i:s') . '-03:00';
  }
}