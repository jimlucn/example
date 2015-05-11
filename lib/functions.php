<?php
function random_text($count, $rm_similar = false)
{
	$chars = array_flip(array_merge(range(0, 9), range('A', 'Z')));
	if ($rm_similar) {
		unset($char['0'],$char['1'],$char['2'],$char['5'],$char['8'],$char['B'],$char['I'],$char['O'],$char['Q'],$char['S'],$char['U'],$char['V'],$char['Z']);
	}
	for ($i = 0, $text = ''; $i < $count; $i++) { 
		$text .= array_rand($chars);
	}
	return $text;
}