<?php
function parse_email_output($output)
{
	$max_points = 0;

	$output = '<h2><a href="#">Digital Quiz</a></h2>' . $output;

	// max points
	$max_points = 0;
	$regex = "/<div style=\"display: none;\" class=\"max-points\">(.*)<\/div>/";
	preg_match($regex, $output, $matches);
	$max_points = $matches[1];
	$_SESSION['max_points'] = $max_points;
	$output = preg_replace_callback($regex, function($matches) {	
		return '';
	}, $output);

	// others avg
	$others_avg = 0;
	$regex = "/<span class=\"others-avg\">(.*)<\/span>/";
	$output = preg_replace_callback($regex, function($matches) {
		$others_avg = abs(intval($matches[1] / $_SESSION['max_points'] * 100));
		return '<span class="others-avg">' . $others_avg . '%</span>';
	}, $output);

	// own score
	$regex = "/<p class=\"score\">(.*)<\/p>/";
	$output = preg_replace_callback($regex, function($matches) {
		return '<p class="score">' . abs(intval($matches[1] / $_SESSION['max_points'] * 100)) . '%</p>';
	}, $output);

	// chart
	$regex = "/<div id=\"chart-container\" class=\"hide-for-print\" style=\"width: 400px; height: 400px;\"><\/div>/";
	$output = preg_replace_callback($regex, function($matches) {
		return '';
	}, $output);

	// hide intro questions
	$regex = "/<h2>A. Introductory Questions<\/h2>/";
	$output = preg_replace_callback($regex, function($matches) {
		return '';
	}, $output);
	$regex = "/<h3>Not Graded <span class=\"hide-for-print\">0<\/span><\/h3>/";
	$output = preg_replace_callback($regex, function($matches) {
		return '';
	}, $output);


	// hide others
	$regex = "/<span class=\"hide-for-print\">(.*)<\/span>/";
	$output = preg_replace_callback($regex, function($matches) {
		return '';
	}, $output);

	return $output;
}