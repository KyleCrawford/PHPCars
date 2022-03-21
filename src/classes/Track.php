<?php

require_once "./includes/loader.php";

/**
 * Track object intended to be used with a Car object to have the Car race down the Track
 */
class Track {
    /** The list of TrackSections in this Track */
    public $trackList = [];

    /**
     * Randomly creates a Track by creating a number of straight elements between the provided values
     * then creating the remaining as curve elements and shuffling them
     */
    public function __construct($minElement, $maxElement)
    {
        $totalElement = $minElement + $maxElement;
        $num = rand($minElement, $maxElement);

        for ($i = 0; $i < $num; $i++) {
            // this many times we add a straight piece
            $this->trackList[$i] = new TrackSection('straight');
        }

        for ($i = 0; $i < ($totalElement - $num); $i++) {
            // the remainder of the pieces are curves
            $this->trackList[$i + $num] = new TrackSection('curve');
        }

        shuffle($this->trackList);
    }
}