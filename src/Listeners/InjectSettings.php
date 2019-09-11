<?php

namespace Ghostiq\FlarumTwitter\Listeners;

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Api\Event\Serializing;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class InjectSettings
{
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(Serializing::class, [$this, 'settings']);
    }

    public function settings(Serializing $event)
    {
        if ($event->serializer instanceof ForumSerializer) {
            $event->attributes['ghostiq-flarumtwitter.consumerAPI'] = $this->settings->get('ghostiq-flarumtwitter.consumerAPI');
            $event->attributes['ghostiq-flarumtwitter.consumerAPISecret'] = $this->settings->get('ghostiq-flarumtwitter.consumerAPISecret');
            $event->attributes['ghostiq-flarumtwitter.accessToken'] = $this->settings->get('ghostiq-flarumtwitter.accessToken');
            $event->attributes['ghostiq-flarumtwitter.accessTokenSecret'] = $this->settings->get('ghostiq-flarumtwitter.accessTokenSecret');
        }
    }
}
