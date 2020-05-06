<?php

namespace App\Entity;

class Team
{
    private string $name;
    private string $country;
    private string $logo;
    /**
     * @var Player[]
     */
    private array $players;
    private string $coach;
    private int $goals;
    private array $playTimeByRole = [];

    public function __construct(string $name, string $country, string $logo, array $players, string $coach)
    {
        $this->assertCorrectPlayers($players);

        $this->name = $name;
        $this->country = $country;
        $this->logo = $logo;
        $this->players = $players;
        $this->coach = $coach;
        $this->goals = 0;

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return Player[]
     */
    public function getPlayersOnField(): array
    {
        return array_filter($this->players, function (Player $player) {
            return $player->isPlay();
        });
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayer(int $number): Player
    {
        foreach ($this->players as $player) {
            if ($player->getNumber() === $number) {
                return $player;
            }
        }

        throw new \Exception(
            sprintf(
                'Player with number "%d" not play in team "%s".',
                $number,
                $this->name
            )
        );
    }

    public function getCoach(): string
    {
        return $this->coach;
    }

    public function addGoal(): void
    {
        $this->goals += 1;
    }

    public function getGoals(): int
    {
        return $this->goals;
    }


    private function assertCorrectPlayers(array $players)
    {
        foreach ($players as $player) {
            if (!($player instanceof Player)) {
                throw new \Exception(
                    sprintf(
                        'Player should be instance of "%s". "%s" given.',
                        Player::class,
                        get_class($player)
                    )
                );
            }
        }
    }


    public function getPlayTimeByRole($role)
    {   

        if(count($this->playTimeByRole) == 0)
        {
            $forward = 0;
            $midfielder = 0;
            $goalkeeper = 0;
            $quarterback = 0;

            $players = $this->players;

            foreach ($players as $player) {
                switch ($player->getRole()) {
                    case 'Н':
                        $forward += $player->getPlayTime();
                        break;
                    case 'В':
                        $goalkeeper += $player->getPlayTime();
                        break;
                    case 'П':
                        $midfielder += $player->getPlayTime();
                        break;
                    case 'З':
                        $quarterback += $player->getPlayTime();
                        break;            
                    default:
                        # code...
                        break;
                }
            }

            $this->playTimeByRole['forward'] = $forward;
            $this->playTimeByRole['midfielder'] = $midfielder;
            $this->playTimeByRole['quarterback'] = $quarterback;
            $this->playTimeByRole['goalkeeper'] = $goalkeeper;     
        }

            return $this->playTimeByRole[$role];
    }


}