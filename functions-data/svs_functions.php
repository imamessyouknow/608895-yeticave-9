<?php
function format_sum($number) {
	$form_num;
	$number = ceil($number);
	if ($number < 1000) {
		$form_num = $number;
	} else {
		$form_num = number_format($number,0,',',' ') . '₽';
	}
	return $form_num;
	}
?>