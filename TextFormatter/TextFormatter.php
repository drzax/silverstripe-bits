<?php
/**
 * Give any Text field two additional template formatting functions.
 */
class TextFormatter extends Extension { 
	
	public function NL2BR() {
		return nl2br($this->owner->value);
	}

	public function NL2P() {
		return str_replace('<p></p>', '', '<p>' . preg_replace('/(\r\n)+|(\n|\r)+/', '</p>$0<p>', $this->owner->value) . '</p>');
	}	
}