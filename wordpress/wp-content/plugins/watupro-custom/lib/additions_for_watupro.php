<?php
// Add lines 13-14 within the email_results function of the WatuPRO class, right before $output = ...
class WatuPRO {

	// class code, functions...

    function email_results($exam, $output, $grade_id = null) {

			// function code...
			
			// add these 2 lines
			require_once WATUPRO_PATH . '/lib/email_parser.php'; 
			$content = parse_email_output($output);
			// don't add anything beyond this line
			
			$output = '<html><head><title>'.__('Your results on ', 'watupro').$exam->name.'</title>';

			// function code
	}
}			