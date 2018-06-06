<?php
namespace templates;
class HeaderItem {
	private $name, $link;
	public function print() {
		echo "<span onclick=\"document.location.href='" . $this->link . "'\">" . $this->name . "</span>";
	}
	function __construct(string $name, string $link) {
		$this->name = $name;
		$this->link = $link;
	}
}