<?php 

class Player { 
    protected $_name;
    protected $_totalScore;
    protected $_frame = array(array());
	protected $_frameScore = array();
	
	public function __construct($value) {
	    $this->_name= $value;
	}
	
	public function setName($value) {
        $this->_name = $value; 
    }

    public function getName() {
	    return $this->_name;
    }

    public function addToTable() {
        echo sprintf('<tr><td>%s</td></tr>', $this->_name);
    }

    public function playBowling() {
        for($i = 0; $i < 10; $i++) {
        // play the 10 frames
            $this->rollFrame($i);
        }
    }
		
    public function rollFrame($nrFrame) {
        
        // do a barrel-roll, I mean roll the bowling ball at a fresh stack of pins
        $firstRoll = $this->bowlBall(10);
        
        if($firstRoll === 10) {
            //a STRIKE!
            $this->_frame[$nrFrame][0] = 'X';
            $this->_frame[$nrFrame][1] = '';
            return;
        }
        else {
            // add pins knocked down to score
            $this->_frame[$nrFrame][0] = $firstRoll;
            
            //roll again with nr of pins remaining as highest possible result
            $secondRoll = $this->bownBall(10-$firstRoll);
            
            if($secondRoll === 10-$firstRoll) {
                // a spare, not too shabby
                $this->_frame[$nrFrame][1] = '/';
                return;
            }
            else {
                // add how many pins got hurt in second roll
                $this->_frame[$nrFrame][1] = $secondRoll;
                return;
            }
		}
        
        // reduntant but fun to have
        return;
    }
	
    protected function bowlBall($pinsLeft) {
        $pinsHit = mt_rand(0,$pinsLeft);
        return $pinsHit;
    }
    
    public function printScores() {
    // old version, new one needs to print from frame array(s)
        echo sprintf('
            <tr>
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
        $this->_name,
        $this->_frameScore[0],
        $this->_frameScore[1],
        $this->_frameScore['2'],
        $this->_frameScore['3'],
        $this->_frameScore['4'],
        $this->_frameScore['5'],
        $this->_frameScore['6'],
        $this->_frameScore['7'],
        $this->_frameScore['8'],
        $this->_frameScore['9']
        );
    }
}
?> 