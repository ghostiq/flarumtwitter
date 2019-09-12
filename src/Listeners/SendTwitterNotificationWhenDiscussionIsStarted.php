<?php

namespace Ghostiq\FlarumTwitter\Listeners;

use Flarum\Discussion\Event\Started;
use Flarum\Tags\Tag;
use Illuminate\Support\Collection;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Http\UrlGenerator;
use DG\Twitter\Twitter;

class SendTwitterNotificationWhenDiscussionIsStarted
{
    protected $baseDiscussionUrl;
    protected $twitter;
    protected $tagIdToFollow;
    protected $tagIdToFollow1;    

    public function __construct(SettingsRepositoryInterface $settings, UrlGenerator $urlGenerator)
    {
        $consumerAPI = $settings->get('ghostiq-flarumtwitter.consumerAPI');
        $consumerAPISecret = $settings->get('ghostiq-flarumtwitter.consumerAPISecret');
        $accessToken = $settings->get('ghostiq-flarumtwitter.accessToken');
        $accessTokenSecret = $settings->get('ghostiq-flarumtwitter.accessTokenSecret');
        $this->baseDiscussionUrl = $urlGenerator->to('forum')->base() . '/d/';
        $this->tagIdToFollow = $settings->get('ghostiq-flarumtwitter.tagIdToFollow');
        $this->tagIdToFollow1 = $settings->get('ghostiq-flarumtwitter.tagIdToFollow1');
        if (!$consumerAPI || !$consumerAPISecret || !$accessToken || !$accessTokenSecret || !$this->tagIdToFollow) {
            throw new Exception('No api or token or tag id to tweet configured for Twitter');
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
        
        $tagIdFound = $tags->find($this->tagIdToFollow);
        if ($tagIdFound == null) {
            if (!$this->tagIdToFollow1)
                return;
            $tagIdFound = $tags->find($this->tagIdToFollow1);
            if ($tagIdFound == null)
                return;    
        }
      
        try {
        	//$debug = var_export($this->tagIdToFollow . "\r\n" . $this->tagIdToFollow1 . "\r\n" . $this->urlGenerator->to("forum"), true);
            //mail('ghostiq@gmail.com', 'Debug', $debug);
            $tweet = $this->twitter->send($discussion->title . ' ' . $this->baseDiscussionUrl . $discussion->id . '-' . $discussion->slug); // you can add $imagePath or array of image paths as second argument            
        }
        catch (DG\Twitter\TwitterException $e)
        {
        	//echo 'Error: ' . $e->getMessage();
        }
    }
}
