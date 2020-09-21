# Social Share Count

## This will help to count the social share count of a url
[![Latest Stable Version](https://poser.pugx.org/sagautam5/social-share-count/v)](//packagist.org/packages/sagautam5/social-share-count)
[![Total Downloads](https://poser.pugx.org/sagautam5/social-share-count/downloads)](//packagist.org/packages/sagautam5/social-share-count)
![Issues](https://img.shields.io/github/issues/sagautam5/social-share-count
) [![Stars](https://img.shields.io/github/stars/sagautam5/social-share-count
)](https://github.com/sagautam5/social-share-count/stargazers) [![License](https://img.shields.io/github/license/sagautam5/social-share-count
)](https://github.com/sagautam5/social-share-count/stargazers) [![Forks](https://img.shields.io/github/forks/sagautam5/social-share-count
)](https://github.com/sagautam5/social-share-count/stargazers) [![Twitter](https://img.shields.io/twitter/url?url=https%3A%2F%2Fgithub.com%2Fsagautam5%2Fsocial-share-count
)](https://github.com/sagautam5/social-share-count/stargazers)

## Description

  Social share count is the laravel package to determine number of times a url is shared on social media like facebook. 
  
  Social Share Count Requires 
  
  PHP >= 7.3.*
  
  Laravel >= 7.0.*
  
## Support
- Facebook
- Pinterest
- Reddit  
   
## Installation

```sh
composer require sagautam5/social-share-count
```

## Configuration

#### Facebook

At first, get App ID and App Secret by creating new app in https://developers.facebook.com. 
![Get App ID and Secret](https://raw.githubusercontent.com/sagautam5/social-share-count/master/src/images/facebook%20credentials.png)

Now, add those credentials in .env file.
```dotenv
FB_APP_ID='xxxxxxxxxxxxxxxx'
FB_APP_SECRET='XXXXXXXXXXXXXXXXXXXXXXXXXX'
```

Now, Clear the configuration cache.

```shell script
php artisan config:cache
```

#### Pinterest

Currently, you don't need any application id or secret to count pinterest shares. You can just call the function.

#### Reddit

Currently, you don't need any application id or secret to count reddit shares. You can just call the function.

## Basic Usage

After installation, you can use the share count feature like this:

```php
use Sagautam5\SocialShareCount\ShareCounter;

$url = 'https://www.example.com';

$facebookShares = ShareCounter::getFacebookShares($url);
echo $facebookShares;

$pinterestShares = ShareCounter::getPinterestShares($url);
echo $pinterestShares;

$redditShares = ShareCounter::getRedditShares($url);
echo $redditShares;
``` 


## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
