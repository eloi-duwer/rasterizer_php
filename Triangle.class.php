<?PHP

class Triangle {

	static $verbose = false;
	private $_A;
	private $_B;
	private $_C;

	public function __construct ($A, $B, $C) {
		$this->_A = $A;
		$this->_B = $B;
		$this->_C = $C;
		if (self::$verbose == true)
			print ("Class Triangle constructed".PHP_EOL);
	}

	public function __destruct () {
	if (self::$verbose == true)
		print ("Class Triangle destructed".PHP_EOL);
	}

	public function __toString () {
		return ("Point A: ".$this->_A.PHP_EOL."Point B: ".$this->_B.PHP_EOL."Point C: ".$this->_C.PHP_EOL);
	}

	public function getA() {
		return $this->_A;
	}

	public function getB() {
		return $this->_B;
		}

	public function getC() {
		return $this->_C;
	}

}

?>
