<?php

namespace UserBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;

class ApiRequestMatcher implements RequestMatcherInterface
{
    /**
     * {@inheritdoc}
     */
    public function matches(Request $request)
    {
        return $request->attributes->get('api') === true;
    }
}
