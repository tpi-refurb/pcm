<?php
	require_once('mc_table.php');
	require_once('../setup.php');
	$assigned_to		= decode_url((isset($_GET['at']) && $_GET['at'] != '') ? $_GET['at'] : '');
	$assigned_partner	= decode_url((isset($_GET['ap']) && $_GET['ap'] != '') ? $_GET['ap'] : '');
	$date				= decode_url((isset($_GET['dt']) && $_GET['dt'] != '') ? $_GET['dt'] : '');
	$dt					= force_date($date);

	class PDF extends FPDF{
		private $deploy_date;
		private $reporttitle;
		private $report_company;
		private $form_number;
		private $requisitioner;
		private $address;
		private $city;
		private $installer;
		private $installer2;
		private $checked_by;
		private $approved_by;
		private $status_con;
		private $status_others;
		public $is_last_page = false;

		function setReportTitle($title){
			$this->reporttitle = $title;
		}
		
		function setCompany($report_company){
			$this->report_company = $report_company;
		}
		
		function setDateDeliver($date){
			$this->deploy_date = $date;
		}
		
		function setFormNumber($form_number){
			$this->form_number = $form_number;
		}

		function setRequisitioner($requisitioner){
			$this->requisitioner = $requisitioner;
		}

		function setAddress($address){
			
			$addr = explode("Rd.,",$address);			
			$this->address = $addr[0].' Rd.,';
			$this->city = $addr[1];
		}
		
		function setInstaller1($installer){
			$this->installer = $installer;
		}

		function setInstaller2($installer2){
			$this->installer2 = $installer2;
		}

		function setChecked_by($returned_by){
			$this->checked_by = $returned_by;
		}

		function setApproved_by($approved_by){
			$this->approved_by = $approved_by;
		}

		function setStatusCon($status_con){
			$this->status_con = $status_con;
		}

		function setStatusOthers($status_others){
			$this->status_others = $status_others;
		}
		
		function RotatedText($x, $y, $txt, $angle){
			//Text rotated around its origin
			$this->Rotate($angle,$x,$y);
			$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}

		// Page header
		function Header(){
			
			if($this->PageNo()===1){
				// Arial bold 15
				$this->SetFont('Arial','B',12);
				// Logo
				$this->Image('logo.png',18,10,0,10,'PNG');
				// Move to the right
				$this->Cell(10);
				// Title
				$this->Cell(12,5,$this->report_company,0,0,'L');
				// Move to the right
				$this->Cell(217);
				$this->SetFont('Arial','I',6);
				$this->Cell(1,1,'Accredited',0,0,'L');
				$this->SetFont('Arial','',7);
				$this->Cell(0,14,'Contractor',0,0,'L');
				// Globe Logo
				$this->Image('globe.png',240,8,0,12,'PNG');
				// Line break
				$this->Ln(6);
				$this->SetFont('Arial','',7);
				// Move to the right
				$this->Cell(10);
				// Address
				$this->Cell(10,0,$this->address,0,0,'L');			
				$this->Ln(3);
				$this->Cell(10);
				$this->Cell(10,0,$this->city,0,0,'L');			
				
				
				$this->SetFont('Times','B',12);
				$this->Cell(0,10,$this->reporttitle,0,0,'C');
				$this->Ln(8);
				$this->SetFont('Arial','',8);
				$header = array('TEAM:', $this->installer, 'Date:');
				$border = array('LT', 'LT', 'LTR');
				$w = array(24.5, 180.2, 50);
				for($i=0;$i<count($header);$i++){
					
					if($i===1){
						$this->SetFont('Arial','B',8);
					} else {
						$this->SetFont('Arial','',8);
					}

					$this->Cell($w[$i],5,$header[$i],$border[$i],0,'L',false);
				}

				$this->Ln();
				$header = array('', $this->installer2, $this->deploy_date);
				$border = array('LB', 'LBR', 'R');
				//Border
				for($i=0;$i<count($header);$i++){
					
					$align ='L';
					if($i===1){
						$this->SetFont('Arial','B',8);
					}else if($i===2){
						$align ='C';
					}else{}
					$this->Cell($w[$i],5,$header[$i],$border[$i],0,$align,false);
				}

				$this->Ln();
			}

			
			if(!$this->is_last_page){
				$this->SetFont('Arial','',7);
				$this->SetFillColor(190);
				$header = array('Order No', 'Job Type','Service No', 'SubsName','Contact Number','Cabinet No.','Job Description','ApptDate','SlotFrom','SlotTo','Status','OK #');
				$border = array('LTB', 'LTB', 'LTB', 'LTB', 'LTB','LTB', 'LTB', 'LTB', 'LTB', 'LTB', 'LTB', 'LTBR');
				//Border
				//$w = array(15,10,16,35,25, 25, 40,15,9,9,7.2,50);
				$w = array(15,9.5,16,35,25, 25, 40,14.8,8.3,8.3,7.8,50,0);
				//Width		
				for($i=0;$i<count($header);$i++){
					$this->Cell($w[$i],7,$header[$i],$border[$i],0,'C',true);
				}

				$this->Ln();
			}

		}

		// Simple table
		function preHeader(){
		}

		

		// -- Function Name : Footer
		// -- Params : 
		// -- Purpose : 
		function Footer(){
			
			if($this->is_last_page){
				$this->SetY(-32);
				$this->SetFont('Arial','',7);
				$header = array('Checked by:', '','', 'Approved by:','');
				$border = array('', '', '', '', '');
				//Border
				$w = array(16,45,30,16,45);
				//Width
				for($i=0;$i<count($header);$i++)$this->Cell($w[$i],5,$header[$i],$border[$i],0,'L',false);
				$this->Ln();
				for($i=0;$i<count($header);$i++)$this->Cell($w[$i],6,'',$border[$i],0,'L',false);
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$header = array('', $this->checked_by,'', '',$this->approved_by);
				$border = array('', 'B', '', '', 'B');
				//Border
				for($i=0;$i<count($header);$i++)$this->Cell($w[$i],5,$header[$i],$border[$i],0,'C',false);
				$this->Ln();
				$this->SetFont('Arial','',5);
				$header = array('', 'Telcomtrix Representative','', '','Globe FO/ Representative');
				$border = array('', '', '', '', '');
				//Border
				for($i=0;$i<count($header);$i++){
					$this->Cell($w[$i],3,$header[$i],$border[$i],0,'C',false);
				}

			}

			$this->SetY(-18);
			// Select Arial italic 8
			$this->SetFont('Arial','B',5);
			$this->SetTextColor(77);
			// Print at bottom right side of page
			$this->Cell(0,10,'Telcomtrix Philippines Inc.',0,0,'R');
			$this->Ln(3);
			$this->SetTextColor(107);
			$this->SetFont('Arial','I',5);
			$cc = iconv('UTF-8', 'windows-1252', html_entity_decode("&copy;"));
			$this->Cell(0,10,'Generated: Cluster Helper, '.$cc.' 2016',0,0,'R');
		}

		var $widths;
		var $aligns;
		var $min_height;

		function SetWidths($w){
			//Set the array of column widths
			$this->widths=$w;
		}

		function SetMinHeight($h){
			//Set the array of column widths
			$this->min_height=$h;
		}

		function SetAligns($a){
			//Set the array of column alignments
			$this->aligns=$a;
		}

		function GetMaxHeight($data){
			$nb=0;
			for($i=0;$i<count($data);$i++){
				$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			}

			return (5*$nb);
		}
		
		function Row($data, $h){
		
			//Issue a page break first if needed
			$this->CheckPageBreak($h);
			//Draw the cells of the row
			for($i=0;$i<count($data);$i++){
				
				if($i==0){
					$this->SetFont('Arial','B',8);
				} else {
					$this->SetFont('Arial','',7);
				}

				$w=$this->widths[$i];
				$a=isset($this->aligns[$i]) ? $this->aligns[$i] :
				'L';
				//Save the current position
				$x=$this->GetX();
				$y=$this->GetY();
				//Draw the border
				$this->Rect($x,$y,$w,$h);
				//Print the text
				$this->MultiCell($w,5,$data[$i],0,$a);
				//Put the position to the right of the cell
				$this->SetXY($x+$w,$y);
			}

			//Go to the next line
			$this->Ln($h);
		}
		
		function CheckPageBreak($h){
			//If the height h would cause an overflow, add a new page immediately			
			if($this->GetY()+$h>$this->PageBreakTrigger)$this->AddPage($this->CurOrientation);
		}
		
		function NbLines($w,$txt){
			//Computes the number of lines a MultiCell of width w will take
			$cw=&$this->CurrentFont['cw'];
			
			if($w==0)$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
			
			if($nb>0 and $s[$nb-1]=="\n")$nb--;
			$sep=-1;
			$i=0;
			$j=0;
			$l=0;
			$nl=1;
			while($i<$nb){
				$c=$s[$i];
				
				if($c=="\n"){
					$i++;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
					continue;
				}

				
				if($c==' ')$sep=$i;
				$l+=$cw[$c];
				
				if($l>$wmax){					
					if($sep==-1){						
						if($i==$j)$i++;
					} else $i=$sep+1;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
				} else $i++;
			}

			return $nl;
		}

	}

	$ins1 = $dispatch->get_fullname($assigned_to);
	$ins2 = $dispatch->get_fullname($assigned_partner);
	
	// Instanciation of inherited class
	$pdf = new PDF('L','mm','Letter');
	$pdf->SetLeftMargin(18);
	
	$pdf->SetTitle('Dispatch Summary '.$dt);
	$pdf->setReportTitle('DISPATCH SUMMARY');
	$pdf->setCompany('Telcomtrix Phils., Inc.');
	$pdf->setDateDeliver($dt);
	$pdf->setRequisitioner('Telcomtrix');
	$pdf->setAddress('241 Pasadena Dr., Santolan Rd.,San Juan City, Manila, Philippines 1500');
	$pdf->setInstaller1($ins1);
	$pdf->setInstaller2($ins2);
	$pdf->setChecked_by($config->dispatch_checked_by);
	$pdf->setApproved_by($config->dispatch_approved_by);
	$pdf->is_last_page = false;
	//$pdf->SetAutoPageBreak(false);
	//$pdf->AliasNbPages();
	$pdf->AddPage('L');
	
	
	$widths = array(15,9.5,16,35,25, 25, 40,14.8,8.3,8.3,7.8,50,0);
	$pdf->SetWidths($widths);
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(243);
	$columns = array('ord_no', 'JobType','ServiceNo', 'FullName','ContactNo','CabinetNo','JobDescription','ApptDate','ApptSlotFrom','ApptSlotTo','HistoryStatus','OKNo');
	

	$q ="SELECT * FROM clus_orders WHERE assigned_to =".$assigned_to." AND assigned_partner =".$assigned_partner." AND assigned_date ='".$dt."';";
	$rs = $db->getResults($q);
	
	$max_height = 0;
	if(count($rs)>0){
		foreach($rs as $r){
			$row_array = array();
			foreach($columns as $col){
				$row_array[] = $r[$col];
			}
			$row_array[] ='';
			$h = $pdf->GetMaxHeight($row_array);
			if($h>$max_height){
				$max_height = $h;
			}
		}
		
		foreach($rs as $r){
			$row_array = array();
			foreach($columns as $col){
				$row_array[] = $r[$col];
			}
			$row_array[] ='';
			$pdf->Row($row_array,$max_height);
		}
		
		
	}else{
		//echo '<p class="h5 text-red">No job orders assigned...</p>';
		$pdf->SetFont('Arial','B',14);
		$pdf->SetTextColor(220,50,50);
		$pdf->Cell(array_sum($widths)+8,100,'No assignment found...','',0,'C',false);
		$pdf->SetTextColor(0); //Reset Text Color
	}
	
	$pdf->is_last_page = true;
	$pdf->Ln();
	$pdf->Output();
?>