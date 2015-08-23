<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace SocialConnect\GitHub;

use InvalidArgumentException;
use SocialConnect\Common\Http\Client\Client as AbstractHttpClient;
use SocialConnect\Common\HttpClient;
use SocialConnect\Common\Hydrator\CloneObjectMap;
use SocialConnect\Common\Hydrator;

class Client extends \SocialConnect\Common\ClientAbstract
{
    use HttpClient;

    const API_BASE_URI = 'https://api.github.com/';

    /**
     * @var string
     */
    protected $apiUri = self::API_BASE_URI;

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param string $uri
     * @param array $parameters
     * @param bool|false $accessToken
     * @return bool|mixed
     * @throws \Exception
     */
    public function request($uri, array $parameters = array(), $accessToken = false, $method = AbstractHttpClient::GET)
    {
        $response = $this->httpClient->request($this->apiUri . $uri, $parameters, $method);
        if ($response) {
            if ($response->isServerError()) {
                $body = $response->getBody();
                if ($body) {
                    throw new \Exception($body);
                }

                throw new \Exception('Unexpected server error with code : ' . $response->getStatusCode());
            }

            $body = $response->getBody();
            if ($body) {
                $json = json_decode($body);
                if (isset($json->data)) {
                    return $json->data;
                } elseif (isset($json->meta)) {
                    throw new \Exception($json->meta->error_message, $json->meta->code);
                }

                throw new \Exception($response);
            } else {
                throw new \Exception($response);
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getApiUri()
    {
        return $this->apiUri;
    }

    /**
     * @param string $apiUri
     */
    public function setApiUri($apiUri)
    {
        $this->apiUri = $apiUri;
    }
}
