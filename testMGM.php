<?php 
	function unniqueNumbers($array)
	{
		for ($i=0; $i < count($array) - 1; $i++) { 
			for ($j=$i+1; $j < count($array); $j++) { 
				if ($array[$i] == $array[$j]) {
					unset($array[$i]);
					break;
				}
			}
			$i--;
		}
		return $array;
	}
	$array = [1,1,2,1,3,3];
	print_r(unniqueNumbers($array));
 ?>