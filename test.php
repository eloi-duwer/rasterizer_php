<?PHP
require_once("Camera.class.php");
require_once("Matrix.class.php");
require_once("Vector.class.php");
require_once("Vertex.class.php");

	$rot = new Matrix(array('preset' => MATRIX::RX, 'angle' => 0));
	$cam = new Camera( array( 'origin' => new Vertex( array( 'x' => 0, 'y' => 0, 'z' => 200 ) ),
						  'orientation' => new Matrix( array( 'preset' => Matrix::RY, 'angle' => 0 ) ),
						  'width' => 640,
						  'height' => 480,
						  'fov' => 60,
						  'near' => 10,
						  'far' => 250) );
	$point = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0));
	$point = $cam->watchVertex($point);
	print ($point.PHP_EOL);
?>
