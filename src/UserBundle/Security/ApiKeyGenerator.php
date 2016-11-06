<?php

namespace UserBundle\Security;

class ApiKeyGenerator
{
    /**
     * @return string
     */
    public static function generate()
    {
        return sha1(uniqid(mt_rand(), true));
    }
}
