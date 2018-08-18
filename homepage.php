<div class="container">
<?php
	if (!$GLOBALS['LOGGED_IN']) {
		echo '<div class="text-danger h4">Please log in to access the applications.</div>';
	} else {

		$button_array = array(
			"New Employee Orientation" => "./neo",
			"Training Calendar Manager" => "./tc_manager",
			"Classification Matrix" => "./compensation_tools",
			"Compensation Analysis" => "./compensation_tools/?page=comp_analysis",
			"Training Catalog" => "./training_catalog",
			"NEO Certification Manager" => "./neo_cert_manager",
			"Class Specs" => "./class_specs",
			"Pay Level Manager" => "./pay_level_manager",
			"Hiring Appointment Process" => "./hiring_appointment_process",
			"SACS" => "./sacs"
		);

		// Create a button for each pair in button_array
		foreach ($button_array as $buttonText => $buttonLink){
			echo '<div class="col-md-4 bottom_buffer">';
				echo '<a class="btn btn-lg btn-style1" ' .
						'role="button" ' . 
						'href="' . $buttonLink . '" ' .
						'style="width:100%;">';
					echo $buttonText;
				echo '</a>';
			echo '</div>';
		}
	}
?>
</div>
