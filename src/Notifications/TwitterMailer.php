<?php
mail('ghostiq@o2.pl', 'Test52', 'ZZ');
namespace Ghostiq\FlarumTwitter\Notifications;

use Exception;
use Flarum\Settings\SettingsRepositoryInterface;
use DG\Twitter\Twitter;
mail('ghostiq@o2.pl', 'Test00', $consumerAPI);
require_once '../../twitter-php/src/twitter.class.php';

class TwitterMailer
{
    protected $twitter;

    public function __construct(SettingsRepositoryInterface $settings)
    {

        $consumerAPI = $settings->get('ghostiq-flarumtwitter.consumerAPI');
        $consumerAPISecret = $settings->get('ghostiq-flarumtwitter.consumerAPISecret');
        $accessToken = $settings->get('ghostiq-flarumtwitter.accessToken');
        $accessTokenSecret = $settings->get('ghostiq-flarumtwitter.accessTokenSecret');
        mail('ghostiq@o2.pl', 'Test01', $consumerAPI);    
        if (!$consumerAPI || !$consumerAPISecret || !$accessToken || !$accessTokenSecret) {
            throw new Exception('No api or token configured for Twitter');
        }
        
        $this->twitter = new Twitter($consumerAPI, $consumerAPISecret, $accessToken, $accessTokenSecret);

    }

    public function send()
    {      
      try {
      	$tweet = $this->twitter->send('Drugi tweet z flarum https://forum.flyhunter.pl/d/27-blyskawiczne-powiadomienia-z-forum'); // you can add $imagePath or array of image paths as second argument
          mail('ghostiq@o2.pl', 'Test5', 'Nic');      
      }
      catch (DG\Twitter\TwitterException $e)
      {
      	//echo 'Error: ' . $e->getMessage();
      }
    }

}
