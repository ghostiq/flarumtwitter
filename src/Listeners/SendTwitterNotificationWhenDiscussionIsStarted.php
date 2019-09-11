<?php

/*
 * This file is part of fof/follow-tags.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Ghostiq\FlarumTwitter\Listeners;

use Flarum\Discussion\Event\Started;
use Flarum\Notification\NotificationSyncer;
use Flarum\Tags\Tag;
use Ghostiq\FlarumTwitter\Notifications\TwitterMailer;
use Illuminate\Support\Collection;

class SendTwitterNotificationWhenDiscussionIsStarted
{
    public function handle(Started $event)
    {
        $discussion = $event->discussion;

        $tags = $discussion->tags;
        $tagIds = $tags->map->id;

        if ($tags->isEmpty() || !$event->actor->can('viewPrivate', $discussion)) {
            return;
        }

        $poster = app(TwitterMailer::class);
        $poster->send();
    }
}
