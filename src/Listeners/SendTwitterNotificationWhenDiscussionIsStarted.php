<?php

namespace Ghostiq\FlarumTwitter\Listeners;

use Flarum\Discussion\Event\Started;
use Flarum\Tags\Tag;
use Illuminate\Support\Collection;

use Flarum\Settings\SettingsRepositoryInterface;
use DG\Twitter\Twitter;

class SendTwitterNotificationWhenDiscussionIsStarted
{

    protected $twitter;
    protected $tagIdToFollow;
    protected $tagIdToFollow1;    

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $consumerAPI = $settings->get('ghostiq-flarumtwitter.consumerAPI');
        $consumerAPISecret = $settings->get('ghostiq-flarumtwitter.consumerAPISecret');
        $accessToken = $settings->get('ghostiq-flarumtwitter.accessToken');
        $accessTokenSecret = $settings->get('ghostiq-flarumtwitter.accessTokenSecret');
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
        	$debug = var_export($discussion, true);
            mail('ghostiq@gmail.com', 'Debug', $discussion);
            $tweet = $this->twitter->send($discussion->title . ' '); // you can add $imagePath or array of image paths as second argument            
        }
        catch (DG\Twitter\TwitterException $e)
        {
        	//echo 'Error: ' . $e->getMessage();
        }
    }
}
