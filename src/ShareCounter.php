<?php


namespace Sagautam5\SocialShareCount;

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
     * Facebook Api End Point
     */
    const FACEBOOK_API = 'https://graph.facebook.com/v3.0';

    /**
     * Pinterest Api End Point
     */
    const PINTEREST_API = 'https://api.pinterest.com/v1/urls/count.json';

    /**
     * Reddit Api End Point
     */
    const REDDIT_API = 'https://www.reddit.com/api/info.json';

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

            $response = file_get_contents(self::FACEBOOK_API.'?fields=engagement&&access_token='.config('share_count.fb_app_id').'|'.config('share_count.fb_app_secret').'&id='.$url);

            /**
             * Format the response
             */
            $response = json_decode($response);

            /**
             * Count the shares
             */
            $count = $response->engagement->share_count;

        }catch (\Exception $e){
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
        $response = file_get_contents(self::PINTEREST_API.'?callback=receiveCount&url='.$url);

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

    /**
     * Get Reddit Shares
     *
     * @param $url
     * @return mixed
     * @throws \Throwable
     */
    public static function getRedditShares($url)
    {
        /**
         * Check if valid URL is added
         */
        throw_if(!filter_var($url, FILTER_VALIDATE_URL), new InvalidUrlException('Please enter valid url http or https !',400));

        /**
         * Hit Pinterest API
         */
        $response = file_get_contents(self::REDDIT_API.'?limit=1&url='.$url);

        /**
         * Format data
         */
        $response = json_decode($response);

        /**
         * Get Counts
         */
        $count = $response &&
            $response->data &&
            count($response->data->children) > 0 &&
            $response->data->children[0]->data &&
            $response->data->children[0]->data->score ? $response->data->children[0]->data->score : 0;

        return $count;
    }
}
