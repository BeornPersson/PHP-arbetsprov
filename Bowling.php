<?php 

class Player { 
    protected $_name;
    public $totalScore = 0;
    protected $_frame = array(array());
	protected $_frameScore = array();
	
	public function __construct($value) {
	    $this->_name= $value;
	}
	
/* 	public function setName($value) {
        $this->_name = $value; 
    }

    public function getName() {
	    return $this->_name;
    } */

    public function addToTable() {
        echo sprintf('<tr><td>%s</td></tr>', $this->_name);
    }

    public function playBowling() {
        for($i = 0; $i < 10; $i++) {
        // play the 10 frames
            $this->rollFrame($i);
        }
        // calculate the score
        $this->calculateScore();
    }
		
    public function rollFrame($nrFrame) {
        
        // do a barrel-roll! I mean roll the bowling ball
        // at a fresh stack of pins
        $firstRoll = $this->bowlBall(10);
        
        if($firstRoll === 10) {
            //a STRIKE!           
            if($nrFrame === 9) {
                // if we are in the last frame then we roll two more balls
                $this->_frame[$nrFrame][0] = 'X';
                $firstBonus = $this->bowlBall(10);
                $secondBonus = $this->bowlBall(10);
                
                if($firstBonus === 10) {
                    $this->_frame[$nrFrame][1] = 'X';
                }
                else {
                    $this->_frame[$nrFrame][1] = $firstBonus;
                }
                if($secondBonus === 10) {
                    $this->_frame[$nrFrame][2] = 'X';
                }
                else {
                    $this->_frame[$nrFrame][2] = $secondBonus;
                }
            }
            else {
            // any other frame
            $this->_frame[$nrFrame][0] = 'X';
            $this->_frame[$nrFrame][1] = '';
            return;
            }
        }
        else {
            // no strike so we go about another roll
            // add pins knocked down to score
            $this->_frame[$nrFrame][0] = $firstRoll;

            //roll again with nr of pins remaining as highest possible result
            $secondRoll = $this->bowlBall(10-$firstRoll);
            
            if($secondRoll === 10-$firstRoll) {
                if($nrFrame === 9) {
                    // no spares allowed in last frame
                    $this->_frame[$nrFrame][1] = $secondRoll;
                    $this->_frame[$nrFrame][2] = '';
                }
                else {
                // a spare, not too shabby
                $this->_frame[$nrFrame][1] = '/';
                }
            }
            else {
                // add how many pins got hurt in second roll
                $this->_frame[$nrFrame][1] = $secondRoll;
                if($nrFrame === 9) {
                    $this->_frame[$nrFrame][2] = '';
                }
            }
		}
    }
	
    protected function bowlBall($pinsLeft) {
        $pinsHit = mt_rand(0,$pinsLeft);
        return $pinsHit;
    }
    
    public function calculateScore() {
        
        for($i = 0;$i < 10; $i++) {
            // calculate each seperate frame first
            if($i === 9) {
                // handle frame 10 first
                if($this->_frame[$i][0] === 'X' 
                && $this->_frame[$i][1] === 'X'
                && $this->_frame[$i][2] === 'X') {
                    // a strike out
                    $this->_frameScore[$i] = 30;
                }
                else if($this->_frame[$i][0] === 'X' 
                && $this->_frame[$i][1] === 'X'
                && $this->_frame[$i][2] !== 'X') {
                    // two strikes and a "normal" score
                    $this->_frameScore[$i] = 20 + (integer)$this->_frame[$i][2];
                }
                else if($this->_frame[$i][0] === 'X' 
                && $this->_frame[$i][1] !== 'X'
                && $this->_frame[$i][2] !== 'X') {
                    // only one strike in last frame
                    // still got to roll three times in total
                    $this->_frameScore[$i] = 10;
                    $this->_frameScore[$i] += (integer)$this->_frame[$i][1];
                    $this->_frameScore[$i] += (integer)$this->_frame[$i][2];
                }
                else {
                    // no strike here, just two normal rolls
                    $this->_frameScore[$i] = (integer)$this->_frame[$i][0]+(integer)$this->_frame[$i][1];
                }
            }
            else {
            // all other frames
            // special cases
            if($this->_frame[$i][0] === 'X') {
                // a strike was made
                if($this->_frame[$i+1][0] === 'X' && $this->_frame[$i+2][0] === 'X') {
                // a turkey
                $this->_frameScore[$i] = 30;
                }
                else if($this->_frame[$i+1][0] === 'X') {
                    // a double, good but no turkey
                    $this->_frameScore[$i] = 20 + (integer)$this->_frame[$i+2][0];
                }
                else {
                    // no double or turkey
                    if($this->_frame[$i+1][1] === '/') {
                        // next frame was a spar, thus points is 20 for the strike
                        $this->_frameScore[$i] = 20;
                    }
                    else {
                        // no spar, just add points
                        $this->_frameScore[$i] = 10;
                        $this->_frameScore[$i] += (integer)$this->_frame[$i+1][0];
                        $this->_frameScore[$i] += (integer)$this->_frame[$i+1][1];
                    }
                }
            }
            else if($this->_frame[$i][1] === '/') {
                // special case - spar, frame is worth 10+first ball of next frame
                if($this->_frame[$i+1][0] === 'X') {
                    // a strike was made, spar is then worth 20 points
                    $this->_frameScore[$i] = 20;
                }
                else {
                    // not expecting any special characters for strike or spar
                    // thus it should be "safe" to typecast into integer
                    $this->_frameScore[$i] = 10 + (integer)$this->_frame[$i+1][0];
                }
                    // spar handling complete
                }
            else {
                    // no strike nor spar was made
                    $this->_frameScore[$i] = (integer)$this->_frame[$i][0]+(integer)$this->_frame[$i][1];
            }
             // spacing is a bit messed up due to frame 10 handling added last
            }
        }
        // calculate the total score
        for($i = 0; $i<10; $i++) {
            $this->totalScore += (integer)$this->_frameScore[$i];
        }
    }
    
    public function printScores() {
        // new better loop of printing scores, takes less space at least, also includes the running total
        $runningScore = 0;
        $tmpString = '<tr><td rowspan="2">' . $this->_name . '</td>';
            for($i = 0; $i<10; $i++) {
                if($i === 9) {
                    $tmpString .= '<td style="width:30px; text-align:center">';
                    $tmpString .= ($this->_frame[$i][0] === 0) ? '-' : $this->_frame[$i][0]  . '</td>';
                    
                    $tmpString .= '<td style="width:30px; text-align:center">';
                    $tmpString .= ($this->_frame[$i][1] === 0) ? '-' : $this->_frame[$i][1]  . '</td>';
                    $tmpString .= '<td style="width:30px; text-align:center">';
                    $tmpString .= ($this->_frame[$i][2] === 0) ? '-' : $this->_frame[$i][2]  . '</td>';
                }
                else {
                    $tmpString .= '<td style="width:30px; text-align:center">';
                    $tmpString .= ($this->_frame[$i][0] === 0) ? '-' : $this->_frame[$i][0]  . '</td>';
                    $tmpString .= '<td style="width:30px; text-align:center">';
                    $tmpString .= ($this->_frame[$i][1] === 0) ? '-' : $this->_frame[$i][1]  . '</td>';
                }
            }
        $tmpString .= '</tr><tr>';
            for($i = 0; $i<10; $i++){
                $runningScore += $this->_frameScore[$i];
                if($i === 9) {
                    $tmpString .= '<td colspan="3" style="text-align:center"><b>Slutpo&auml;ng: ' . $runningScore . '</b></td>';
                }
                else {
                    $tmpString .=  '<td colspan="2" style="text-align:center">' . $runningScore . '</td>';
                }
            }
        $tmpString .= '</tr>';
        
        echo $tmpString;
    }
}
?> 