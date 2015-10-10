<?php
/**
 * SocialConnect project
 * @author: Patsura Dmitry https://github.com/ovr <talk@dmtry.me>
 */

namespace SocialConnect\GitHub\Exception;

class ApiLimitExceed extends \RuntimeException
{
    public function __construct($limit = 5000, $code = 0, $previous = null)
    {
        parent::__construct('You have reached GitHub hour limit! Actual limit is: '. $limit, $code, $previous);
    }
}
