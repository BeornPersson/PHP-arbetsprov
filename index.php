<!DOCTYPE html>
		
<?php 
    include('Bowling.php');
    session_start();

    if(!isset($_SESSION['plrArray'])) {
        $playerList=array();
        $_SESSION['plrArray'] = $playerList;
    }
    
    function sortScores() {
    }
    
 ?>
 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;
        charset=iso-8859-1" />
		
		<title>Spela lite Bowling!</title>
    </head>
    <body>
        <div align="center">Nuvarande spelare:
            <table border="1">
                <tr>
                    <th>Namn</th>
                </tr>

            <?php 
                if($_POST['submit']) {
                    $_SESSION['nrOfPlayers'] = new Player($_POST[name]);
                    array_push($_SESSION['plrArray'],$_SESSION['nrOfPlayers']);
                    $_SESSION['nrOfPlayers']++;
                }
	
                if($_POST['clear']) {
                    unset($_SESSION['plrArray']);
                    $playerList=array();
                    $_SESSION['plrArray'] = $playerList;
                }
	
                foreach($_SESSION['plrArray'] as $player) {
                $player->addToTable();
                }
            ?>
        </table>
    </div>
 
    <form action="<?php $_PHP_SELF ?>" method="post">
        <div> L&auml;gg till spelare:<br />
            Spelarens namn: <input type="text" name="name" /><br />
            <input type="submit" name="submit" value="L&auml;gg till" />
            <input type="submit" name="clear" value="Rensa listan" />
	    </div>
	    <br /><br />
    </form>
    
	<form action="<?php $_PHP_SELF ?>" method="post">
        <input type="submit" name="startGame" value="Starta spelet" />
    </form>

<?php
	if($_POST['startGame']) {
	    foreach($_SESSION['plrArray'] as $player) {
	        $player->playBowling(); 
	    }
        
        // after game is played and scores are tallied, sort the winner to the top
        
?>
	
	<table border="1">
		<tr>
            <th>Spelare</th>
            <th colspan="2" style="width:60px">1</th>
            <th colspan="2" style="width:60px">2</th>
            <th colspan="2" style="width:60px">3</th>
            <th colspan="2" style="width:60px">4</th>
            <th colspan="2" style="width:60px">5</th>
            <th colspan="2" style="width:60px">6</th>
            <th colspan="2" style="width:60px">7</th>
            <th colspan="2" style="width:60px">8</th>
            <th colspan="2" style="width:60px">9</th>
            <th colspan="3" style="width:90px">10</th>
        </tr>

        <?php
            foreach($_SESSION['plrArray'] as $player) {
                $player->printScores();
            }
        ?>
    </table>

    <?PHP
	}
	?>
</body>
</html>