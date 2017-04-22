<?PHP

class Color {
	
	static $verbose = false;
	public $red = 255;
	public $green = 255;
	public $blue = 255;
	
	
	public function __construct(array $kwargs) {
		if (array_key_exists("rgb", $kwargs)) {
			$color = $kwargs['rgb'];
			$this->blue = (int)$color % 256;
			$color -= $this->blue;
			$color /= 256;
			$this->green = (int)$color % 256;
			$color -= $this->green;
			$color /= 256;
			$this->red = (int)$color;
		}
		else {
			$this->red = (int)$kwargs['red'];
			$this->green = (int)$kwargs['green'];
			$this->blue = (int)$kwargs['blue'];
		}
		if (self::$verbose == true)
			print ("Color( red:".$this->red.", green: ".$this->green." blue:".$this->blue.") constructed." . PHP_EOL);
	}
	public function __destruct() {
			if (self::$verbose == true)
				print ("Color( red:".$this->red.", green: ".$this->green." blue:".$this->blue.") destructed." . PHP_EOL);
	}
	
	public function __toString() {
		return ("Color( red:".$this->red.", green: ".$this->green." blue:".$this->blue." )");
	}
	
	public function doc() {
		print (file_get_contents("Color.doc.txt"));
	}
	
	public function add( Color $color) {
		$new_red = $this->red + $color->red;
		$new_green = $this->green + $color->green;
		$new_blue = $this->blue + $color->blue;
		return (new Color(array('red' => $new_red, 'green' => $new_green, 'blue' => $new_blue)));
	}
	
	public function sub( Color $color) {
		$new_red = $this->red - $color->red;
		$new_green = $this->green - $color->green;
		$new_blue = $this->blue - $color->blue;
		return (new Color(array('red' => $new_red, 'green' => $new_green, 'blue' => $new_blue)));
	}
	
	public function mult( $factor) {
		$new_red = $this->red * $factor;
		$new_green = $this->green * $factor;
		$new_blue = $this->blue * $factor;
		return (new Color(array('red' => $new_red, 'green' => $new_green, 'blue' => $new_blue)));
	}
	
	
}

?>
