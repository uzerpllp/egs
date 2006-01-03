<?php
// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Save Account Access 1.0          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2005 Jake Stride                                  |
// +----------------------------------------------------------------------+
// | This file is part of EGS.                                            |
// |                                                                      |
// | EGS is free software; you can redistribute it and/or modify it under |
// | the terms of the GNU General Public License as published by the Free |
// | Software Foundation; either version 2 of the License, or (at your    |
// | option) any later version.                                           |
// |                                                                      |
// | EGS is distributed in the hope that it will be useful, but WITHOUT   |
// | ANY WARRANTY; without even the implied warranty of MERCHANTABILITY   |
// | or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public     |
// | License for more details.                                            |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with EGS; if not, write to the Free Software Foundation, Inc., |
// | 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA               |
// +----------------------------------------------------------------------+
// | Author: Jake Stride <jake.stride@senokian.com>                       |
// +----------------------------------------------------------------------+
// | 1.0                                                                  |
// | ===                                                                  |
// | First Stable Release                                                 |
// +----------------------------------------------------------------------+
////////////////////////////////////////////////////////////
function hex2dec($couleur = "#000000") {
	$R = substr($couleur, 1, 2);
	$rouge = hexdec($R);
	$V = substr($couleur, 3, 2);
	$vert = hexdec($V);
	$B = substr($couleur, 5, 2);
	$bleu = hexdec($B);
	$tbl_couleur = array ();
	$tbl_couleur['R'] = $rouge;
	$tbl_couleur['G'] = $vert;
	$tbl_couleur['B'] = $bleu;
	return $tbl_couleur;
}

//conversion pixel -> millimeter in 72 dpi
function px2mm($px) {
	return $px * 25.4 / 72;
}

function txtentities($html) {
	$trans = get_html_translation_table(HTML_ENTITIES);
	$trans = array_flip($trans);
	return strtr($html, $trans);
}

require_once EGS_FILE_ROOT.'/src/fpdf/fpdf.php';
class PDF extends FPDF {
	//Page header
	function addHeader() {
		//if($this->PageNo() == 1) {
		//Logo
		$this->Image(EGS_FILE_ROOT.'/modules/contacts/logo.jpg', 166, 8, 33);
		//Helvetica bold 15
		$this->SetTextColor(0, 0, 0);
		//Move to the right
		//Title
		$this->SetFont('Helvetica', 'B', 10);
		$this->Ln(20);
		$this->Cell(166, 0, 'Business Innovation Centre, Binley Business Park', 0, 1, 'R');
		$this->Ln(4);
		$this->Cell(166, 0, '', 0, 1, 'L');
		$this->Cell(166, 0, 'Harry Weston Road, Coventry CV3 2TX', 0, 1, 'R');
		$this->Ln(8);
		$this->SetFont('Helvetica', 'B', 10);
		$this->SetTextColor(0, 0, 0);
		$this->Cell(166, 0, '024 76 430 131', 0, 0, 'R');
		$this->SetTextColor(102, 102, 102);
		$this->Cell(33, 0, 'Tel', 0, 1, 'L');
		$this->Ln(4);
		$this->SetFont('Helvetica', '', 10);
		$this->SetTextColor(0, 0, 0);
		$this->Cell(166, 0, '0870 460 2623', 0, 0, 'R');
		$this->SetTextColor(102, 102, 102);
		$this->Cell(33, 0, 'Fax', 0, 1, 'L');
		$this->Ln(4);
		$this->SetFont('Helvetica', 'I', 10);
		$this->SetTextColor(0, 0, 0);
		$this->Cell(166, 0, 'info@senokian.com', 0, 0, 'R');
		$this->SetFont('Helvetica', '', 10);
		$this->SetTextColor(102, 102, 102);
		$this->Cell(33, 0, 'E-mail', 0, 1, 'L');
		$this->Ln(4);
		$this->SetFont('Helvetica', 'I', 10);
		$this->SetTextColor(0, 0, 0);
		$this->Cell(166, 0, 'www.senokian.com', 0, 0, 'R');
		$this->SetFont('Helvetica', '', 10);
		$this->SetTextColor(102, 102, 102);
		$this->Cell(33, 0, 'URL', 0, 1, 'L');
		$this->Ln(4);
		//Line break
		//}
	}

	//Page footer
	function addFooter() {
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Helvetica italic 8
		$this->SetFont('Helvetica', '', 7);
		$this->SetTextColor(0, 0, 0);
		//Page number
		$this->Cell(166, 0, 'Senokian Solutions Ltd', 0, 0, 'R');
		$this->SetTextColor(102, 102, 102);
		$this->Cell(35, 0, 'Registered in England', 0, 1, 'L');
		$this->Ln(3);
		$this->SetTextColor(0, 0, 0);
		$this->Cell(166, 0, '04415783', 0, 0, 'R');
		$this->SetTextColor(102, 102, 102);
		$this->Cell(35, 0, 'Company No.', 0, 1, 'L');
		$this->Ln(3);
		$this->SetTextColor(0, 0, 0);
		$this->Cell(166, 0, 'GB 793 8163 86', 0, 0, 'R');
		$this->SetTextColor(102, 102, 102);
		$this->Cell(35, 0, 'VAT No.', 0, 1, 'L');
		$this->Ln(3);
		$this->SetTextColor(0, 0, 0);
		$this->Cell(166, 0, 'The TechnoCentre, Coventry University Technology Park, Puma Way, Coventry CV1 2TT', 0, 0, 'R');
		$this->SetTextColor(102, 102, 102);
		$this->Cell(35, 0, 'Registered Office', 0, 1, 'L');
		$this->Ln(3);
	}

	//////////////////////////////////////////////////////////

	function WriteHTML($html) {
		//if($this->GetY()>270)$this->AddPage();
		global $personname; //personname variable replaced in html
		//$tab = $this->Write(0, "   ");
		//$bullet = $this->Write(0, "-");
		$html = str_replace('<li', '<br><li', $html);
		$html = str_replace('<br/>', '<br>', $html);
		$html = strip_tags($html, "<q><b><u><i><h1><h2><a><li><ol><ul><img><p><br><strong><em><font><tr><blockquote><hr><td><tr><table><sup><span>"); //remove all unsupported tags
		$array = explode("<br>", $html);
		$html = '';
		foreach ($array as $row) {
			if ((strpos($row, '{personname}') == false)) {
				$html .= $row.'<br>';
			} else
				if ($personname != '') {
					$row = str_replace('{personname}', $personname, $row);
					$html .= $row.'<br>';
				} else
					if ((strlen($row) > 40)) {
						$row = str_replace('{personname}', '', $html);
						$html .= $row.'<br>';
					}
		}
		$html = str_replace("\n", '', $html); //replace carriage returns by spaces
		$html = str_replace("\t", '', $html); //replace carriage returns by spaces
		//$html=str_replace("{personname}",'Mr Johnson',$html);
		$a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE); //explodes the string
		foreach ($a as $i => $e) {
			if ($i % 2 == 0) {
				//Text
				//echo 'text: '.$e. "<br/>";
				if (isset ($this->HREF) && ($this->HREF))
					$this->PutLink($this->HREF, $e);
				elseif (isset ($this->tdbegin) && ($this->tdbegin)) {
					if (trim($e) != '' and $e != "&nbsp;") {
						$this->Cell($this->tdwidth, $this->tdheight, $e, $this->tableborder, '', $this->tdalign, $this->tdbgcolor);
					}
					elseif ($e == "&nbsp;") {
						$this->Cell($this->tdwidth, $this->tdheight, '', $this->tableborder, '', $this->tdalign, $this->tdbgcolor);
					}
				} else
					$this->Write(5, trim(stripslashes(txtentities($e))));
			} else {
				//Tag
				if ($e {
					0 }
				== '/') {
					//echo 'close: '.$e. "<br/>";
					$this->CloseTag(strtoupper(substr($e, 1)));

				} else { //echo 'open: '.$e. "<br/>";
					//Extract attributes
					$a2 = explode(' ', $e);
					$tag = strtoupper(array_shift($a2));
					$attr = array ();
					foreach ($a2 as $v) {
						if (ereg('font-style:', $v, $a3)) {
							$attr['STYLE'] = $a3[0];
						} else
							if (ereg('font-weight:', $v, $a3)) {
								$attr['STYLE2'] = $a3[0];
							}
					}
					$this->OpenTag($tag, $attr);
				}
			}

		}

	}

	function OpenTag($tag, $attr) {
		global $countnumbering;
		global $bullnotnum;
		global $style;
		global $style2;

		//$bullnotnum = false;
		switch ($tag) {
			case 'LI' :
				if (!isset ($style))
					$style = false;
				if (!isset ($style2))
					$style2 = false;
				if ($bullnotnum == true) {
					$this->Write(5, "    -");
				} else {
					$countnumbering ++;
					$this->Write(5, "    ");
					$this->Write(5, $countnumbering);
					$this->Write(5, ". ");
				}
				if (!isset ($attr['STYLE']))
					$attr['STYLE'] = '';
				if (!isset ($attr['STYLE2']))
					$attr['STYLE2'] = '';
				if ($attr['STYLE2'] == 'font-weight:') {
					$style2 = true;
					if ($this->sbold == true) {
						$this->SetStyle('B', false);
						$this->sbold = false;
					}
					elseif ($this->sbold == false) {
						$this->SetStyle('B', true);
						$this->sbold = true;
					}
				}
				if ($attr['STYLE'] == 'font-style:') {
					$style = true;
					if (!isset ($this->sitalic))
						$this->sitalic = false;
					if ($this->sitalic == true) {
						$this->SetStyle('I', false);
						$this->sitalic = false;
					}
					elseif ($this->sitalic == false) {
						$this->SetStyle('I', true);
						$this->sitalic = true;
					}
				}
				break;
			case 'OL' :
				$bullnotnum = false;
				if (!isset ($attr['STYLE']))
					$attr['STYLE'] = '';
				if (!isset ($attr['STYLE2']))
					$attr['STYLE2'] = '';
				if ($attr['STYLE2'] == 'font-weight:') {
					$this->SetStyle('B', true);
					$this->sbold = true;
				}
				if ($attr['STYLE'] == 'font-style:') {
					$this->SetStyle('I', true);
					$this->sitalic = true;
				}
				break;
			case 'UL' :
				$bullnotnum = true;
				if (!isset ($attr['STYLE']))
					$attr['STYLE'] = '';
				if (!isset ($attr['STYLE2']))
					$attr['STYLE2'] = '';
				if ($attr['STYLE2'] == 'font-weight:') {
					$this->SetStyle('B', true);
					$this->sbold = true;
				}
				if ($attr['STYLE'] == 'font-style:') {
					$this->SetStyle('I', true);
					$this->sitalic = true;
				}
				break;
			case 'Q' :
				$this->Write(5, "\"");
				break;
			case 'H1' :

				$this->SetFontSize(22);
				break;
			case 'H2' :
				$this->SetFontSize(16);

				break;
			case 'SUP' :
				if ($attr['SUP'] != '') {
					//Set current font to: Bold, 6pt     
					$this->SetFont('', '', 6);
					//Start 125cm plus width of cell to the right of left margin         
					//Superscript "1"
					$this->Cell(2, 2, $attr['SUP'], 0, 0, 'L');
				}
				break;

			case 'TABLE' : // TABLE-BEGIN
				$this->Ln(5);
				if (@ $attr['BORDER'] != '')
					$this->tableborder = $attr['BORDER'];
				else
					$this->tableborder = 0;
				break;
			case 'TR' : //TR-BEGIN
				break;
			case 'TD' : // TD-BEGIN
				if (@ $attr['WIDTH'] != '')
					$this->tdwidth = ($attr['WIDTH'] / 4);
				else
					$this->tdwidth = 35; // SET to your own width if you need bigger fixed cells
				if (@ $attr['HEIGHT'] != '')
					$this->tdheight = ($attr['HEIGHT'] / 6);
				else
					$this->tdheight = 6; // SET to your own height if you need bigger fixed cells
				if (@ $attr['ALIGN'] != '') {
					$align = $attr['ALIGN'];
					if ($align == "LEFT")
						$this->tdalign = "L";
					if ($align == "CENTER")
						$this->tdalign = "C";
					if ($align == "RIGHT")
						$this->tdalign = "R";
				} else
					$this->tdalign = "L"; // SET to your own
				if (@ $attr['BGCOLOR'] != '') {
					$coul = hex2dec($attr['BGCOLOR']);
					$this->SetFillColor($coul['R'], $coul['G'], $coul['B']);
					$this->tdbgcolor = true;
				}
				$this->SetFontSize(8);
				$this->tdbegin = true;
				break;

			case 'HR' :
				if ($attr['WIDTH'] != '')
					$Width = $attr['WIDTH'];
				else
					$Width = $this->w - $this->lMargin - $this->rMargin;
				$x = $this->GetX();
				$y = $this->GetY();
				$this->SetLineWidth(0.2);
				$this->Line($x, $y, $x + $Width, $y);
				$this->SetLineWidth(0.2);
				$this->Ln(1);
				break;
			case 'STRONG' :
				$this->SetStyle('B', true);
				break;
			case 'EM' :
				$this->SetStyle('I', true);
				break;
			case 'B' :
			case 'I' :
			case 'U' :
				$this->SetStyle($tag, true);
				break;
			case 'A' :
				$this->HREF = $attr['HREF'];
				break;
			case 'IMG' :
				if (isset ($attr['SRC']) and (isset ($attr['WIDTH']) or isset ($attr['HEIGHT']))) {
					if (!isset ($attr['WIDTH']))
						$attr['WIDTH'] = 0;
					if (!isset ($attr['HEIGHT']))
						$attr['HEIGHT'] = 0;
					$this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
				}
				break;
				//case 'TR':
			case 'BLOCKQUOTE' :
			case 'BR' :
				$this->Ln(5);
				break;
			case 'P' :
				$this->Ln(10);
				break;
			case 'SPAN';
				if (!isset ($attr['STYLE']))
					$attr['STYLE'] = '';
				if (!isset ($attr['STYLE2']))
					$attr['STYLE2'] = '';
				if ($attr['STYLE2'] == 'font-weight:') {
					$this->SetStyle('B', true);
					$this->sbold = true; /*echo 'b1';*/
				}
				if ($attr['STYLE'] == 'font-style:') {
					$this->SetStyle('I', true);
					$this->sitalic = true; /*echo 'i1';*/
				}
				if ($attr['STYLE'] == 'text-decoration:') {
					$this->SetStyle('U', true);
					$this->sunderline = true; /*echo 'u1';*/
				}
				break;
			case 'FONT' :
				if (isset ($attr['COLOR']) and $attr['COLOR'] != '') {
					$coul = hex2dec($attr['COLOR']);
					$this->SetTextColor($coul['R'], $coul['G'], $coul['B']);
					$this->issetcolor = true;
				}
				if (isset ($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist)) {
					$this->SetFont(strtolower($attr['FACE']));
					$this->issetfont = true;
				}
				if (isset ($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist) and isset ($attr['SIZE']) and $attr['SIZE'] != '') {
					$this->SetFont(strtolower($attr['FACE']), '', $attr['SIZE']);
					$this->issetfont = true;
				}
				break;
		}
	}

	function CloseTag($tag) {
		global $countnumbering;
		global $style;
		global $style2;
		if ($tag == 'OL') {
			$countnumbering = 0;
			$this->Ln();
			if (isset ($this->sbold)) {
				if ($this->sbold == true) {
					$this->SetStyle('B', false);
					$this->sbold = false;
				}
			}
			if (isset ($this->sitalic)) {
				if ($this->sitalic == true) {
					$this->SetStyle('I', false);
					$this->sitalic = false;
				}
			}
		}
		if ($tag == 'LI') {
			if (!isset ($style))
				$style = false;
			if (!isset ($style2))
				$style2 = false;
			if (isset ($this->sbold) && $style2 == true) {
				$style2 = false;
				if ($this->sbold == true) {
					$this->SetStyle('B', false);
					$this->sbold = false;
				}
				elseif ($this->sbold == false) {
					$this->SetStyle('B', true);
					$this->sbold = true;
				}
			}
			if (isset ($this->sitalic) && $style == true) {
				$style = false;
				if ($this->sitalic == true) {
					$this->SetStyle('I', false);
					$this->sitalic = false;
				}
				elseif ($this->sitalic == false) {
					$this->SetStyle('I', true);
					$this->sitalic = true;
				}
			}
		}
		if ($tag == 'UL') {
			$this->Ln();
			if (isset ($this->sbold)) {
				if ($this->sbold == true) {
					$this->SetStyle('B', false);
					$this->sbold = false;
				}
			}
			if (isset ($this->sitalic)) {
				if ($this->sitalic == true) {
					$this->SetStyle('I', false);
					$this->sitalic = false;
				}
			}
		}
		if ($tag == 'SUP') {
		}

		if ($tag == 'TD') { // TD-END
			$this->tdbegin = false;
			$this->tdwidth = 0;
			$this->tdheight = 0;
			$this->tdalign = "L";
			$this->tdbgcolor = false;
		}
		if ($tag == 'TR') { // TR-END
			$this->Ln();
		}
		if ($tag == 'TABLE') { // TABLE-END
			//$this->Ln();
			$this->tableborder = 0;
		}

		if ($tag == 'STRONG')
			$tag = 'B';
		if ($tag == 'EM')
			$tag = 'I';
		if ($tag == 'B' or $tag == 'I' or $tag == 'U')
			$this->SetStyle($tag, false);
		if ($tag == 'SPAN') {
			if (isset ($this->sbold)) {
				if ($this->sbold == true) {
					$this->SetStyle('B', false);
					$this->sbold = false; /*echo 'b';*/
				}
			}
			if (isset ($this->sitalic)) {
				if ($this->sitalic == true) {
					$this->SetStyle('I', false);
					$this->sitalic = false; /*echo 'i';*/
				}
			}
			if (isset ($this->sunderline)) {
				if ($this->sunderline == true) {
					$this->SetStyle('U', false);
					$this->sunderline = false; /*echo 'u';*/
				}
			}
		}
		if ($tag == 'A')
			$this->HREF = '';
		if ($tag == 'FONT') {
			if ($this->issetcolor == true) {
				$this->SetTextColor(0);
			}
			if ($this->issetfont) {
				$this->SetFont('arial');
				$this->issetfont = false;
			}
		}
		if ($tag == 'H1' || $tag == 'H2') {
			$this->SetFontSize(12);

		}
		if ($tag == 'Q') {
			$this->Write(5, "\"");
		}
		if ($tag == 'P') {
			$this->Ln(5);
		}
	}

	function SetStyle($tag, $enable) {
		//Modify style and select corresponding font
		if (!isset ($this-> $tag))
			$this-> $tag = 0;
		$this-> $tag += ($enable ? 1 : -1);
		$style = '';
		foreach (array ('B', 'I', 'U') as $s) {
			if (!isset ($this-> $s))
				$this-> $s = 0;
			if ($this-> $s > 0)
				$style .= $s;
			$this->SetFont('', $style);
		}
	}

	function PutLink($URL, $txt) {
		//Put a hyperlink
		$this->SetTextColor(100, 0, 100);
		$this->SetStyle('U', true);
		$this->Write(5, $txt, $URL);
		$this->SetStyle('U', false);
		$this->SetTextColor(0);
	}
} //end class
//////////////////////////////////////////////////////////



?>