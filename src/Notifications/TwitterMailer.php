<?php

namespace Ghostiq\FlarumTwitter\Notifications;

use Exception;
use Flarum\Settings\SettingsRepositoryInterface;
use DG\Twitter\Twitter;

require_once '../../src/twitter-php/src/twitter.class.php';

class TwitterMailer
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
        
        $twitter = new Twitter($consumerAPI, $consumerAPISecret, $accessToken, $accessTokenSecret);
    }

    public function send()
    {      
      try {
      	$tweet = $twitter->send('Drugi tweet z flarum https://forum.flyhunter.pl/d/27-blyskawiczne-powiadomienia-z-forum'); // you can add $imagePath or array of image paths as second argument      
      }
      catch (DG\Twitter\TwitterException $e)
      {
      	//echo 'Error: ' . $e->getMessage();
      }
    }

}
