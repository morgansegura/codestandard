<?php

// Print Preview
function print_pre($array_data)
{
	return print("<pre>" . print_r($array_data, true) . "</pre>");
}