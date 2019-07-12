<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DiscordController extends AbstractController
{
	/**
	 * @Route("/connect/discord", methods={"GET"}, name="connect_discord")
	 */
	public function connectDiscord(ClientRegistry $registry)
	{
		return $registry->getClient('discord')->redirect(['identify', 'email', 'connections']);
	}

	/**
	 * @Route("/connect/discord/check", methods={"GET"}, name="connect_discord_check")
	 */
	public function connectDiscordCheck(ClientRegistry $clientRegistry)
	{
	}
}