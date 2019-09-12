<?php

namespace Ghostiq\FlarumTwitter;

use Flarum\Extend;
use Flarum\Discussion\Event as Discussion;
//use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Events\Dispatcher as Dispatcher;

return [
    new Extend\Locales(__DIR__.'/locale'),
    
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Compat(function (Dispatcher $events) {
        $events->listen(Discussion\Started::class, Listeners\SendTwitterNotificationWhenDiscussionIsStarted::class);
    }),
];
