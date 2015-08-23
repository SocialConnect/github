<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace SocialConnect\GitHub\Entity;

class Repository extends \stdClass
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var User
     */
    public $owner;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $full_name;
}
