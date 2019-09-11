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
use Ghostiq\FlarumTwitter\Notifications\TwitterMailer as TwitterMailer;
use Illuminate\Support\Collection;

//use Flarum\User\User;
//use Illuminate\Contracts\Events\Dispatcher;

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
        $dump = print_r($discussion, true);
        //mail('ghostiq@o2.pl', 'Test4', 'Z'.$dump.'Z');
        mail('ghostiq@o2.pl', 'Test51', 'ZZ');
        $poster = app(TwitterMailer::class);
        mail('ghostiq@o2.pl', 'Test55', 'ZZ');
        $poster->send();
    }
}
