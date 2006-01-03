<?php
require (EGS_FILE_ROOT.'/src/fpdf/fpdf.php');

class PDF extends FPDF {

	function SetWidths($w) {
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a) {
		//Set the array of column alignments
		$this->aligns = $a;
	}

	function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border		
		if(!$this->header && !$this->footer) {
			if($i == 1) {
				$this->SetFillColor(204, 204, 204);
				$this->Rect($x, $y+0.3, $w, $h, 'F');
			}
			$this->SetTextColor(102, 102, 102);
			$this->SetFont('Arial', '', 11);
		} else {
			$this->SetFillColor(102, 102, 102);
			$this->Rect($x, $y, $w, $h, 'F');
			$this->SetTextColor(255, 255, 255);
			$this->SetFont('Arial', 'B', 11);
			$this->Line($x,$y,$x+$w,$y);
			$this->Line($x,$y+$h,$x+$w,$y+$h);
		}
		
		if($i == 0) $this->Line($x,$y,$x,$y+$h);
        if($i == (count($data)-1)) $this->Line($x+$w,$y,$x+$w,$y+$h);
		
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a, 0);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

	function CheckPageBreak($h) {
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger) {
			$x=$this->GetX();
        	$y=$this->GetY();
        	$this->Line($x,$y,$x+185,$y);
			$this->AddPage($this->CurOrientation);
			$x=$this->GetX();
        	$y=$this->GetY();
        	$this->Line($x,$y,$x+185,$y);
		}
		
		return false;
	}

	function NbLines($w, $txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw = & $this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w -2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb -1] == "\n")
			$nb --;
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i ++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl ++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
						$i ++;
				} else
					$i = $sep +1;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl ++;
			} else
				$i ++;
		}
		return $nl;
	}
}
