<?php


namespace Sagautam5\SocialShareCount;

use GuzzleHttp\Client;

/**
 * Class ShareCounter
 * @package Sagautam5\SocialShareCount
 */
class ShareCounter
{
    /**
     * Count no of facebook shares of a url
     *
     * @param $url
     * @return int
     */
    public static function getFacebookShares($url)
    {
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

            return $data->engagement->share_count;
        }

        return 0;
    }
}
