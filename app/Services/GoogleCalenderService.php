<?php 
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

class GoogleCalendarService
{
    protected $googleClient;
    protected $service;

    public function __construct()
    {
        $this->googleClient = new Google_Client();
        $this->googleClient->setAuthConfig('path/to/credentials.json');
        $this->googleClient->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);

        $this->service = new Google_Service_Calendar($this->googleClient);
    }

    public function addToCalendar($accessToken, $quiz)
    {
        $this->googleClient->setAccessToken($accessToken);

        if ($this->googleClient->isAccessTokenExpired()) {
            // Refresh the access token if it has expired
            $this->googleClient->fetchAccessTokenWithRefreshToken($this->googleClient->getRefreshToken());
            // Save the updated access token
            // ...
        }

        $event = $this->createEvent($quiz);

        $calendarId = 'primary';
        $event = $this->service->events->insert($calendarId, $event);

        return $event;
    }

    protected function createEvent($quiz)
    {
        $event = new Google_Service_Calendar_Event([
            'summary' => 'Quiz: ' . $quiz->title,
            'start' => [
                'dateTime' => $quiz->start_date,
                'timeZone' => 'YOUR_TIMEZONE',
            ],
            'end' => [
                'dateTime' => $quiz->end_date,
                'timeZone' => 'YOUR_TIMEZONE',
            ],
        ]);

        return $event;
    }
}