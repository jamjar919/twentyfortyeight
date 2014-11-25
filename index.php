<?php
	header("refresh: 3;");
	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">";	
	
	include 'functions.php';
	
	LoadFromDatabase();
	
	$C11Value = $_2048Data[0][0];
	$C12Value = $_2048Data[0][1];
	$C13Value = $_2048Data[0][2];
	$C14Value = $_2048Data[0][3];
	$C21Value = $_2048Data[1][0];
	$C22Value = $_2048Data[1][1];
	$C23Value = $_2048Data[1][2];
	$C24Value = $_2048Data[1][3];
	$C31Value = $_2048Data[2][0];
	$C32Value = $_2048Data[2][1];
	$C33Value = $_2048Data[2][2];
	$C34Value = $_2048Data[2][3];
	$C41Value = $_2048Data[3][0];
	$C42Value = $_2048Data[3][1];
	$C43Value = $_2048Data[3][2];
	$C44Value = $_2048Data[3][3];
	
	if (IsGameOver()) { 
		echo "Game Over! Try sucking less next time";
		echo "<form action=\"move.php\" method=\"POST\">
				<input id=\"resetGame\" type=\"submit\" value=\"Reset Board\" />
				<input type=\"hidden\" name=\"reset\" value=\"1\">
			</form>";
	}
	
	?>
	
	
<html>
<head>
	<title>2048 Multiplayer</title>
	<style>
		/*I'm including style information here because f*ck accessibility, that's why.*/
		body {
			background-color: #faf8ef;
		}	
		table#gameTable {
			margin: 5em auto;
			background-color: #bbada0;
			padding: 0.5em;
			border-radius: 0.5em;
			font-family: "Clear Sans", "Helvetica Neue", Arial, sans-serif;
			font-weight: 800;
			font-size: 20px;
		}
		table#gameTable td div{
			width: 4em;
			height: 4em;
			margin: 0.25em;
			text-align: center;
			line-height: 4em;
			border-radius: 0.1em;
		}
		#gameControlsUp, #gameControlsDown {
			margin: 0.5em auto;
			width: 3em;
		}
		#gameControlsUp input, #gameControlsDown input {
			width: 3em;
			height: 3em;
		}
		#gameControlsSide {
			margin: 0 auto;
			width: 9.25em;
		}
		#gameControlsSide input {
			width: 3em;
			height: 3em;
			margin-left: 0.25em;
		}
		#gameControls form {
			display: inline;
		}
	
		#_11 { background-color:<?php echo GetCellColor($C11Value); ?>; color:<?php echo GetFontColor($C11Value);?>;}
		#_12 { background-color:<?php echo GetCellColor($C12Value); ?>; color:<?php echo GetFontColor($C12Value);?>;}
		#_13 { background-color:<?php echo GetCellColor($C13Value); ?>; color:<?php echo GetFontColor($C13Value);?>;}
		#_14 { background-color:<?php echo GetCellColor($C14Value); ?>; color:<?php echo GetFontColor($C14Value);?>;}
		#_21 { background-color:<?php echo GetCellColor($C21Value); ?>; color:<?php echo GetFontColor($C21Value);?>;}
		#_22 { background-color:<?php echo GetCellColor($C22Value); ?>; color:<?php echo GetFontColor($C22Value);?>;}
		#_23 { background-color:<?php echo GetCellColor($C23Value); ?>; color:<?php echo GetFontColor($C23Value);?>;}
		#_24 { background-color:<?php echo GetCellColor($C24Value); ?>; color:<?php echo GetFontColor($C24Value);?>;}
		#_31 { background-color:<?php echo GetCellColor($C31Value); ?>; color:<?php echo GetFontColor($C31Value);?>;}
		#_32 { background-color:<?php echo GetCellColor($C32Value); ?>; color:<?php echo GetFontColor($C32Value);?>;}
		#_33 { background-color:<?php echo GetCellColor($C33Value); ?>; color:<?php echo GetFontColor($C33Value);?>;}
		#_34 { background-color:<?php echo GetCellColor($C34Value); ?>; color:<?php echo GetFontColor($C34Value);?>;}
		#_41 { background-color:<?php echo GetCellColor($C41Value); ?>; color:<?php echo GetFontColor($C41Value);?>;}
		#_42 { background-color:<?php echo GetCellColor($C42Value); ?>; color:<?php echo GetFontColor($C42Value);?>;}
		#_43 { background-color:<?php echo GetCellColor($C43Value); ?>; color:<?php echo GetFontColor($C43Value);?>;}
		#_44 { background-color:<?php echo GetCellColor($C44Value); ?>; color:<?php echo GetFontColor($C44Value);?>;}
	</style>
</head>
<body>
	<table id="gameTable">
		<tr>
			<td><div id="_11"><?php echo $C11Value;?></div></td>
			<td><div id="_12"><?php echo $C12Value;?></div></td>
			<td><div id="_13"><?php echo $C13Value;?></div></td>
			<td><div id="_14"><?php echo $C14Value;?></div></td>
		</tr>
		<tr>
			<td><div id="_21"><?php echo $C21Value;?></div></td>
			<td><div id="_22"><?php echo $C22Value;?></div></td>
			<td><div id="_23"><?php echo $C23Value;?></div></td>
			<td><div id="_24"><?php echo $C24Value;?></div></td>
		</tr>
		<tr>
			<td><div id="_31"><?php echo $C31Value;?></div></td>
			<td><div id="_32"><?php echo $C32Value;?></div></td>
			<td><div id="_33"><?php echo $C33Value;?></div></td>
			<td><div id="_34"><?php echo $C34Value;?></div></td>
		</tr>
		<tr>
			<td><div id="_41"><?php echo $C41Value;?></div></td>
			<td><div id="_42"><?php echo $C42Value;?></div></td>
			<td><div id="_43"><?php echo $C43Value;?></div></td>
			<td><div id="_44"><?php echo $C44Value;?></div></td>
		</tr>
	</table>
	<div id="gameControls">
		<div id="gameControlsUp">
			<form action="move.php" method="POST">
				<input id="gameControlsButtonUp" type="submit" <?php if (!CanMoveUp()) { echo"disabled=\"disabled\" value=\"-\" ";} else { echo "value=\"&uarr;\""; }?> />
				<input type="hidden" name="gameMove" value="up">
			</form>
		</div>
		<div id="gameControlsSide">	
			<form action="move.php" method="POST">
				<input id="gameControlsButtonLeft" type="submit" <?php if (!CanMoveLeft()) { echo"disabled=\"disabled\" value=\"-\" ";} else { echo "value=\"&larr;\""; }?> />
				<input type="hidden" name="gameMove" value="left">
			</form>
			<input id="gameControlsButtonRefresh" type="button" value="R" onClick="window.location.reload()" />
			<form action="move.php" method="POST">
				<input id="gameControlsButtonRight" type="submit" <?php if (!CanMoveRight()) { echo"disabled=\"disabled\" value=\"-\" ";} else { echo "value=\"&rarr;\""; }?>  />
				<input type="hidden" name="gameMove" value="right">
			</form>
		</div>
		<div id="gameControlsDown">
			<form action="move.php" method="POST">
				<input id="gameControlsButtonDown" type="submit" <?php if (!CanMoveDown()) { echo"disabled=\"disabled\" value=\"-\" ";} else { echo "value=\"&darr;\""; }?> />	
				<input type="hidden" name="gameMove" value="down">
			</form>
		</div>
	</div>
</body>
</html>