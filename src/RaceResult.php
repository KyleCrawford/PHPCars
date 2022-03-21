<?php

class RaceResult
{
    /**
     * @var array of StepResult
     */
    private $roundResults = [];

    public function getRoundResults(): array
    {
        return $this->roundResults;
    }

    /**
     * adds the provided RoundResult object to the roundResults list
     * @param RoundResult $rResult The RoundResult to add
     */
    public function addToRoundResults($rResult) {
        array_push($this->roundResults, $rResult);
    }
}
