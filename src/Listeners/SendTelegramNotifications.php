<?php

namespace Ghostiq\FlarumTwitter\Listeners;

use Ghostiq\FlarumTwitter\Notifications\TwitterMailer;
use Flarum\Notification\Event\Sending;
use Illuminate\Contracts\Events\Dispatcher;

class SendTwitterNotifications
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Sending::class, [$this, 'send']);
    }

    public function send(Sending $event)
    {
        //$mailer = app(TwitterMailer::class);
        $poster = app(TwitterMailer::class);
        $poster->send();
    }
}
