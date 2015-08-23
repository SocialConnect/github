<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace SocialConnect\GitHub\Entity;

class User extends \stdClass
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $avatar_url;

    /**
     * @var string
     */
    public $gravatar_id;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $html_url;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $public_repos;

    /**
     * @var string
     */
    public $public_gists;

    /**
     * @var string
     */
    public $followers;

    /**
     * @var string
     */
    public $following;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;
}
