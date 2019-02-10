<?php
function escape($string) {
	return htmlentities($string); //ADD ENT_QUOTES TO BOTH LATER
}

function escapeFormatting($string) {
    // Custom markdown editor. Supports bold, italic, strikethrough and code (pre).
    $string = preg_replace('/\+([^\+]+)\+/', '<pre>$1</pre>', htmlentities($string)); // /\*(\S[^\*]+\S)\*
    $string = preg_replace('/\*([^\*]+)\*/', '<strong>$1</strong>', $string);
    $string = preg_replace('/\__([^\__]+)\__/', '<em>$1</em>', $string);
    $string = preg_replace('/\--([^\--]+)\--/', '<s>$1</s>', $string);
    
    return $string;
}