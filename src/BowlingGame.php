<?php

namespace App;

class BowlingGame
{
    /**
     * number of frames in a game.
     */
    const FRAMES_PER_GAME = 10;
    /**
     * all rolls for a game
     *
     * @var array
     */
    protected array $rolls = [];

    /**
     * roll the ball
     *
     * @param int $pins
     * @return void
     */
    public function roll(int $pins)
    {
        $this->rolls[] = $pins;
    }

    /**
     * calculate final score
     *
     * @return int|mixed
     */
    public function score()
    {
        $score = 0;
        $roll = 0;
        foreach (range(1, self::FRAMES_PER_GAME) as $frame) {
            if($this->isStrike($roll)){
                $score += $this->pinCount($roll) + $this->strikeBonus($roll);
                $roll += 1;
                continue;
            }
            $score += $this->defaultFrameScore($roll);
            if($this->isSpare($roll)){
                $score += $this->spareBonus($roll);
            }
            $roll += 2;
        }
        return $score;
    }

    protected function isStrike(int $roll): bool
    {
        return $this->pinCount($roll) === 10;
    }

    protected function isSpare(int $roll): bool
    {
        return $this->defaultFrameScore($roll) === 10;
    }

    protected function defaultFrameScore(int $roll): int
    {
        return $this->pinCount($roll) + $this->pinCount($roll + 1);

    }

    protected function strikeBonus(int $roll): int
    {
        return $this->pinCount($roll+1) + $this->pinCount($roll+2);
    }

    protected function spareBonus(int $roll): int
    {
        return $this->pinCount($roll + 2);
    }

    protected function pinCount(int $roll): int
    {
        return $this->rolls[$roll];
    }
}