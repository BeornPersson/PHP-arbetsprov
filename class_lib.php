<?php 

class player { 

    var $name;
	var $totalScore;
	var $frames = array('1-1','1-2','2-1','2-2','3-1','3-2','4-1',
						'4-2','5-1','5-2','6-1','6-2','7-1','7-2',
						'8-1','8-2','9-1','9-2','10-1','10-2');
	
	var $frameScore = array();
	
		public function __construct($var1)
		{
		$this->name= $var1;
		}
	
		function setName($value)
		{
		$this->name = $value; 
		}

		function getName()
		{
		return $this->name;
		}
		
		function addToTable()
		{
		echo sprintf('<tr><td>%s</td></tr>', $this->name);
		}

		function playBowling()
		{
			$tmpArray = array();
			
			for($i = 0; $i < 10; $i++)
			{
				array_push($tmpArray, $this->rollFrame());
			}
			
			$this->frameScore = $tmpArray;
		}
		
		function rollFrame()
		{
		$tmpscore = $this->firstRoll();
		// secondRoll();
		
		return $tmpscore;
		}
		
		function firstRoll()
		{
		return mt_rand(0,10);
		}
		
		function secondRoll()
		{
		}

		function printScores()
		{
		echo sprintf('<tr>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		</tr>',
		$this->name,$this->frameScore[0],
		$this->frameScore[1],$this->frameScore['2'],$this->frameScore['3'],$this->frameScore['4'],$this->frameScore['5'],
		$this->frameScore['6'],$this->frameScore['7'],$this->frameScore['8'],$this->frameScore['9']);
		}
} 

?> 