<?php
	$_2048Data = array(array());
	
	function GetCellColor($CValue) {
		switch ($CValue) {
			case 0:
				return "#CCC0B2";
			case 2:
				return "#EFE5DB";
			case 4:
				return "#ECE0CA";
			case 8:
				return "#F1B078";
			case 16:
				return "#F49662";
			case 32:
				return "#F57E5E";
			case 64:
				return "#F55F3A";
			case 128:
				return "#ECCF71";
			case 256:
				return "#EDCC61";
			case 512:
				return "#EEC74E";
			case 1024:
				return "#EFC53F";
			case 2048:
				return "#EEC22E";
			case 4096:
				return "#3E3933";
			case "PENIS":
				return "#ff69b4";
		} #switchCValue
	} #funcGetCellColour
	
	function GetFontColor($CValue) {
		switch($CValue) {
			case 0:
				return "#CCC0B2";
			case 2:
			case 4:
				return "#7E7168";
			case 8:
			case 16:
			case 32:
			case 64:
			case 128:
			case 256:
			case 512:
			case 1024:
			case 2048:
			case 4096:
				return "#EDF5F7";
			case "PENIS":
				return "#FFF";
		} #switchCValue
	} #funcGetFontColor
	
	function ClearScore() {
		$scoreFile = "score.txt";
		$fh = fopen($scoreFile, 'w') or die("can't open file");
		fwrite($fh, "0");
		fclose($fh);
	}
	
	function UpdateScore($Add) {
		$scoreFile = "score.txt";
		$fhr = fopen($scoreFile, 'r') or die("can't open file");
		$currentScore = fread($fh, filesize($scoreFile));
		$newScore = strval(intval($currentScore) + $Add);
		fclose($fhr);
		$fhw = fopen($scoreFile, 'w') or die("can't open file");
		fwrite($fhw, $newScore);
		fclose($fhw);
	}
	
	function LoadFromDatabase() {
	#yes i used mysql_, shoot me. Not accepting user input anyway so it's not like it matters
	global $_2048Data;
	include 'dbcon.php';
	$query1 = "SELECT * FROM 2048Table WHERE id = '1'";
	$rs1 = mysql_query($query1);
	while($row = mysql_fetch_array($rs1)) {
		$_2048Data[0][0] = $row["Col1"];
		$_2048Data[0][1] = $row["Col2"];
		$_2048Data[0][2] = $row["Col3"];
		$_2048Data[0][3] = $row["Col4"];
	}
	$query2 = "SELECT * FROM 2048Table WHERE id = '2'";
	$rs2 = mysql_query($query2);
	while($row = mysql_fetch_array($rs2)) {
		$_2048Data[1][0] = $row["Col1"];
		$_2048Data[1][1] = $row["Col2"];
		$_2048Data[1][2] = $row["Col3"];
		$_2048Data[1][3] = $row["Col4"];
	}
	$query3 = "SELECT * FROM 2048Table WHERE id = '3'";
	$rs3 = mysql_query($query3);
	while($row = mysql_fetch_array($rs3)) {
		$_2048Data[2][0] = $row["Col1"];
		$_2048Data[2][1] = $row["Col2"];
		$_2048Data[2][2] = $row["Col3"];
		$_2048Data[2][3] = $row["Col4"];
	}
	$query4 = "SELECT * FROM 2048Table WHERE id = '4'";
	$rs4 = mysql_query($query4);
	while($row = mysql_fetch_array($rs4)) {
		$_2048Data[3][0] = $row["Col1"];
		$_2048Data[3][1] = $row["Col2"];
		$_2048Data[3][2] = $row["Col3"];
		$_2048Data[3][3] = $row["Col4"];
	}
	mysql_close();
	}
	
	function SaveToDatabase() {
	global $_2048Data;
	include 'dbcon.php';
	for ($Rw = 0; $Rw <= 3; $Rw += 1)
	{
		for ($Cl = 0; $Cl <= 3; $Cl += 1)
		{
			#echo "Updating Row:".($Rw+1)." and Col: ".($Cl+1)." with data ".$_2048Data[$Rw][$Cl].".";
			$sql = "UPDATE 2048Table SET Col".($Cl+1)."='".$_2048Data[$Rw][$Cl]."' where id='".($Rw+1)."'";
			mysql_query($sql) or die(mysql_error()); 
		}
	}
	}
	
	function ClearGrid() {
		global $_2048Data;
		for ($Rw = 0; $Rw <= 3; $Rw += 1)
		{
			for ($Cl = 0; $Cl <= 3; $Cl += 1)
			{
				$_2048Data[$Rw][$Cl] = '0';
			}
		}
		SaveToDataBase();
	}
	
	function CanMoveRight() {
		global $_2048Data;
		for ($Rw = 0; $Rw <= 3; $Rw += 1)
		{
			for ($Cl = 0; $Cl <= 3; $Cl += 1)
			{
				if ($_2048Data[$Rw][$Cl] == '0') {	                
					switch($Cl) {								
						case 0:									
							echo '';
							break;
						case 1:									
							if ($_2048Data[$Rw][0] <> '0') {
								return True;
							} 
							break;
						case 2:								
							if ($_2048Data[$Rw][1] <> '0') {
								return True;
							} elseif ($_2048Data[$Rw][0] <> '0') {
								return True;
							}
							break;
						case 3:										
							if ($_2048Data[$Rw][2] <> '0') {
								return True;
							} elseif ($_2048Data[$Rw][1] <> '0') {
								return True;
							} elseif ($_2048Data[$Rw][0] <> '0') {
								return True;
							}
							break;						
					}
				}
			}
		}
		for ($Rw = 0; $Rw <= 3; $Rw += 1)
		{
			if ($_2048Data[$Rw][0] <> '0') {
				if ($_2048Data[$Rw][0] == $_2048Data[$Rw][1]) {
					return True; 
				}
			}
			if ($_2048Data[$Rw][1] <> '0') {
				if ($_2048Data[$Rw][1] == $_2048Data[$Rw][2]) {
					return True; 
				}
			}
			if ($_2048Data[$Rw][2] <> '0') {
				if ($_2048Data[$Rw][2] == $_2048Data[$Rw][3]) {
					return True; 
				}
			}
		} 
	} #funcCanMoveRight
	
	function CanMoveLeft() {
	global $_2048Data;
	for ($Rw = 0; $Rw <= 3; $Rw += 1)
	{
		for ($Cl = 0; $Cl <= 3; $Cl += 1)
		{
			if ($_2048Data[$Rw][$Cl] == '0') {	              
				switch($Cl) {								
				case 3:									
					echo '';
					break;
				case 2:										
					if ($_2048Data[$Rw][3] <> '0') {
						return True;
					} 
					break;
				case 1:									
					if ($_2048Data[$Rw][3] <> '0') {
						return True;
					} elseif ($_2048Data[$Rw][2] <> '0') {
						return True;
					}
					break;
				case 0:										
					if ($_2048Data[$Rw][3] <> '0') {
						return True;
					} elseif ($_2048Data[$Rw][2] <> '0') {
						return True;
					} elseif ($_2048Data[$Rw][1] <> '0') {
						return True;
					}
					break;						
				}
			}
		} 
	} 
		for ($Rw = 0; $Rw <= 3; $Rw += 1)
		{
			if ($_2048Data[$Rw][0] <> '0') {
				if ($_2048Data[$Rw][0] == $_2048Data[$Rw][1]) {
					return True; 
				}
			}
			if ($_2048Data[$Rw][1] <> '0') {
				if ($_2048Data[$Rw][1] == $_2048Data[$Rw][2]) {
					return True; 
				}
			}
			if ($_2048Data[$Rw][2] <> '0') {
				if ($_2048Data[$Rw][2] == $_2048Data[$Rw][3]) {
					return True; 
				}
			}
		}
	} #funcCanMoveLeft
	
	function CanMoveDown() {
	global $_2048Data;
	for ($Rw = 0; $Rw <= 3; $Rw += 1)
	{
		for ($Cl = 0; $Cl <= 3; $Cl += 1)
		{
			if ($_2048Data[$Rw][$Cl] == '0') {	                
				switch($Rw) {									
					case 0:									
						echo '';
						break;
					case 1:										
						if ($_2048Data[0][$Cl] <> '0') {
							return True;
						} 
						break;
					case 2:										
						if ($_2048Data[0][$Cl] <> '0') {
							return True;
						} elseif ($_2048Data[1][$Cl] <> '0') {
							return True;
						}
						break;
					case 3:									
						if ($_2048Data[0][$Cl] <> '0') {
							return True;
						} elseif ($_2048Data[1][$Cl] <> '0') {
							return True;
						} elseif ($_2048Data[2][$Cl] <> '0') {
							return True;
						}
						break;						
				} 
				} 
			} 
		} 
		for ($Cl = 0; $Cl <= 3; $Cl += 1)
		{
			if ($_2048Data[0][$Cl] <> '0') {
				if ($_2048Data[0][$Cl] == $_2048Data[1][$Cl]) {
					return True; 
				}
			}
			if ($_2048Data[1][$Cl] <> '0') {
				if ($_2048Data[1][$Cl] == $_2048Data[2][$Cl]) {
					return True; 
				}
			}
			if ($_2048Data[2][$Cl] <> '0') {
				if ($_2048Data[2][$Cl] == $_2048Data[3][$Cl]) {
					return True; 
				}
			}
		}
	}
	
	function CanMoveUp() {
	global $_2048Data;
	for ($Rw = 0; $Rw <= 3; $Rw += 1)
	{
		for ($Cl = 0; $Cl <= 3; $Cl += 1)
		{
			if ($_2048Data[$Rw][$Cl] == '0') {	               
				switch($Rw) {									
					case 3:										
						echo '';
						break;
					case 2:										
						if ($_2048Data[3][$Cl] <> '0') {
							return True;
						} 
						break;
					case 1:										
						if ($_2048Data[3][$Cl] <> '0') {
							return True;
						} elseif ($_2048Data[2][$Cl] <> '0') {
							return True;
						}
						break;
					case 0:										
						if ($_2048Data[3][$Cl] <> '0') {
							return True;
						} elseif ($_2048Data[2][$Cl] <> '0') {
							return True;
						} elseif ($_2048Data[1][$Cl] <> '0') {
							return True;
						}
						break;						
				} 
				} 
			} 
		} 
		for ($Cl = 0; $Cl <= 3; $Cl += 1)
		{
			if ($_2048Data[0][$Cl] <> '0') {
				if ($_2048Data[0][$Cl] == $_2048Data[1][$Cl]) {
					return True; 
				}
			}
			if ($_2048Data[1][$Cl] <> '0') {
				if ($_2048Data[1][$Cl] == $_2048Data[2][$Cl]) {
					return True; 
				}
			}
			if ($_2048Data[2][$Cl] <> '0') {
				if ($_2048Data[2][$Cl] == $_2048Data[3][$Cl]) {
					return True; 
				}
			}
		}
	}
	
	function MoveLeft() {
		function CombinePairLeft($Rw,$Cl) {
			global $_2048Data;
			if ($_2048Data[$Rw][0] == $_2048Data[$Rw][1]) {
				$_2048Data[$Rw][0] = strval(2*intval($_2048Data[$Rw][0]));
				$_2048Data[$Rw][1] = '0';
			}
			if ($_2048Data[$Rw][1] == $_2048Data[$Rw][2]) {
				$_2048Data[$Rw][1] = strval(2*intval($_2048Data[$Rw][1]));
				$_2048Data[$Rw][2] = '0';
			}
			if ($_2048Data[$Rw][2] == $_2048Data[$Rw][3]) {
				$_2048Data[$Rw][2] = strval(2*intval($_2048Data[$Rw][2]));
				$_2048Data[$Rw][3] = '0';
			}
		}
	global $_2048Data;
	for ($Rw = 0; $Rw <= 3; $Rw += 1)
		{
			for ($Cl = 0; $Cl <= 3; $Cl += 1)
			{
				CombinePairLeft($Rw,$Cl);
				#echo strval(2*intval($_2048Data[$Rw][0]));
				#check for any pairs and combine them
				if ($_2048Data[$Rw][0] <> '0') {
					if ($_2048Data[$Rw][1] <> '0') {
						if ($_2048Data[$Rw][2] <> '0') {
							if ($_2048Data[$Rw][3] <> '0') {
								#CombinePairLeft($Rw,$Cl);
							}
						} elseif ($_2048Data[$Rw][2] == '0') {
							$_2048Data[$Rw][2] = $_2048Data[$Rw][3];
							$_2048Data[$Rw][3] = '0';
							#CombinePairLeft($Rw,$Cl);
						}
					} elseif ($_2048Data[$Rw][1] == '0') {
						$_2048Data[$Rw][1] = $_2048Data[$Rw][2];
						$_2048Data[$Rw][2] = $_2048Data[$Rw][3];
						$_2048Data[$Rw][3] = '0';
						#CombinePairLeft($Rw,$Cl);
					}
				} elseif ($_2048Data[$Rw][0] == '0') {
					$_2048Data[$Rw][0] = $_2048Data[$Rw][1];
					$_2048Data[$Rw][1] = $_2048Data[$Rw][2];
					$_2048Data[$Rw][2] = $_2048Data[$Rw][3];
					$_2048Data[$Rw][3] = '0';
					#CombinePairLeft($Rw,$Cl);
				}
			} #forCl
		} #forRw
	} #funcMoveLeft
	
	function MoveRight() {
		function CombinePairRight($Rw,$Cl) {
			global $_2048Data;
			if ($_2048Data[$Rw][3] == $_2048Data[$Rw][2]) {
				$_2048Data[$Rw][3] = strval(2*intval($_2048Data[$Rw][3]));
				$_2048Data[$Rw][2] = '0';
			}
			if ($_2048Data[$Rw][2] == $_2048Data[$Rw][1]) {
				$_2048Data[$Rw][2] = strval(2*intval($_2048Data[$Rw][2]));
				$_2048Data[$Rw][1] = '0';
			}
			if ($_2048Data[$Rw][1] == $_2048Data[$Rw][0]) {
				$_2048Data[$Rw][1] = strval(2*intval($_2048Data[$Rw][1]));
				$_2048Data[$Rw][0] = '0';
			}
		}
	global $_2048Data;
	for ($Rw = 0; $Rw <= 3; $Rw += 1)
		{
			for ($Cl = 0; $Cl <= 3; $Cl += 1)
			{
				CombinePairRight($Rw,$Cl);
				#echo strval(2*intval($_2048Data[$Rw][0]));
				#check for any pairs and combine them
				if ($_2048Data[$Rw][3] <> '0') {
					if ($_2048Data[$Rw][2] <> '0') {
						if ($_2048Data[$Rw][1] <> '0') {
							if ($_2048Data[$Rw][0] <> '0') {
								#CombinePairRight($Rw,$Cl);
							}
						} elseif ($_2048Data[$Rw][1] == '0') {
							$_2048Data[$Rw][1] = $_2048Data[$Rw][0];
							$_2048Data[$Rw][0] = '0';
							#CombinePairRight($Rw,$Cl);
						}
					} elseif ($_2048Data[$Rw][2] == '0') {
						$_2048Data[$Rw][2] = $_2048Data[$Rw][1];
						$_2048Data[$Rw][1] = $_2048Data[$Rw][0];
						$_2048Data[$Rw][0] = '0';
						#CombinePairRight($Rw,$Cl);
					}
				} elseif ($_2048Data[$Rw][3] == '0') {
					$_2048Data[$Rw][3] = $_2048Data[$Rw][2];
					$_2048Data[$Rw][2] = $_2048Data[$Rw][1];
					$_2048Data[$Rw][1] = $_2048Data[$Rw][0];
					$_2048Data[$Rw][0] = '0';
					#CombinePairRight($Rw,$Cl);
				}
			} #forCl
		} #forRw
	}

	function MoveUp() {
		function CombinePairUp ($Rw,$Cl) {
			global $_2048Data;
			if ($_2048Data[0][$Cl] == $_2048Data[1][$Cl]) {
				$_2048Data[0][$Cl] = strval(2*intval($_2048Data[0][$Cl]));
				$_2048Data[1][$Cl] = '0';
			}
			if ($_2048Data[1][$Cl] == $_2048Data[2][$Cl]) {
				$_2048Data[1][$Cl] = strval(2*intval($_2048Data[1][$Cl]));
				$_2048Data[2][$Cl] = '0';
			}
			if ($_2048Data[2][$Cl] == $_2048Data[3][$Cl]) {
				$_2048Data[2][$Cl] = strval(2*intval($_2048Data[2][$Cl]));
				$_2048Data[3][$Cl] = '0';
			}
		}
	global $_2048Data;
	for ($Rw = 0; $Rw <= 3; $Rw += 1)
		{
			for ($Cl = 0; $Cl <= 3; $Cl += 1)
			{
				CombinePairUp($Rw,$Cl);
				#echo strval(2*intval($_2048Data[$Rw][0]));
				#check for any pairs and combine them
				if ($_2048Data[0][$Cl] <> '0') {
					if ($_2048Data[1][$Cl] <> '0') {
						if ($_2048Data[2][$Cl] <> '0') {
							if ($_2048Data[3][$Cl] <> '0') {
								#CombinePairUp($Rw,$Cl);
							}
						} elseif ($_2048Data[2][$Cl] == '0') {
							$_2048Data[2][$Cl] = $_2048Data[3][$Cl];
							$_2048Data[3][$Cl] = '0';
							#CombinePairUp($Rw,$Cl);
						}
					} elseif ($_2048Data[1][$Cl] == '0') {
						$_2048Data[1][$Cl] = $_2048Data[2][$Cl];
						$_2048Data[2][$Cl] = $_2048Data[3][$Cl];
						$_2048Data[3][$Cl] = '0';
						#CombinePairUp($Rw,$Cl);
					}
				} elseif ($_2048Data[0][$Cl] == '0') {
					$_2048Data[0][$Cl] = $_2048Data[1][$Cl];
					$_2048Data[1][$Cl] = $_2048Data[2][$Cl];
					$_2048Data[2][$Cl] = $_2048Data[3][$Cl];
					$_2048Data[3][$Cl] = '0';
					#CombinePairUp($Rw,$Cl);
				}
			} #forCl
		} #forRw
	}
	
	function MoveDown() {
		function CombinePairDown ($Rw,$Cl) {
			global $_2048Data;
			if ($_2048Data[3][$Cl] == $_2048Data[2][$Cl]) {
				$_2048Data[3][$Cl] = strval(2*intval($_2048Data[3][$Cl]));
				$_2048Data[2][$Cl] = '0';
			}
			if ($_2048Data[2][$Cl] == $_2048Data[1][$Cl]) {
				$_2048Data[2][$Cl] = strval(2*intval($_2048Data[2][$Cl]));
				$_2048Data[1][$Cl] = '0';
			}
			if ($_2048Data[1][$Cl] == $_2048Data[0][$Cl]) {
				$_2048Data[1][$Cl] = strval(2*intval($_2048Data[1][$Cl]));
				$_2048Data[0][$Cl] = '0';
			}
		}
	global $_2048Data;
	for ($Rw = 0; $Rw <= 3; $Rw += 1)
		{
			for ($Cl = 0; $Cl <= 3; $Cl += 1)
			{
				CombinePairDown($Rw,$Cl);
				#echo strval(2*intval($_2048Data[$Rw][0]));
				#check for any pairs and combine them
				if ($_2048Data[3][$Cl] <> '0') {
					if ($_2048Data[2][$Cl] <> '0') {
						if ($_2048Data[1][$Cl] <> '0') {
							if ($_2048Data[0][$Cl] <> '0') {
								#CombinePairDown($Rw,$Cl);
							}
						} elseif ($_2048Data[1][$Cl] == '0') {
							$_2048Data[1][$Cl] = $_2048Data[0][$Cl];
							$_2048Data[0][$Cl] = '0';
							#CombinePairDown($Rw,$Cl);
						}
					} elseif ($_2048Data[2][$Cl] == '0') {
						$_2048Data[2][$Cl] = $_2048Data[1][$Cl];
						$_2048Data[1][$Cl] = $_2048Data[0][$Cl];
						$_2048Data[0][$Cl] = '0';
						#CombinePairDown($Rw,$Cl);
					}
				} elseif ($_2048Data[3][$Cl] == '0') {
					$_2048Data[3][$Cl] = $_2048Data[2][$Cl];
					$_2048Data[2][$Cl] = $_2048Data[1][$Cl];
					$_2048Data[1][$Cl] = $_2048Data[0][$Cl];
					$_2048Data[0][$Cl] = '0';
					#CombinePairDown($Rw,$Cl);
				}
			} #forCl
		} #forRw
	}
	
	function IsGameOver() {
		if (!CanMoveRight()) {
			if (!CanMoveLeft()) {
				if (!CanMoveUp()) {
					if (!CanMoveDown()) {
						return True;
					}
				}
			}
		}
	}
	
	function AddNewBlock() {
		global $_2048Data;
		$addedBlock = false;
		do {
			$Row = mt_rand(0,3);
			$Col = mt_rand(0,3);
			if ($_2048Data[$Row][$Col] == '0') {
				$_2048Data[$Row][$Col] = '2';
				$addedBlock = true;
			}
		} while (!$addedBlock);
	}
	?>