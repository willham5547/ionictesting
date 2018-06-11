<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php 
	$name = $_GET["name"];
	$search = " " ;
	$name1 = str_replace($search, "%20", $name);
	?>
	<title><?php echo "The Wash at " . $name; ?></title>
	
</head>
<body>
	<div id="show"></div>
	<?php 
	$id = $_GET["id"];
	?>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			setInterval(function () {
				$('#show').load('device_info.php?id=<?php echo json_encode($id); ?>&name=<?php echo json_encode($name1); ?>')
			}, 1000);
		});
	</script>
</body>
</html>
