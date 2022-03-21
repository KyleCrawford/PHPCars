<?php
require_once "./includes/loader.php";

/**
 * Represents one section of straight or curve track.
 * Contains the (default of) 40 elements that the Cars travel down.
 */
class TrackSection {
    
    /** The type of TrackSection */
    public $type;

    /** The number of elements in a TrackSection */
    public $length = Settings::TRACK_SECTION_LENGTH;

    public function __construct($type)
    {
        $this->type = $type;
    }

}