<?php
namespace Eventick\Lib;

class EventickAPI {
  public $token = null;
  public $isLogged = false;
  public $apiURL = 'www.eventick.com.br/api/v1/';
  public $apiURLResponseFormat = '.json';
  public $https = true;

  # Private
  private $username;
  private $password;

  public function auth() {
    if (!$this->checkCredentials()) {
      $this->isLogged = false;

      return $this;
    }

    $this->setAuth(array(
      'username' => $this->username,
      'password' => $this->password
    ));

    $this->request('auth')->setToken();

    if ($this->result->token == $this->token) {
      $this->isLogged = true;
    }

    return $this;
  }

  public function setCredentials($username = null, $password = null) {
    $this->username = $username;
    $this->password = $password;

    return $this;
  }

  public function events() {
    $this->request('events');

    return $this->events = $this->result->events;
  }

  public function event($id = null) {
    $this->request('event', array('id' => $id));

    return $this->result->events[0];
  }

  public function attendees($eventId, $checked_after = null) {
    $params = array(
      'event_id' => $eventId,
      'checked_after' => $checked_after
    );

    $this->request('attendees', $params);

    return $this->result->attendees;
  }

  public function attendee($eventId = null, $id = null) {
    $params = array(
      'event_id' => $eventId,
      'id' => $id
    );

    $this->request('attendee', $params);

    return $this->result->attendees[0];
  }

  public function attendeeCheckin($eventId = null, $code = null, $checkedAt = null) {
    $params = array(
      'event_id' => $eventId,
      'code' => $code,
      'checked_at' => $checkedAt
    );

    $this->request('attendeeCheckin', $params);

    return Http::isSuccess();
  }

  # Private

  private function request($type = null, $params = null) {
    $apiURL = $this->getAPIUrl();

    switch ($type) {
      case 'auth':
        $this->setResult(Http::get($apiURL . 'tokens' . $this->apiURLResponseFormat));
        break;

      case 'events':
        $this->setAuth(array('token' => $this->token));
        $this->setResult(Http::get($apiURL . 'events' . $this->apiURLResponseFormat));
        break;

      case 'event':
        $this->setAuth(array('token' => $this->token));
        $this->setResult(Http::get($apiURL . 'events/' . $params['id'] . $this->apiURLResponseFormat));
        break;

      case 'attendees':
        $getParams = (isset($params['checked_after']) && ($params['checked_after'] !== null)) ? array('checked_after' => $params['checked_after']) : false;

        $this->setAuth(array('token' => $this->token));
        $this->setResult(Http::get($apiURL . 'events/' . $params['event_id'] . '/attendees' . $this->apiURLResponseFormat, $getParams));
        break;

      case 'attendee':
        $this->setAuth(array('token' => $this->token));
        $this->setResult(Http::get($apiURL . 'events/' . $params['event_id'] . '/attendees/' . $params['id'] . $this->apiURLResponseFormat));
        break;

      case 'attendeeCheckin':
        $getParams = array('checked_at' => $params['checked_at']);

        $this->setAuth(array('token' => $this->token));
        Http::put($apiURL . 'events/' . $params['event_id'] . '/attendees/' . $params['code'] . $this->apiURLResponseFormat, $getParams);
        break;

      default:
        $this->setResult(false);
        break;
    }

    Http::clear();

    return $this;
  }

  private function setAuth($params) {
    if (isset($params['username']) && isset($params['password'])) {
      Http::auth($params['username'], $params['password']);
    }
    else if ($params['token']) {
      Http::auth($params['token'], '');
    }
    else {
      return false;
    }

    return $this;
  }

  private function setToken() {
    $this->token = $this->result->token;

    return $this;
  }

  private function setResult($result) {
    $this->result = json_decode($result);

    return $this;
  }

  private function getAPIUrl() {
    return $this->parseHttps() . $this->apiURL;
  }

  private function parseHttps() {
    $secure = ($this->https) ? 's' : '';

    return 'http' . $secure . '://';
  }

  private function checkCredentials() {
    return (isset($this->username) && (isset($this->password)));
  }
}