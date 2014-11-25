<?	
	include 'functions.php';
	
	LoadFromDatabase();
	
	if (isset($_POST['reset'])) {
		if (IsGameOver()) {
			ClearGrid();
			AddNewBlock();
			SaveToDataBase();
		}
	}
	
	if (isset($_POST['gameMove'])) {
		$nextMove = $_POST['gameMove'];
		switch ($nextMove) {
			case 'up': if (CanMoveUp()) {
							MoveUp();
							SaveToDataBase();
						}
						break;
			case 'down': if (CanMoveDown()) {
							MoveDown();
							SaveToDataBase();
						}
						break;
			case 'left': if (CanMoveLeft()) {
							MoveLeft();
							SaveToDataBase();
						}
						break;
			case 'right': if (CanMoveRight()) {
							MoveRight();
							SaveToDataBase();
						}
						break;
		} #switchNextMove
		AddNewBlock();
		SaveToDataBase();
	} #ifIsset
	header( 'Location: http://thejamespaterson.com/scripts/2048/index.php' )
?>