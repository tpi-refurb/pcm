<?php
	require_once('mc_table.php');
	require_once('../setup.php');
	
	
	$query = (isset($_GET['q']) && $_GET['q'] != '') ? decode_url($_GET['q']) : '';
	$dt = decode_url((isset($_GET['dt']) && $_GET['dt'] != '') ? $_GET['dt'] : '');
	$status = decode_url((isset($_GET['pss']) && $_GET['pss'] != '') ? $_GET['pss'] : 'ALL');
	$bt = decode_url((isset($_GET['bt']) && $_GET['bt'] != '') ? $_GET['bt'] : '');
	//$sp = decode_url((isset($_GET['sp']) && $_GET['sp'] != '') ? $_GET['sp'] : '0');
	//$tb = decode_url((isset($_GET['tb']) && $_GET['tb'] != '') ? $_GET['tb'] : '');
	
	$brand  = $db->getValue('pcm_brands','brand_name','id='.$bt);
	#$requisitioner  = $db->getValue('pcm_requisitioners','requisitioner','id='.$rt);
	
	echo $query;
	
	$filename = "ps_".force_date($dt).'_'.$status.'_'.$brand;
	
	class PDF extends FPDF{
		private $date_delivered;
		private $report_company;
		private $requisitioner;
		private $status;
		private $total;
		private $brand;
		private $tin;
		public $is_last_page = false;
		//public $borders ='LTRB';
		public $borders ='';
		
		function setCompany($report_company){
			$this->report_company = $report_company;
		}
		
		function setDateDeliver($date){
			$this->date_delivered = $date;
		}
		
		function setRequisitioner($requisitioner){
			$this->requisitioner = $requisitioner;
		}

		function setStatus($status){
			$this->status = $status;
		}
		function setBrand($brand){
			$this->brand = $brand;
		}
		function setTotal($total){
			$this->total = $total;
		}
		// Page header
		function printHeader(){
			$this->Ln(6);		
			// First line
			$this->SetFont('Arial','B',8);			
			$this->Cell(10);
			$this->Cell(20,5,"Brand/Model : ",$this->borders,0,'L',false);
			$this->SetFont('Arial','',8);			
			$this->Cell(105,5,$this->brand,$this->borders,0,'L',false);
			$this->Ln(5);
			$this->Cell(10);	
			$this->SetFont('Arial','B',8);
			$this->Cell(20,5,"Status : ",$this->borders,0,'L',false);
			$this->SetFont('Arial','',8);
			$p_status = ($this->status=='ALL')? 'REPAIRED/UNDER REPAIR': $this->status;
			$this->Cell(80,5,$p_status,$this->borders,0,'L',false);
			$this->SetFont('Arial','B',8);
			$this->Cell(10,5,"Total : ",$this->borders,0,'L',false);
			$this->SetFont('Arial','',8);
			$this->Cell(15,5,$this->total,$this->borders,0,'C',false);
			$this->Ln(8);
			
			$this->SetFont('Arial','B',9);
			$this->Cell(10);
			$this->Cell(125,5,"SUMMARY",$this->borders,0,'C',false);
			$this->Ln(6);
			$widths = array(10,40,30,25,25);
			$aligns = array('C','C','C','C','C');
			$bolds = array('B','B','B','B','B');	
			$border = array('LTB', 'LTB', 'LTB', 'LTB', 'LTBR');
			$header = array('NO.', 'SERIAL NO.','REF #', 'DATE RECEIVED', 'Days');
			if($this->status=='ALL'){
				$widths = array(10,40,20,35,25);
				$aligns = array('C','C','C','C','C');
				$bolds = array('B','B','B','B','B');	
				$header = array('NO.', 'SERIAL NO.','Status','REF #', 'DATE RECEIVED');
				$border = array('LTB', 'LTB', 'LTB', 'LTB', 'LTBR');
			}else if($this->status=='REPAIRED'){
				$widths = array(10,40,30,25,25);
				$aligns = array('C','C','C','C','C');
				$bolds = array('B','B','B','B','B');	
				$border = array('LTB', 'LTB', 'LTB', 'LTB', 'LTBR');
				$header = array('NO.', 'SERIAL NO.','REF #', 'DATE RECEIVED', 'DATE DELIVERED');
			}else{
				$widths = array(10,40,30,18,30);
				$aligns = array('C','C','C','C','C');
				$bolds = array('B','B','B','B','B');	
				$border = array('LTB', 'LTB', 'LTB', 'LTB', 'LTBR');
				$header = array('NO.', 'SERIAL NO.','REF #', 'DATE RECEIVED', 'Days');
			}
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(66);
			$this->SetTextColor(255);		
			
			$this->Cell(10);
			for($i=0;$i<count($header);$i++){
				if($header[$i]==='DATE RECEIVED'){
					$this->SetFont('Arial','B',6);
				}else{
					$this->SetFont('Arial','B',8);
				}
				$this->Cell($widths[$i],5,$header[$i],$border[$i],0,$aligns[$i],true);
			}
			$this->Ln(5);
		}
		
		function print_status_repaired($data,$count){
			
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255);
			$this->SetTextColor(3);
			$widths = array(45,45,25);
			$aligns = array('C','C','C');	
			$border = array('LTB', 'LTB', 'LTBR');
			
			$widths = array(40,30,25,25);
			$aligns = array('C','C','C','C');
			$bolds = array('B','B','B','B');	
			$border = array('LTB', 'LTB', 'LTB', 'LTBR');
			
			$header = array('serial','reference_no', 'date_in', 'date_out');			
			$index =1;
			foreach($data as $r){
				
				$this->Cell(10);
				$this->Cell(10,5,$index,'LTB',0,'C',false);
				for($i=0;$i<count($header);$i++){
					$value = $r[$header[$i]];
					$this->Cell($widths[$i],5,$value,$border[$i],0,$aligns[$i],true);
				}
				$this->Ln(5);
				$index++;
			}
		}
		function print_status($data,$count){
			
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255);
			$this->SetTextColor(3);
			
			$widths = array(40,30,18,30);
			$aligns = array('C','C','C','C');
			$bolds = array('B','B','B','B');	
			$border = array('LTB', 'LTB', 'LTB', 'LTBR');
			
			$header = array('serial','reference_no', 'date_in');			
			$index =1;
			foreach($data as $r){
				$date_in =$r["date_in"];
				$days_in = get_days_complete($date_in,get_currentdate());
				$this->SetFont('Arial','',8);
				$this->Cell(10);
				$this->Cell(10,5,$index,'LTB',0,'C',false);
				
				for($i=0;$i<count($header);$i++){
					$value = $r[$header[$i]];
					$this->Cell($widths[$i],5,$value,$border[$i],0,$aligns[$i],true);
				}
				
				$lngth = intval(strlen($days_in));
				//Adjust font size if value out of borders
				if($lngth >=12){
					if($lngth>=20 and $lngth<=22){
						$this->SetFont('Arial','',5.8);
					}else if($lngth>=17 and $lngth<=19){
						$this->SetFont('Arial','',6);
					}else if($lngth>=14 and $lngth<=16){
						$this->SetFont('Arial','',6.6);
					}else if($lngth>=12 and $lngth<=13){
						$this->SetFont('Arial','',7.8);
					}else{
						$this->SetFont('Arial','',8);
					}
				}else{
					$this->SetFont('Arial','',8);
				}
				$this->Cell($widths[3],5,$days_in.' '.$lngth,'LTBR',0,'C',false);
				$this->Ln(5);
				$index++;
			}
		}
		function print_all_status($data,$count){
			
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255);
			$this->SetTextColor(3);
			$widths = array(40,20,35,25);
			$aligns = array('C','C','C','C');	
			$border = array('LTB', 'LTB', 'LTB', 'LTBR');
			$header = array('serial','status','reference_no', 'date_in');			
			$index =1;
			foreach($data as $r){
				
				$this->Cell(10);
				$this->Cell(10,5,$index,'LTB',0,'C',false);
				for($i=0;$i<count($header);$i++){
					$value = $r[$header[$i]];
					$this->Cell($widths[$i],5,$value,$border[$i],0,$aligns[$i],true);
				}
				$this->Ln(5);
				$index++;
			}
		}

	}
	
	// Instanciation of inherited class
	//$pdf = new PDF('P','mm',array(100,170));
	$pdf = new PDF('P','mm','A5');
	$pdf->setLeftMargin(1);
	$pdf->SetTitle(full_date($dt).'-Summary');
	$pdf->setDateDeliver(shorten_date($dt));
	$pdf->setStatus($status);
	$pdf->setBrand($brand);
	
	//$query ="SELECT * FROM pcm_statistics_notrepaired WHERE brand=3";	
	$rs = $db->getResults($query);
	
	$pdf->setTotal(count($rs));
	$pdf->AddPage('P');
	$pdf->is_last_page = false;
	
	$pdf->printHeader();
	if(count($rs)){	
		if($status=='ALL'){
			$pdf->print_all_status($rs,count($rs));
		}else if($status=='REPAIRED'){
			$pdf->print_status_repaired($rs,count($rs));
		}else{		
			$pdf->print_status($rs,count($rs));
		}			
	}
	
	$pdf->is_last_page = true;
	$pdf->Ln();
	try{
		error_reporting(0);
		$pdf->Output(ATTACHMENTS.DS.'summary'.DS.$filename.'.pdf','F');
	}catch(Exception $e){
		
	}
	$pdf->Output();
?>