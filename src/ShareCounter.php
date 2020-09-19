<?php


namespace Sagautam5\SocialShareCount;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Sagautam5\SocialShareCount\Exceptions\EmptyFacebookCredentialsException;
use Sagautam5\SocialShareCount\Exceptions\InvalidFacebookCredentialsException;
use Sagautam5\SocialShareCount\Exceptions\InvalidUrlException;

/**
 * Class ShareCounter
 * @package Sagautam5\SocialShareCount
 */
class ShareCounter
{
    /**
     * @param $url
     * @return int
     * @throws \Throwable
     */
    public static function getFacebookShares($url)
    {
        $count = 0;

        throw_if(!(config('share_count.fb_app_id') && config('share_count.fb_app_secret')), new EmptyFacebookCredentialsException('Please add facebook app id and app secret correctly !'));

        throw_if(!filter_var($url, FILTER_VALIDATE_URL), new InvalidUrlException('Please enter valid url !',400));

        try{
            $client = new Client();
            $response = $client->get('https://graph.facebook.com/v3.0', [
                'query' =>
                    [
                        'fields' => 'engagement',
                        'access_token' => config('share_count.fb_app_id').'|'.config('share_count.fb_app_secret'),
                        'id' => $url
                    ]
            ]);

            if($response->getStatusCode() == 200)
            {
                $data = json_decode($response->getBody());

                $count = $data->engagement->share_count;
            }

        }catch (ClientException $e){
            throw new InvalidFacebookCredentialsException('Facebook App ID and App Secret are incorrect !');
        }

        return $count;
    }
}
