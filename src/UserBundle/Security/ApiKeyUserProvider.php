<?php

namespace UserBundle\Security;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use UserBundle\Entity\User;

class ApiKeyUserProvider implements UserProviderInterface
{
    /** @var UserManagerInterface */
    private $userManager;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param $apiKey
     *
     * @return string
     */
    public function getUsernameByApiKey($apiKey)
    {
        $user = $this->userManager->findUserBy(['apiKey' => $apiKey]);

        if (!$user instanceof User) {
            throw new AuthenticationException('No user with this api key was found.');
        }

        return $user->getUsername();
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Could not found user for username %s.', $username));
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
