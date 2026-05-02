<?php
function ruby(string $text, string $ruby) {
	return "<RUBY>".$text."<RP>(</RP><RT>".$ruby."</RT><RP>)</RP></RUBY>";
}