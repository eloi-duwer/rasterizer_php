<?PHP
require_once("Camera.class.php");
require_once("Matrix.class.php");
require_once("Vector.class.php");
require_once("Vertex.class.php");
require_once("Render.class.php");

	$rot = new Matrix(array('preset' => MATRIX::RY, 'angle' => M_PI));
	$cam = new Camera( array( 'origin' => new Vertex( array( 'x' => 15.0, 'y' => 15.0, 'z' => 80.0 ) ),
						  'orientation' => $rot,
						  'width' => 640,
						  'height' => 480,
						  'fov' => 60,
						  'near' => 1,
						  'far' => 100) );
	$point = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0));
	$point = $cam->watchVertex($point);
	$render = new Render (640, 480, "img.png");
	$render->renderVertex($point);
	//print ($point.PHP_EOL);
?>
