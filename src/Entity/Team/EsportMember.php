<?php

namespace App\Entity\Team;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class EsportMember extends AMember
{
    const GAME_LEAGUE_OF_LEGENDS = 'game_lol';
    const GAME_ROCKET_LEAGUE = 'game_rl';

    const MAIN_TEAM = 'team_main';
    const ACADEMY_TEAM = 'team_academy';

    const ROLE_TOP = '10_top';
    const ROLE_JUNGLE = '20_jungle';
    const ROLE_MID = '30_mid';
    const ROLE_ADC = '40_adc';
    const ROLE_SUPPORT = '50_support';
    const ROLE_COACH = '60_coach';
    const ROLE_MANAGER = '70_manager';
    const ROLE_PROJECT_MANAGER = '80_project_manager';
    const ROLE_PLAYER = '90_player';
    const ROLE_PLAYERE = '91_playere';


    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Choice(callback="getAvailableGames")
     */
    protected $game;

    public static function getAvailableGames()
    {
        return [
            self::GAME_LEAGUE_OF_LEGENDS,
            self::GAME_ROCKET_LEAGUE,
        ];
    }

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Choice(callback="getAvailableTeams")
     */
    protected $team;

    public static function getAvailableTeams()
    {
        return [
            self::MAIN_TEAM,
            self::ACADEMY_TEAM,
        ];
    }

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Choice(callback="getAvailableRoles")
     */
    protected $role;

    public static function getAvailableRoles()
    {
        return [
            self::ROLE_TOP,
            self::ROLE_JUNGLE,
            self::ROLE_MID,
            self::ROLE_ADC,
            self::ROLE_SUPPORT,
            self::ROLE_COACH,
            self::ROLE_MANAGER,
            self::ROLE_PROJECT_MANAGER,
            self::ROLE_PLAYER,
            self::ROLE_PLAYERE,
        ];
    }

    public function getGame(): ?string
    {
        return $this->game;
    }

    public function setGame(string $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getTeam(): string
    {
        return $this->team;
    }

    public function setTeam(string $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}
