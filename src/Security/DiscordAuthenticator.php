<?php

namespace App\Security;

use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class DiscordAuthenticator extends SocialAuthenticator
{
    /**
     * @var ClientRegistry
     */
    private $clientRegistry;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager)
    {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse('/login');
    }

    public function supports(Request $request): bool
    {
        return 'connect_discord_check' === $request->attributes->get('_route');
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getDiscordClient());
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        /** @var DiscordResourceOwner $discordUser */
        $discordUser = $this->getDiscordClient()->fetchUserFromToken($credentials);

        //user already linked discord
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['discordId' => $discordUser->getId()]);
        if ($user instanceof UserInterface) {
            return $user;
        }

        //user exists without having linked
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $discordUser->getEmail()]);
        if ($user instanceof UserInterface) {
            $user->setDiscordId($discordUser->getId());
            $this->entityManager->flush();

            return $user;
        }

        $user = new User();
        $user->setEmail($discordUser->getEmail());
        $user->setDisplayName($discordUser->getUsername());
        $user->setDiscordId($discordUser->getId());
        $user->setDiscord($discordUser->getUsername().'#'.$discordUser->getDiscriminator());
        $user->setRoles([User::ROLE_DEFAULT]);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse('/');
    }

    private function getDiscordClient()
    {
        return $this->clientRegistry->getClient('discord');
    }
}
