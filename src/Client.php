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
use SocialConnect\GitHub\Exception\ApiLimitExceed;

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
     * @return bool|mixed
     * @throws \Exception
     */
    public function request($uri, array $parameters = array(), $method = AbstractHttpClient::GET)
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

            if ($response->getHeader('X-RateLimit-Remaining') == 0) {
                throw new ApiLimitExceed($response->getHeader('X-RateLimit-Limit'));
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
     * Get all users
     *
     * @link https://developer.github.com/v3/users/#get-all-users
     *
     * @param int $since
     * @return bool|array
     */
    public function getUsers($since = 0)
    {
        if ($since < 0) {
            throw new InvalidArgumentException('$since must be >= 0');
        }

        if ($since > 0) {
            $result = $this->request('users', ['since' => $since]);
        } else {
            /**
             * 0 is a default parameter for $since and it's not neeeded to be passed for API
             */
            $result = $this->request('users');
        }

        if ($result) {
            /**
             * @todo w8 collection(s) class and amazing hydrator
             */
        }

        return $result;
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
