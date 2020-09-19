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
        /**
         * setup default counter value
         */
        $count = 0;

        /**
         * Check if credentials are added
         */

        throw_if(!(config('share_count.fb_app_id') && config('share_count.fb_app_secret')), new EmptyFacebookCredentialsException('Please add facebook app id and app secret correctly !'));

        /**
         * Check if valid URL is added
         */

        throw_if(!filter_var($url, FILTER_VALIDATE_URL), new InvalidUrlException('Please enter valid url including http or https !',400));

        /**
         * Send get request to facebook server
         */

        try{
            /**
             * Hit Facebook API
             */

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
                /**
                 * Format the data
                 */
                $data = json_decode($response->getBody());

                $count = $data->engagement->share_count;
            }

        }catch (ClientException $e){
            throw new InvalidFacebookCredentialsException('Facebook App ID and App Secret are incorrect !');
        }

        return $count;
    }

    /**
     * @param $url
     * @return mixed
     * @throws \Throwable
     */
    public static function getPinterestShares($url)
    {
        /**
         * Check if valid URL is added
         */
        throw_if(!filter_var($url, FILTER_VALIDATE_URL), new InvalidUrlException('Please enter valid url http or https !',400));

        /**
         * Hit Pinterest API
         */
        $response = file_get_contents('https://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url='.$url);

        /**
         * Format the response
         */
        if($response[0] !== '[' && $response[0] !== '{') {
            $response = substr($response, strpos($response, '('));
        }

        $response =  json_decode(trim($response,'();'), false);

        /**
         * Get Counts
         */
        $count = $response->count;

        return $count;
    }
}
