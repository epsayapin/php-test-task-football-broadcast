<?php
namespace App\Entity;

class Player
{
    private const PLAY_PLAY_STATUS = 'play';
    private const BENCH_PLAY_STATUS = 'bench';

    private int $number;
    private string $name;
    private string $playStatus;
    private int $inMinute;
    private int $outMinute;
    private int $score;
    private int $yellowCardsCount;
    private string $role;

    public function __construct(int $number, string $name, string $role, int $score = 0, int $yellowCardsCount = 0)
    {
        $this->number = $number;
        $this->name = $name;
        $this->playStatus = self::BENCH_PLAY_STATUS;
        $this->inMinute = 0;
        $this->outMinute = 0;
        $this->score = $score;
        $this->yellowCardsCount =  $yellowCardsCount;
        $this->role = $role;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInMinute(): int
    {
        return $this->inMinute;
    }

    public function getOutMinute(): int
    {
        return $this->outMinute;
    }

    public function isPlay(): bool
    {
        return $this->playStatus === self::PLAY_PLAY_STATUS;
    }

    public function getPlayTime(): int
    {
        if(!$this->outMinute) {
            return 0;
        }

        return $this->outMinute - $this->inMinute + 1;
    }

    public function goToPlay(int $minute): void
    {
        $this->inMinute = $minute;
        $this->playStatus = self::PLAY_PLAY_STATUS;
    }

    public function goToBench(int $minute): void
    {
        $this->outMinute = $minute;
        $this->playStatus = self::BENCH_PLAY_STATUS;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function scoreUp()
    {
        $this->score++;
    }

    public function getYellowCardsCount()
    {
        return $this->yellowCardsCount;
    }

    public function giveOutYellowCard()
    {
        $this->yellowCardsCount++;
    }

    public function getRole()
    {
        return $this->role;
    }

}