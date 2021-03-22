<!DOCTYPE HTML>
<head>
    <link type="text/css" rel="stylesheet" href="public/css/main.css">
</head>

<body>	
		
	<?php
		include_once(__DIR__ . "/../../src/common/header.php");
		include_once(__DIR__ . "/../../src/common/menu.php");
	?>

	<h1>AVATAR</h1>
	<?php
		if(isset($messages)) {
			foreach($messages as $message) {
				echo $message;
			}
		}
	?>

	<form action="#" method="POST" ENCTYPE="multipart/form-data">
		<input type="file" name="file"> <br/>
		<button type="submit">UPLOAD</button>
	
	</form>
	
	<div class="content"> 
	</div>
</body>