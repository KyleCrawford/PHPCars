<?php

/**
 * Contains many settings to configure the Race
 */
class Settings {
    /** @var int Minimum amount of a type of TrackSection that can be in a Track */
    public const TRACK_MIN_ELEMENT = 23;

     /** @var int Maximum amount of a type of TrackSection that can be in a Track */
    public const TRACK_MAX_ELEMENT = 27;

    /**
     * #var int Amount of TrackSections a Track will have
     * Must be the sum of TRACK_MIN_ELEMENT and TRACK_MAX_ELEMENT
     */
    public const TRACK_LENGTH = 50;
    
    /** @var int Amount of elements a track section has */
    public const TRACK_SECTION_LENGTH = 40;

    /** @var int Maximum total Car speed */
    public const CAR_TOTAL_SPEED = 22;

    /** @var int Minimum speed a Car can go */
    public const CAR_MIN_SPEED = 4;

    /** @var int The number of cars to be created */
    public const DEFAULT_NUM_CARS = 5;


}