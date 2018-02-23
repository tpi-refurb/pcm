<?php
	require_once('mc_table.php');
	require_once('../setup.php');
	$dt = decode_url((isset($_GET['dt']) && $_GET['dt'] != '') ? $_GET['dt'] : '');
	$st = decode_url((isset($_GET['st']) && $_GET['st'] != '') ? $_GET['st'] : '');
	$bt = decode_url((isset($_GET['bt']) && $_GET['bt'] != '') ? $_GET['bt'] : '');
	$rt = decode_url((isset($_GET['rt']) && $_GET['rt'] != '') ? $_GET['rt'] : '');
	$sp = decode_url((isset($_GET['sp']) && $_GET['sp'] != '') ? $_GET['sp'] : '0');
	$tb = decode_url((isset($_GET['tbl']) && $_GET['tbl'] != '') ? $_GET['tbl'] : '0');
	$tc = decode_url((isset($_GET['tc']) && $_GET['tc'] != '') ? $_GET['tc'] : '');
	$dr = decode_url((isset($_GET['dr']) && $_GET['dr'] != '') ? $_GET['dr'] : '');
	
	$test_burn	= decode_url((isset($_GET['tbl']) && $_GET['tb'] != '') ? $_GET['tb'] : '');
	$test_fan	= decode_url((isset($_GET['tf']) && $_GET['tf'] != '') ? $_GET['tf'] : '');
	$test_power	= decode_url((isset($_GET['tp']) && $_GET['tp'] != '') ? $_GET['tp'] : '');
	
	$table = str_replace('pcm_view_','pcm_delivery_',$tb);
	$status = $db->getValue('pcm_status','status','id='.$st);
	$brand  = $db->getValue('pcm_brands','brand_name','id='.$bt);
	$requisitioner  = $db->getValue('pcm_requisitioners','requisitioner','id='.$rt);
	$tin  = $db->getValue('pcm_requisitioners','tin','id='.$rt);
	$contact_person  = $db->getValue('pcm_requisitioners','contact_person','id='.$rt);
	$address  = $db->getValue('pcm_requisitioners','address','id='.$rt);
	$firstname  = $db->getValue('pcm_technicians','firstname','id='.$tc);
	$lastname  = $db->getValue('pcm_technicians','lastname','id='.$tc);
	$middlename  = $db->getValue('pcm_technicians','middlename','id='.$tc);
	$tech = $firstname.' '.$middlename[0].'.' .$lastname;
	$company =$requisitioner;
	
	$filename = 'TSR_'.$dr;
	class PDF extends FPDF{
		private $deploy_date;
		private $reporttitle;
		private $report_company;
		private $dr_number;
		private $requisitioner;
		private $contact_person;
		private $address;
		private $city;
		private $tech;
		private $checked_by;
		private $approved_by;
		private $noted_by;
		private $status_con;
		private $status_others;
		public $is_last_page = false;
		public $footer_next_page = false;
		public $hide_delivery_date = false;

		public $borders ='LTRB';
		//public $borders ='';
		
		function setReportTitle($title){
			$this->reporttitle = $title;
		}
		
		function setCompany($report_company){
			$this->report_company = $report_company;
		}
		
		function setDateDeliver($date){
			$this->deploy_date = $date;
		}
		
		function setDRNumber($dr_number){
			$this->dr_number = $dr_number;
		}

		function setRequisitioner($requisitioner){
			$this->requisitioner = $requisitioner;
		}
		
		function setContactPerson($contact_person){
			$this->contact_person = $contact_person;
		}

		function setAddress($address){
			
			$addr = explode("Rd.,",$address);			
			$this->address = $addr[0].' Rd.,';
			$this->city = $addr[1];
		}
		
		function setTechnician($tech){
			$this->tech = $tech;
		}

		function setChecked_by($returned_by){
			$this->checked_by = $returned_by;
		}

		function setApproved_by($approved_by){
			$this->approved_by = $approved_by;
		}
		
		function setNoted_by($noted_by){
			$this->noted_by = $noted_by;
		}

		function setStatusCon($status_con){
			$this->status_con = $status_con;
		}

		function setStatusOthers($status_others){
			$this->status_others = $status_others;
		}
		function setHideDeliveryDate($hide_delivery_date){
			$this->hide_delivery_date = $hide_delivery_date;
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
				// Arial bold 12
				$this->SetFont('Arial','B',12);
				// Logo
				$this->Image('logo.png',18,10,0,20,'PNG');
				// Move to the right
				$this->Cell(20);
				// Title
				$this->Cell(240,5,$this->report_company,'',0,'L',false);		
				// Move to the right
				
				
				$this->Ln(6);
				$this->SetFont('Arial','',7);
				// Move to the right
				$this->Cell(20);
				// Address
				$this->Cell(130,3,$this->address,'',0,'L',false);	
				$this->Ln();
				$this->Cell(20);
				$this->Cell(130,3,$this->city,'',0,'L',false);
								
				$this->Ln();
				$this->Cell(20);
				$this->Cell(130,3,'Tel: (632)7440237; Telefax: (632)7241455','',0,'L',false);
				$this->Ln();
				$this->Cell(20);
				$this->Cell(130,3,'Email: jcdeguzman@telcomtrix.com','',0,'L',false);
				
				
				
				
				
				
				
				
				
				$this->SetY(10);
				$this->SetFont('Arial','',7);
				$this->Cell(163);
				$this->Cell(30,4,'DOCUMENT','LT',0,'C',false);
				$this->SetFont('Arial','B',7);
				$this->Cell(60,4,'TECHNICAL SERVICE REPORT','LTR',0,'C',false);
				$this->SetFont('Arial','',7);
				$this->Ln();
				
				$this->Cell(163);
				$this->Cell(30,4,'CLIENT','LT',0,'C',false);
				$this->SetFont('Arial','',7);
				$this->Cell(60,4,$this->requisitioner,'LTR',0,'C',false);
				$this->SetFont('Arial','',7);
				$this->Ln();
				
				$this->Cell(163);
				$this->Cell(30,4,'CONTACT PERSON','LTB',0,'C',false);
				$this->SetFont('Arial','B',7);
				$this->Cell(60,4,$this->contact_person,'LTBR',0,'C',false);
				$this->SetFont('Arial','',7);
				$this->Ln();
				
				if($this->hide_delivery_date==false){
					$this->Cell(163);
					$this->Cell(30,4,'DATE DELIVERED','LTB',0,'C',false);
					$this->SetFont('Arial','B',7);
					$this->Cell(60,4,$this->deploy_date,'LTBR',0,'C',false);
					$this->SetFont('Arial','',7);
					$this->Ln();
				}
				
				$this->Cell(163);
				$this->Cell(30,6,'D.R. NUMBER','LTB',0,'C',false);
				$this->SetFont('Arial','B',10);
				$this->Cell(60,6,$this->dr_number,'LTBR',0,'C',false);
				$this->SetFont('Arial','',7);
				$this->Ln(5);
				
				
				$this->SetFont('Arial','',7);
				$border = array('LT', 'LT', 'LTR');
				$w = array(24.5, 180.2, 50);
			

				$this->Ln();
			}

			

		}

		// Simple table
		function ColumnHeader(){			
			
			
		}

		
		function SetManualFooter($bottom_margin){
				if(empty($bottom_margin)){
					$this->SetY(-40);
				}else{
					$this->SetY($bottom_margin);
				}
				
				$this->SetFont('Arial','',7);
				$header = array('Acknowledged  By:', '','', 'Repaired By:','','', 'Noted  By:','');
				$border = array('', '', '', '', '', '', '', '');
				//Border
				$w = array(16,45,20,16,45,20,16,45);
				//Width
				for($i=0;$i<count($header);$i++)$this->Cell($w[$i],5,$header[$i],$border[$i],0,'L',false);
				$this->Ln();
				for($i=0;$i<count($header);$i++)$this->Cell($w[$i],6,'',$border[$i],0,'L',false);
				$this->Ln();
				$this->SetFont('Arial','B',7);
				$header = array('', '(Signature Over Printed Name/Date)','', '',$this->tech,'', '',$this->noted_by);
				$border = array('', 'T', '', '', 'T','', '','T');
				//Border
				for($i=0;$i<count($header);$i++){
					if($i===1){
						$this->SetFont('Arial','BI',6);					
					}else{
						$this->SetFont('Arial','B',7);						
					}
					$this->Cell($w[$i],5,$header[$i],$border[$i],0,'C',false);
				}
				$this->Ln();
				$this->SetFont('Arial','',6);
				$header = array('', 'GLOBE Representative','', '','TELCOMTRIX Representative', '', '','TELCOMTRIX Representative');
				$border = array('', '', '', '', '','', '', '', '', '');
				//Border
				for($i=0;$i<count($header);$i++){
					$this->Cell($w[$i],3,$header[$i],$border[$i],0,'C',false);
				}
		}

		// -- Function Name : Footer
		// -- Params : 
		// -- Purpose : 
		function Footer(){
			
			if($this->is_last_page){
				if($this->footer_next_page===false){
					$this->SetManualFooter('');
				}
			}

			$this->SetY(-18);
			// Select Arial italic 8
			$this->SetFont('Arial','B',5);
			$this->SetTextColor(220);
			// Print at bottom right side of page
			$this->Cell(0,10,'Telcomtrix Philippines, Inc.',0,0,'R');
			$this->Ln(3);
			$this->SetTextColor(222);
			$this->SetFont('Arial','I',5);
			$cc = iconv('UTF-8', 'windows-1252', html_entity_decode("&copy;"));
			$this->Cell(0,10,'Generated: PCM Assistant, '.$cc.' 2016',0,0,'R');
		}

		var $widths;
		var $aligns;
		var $bolds;
		var $min_height;

		function SetWidths($w){
			//Set the array of column widths
			$this->widths=$w;
		}

		function SetMinHeight($h){
			//Set the array of column widths
			$this->min_height=$h;
		}

		function SetBolds($b){
			//Set the array of column widths
			$this->bolds=$b;
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
		
		function Row($data, $h, $fill =false){
		
			//Issue a page break first if needed
			if(!empty($this->min_height)){
				if($h<$this->min_height){
					$h =$this->min_height;
				}
			}
			
			$this->CheckPageBreak($h);
			//Draw the cells of the row
			for($i=0;$i<count($data);$i++){
				
				if($i==2){
					$this->SetFont('Arial','B',7);
				} else {
					$this->SetFont('Arial','',7);
				}
				if(!empty($this->bolds)){
					$this->SetFont('Arial',$this->bolds[$i],7);
				}else{
					$this->SetFont('Arial','',7);
				}

				$w=$this->widths[$i];
				$a=isset($this->aligns[$i]) ? $this->aligns[$i] :'L';
				//Save the current position
				$x=$this->GetX();
				$y=$this->GetY();
				//Draw the border
				$this->Rect($x,$y,$w,$h,$fill);
				//Print the text
				$this->MultiCell($w,5,$data[$i],0,$a,$fill);
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


	// Instanciation of inherited class
	$pdf = new PDF('L','mm','Letter');
	$pdf->SetLeftMargin(18);
	
	$pdf->SetTitle('TSR '.strtoupper(long_date($dt)));
	$pdf->setReportTitle('TECHNICAL SERVICE REPORT');
	$pdf->setCompany('Telcomtrix Philippines., Inc.');
	$pdf->setDateDeliver(strtoupper(long_date($dt)));
	$pdf->setDRNumber($dr);
	$pdf->setRequisitioner($requisitioner);
	$pdf->setContactPerson($contact_person);
	$pdf->setAddress('241 Pasadena Dr., Santolan Rd.,San Juan City, Manila, Philippines 1500');
	$pdf->setTechnician($tech);
	$pdf->setNoted_by($config->pcm_noted_by);
	$pdf->setApproved_by($config->pcm_acknowledged_by);
	$pdf->setHideDeliveryDate($config->pcm_hide_delivery_date);
	$pdf->is_last_page = false;
	$pdf->SetAutoPageBreak(false);
	$pdf->AliasNbPages();
	$pdf->AddPage('L');
	
	
	$widths = array(7,40,34,24,96, 12.8, 10,11,18);
	$aligns = array('C','C','C','C','C', 'C', 'C','C','C');
	$bolds = array('B','B','B','B','B', 'B', 'B','B','B');
	$pdf->SetWidths($widths);
	$pdf->SetAligns($aligns);
	$pdf->SetBolds($bolds);
	$pdf->SetFont('Arial','B',7);
	$pdf->SetFillColor(66);
	$pdf->SetTextColor(255);
	$header = array('NO.', 'BRAND','SERIAL NO.', 'REPAIRED PORTION','REPLACED PARTS','POWER ON TEST','FAN TEST','BURN TEST','DATE REPAIRED');
	$border = array('LTB', 'LTB', 'LTB', 'LTB', 'LTB','LTB', 'LTB', 'LTB', 'LTB', 'LTB', 'LTBR');	
	$max_height = 0;	
	$h = $pdf->GetMaxHeight($header);
	if($h>$max_height){$max_height = $h;}	
	$pdf->Row($header,$max_height, true);
	
	$q ="SELECT * FROM ".$tb;
	$rs = $db->getResults($q);
	$row_count = count($rs);
	
	$pdf->SetBolds('');
	$pdf->SetFont('Arial','',7);
	$pdf->SetFillColor(255);
	$pdf->SetTextColor(3);
	$pdf->SetMinHeight(10);
	$max_height = 0;
	
	if($row_count>0){
		$index= 1;
		foreach($rs as $r){
			$row_array = array();
			$row_array[] = $index;
			$row_array[] = $r['brand_name'];
			$row_array[] = $r['serial'];
			$row_array[] = str_replace('&AMP;','&', $r['repaired_portion']);
			$row_array[] = $r['replaced_parts'];
			$row_array[] ='OK';
			$row_array[] ='OK';
			$row_array[] ='OK';
			$row_array[] = strtoupper(long_date($r['date_repaired']));
			$h = $pdf->GetMaxHeight($row_array);
			if($h>$max_height){
				$max_height = $h;
			}
		}
		$index= 1;
		foreach($rs as $r){
			$row_array = array();
			$row_array[] = $index;
			$row_array[] = $r['brand_name'];
			$row_array[] = $r['serial'];
			$row_array[] = str_replace('&AMP;','&', $r['repaired_portion']);
			$row_array[] = $r['replaced_parts'];
			$row_array[] =$test_power;
			$row_array[] =$test_fan;
			$row_array[] =$test_burn;
			$row_array[] = strtoupper(long_date($r['date_repaired']));
			$pdf->Row($row_array,$max_height,false);
			$index +=1;
			
			$id = $r['id'];
			$data['tsr'] ='attachments/tsr/'.$filename.'.pdf';
			if($db->exist($table,'serial_id',$id)){
				$db->update($table,$data,'serial_id='.$id);
			}
			if($index % 16 ===0){
				$pdf->AddPage('L');
			}
		}
		
		
	}
	
	if($row_count ===14){
		$pdf->footer_next_page= true;	
		$pdf->SetManualFooter(-28);
	}
	
	$pdf->is_last_page = true;
	$pdf->Ln();	
	try{
		error_reporting(0);
		$pdf->Output(ATTACHMENTS.DS.'tsr'.DS.$filename.'.pdf','F');
	}catch(Exception $e){
		
	}
	
	
	$pdf->Output();
?>