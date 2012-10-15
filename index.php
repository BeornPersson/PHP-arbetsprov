<!DOCTYPE html>
		
<?php 
include('class_lib.php');
session_start();

if(!isset($_SESSION['plrArray']))
{
$playerList=array();
$_SESSION['plrArray'] = $playerList;
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
			if($_POST['submit'])
			{
				$_POST['name'] = new player($_POST[name]);
				array_push($_SESSION['plrArray'],$_POST[name]);
			}
	
			if($_POST['clear'])
			{
				unset($_SESSION['plrArray']);
				$playerList=array();
				$_SESSION['plrArray'] = $playerList;
			}
	
			foreach($_SESSION['plrArray'] as $player)
			{
				$player->addToTable();
			}
		?>

	</table>
</div>
 
<form action="<?php $_PHP_SELF ?>" method="post">
	<div> L&auml;gg till spelare:<br />
	Spelarens namn: <input type="text" name="name" /><br />
	<input type="submit" name="submit" value="L&auml;gg till" /> <input type="submit" name="clear" value="Rensa listan" />
	</div>
	<br />
	<br />
</form>
	<form action="<?php $_PHP_SELF ?>" method="post">
	<input type="submit" name="startGame" value="Starta spelet" />
</form>

<?php
	if($_POST['startGame'])
	{
	foreach($_SESSION['plrArray'] as $player)
	{
	$player->playBowling();
	}
	?>
	
	<table border="1">
		<tr>
			<th>Spelare</th>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>6</th>
			<th>7</th>
			<th>8</th>
			<th>9</th>
			<th>10</th>
		</tr>
		
		<?php foreach($_SESSION['plrArray'] as $player)
				{
				$player->printScores();
				
				}
		
		
		?>
	</table>
	
	<?PHP
	}
	?>

</body>
</html>