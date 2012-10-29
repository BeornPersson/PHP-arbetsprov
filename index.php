<!DOCTYPE html>

<?php 
    include('Bowling.php');
    session_start();

    if(!isset($_SESSION['plrArray'])) {
        $playerList=array();
        $_SESSION['plrArray'] = $playerList;
    }
    
 ?>
 
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <title>Bowling, bowling, bowling, och disco!</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Style (aka, calling Bootstrap) -->
    <link href="bootstrap.css" rel="stylesheet">

  </head>

  <body>

    <!-- Top Navigation -->
   <div class="topbar">
    <div class="fill">
        <div class="container">
            <h2>Bowling för alla!</h2>

        </div>
    </div>
</div>

    <div class="container">


      
      <!-- Example row of columns -->
        <div class="row">
            <div class="span6">
            <h3>Välkommen!</h3>
                <p>Som ett led i projektet <i>Bowling för alla!</i> har HL Design och Media&copy; beslutat att hålla en disco-bowling gala
                den 22:a december 2012. Alla inkomster kommer att gå till projektet <i>Bowling för alla!</i> vars mål är att var man(och kvinna)
                ska alla ha en chans att få fumla lite med ett bowlingklot.</p>
                <p>För er som vill öva upp er lite innan galan finns det här en möjlighet att simulera bowling, fyll i namn på spelarna
                (ett i taget) och kör sedan igång!</p>
                
                <p>
                <form action="<?php $_PHP_SELF ?>" method="post">
               
                <b>Namn:</b> <input type="text" name="name" />
                <input type="submit" name="submit" value="L&auml;gg till" class="btn" />
                
                
                </form>
                </p>
                
            </div>
        
            <!-- The second column -->
            <div class="span5" align="center">
                <h2>&nbsp;</h2>
                <p><h4>Lista av spelare:</h4></p>
                <table border="1">
                <tr>
                    <th style="width:100px">Namn</th>
                </tr>

            <?php 
                if($_POST['submit']) {
                    if($_POST[name] === '' || $_POST[name] === null) {
                    echo 'Name can not be empty or null';
                    }
                    else {
                        if(array_key_exists($_POST[name],$_SESSION['plrArray'])) {
                            echo 'A player with that name is already registered';                    
                        }
                        else {                    
                            $_POST[name] = new Player($_POST[name]);
                            array_push($_SESSION['plrArray'],$_POST[name]);
                        }
                    }
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
            <div>
                    <form action="<?php $_PHP_SELF ?>" method="post">
        <input type="submit" name="clear" value="Rensa listan" class="btn" />
        </form>
            </div>
           </div>
        </div>
      
    <div class="row">
        <div class="span12">
            <!-- Resultatet visas här -->
            <hr />
            <p>När du är färdig är det bara att starta spelet genom att trycka på denna knapp!</p>
            <form action="<?php $_PHP_SELF ?>" method="post">
                <input type="submit" name="startGame" value="Starta spelet" class="btn" />
            </form>
            
            
<?php
	if($_POST['startGame']) {
	    foreach($_SESSION['plrArray'] as $player) {
	        $player->playBowling(); 
	    }
        
        // after game is played and scores are tallied, sort the winner to the top
        
?>
	<hr />
	<table border="1">
		<tr>
            <th style="width:80px">Spelare</th>
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
            
        </div>
      
      </div>
<!-- Footer -->
      <footer>
            <hr />
        <p>&copy; Björn Persson, 2012 <small>inte egentligen</small><br />
        <small>Denna sida är gjort som ett arbetsprov av Björn Persson för företaget HL Design och Media</small></p>
      </footer>

    </div> <!-- /container -->

  </body>
</html>
