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
use Flarum\Tags\Tag;
use Illuminate\Support\Collection;

use Flarum\Settings\SettingsRepositoryInterface;
use DG\Twitter\Twitter;
require_once __DIR__ . '/../../twitter-php/src/twitter.class.php';

class SendTwitterNotificationWhenDiscussionIsStarted
{

    protected $twitter;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $consumerAPI = $settings->get('ghostiq-flarumtwitter.consumerAPI');
        $consumerAPISecret = $settings->get('ghostiq-flarumtwitter.consumerAPISecret');
        $accessToken = $settings->get('ghostiq-flarumtwitter.accessToken');
        $accessTokenSecret = $settings->get('ghostiq-flarumtwitter.accessTokenSecret'); 
        if (!$consumerAPI || !$consumerAPISecret || !$accessToken || !$accessTokenSecret) {
            throw new Exception('No api or token configured for Twitter');
        }
        $this->twitter = new Twitter($consumerAPI, $consumerAPISecret, $accessToken, $accessTokenSecret);
    }
    
    public function handle(Started $event)
    { 
        $discussion = $event->discussion;

        $tags = $discussion->tags;
        $tagIds = $tags->map->id;

        if ($tags->isEmpty() || !$event->actor->can('viewPrivate', $discussion)) {
            return;
        }
        
        $test = $tags->find(16);
        if ($test != null)
            mail('ghostiq@gmail.com', 'Tagi i ID', $test . 'KONIEC');
        //$dump = print_r(get_class_methods($tags), true);
        //$dump1 = print_r($tagIds, true);

        
        try {
        	//$tweet = $this->twitter->send('Drugi tweet z flarum https://forum.flyhunter.pl/d/27-blyskawiczne-powiadomienia-z-forum'); // you can add $imagePath or array of image paths as second argument
        }
        catch (DG\Twitter\TwitterException $e)
        {
        	//echo 'Error: ' . $e->getMessage();
        }
    }
}
