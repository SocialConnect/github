<?php
/**
 * @author Patsura Dmitry <talk@dmtry.me>
 */

namespace TestInstagram;

use SocialConnect\GitHub\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    const USER_ENTITY_CLASS = 'SocialConnect\GitHub\Entity\User';

    const REPOSITORY_ENTITY_CLASS = 'SocialConnect\GitHub\Entity\Repository';

    const COLLECTION_ENTITY_CLASS = 'SocialConnect\GitHub\Entity\Repository';

    /**
     * @return Client
     */
    protected function getClient()
    {
        $client = new Client(getenv('applicationId'), getenv('applicationSecret'));
        $client->setHttpClient(new \SocialConnect\Common\Http\Client\Curl());

        return $client;
    }

    /**
     * @return string
     */
    protected function getAccessToken()
    {
        return getenv('testUserAccessToken');
    }

    /**
     * @return integer
     */
    protected function getDemoUserName()
    {
        return (int) getenv('testUser');
    }

    protected function assertUser($user)
    {
        $this->assertInternalType('object', $user);
        $this->assertInternalType('string', $user->login);
        $this->assertInternalType('integer', $user->id);
    }

    public function testRequestMethod()
    {
        $client = $this->getClient();
        $client->setAccessToken($this->getAccessToken());

        $user = $client->request('users/' . $this->getDemoUserName());
        $this->assertUser($user);
    }

    public function testGetUser()
    {
        $client = $this->getClient();
        $client->setAccessToken($this->getAccessToken());

        $this->assertInstanceOf(self::USER_ENTITY_CLASS, $client->getUser($this->getDemoUserName()));
    }

    public function testGetUsers()
    {
        $client = $this->getClient();
        $client->setAccessToken($this->getAccessToken());

        $this->assertInternalType('array', $client->getUsers());
        $this->assertCount(30, $client->getUsers());
    }

    public function testGetUsersWithSpecifiedSince()
    {
        $client = $this->getClient();
        $client->setAccessToken($this->getAccessToken());

        $this->assertInternalType('array', $client->getUsers(30));
        $this->assertCount(30, $client->getUsers());
    }

    public function testGetUsersWithNegativeSince()
    {
        $client = $this->getClient();
        $client->setAccessToken($this->getAccessToken());

        $this->setExpectedException('InvalidArgumentException', '$since must be >= 0');
        $client->getUsers(-1);
    }

    public function testGetUserRepository()
    {
        $client = $this->getClient();
        $client->setAccessToken($this->getAccessToken());

        $this->assertInstanceOf(
            self::REPOSITORY_ENTITY_CLASS,
            $client->getRepository('socialconnect', 'github')
        );
    }
}
