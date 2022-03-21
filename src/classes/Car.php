<?php
require_once "./includes/loader.php";

/**
 * A Car class intended to be used with a Track object to have it 'race' down the Track
 */
class Car {
    /** The speed the Car moves on a straight section */
    public $straightSpeed;

    /** The speed the Car moves on a curve section */
    public $curveSpeed;

    /** The ID of the car */
    public $carId;

    /** Total distance travelled by the car. */ 
    public $totalTravelled;

    public function __construct($id)
    {
        $this->straightSpeed = $this->calcStraightSpeed();
        $this->curveSpeed = $this->calcCurveSpeed();
        $this->carId = $id;
    }

    /**
     * Calculates a speed between min, and (max - min) (allows the next to have a minimum of 4)
     */
    private function calcStraightSpeed():int {
        return rand(Settings::CAR_MIN_SPEED, Settings::CAR_TOTAL_SPEED - Settings::CAR_MIN_SPEED);
    }

    /** 
     * sets the curve speed to be the remainder of the speed to add up to the max
     */
    private function calcCurveSpeed():int {
        return Settings::CAR_TOTAL_SPEED - $this->straightSpeed;
    }

    /**
     * Moves the Car by adding the movement of the track it is currently on to it's totalTravelled
     * @param str $type The type of TrackSection
     * @param int $elementNum (optional) The element number we are currently on
     * @param int $maxLength (optional) Provides the option to change the length of Track being used
     */
    public function moveCar($type, $elementNum = 0, $maxLength = SETTINGS::TRACK_SECTION_LENGTH) {
        switch ($type) {
            case 'straight':
                $this->totalTravelled += $this->straightSpeed;
                break;
            case 'curve':
                $this->totalTravelled += $this->curveSpeed;
                break;
            // this one is to move the car the remainder of the elements in a TrackSection
            default:
                $this->totalTravelled += ($maxLength - $elementNum + 1);
                break;
        }
    }

    /**
     * Gets the movement value for a Car based on the Track type.
     * @param str $type The Track type.
     */
    public function getMovement($type): string {
        return ($type === 'straight') ? $this->straightSpeed : $this->curveSpeed;
    }


}