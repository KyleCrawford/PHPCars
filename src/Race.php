<?php

require_once "./RaceResult.php";
require_once "./classes/Car.php";
require_once "./classes/Track.php";
require_once "RoundResult.php";

/**
 * Used to run a race between (default of) 5 cars.
 */
class Race
{
    /**
     * Starts the race and returns a RaceResult Object
     * @return RaceResult 
     */
    public function runRace(): RaceResult
    {
        $step = 0;              // used to keep track of what step we are on
        $winnerFound = false;   // used to keep track of if a winner is found
        // create the cars
        $carList = $this->prepareCars(Settings::DEFAULT_NUM_CARS);  // The list of car elements to race

        // create the track
        $track = new Track(Settings::TRACK_MIN_ELEMENT, Settings::TRACK_MAX_ELEMENT); 
        
        // prepare the results
        $results = new RaceResult();
        // create initial placement
        $results->addToRoundResults($this->makeResult($step, $carList));
        
        // start race
        do {
            // Loop through each car, move it. Exits when we find a winner
            foreach ($carList as $car) {
                if ($this->carMove($car, $track)) {
                    // we have a winner, 
                    $winnerFound = true;
                }
            }

            $results->addToRoundResults($this->makeResult(++$step, $carList));
        } while (!$winnerFound);

        return $results;
    }

    /**
     * Creates a list of car objects
     * @param int $numCars The number of cars to create
     * @return array The array of Car objects
     */
    private function prepareCars($numCars): array {
        $carList = [];
        for ($i = 0; $i < $numCars; $i++) {
            array_push($carList, new Car($i, ));
        }
        return $carList;
    }

    /**
     * Creates a RoundResult object with the provided values
     * If we are on the first step (0), returns an array of 1's
     * @param int $step The step value to make a result for
     * @param array $carArr An array of Car Objects
     * @return RoundResult 
     */
    private function makeResult($step, $carArr): RoundResult {

        // if we are null, we are on the first round, everyone starts in 1st.
        //is_null($carArr[0]->totalTravelled) // can use this instead of step
        if ($step === 0) {
            return new RoundResult($step, [1,1,1,1,1]);
        }
        
        $driverPosArr = $this->getDriverPositions($carArr);

        return new RoundResult($step, $driverPosArr);
    }

    /**
     * Takes an array of Car objects and returns an array with their positions
     * Index positions of returned array match with index positions of passed Car array
     * @param array $carArr An array of Car Objects
     * @return array Array of Car positions based on totalTravelled
     */
    private function getDriverPositions($carArr): array {

        $carPosArr = [];            // The array of car positions that will be returned
        $carArrClone = $carArr;     // copy of the $carArr array as we are going to sort it
        // sort the list of cars by the total travelled (first place moved to index 0)
        usort($carArrClone, function ($a, $b) {
            return $a->totalTravelled < $b->totalTravelled;
        });
    
        // as $carArr was sorted, and Car has an id, we can grab the id, and assign pos
        for ($i = 0; $i < count($carArrClone); $i++) {
            if ($i === 0) {
                // set first car to be pos 1
                $carPosArr[$carArrClone[$i]->carId] = ($i + 1);
                continue;
            }
            // if this car has travelled the same as the car 'in front'
            // set it's position to the same as the car in front
            if ($carArrClone[$i]->totalTravelled === $carArrClone[$i - 1]->totalTravelled) {
                $carPosArr[$carArrClone[$i]->carId] = $carPosArr[$carArrClone[$i - 1]->carId];
            }
            // if it hasn't, assign it the next position
            else {
                $carPosArr[$carArrClone[$i]->carId] = ($carPosArr[$carArrClone[$i - 1]->carId] + 1);
            }
        }

        // sort the array by keys as it will be out of order
        ksort($carPosArr);
        return $carPosArr;
    }

    /**
     * Moves the Car argument object along the Track argument.
     * Returns true if a car reaches the end of the Track
     * @param Car $car The Car object to move down the Track
     * @param Track $track The Track object to move the Car down
     * @return bool true if Car reaches the end of the track. Otherwise false.
     */
    private function carMove($car, $track): bool {

        $travelled = $car->totalTravelled;                                  // distance the car has travelled
        $sectionNum = intval($travelled / Settings::TRACK_SECTION_LENGTH);  // the TrackSection number that we are on
        $elementNum = $travelled % Settings::TRACK_SECTION_LENGTH;          // The element in the TrackSection we are on
        $trackType = $track->trackList[$sectionNum]->type;                  // Type of track we are on
        $movement = $car->getMovement($trackType);                          // Movement value based on trackType
        $nextTrack = '';                                                    // The type of the next track

        // if we are on the last section, check if we make it to the end.
        if ($sectionNum >= (Settings::TRACK_LENGTH - 1)) {
            if ($movement + $elementNum >= Settings::TRACK_SECTION_LENGTH) {
                // we finished, add the distance to the car, then return
                $car->moveCar($trackType);
                return true;
            } else {
                // we are not at the end, add to movement and return something
                $car->moveCar($trackType);
                return false;
            }
        }

        // We are not at the last trackSection. There is at least one more trackSection left

        // check if we are going to get to next section
        if (($movement + $elementNum) <= Settings::TRACK_SECTION_LENGTH) {
            // we are not going to hit the end, just add to it and return
            $car->moveCar($trackType);
            return false;
        } 

        // we are going to hit the next section
        $nextTrack = $track->trackList[$sectionNum + 1]->type;

        if ($nextTrack === $trackType) {
            // we can add full speed
            $car->moveCar($trackType);
            return false;
        } else {
            // can only add remaining distance, + 1 (to move us onto the next section)
            $car->moveCar('default', $elementNum);
            return false;
        }

    }

    // Ended up not needing this function as I am determining ties every round
    /**
     * Gets the array positions of the winning cars
     * @param array $carList The list of Car Objects to find the winners
     * @return array An array of index positions
     */
    private function getWinningCars($carList) {
        // get the max distance 
        $maxTravelled = max(array_column($carList, 'totalTravelled'));
        // get the indexes of who has that distance
        return array_keys((array_column($carList, 'totalTravelled')), $maxTravelled);
    }

}
