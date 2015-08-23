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

                if (isset($json->message)) {
                    throw new \Exception($json->message, $response->getStatusCode());
                } elseif ($json) {
                    return $json;
                }

                throw new \Exception($response->getBody());
            } else {
                throw new \Exception($response->getBody());
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

    /**
     * Get a single user
     *
     * @link https://developer.github.com/v3/users/#get-a-single-user
     *
     * @param integer $username
     * @return Entity\User|bool false if it's not exists
     * @throws \Exception
     */
    public function getUser($username)
    {
        try {
            $result = $this->request('users/' . $username);

            $hydrator = new \SocialConnect\Common\Hydrator\ObjectMap(array());
            return $hydrator->hydrate(new Entity\User(), $result);
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * Get a single repository
     *
     * @link https://developer.github.com/v3/repos/#get
     *
     * @param $username
     * @param string $owner
     * @param string $repo
     * @return Entity\Repository|bool false if it's not exists
     * @throws \Exception
     */
    public function getRepository($owner, $repo)
    {
        try {
            $result = $this->request('repos/' . $owner . '/' . $repo);

            $hydrator = new \SocialConnect\Common\Hydrator\ObjectMap(array());
            return $hydrator->hydrate(new Entity\Repository(), $result);
        } catch (\Exception $e) {
            return false;
        }
    }
}
