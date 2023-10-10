<?php 
/**
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */

function generateRandomStringNative(int $n=0)
{
  $al = ['a','b','c','d','e','f','g','h','i','j','k'
  , 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u',
  'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E',
  'F','G','H','I','J','K', 'L', 'M', 'N', 'O', 'P',
  'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
  '0', '2', '3', '4', '5', '6', '7', '8', '9'];

  $len = !$n ? random_int(7, 12) : $n; // Chose length randomly in 7 to 12

  $ddd = array_map(function($a) use ($al){
    $key = random_int(0, 60);
    return $al[$key];
  }, array_fill(0,$len,0));
  return implode('', $ddd);
}

