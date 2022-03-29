# PHPCars
 PHP Car Race


A PHP project that has cars 'race' along a random track and print out the results.

The Track consists of multiple Track Sections that each contain a number of elements. The Track section can be a straight or a curve. The cars travel down the elements until they reach the end of the course.

The Cars randomly select a speed for the straight and for the curve. The minimum speed for any section is 4. The total speed for both sections combined is 22. The speed represents how many elements the car can travel down in one round. If a car transitions on to a different type of track, the car moves onto the first element of the next type of track, regardless of how much remaining movement is left. If the next track type is the same as the current one, it can continue on at it's current speed.

There are (a default of) five cars in a race. The data returned shows the round number and the positions of the cars as an array. In this array, the index represents the car 'number' and the value is the car's position. Cars can be tied for any position if they have travelled the exact same number of elements at the end of a round. The race is considered over once one car has reached the end of the track.
