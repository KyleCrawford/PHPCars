<?php
include('Race.php');


// run a race and print the results
 $test = new Race;
 $results = $test->runRace();
 print_r($results->getRoundResults());
