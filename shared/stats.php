<?php
	/* Function Header Template */
	/******
		Function:
		Created by: Seth Kerr
		Date Created:
		Parameter(s):
		Returns:
		Description:
		Updates:
	******/
	function quartiles($val_array, $quartile)
	{
		$num_values = count($val_array);

		if ($quartile == 1){
			return round(.25 * ($num_values + 1)) - 1;
		}
		else if ($quartile == 2){

			// Even number of values
			if ($num_values % 2 == 0){
				return ($val_array[($num_values / 2) - 1] + $val_array[$num_values / 2]) / 2;
			}
			// Odd number of values
			else{
				return $val_array[($num_values + 1) / 2];
			}
		}
		else if ($quartile == 3){
			return round(.75 * ($num_values + 1)) - 1;
		}
		else{
			return false;
		}
	}

?>