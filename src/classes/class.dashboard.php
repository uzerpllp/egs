<?php

// +----------------------------------------------------------------------+
// | Enterprise Groupware System (EGS) - Dashboard Class 1.0              |
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

class dashboard {
	function dashboard() {
		/* Bring in the DB */
		global $db;
		$this->db = $db;

		/* Include the JP Graph Stuff */
		include (EGS_FILE_ROOT.'/src/jpgraph/jpgraph.php');
		include (EGS_FILE_ROOT.'/src/jpgraph/jpgraph_bar.php');
	}

	function pipelineSalesStage() {
		$height = 400;
		if (!file_exists(CACHE_DIR.EGS_COMPANY_ID.EGS_USERNAME.'salesstage')) {
			$leftMax = 0;
			/* Grab the opportunity Types */
			$query = 'SELECT id, name FROM crmopportunity WHERE companyid='.$this->db->qstr(EGS_COMPANY_ID).' ORDER BY id';

			$rs = $this->db->Execute($query);

			$xKeys = array ();
			$plots = array ();

			/* Iterate over the opportunity types */
			while (!$rs->EOF) {
				$xKeys[] = $rs->fields['name'];

				$leftMax = max($leftMax, strlen($rs->fields['name']));

				$rs->MoveNext();
			}

			$height = sizeof($xKeys) * 50;
		}
		// Set the basic parameters of the graph
		$graph = new Graph(600, $height, EGS_COMPANY_ID.EGS_USERNAME.'salesstage', 999999);
		$data = array ();

		$totalCost = 0;
		/* Now do the users */
		for ($i = 0; $i < sizeof($_SESSION['pipelineSalesStageUsers']); $i ++) {
			$query = 'SELECT sum(o.cost)::bigint/1000 AS cost, c.id FROM crmopportunity c LEFT OUTER JOIN opportunity o ON (o.crmstatusid=c.id AND o.usercompanyid='.$this->db->qstr(EGS_COMPANY_ID).' AND o.assigned='.$this->db->qstr($_SESSION['pipelineSalesStageUsers'][$i]).') WHERE c.companyid='.$this->db->qstr(EGS_COMPANY_ID).' GROUP BY c.id ORDER BY c.id';

			$rs = $this->db->Execute($query);

			$user = array ();
			while (!$rs->EOF) {
				if ($rs->fields['cost'] == '')
					$user[] = 0;
				else {
					$user[] = $rs->fields['cost'];
					$totalCost += $rs->fields['cost'];
				}

				$rs->MoveNext();
			}

			$data[] = $user;
		}

		$plots = array ();

		$colours = array ('#4D4466', '#9DB029', '#6484A4', '#C95616', '#9db029', '#73adef', '#E88000', '#626A69');

		$colour = 0;

		$rightMax = 0;

		for ($i = 0; $i < sizeof($_SESSION['pipelineSalesStageUsers']); $i ++) {
			$plot = 'plot'.$i;

			$$plot = new BarPlot($data[$i]);
			$$plot->SetFillColor($colours[$colour]);

			//$$plot->value->Show();
			$$plot->SetValuePos('center');
			//$$plot->value->SetFont(FF_ARIAL,FS_NORMAL,10);
			$$plot->value->SetColor("white", "darkred");
			$$plot->value->SetFormat('%d');
			$$plot->SetLegend($_SESSION['pipelineSalesStageUsers'][$i]);

			$colour ++;

			$rightMax = max($rightMax, strlen($_SESSION['pipelineSalesStageUsers'][$i]));

			if ($colour == sizeof($colours))
				$colour = 0;
			$plots[] = $$plot;
		}

		$graph->SetScale("textlin");

		$top = 50;
		$bottom = 20;
		$left = ($leftMax * 6.4) + 20;
		$right = ($rightMax * 6.4) + 80;
		$graph->Set90AndMargin($left, $right, $top, $bottom);
		// Setup labels
		$graph->xaxis->SetTickLabels($xKeys);

		// Label align for X-axis
		$graph->xaxis->SetLabelAlign('right', 'center', 'right');

		// Label align for Y-axis
		$graph->yaxis->SetLabelAlign('center', 'bottom');

		// Titles
		$graph->title->Set('Pipeline Total: '.$totalCost);

		$graph->SetMarginColor('#999999');
		$graph->legend->SetShadow(false);
		$graph->legend->SetFillColor('#cccccc'); 
		
		// Create the grouped bar plot
		$gbplot = new AccBarPlot($plots);

		$graph->Add($gbplot);

		$graph->legend->Pos(0.05, 0.5, "right", "center");
		$graph->Stroke();
	}

	function myPipeline() {
		$height = 400;

		// Set the basic parameters of the graph
		$graph = new Graph(400, $height, EGS_COMPANY_ID.EGS_USERNAME.'mypipeline', 60);
		$data = array ();
		
		$leftMax = 0;
		/* Grab the opportunity Types */
		$query = 'SELECT id, name FROM crmopportunity WHERE companyid='.$this->db->qstr(EGS_COMPANY_ID).' ORDER BY id';

		$rs = $this->db->Execute($query);

		$xKeys = array ();
		$plots = array ();

		/* Iterate over the opportunity types */
		while (!$rs->EOF) {
			$xKeys[] = $rs->fields['name'];

			$leftMax = max($leftMax, strlen($rs->fields['name']));

			$rs->MoveNext();
		}

		$height = sizeof($xKeys) * 50;

		$totalCost = 0;

			$query = 'SELECT sum(o.cost)::bigint/1000 AS cost, c.id FROM crmopportunity c LEFT OUTER JOIN opportunity o ON (o.crmstatusid=c.id AND o.usercompanyid='.$this->db->qstr(EGS_COMPANY_ID).' AND o.assigned='.$this->db->qstr(EGS_USERNAME).' AND extract(\'month\' FROM o.enddate)=extract(\'month\' FROM now()) AND extract(\'year\' FROM o.enddate)=extract(\'year\' FROM now())) WHERE c.companyid='.$this->db->qstr(EGS_COMPANY_ID).' GROUP BY c.id ORDER BY c.id';

			$rs = $this->db->Execute($query);

			$user = array ();
			while (!$rs->EOF) {
				if ($rs->fields['cost'] == '')
					$user[] = 0;
				else {
					$user[] = $rs->fields['cost'];
					$totalCost += $rs->fields['cost'];
				}

				$rs->MoveNext();
			}

			$data = $user;

		$plots = array ();

		$colours = array ('#4D4466', '#9DB029', '#6484A4', '#C95616', '#9db029', '#73adef', '#E88000', '#626A69');

		$colour = 0;

		$rightMax = 0;


			$plot = new BarPlot($data);
			$plot->SetFillColor($colours[$colour]);

			//$$plot->value->Show();
			$plot->SetValuePos('center');
			//$$plot->value->SetFont(FF_ARIAL,FS_NORMAL,10);
			$plot->value->SetColor("white", "darkred");
			$plot->value->SetFormat('%d');


		$graph->SetScale("textlin");

		$top = 50;
		$bottom = 20;
		$left = ($leftMax * 6.4) + 20;
		$right = 20;
		$graph->Set90AndMargin($left, $right, $top, $bottom);
		// Setup labels
		$graph->xaxis->SetTickLabels($xKeys);

		// Label align for X-axis
		$graph->xaxis->SetLabelAlign('right', 'center', 'right');

		// Label align for Y-axis
		$graph->yaxis->SetLabelAlign('center', 'bottom');

		// Titles
		$graph->title->Set('Pipeline Total: '.$totalCost);

		$graph->SetMarginColor('#999999');
		$graph->legend->SetShadow(false);
		$graph->legend->SetFillColor('#cccccc'); 

		$graph->Add($plot);

		$graph->legend->Pos(0.05, 0.5, "right", "center");
		$graph->Stroke();
	}
	
	function opportunitySourceOutcome() {

		// Set the basic parameters of the graph
		$graph = new Graph(600, sizeof($_SESSION['opportunitySources']) * 50, EGS_COMPANY_ID.EGS_USERNAME.'opportunitysourceoutcome', 0);
		$data = array ();

		$totalCost = 0;
		
		$data = array();
		
		$xKeys = array();
		
		$leftMax = 0;
		$rightMax = 0;

		/* Iterate over the sources */
		while (list($stageKey, $stageVal) = each($_SESSION['opportunityStages'])) {
			$datarow = array();
			/* Iterate over the outcomes */
			while (list($sourceKey, $sourceVal) = each($_SESSION['opportunitySources'])) {
				$query = 'SELECT sum(cost)::bigint/1000 FROM opportunity WHERE crmstatusid='.$this->db->qstr($stageKey).' AND companysourceid='.$this->db->qstr($sourceKey).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);
				
				$value = $this->db->GetOne($query);
				
				if($value == '') $datarow[] = 0;
				else {
					$datarow[] = $value;
					$totalCost += $value;
				}
				
				$rightMax = max($rightMax, strlen($stageVal));
				
				if(!in_array($sourceVal, $xKeys)) {
					$xKeys[] = $sourceVal;
					$leftMax = max($leftMax, strlen($sourceVal));
				}
			}
			
			reset($_SESSION['opportunitySources']);
			$data[] = $datarow;
		}

		reset($_SESSION['opportunityStages']);

		$datarow = array();
	
		/* Iterate over the outcomes */
                        while (list($sourceKey, $sourceVal) = each($_SESSION['opportunitySources'])) {
                                $query = 'SELECT sum(cost)::bigint/1000 FROM opportunity WHERE companysourceid='.$this->db->qstr($sourceKey).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);

				while (list($stageKey, $stageVal) = each($_SESSION['opportunityStages'])) {
					$query .= ' AND crmstatusid<>'.$this->db->qstr($stageKey);
				}

                                $value = $this->db->GetOne($query);

                                if($value == '') $datarow[] = 0;
                                else {
                                        $datarow[] = $value;
                                        $totalCost += $value;
                                }

                                $rightMax = max($rightMax, strlen(_('Others')));

                        }

                        reset($_SESSION['opportunitySources']);
                        $data[] = $datarow;

		$plots = array ();

		$colours = array ('#4D4466', '#9DB029', '#6484A4', '#C95616', '#73adef', '#E88000', '#626A69');

		$colour = 0;

		$rightMax = 0;

		$colour = reset($colours);
		$stages = $_SESSION['opportunityStages'];
		$stages[] = _('Others');

		for ($i = 0; $i < sizeof($data); $i ++) {
			$plot = 'plot'.$i;

			$$plot = new BarPlot($data[$i]);
			$$plot->SetFillColor($colour);

			//$$plot->value->Show();
			$$plot->SetValuePos('center');
			//$$plot->value->SetFont(FF_ARIAL,FS_NORMAL,10);
			$$plot->value->SetColor("white", "darkred");
			$$plot->value->SetFormat('%d');
			
			$stage = array_shift($stages);
			
			$$plot->SetLegend($stage);

			$colour ++;

			$rightMax = max($rightMax, strlen($stage));

			if ($colour == sizeof($colours))
				$colour = 0;
			$plots[] = $$plot;
			
			$colour = next($colours);
			if($colour === false) $colour = reset($colours);
		}

		$graph->SetScale("textlin");

		$top = 50;
		$bottom = 20;
		$left = ($leftMax * 6.4) + 20;
		$right = ($rightMax * 6.4) + 80;
		$graph->Set90AndMargin($left, $right, $top, $bottom);
		// Setup labels
		$graph->xaxis->SetTickLabels($xKeys);

		// Label align for X-axis
		$graph->xaxis->SetLabelAlign('right', 'center', 'right');

		// Label align for Y-axis
		$graph->yaxis->SetLabelAlign('center', 'bottom');

		// Titles
		$graph->title->Set('Pipeline Total: '.$totalCost);
		
		$graph->SetMarginColor('#999999');
		$graph->legend->SetShadow(false);
		$graph->legend->SetFillColor('#cccccc'); 

		// Create the grouped bar plot
		$gbplot = new AccBarPlot($plots);

		$graph->Add($gbplot);

		$graph->legend->Pos(0.05, 0.5, "right", "center");
		$graph->Stroke();
	}
	
	function opportunityMonthOutcome() {

		// Set the basic parameters of the graph
		$graph = new Graph(600, 400, EGS_COMPANY_ID.EGS_USERNAME.'opportunitymonthoutcome', 0);
		$data = array ();

		$totalCost = 0;
		
		$data = array();
		
		$xKeys = array();

		$leftPad = 0;
		
		/* Iterate over the sources */
		while (list($stageKey, $stageVal) = each($_SESSION['monthStages'])) {
			$datarow = array();
			
			$tmpTotal = 0;
			
			/* Iterate over the outcomes */
			 for($i =1; $i <= 12; $i++) {
				$query = 'SELECT sum(cost)::bigint/1000 FROM opportunity WHERE crmstatusid='.$this->db->qstr($stageKey).' AND date_part(\'month\', enddate)='.$this->db->qstr($i).' AND date_part(\'year\', enddate)='.$this->db->qstr($_SESSION['monthYear']).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);
				
				$value = $this->db->GetOne($query);
				
				if($value == '') $datarow[] = 0;
				else {
					$datarow[] = $value;
					$totalCost += $value;
					$tmpTotal += $value;
				}
			}

			$leftPad = max($leftPad, $tmpTotal);
			$tmpTotal = 0;
				
				$data[] = $datarow;
		}
		
		reset($_SESSION['monthStages']);
		
		$datarow = array();
			/* Iterate over the outcomes */
			 for($i =1; $i <= 12; $i++) {
				$query = 'SELECT sum(cost)::bigint/1000 FROM opportunity WHERE date_part(\'month\', enddate)='.$this->db->qstr($i).' AND date_part(\'year\', enddate)='.$this->db->qstr($_SESSION['monthYear']).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);
				
				while (list($stageKey, $stageVal) = each($_SESSION['monthStages'])) {
					$query .= ' AND crmstatusid<>'.$this->db->Qstr($stageKey);	
				}
				
				$value = $this->db->GetOne($query);
				
				if($value == '') $datarow[] = 0;
				else {
					$datarow[] = $value;
					$totalCost += $value;
				}
				
				$leftPad = max($leftPad, $value);
				
				$xKeys[] = $i;
			}

				
				$data[] = $datarow;

		$plots = array ();

		$colours = array ('#4D4466', '#9DB029', '#6484A4', '#C95616', '#73adef', '#E88000', '#626A69');

		$colour = 0;

		$colour = reset($colours);
		$stages = $_SESSION['opportunityStages'];
		$stages[] = _('Others');

		for ($i = 0; $i < sizeof($data); $i ++) {
			$plot = 'plot'.$i;

			$$plot = new BarPlot($data[$i]);
			$$plot->SetFillColor($colour);

			//$$plot->value->Show();
			$$plot->SetValuePos('center');
			//$$plot->value->SetFont(FF_ARIAL,FS_NORMAL,10);
			$$plot->value->SetColor("white", "darkred");
			$$plot->value->SetFormat('%d');
			
			$stage = array_shift($stages);
			
			$$plot->SetLegend($stage);

			$colour ++;

			if ($colour == sizeof($colours))
				$colour = 0;
			$plots[] = $$plot;
			
			$colour = next($colours);
			if($colour === false) $colour = reset($colours);
		}

		$graph->SetScale("textlin");

		$top = 50;
		$bottom = 65;
		$left = (strlen($leftPad)*5) + 40;
		$right = 20;
		$graph->img->SetMargin($left, $right, $top, $bottom);
		// Setup labels
		$graph->xaxis->SetTickLabels($xKeys);


		// Titles
		$graph->title->Set('Pipeline for '.$_SESSION['monthYear'].' - Total: '.$totalCost);
		
		$graph->SetMarginColor('#999999');
		$graph->legend->SetShadow(false);
		$graph->legend->SetFillColor('#cccccc'); 

		// Create the grouped bar plot
		$gbplot = new AccBarPlot($plots);

		$graph->Add($gbplot);

		//$graph->legend->Pos(0.05, 0.5, "right", "center");
		$graph->legend->SetLayout(LEGEND_HOR);
		$graph->legend->Pos(0.5,0.97,"center","bottom");
		$graph->Stroke();
	}
	
	function allOpportunities() {
		require_once (EGS_FILE_ROOT.'/src/jpgraph/jpgraph_pie.php');
		require_once (EGS_FILE_ROOT.'/src/jpgraph/jpgraph_pie3d.php');
		
		$graph = new PieGraph(600,400,EGS_COMPANY_ID.EGS_USERNAME.'allopportunities');

		$data = array();
		$totalCost = 0;
		
		$allOpportunitySources = $_SESSION['allOpportunitySources'];
		
		$explode = 0;
		$max = 0;
		$i = 0;
		
		while (list($sourceKey, $sourceVal) = each($_SESSION['allOpportunitySources'])) {
			$query = 'SELECT sum(cost)::bigint/1000 FROM opportunity WHERE companysourceid='.$this->db->qstr($sourceKey).' AND usercompanyid='.$this->db->qstr(EGS_COMPANY_ID);	
			
			$value = $this->db->GetOne($query);
			
			if($value == '') unset($allOpportunitySources[$sourceKey]);
			else {
				$data[] = $value;
				$totalCost += $value;
				
				$max = max($max, $value);
				
				if($max == $value) $explode = $i;
				
				$i++;
			}
		}

		$graph->title->Set(_('Pipeline Total: '.$totalCost));
		
		$graph->SetMarginColor('#999999');
		$graph->legend->SetShadow(false);
		$graph->legend->SetFillColor('#cccccc'); 
		
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		
		$p1 = new PiePlot3D($data);
		$p1->ExplodeSlice($explode);
		$p1->SetCenter(0.45);
		$p1->SetLegends($allOpportunitySources);
		$p1->SetSliceColors(array ('#4D4466', '#9DB029', '#6484A4', '#C95616', '#73adef', '#E88000', '#626A69'));
		
		$p1->SetLabelType(PIE_VALUE_ABS);
		$p1->value->SetFormat('%d'); 
		
		$graph->Add($p1);
		$graph->Stroke();
	}

	function show($type) {
		if ($type == 'opportunities')
			$this->pipelineSalesStage();
		if ($type == 'sourceoutcome')
			$this->opportunitySourceOutcome();
		if ($type == 'monthoutcome')
			$this->opportunityMonthOutcome();
		if ($type == 'allopportunities')
			$this->allOpportunities();
		if ($type == 'mypipeline')
			$this->myPipeline();
	}
	
	function refresh() {
		if(file_exists(CACHE_DIR.EGS_COMPANY_ID.EGS_USERNAME.'salesstage')) unlink(CACHE_DIR.EGS_COMPANY_ID.EGS_USERNAME.'salesstage');
		if(file_exists(CACHE_DIR.EGS_COMPANY_ID.EGS_USERNAME.'opportunitysourceoutcome')) unlink(CACHE_DIR.EGS_COMPANY_ID.EGS_USERNAME.'opportunitysourceoutcome');
		if(file_exists(CACHE_DIR.EGS_COMPANY_ID.EGS_USERNAME.'opportunitymonthoutcome')) unlink(CACHE_DIR.EGS_COMPANY_ID.EGS_USERNAME.'opportunitymonthoutcome');
		if(file_exists(CACHE_DIR.EGS_COMPANY_ID.EGS_USERNAME.'allopportunities')) unlink(CACHE_DIR.EGS_COMPANY_ID.EGS_USERNAME.'allopportunities');
	}
}
?>
