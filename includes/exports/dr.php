<?php
	require_once('mc_table.php');
	require_once('../setup.php');
	$dt = decode_url((isset($_GET['dt']) && $_GET['dt'] != '') ? $_GET['dt'] : '');
	$st = decode_url((isset($_GET['st']) && $_GET['st'] != '') ? $_GET['st'] : '');
	$bt = decode_url((isset($_GET['bt']) && $_GET['bt'] != '') ? $_GET['bt'] : '');
	$rt = decode_url((isset($_GET['rt']) && $_GET['rt'] != '') ? $_GET['rt'] : '');
	$sp = decode_url((isset($_GET['sp']) && $_GET['sp'] != '') ? $_GET['sp'] : '0');
	$tb = decode_url((isset($_GET['tb']) && $_GET['tb'] != '') ? $_GET['tb'] : '');
	
	$table = str_replace('pcm_view_','pcm_delivery_',$tb);
	$status = $db->getValue('pcm_status','status','id='.$st);
	$brand  = $db->getValue('pcm_brands','brand_name','id='.$bt);
	$requisitioner  = $db->getValue('pcm_requisitioners','requisitioner','id='.$rt);
	$tin  = $db->getValue('pcm_requisitioners','tin','id='.$rt);
	$address  = $db->getValue('pcm_requisitioners','address','id='.$rt);
	$company =$requisitioner;
	
	$filename = force_date($dt).'_'.remove_unwanted_char($requisitioner).'_'.remove_unwanted_char($brand).'_'.remove_unwanted_char($status).'_'.$sp;
	class PDF extends FPDF{
		private $date_delivered;
		private $report_company;
		private $requisitioner;
		private $address;
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

		function setAddress($address){
			$this->address = $address;
		}
		function setTin($tin){
			$this->tin = $tin;
		}
		// Page header
		function Header(){
			
			
			$this->Ln(23);
			// First line
			$this->SetFont('Arial','',8);			
			$this->Cell(28);		
			$this->Cell(88,6,$this->report_company,$this->borders,0,'L',false);
			$this->Cell(20,6,$this->date_delivered,$this->borders,0,'L',false);
			$this->Ln(6);
			
			//Second Line	
			$this->Cell(28);
			$this->Cell(85,6,$this->tin,$this->borders,0,'L',false);
			$this->Ln(6);
			
			// Third Line
			$this->Cell(28);
			$this->Cell(85,6,$this->address,$this->borders,0,'L',false);
			$this->Ln();
		
			

		}
		function print_dr($data,$count,$sp,$brand,$status){
			$unit = ($count >1)? 'PCS': 'PC';
			$sp = (empty($sp))? '': '-'.$sp;
			$this->Ln(16);
			$this->Cell(35);
			$this->SetFont('Arial','B',9);
			$this->Cell(50,6,$brand.' ('.$status.')'.$sp,$this->borders,0,'L',false);			
			$this->Ln(6);
			
			$this->SetFont('Arial','',8);
			$this->Cell(20,6,$count,$this->borders,0,'C',false);		
			$this->Cell(15,6,$unit,$this->borders,0,'C',false);	
			$this->Cell(80,6,'',$this->borders,0,'C',false);
			$this->Ln(6);
			
			
			foreach($data as $r){
				$serial = $r['serial'];
				$this->Cell(35);
				$this->SetFont('Arial','',7);
				$this->Cell(7,6,'S/N:',$this->borders,0,'L',false);
				$this->SetFont('Arial','',8);
				$this->Cell(80,6,$serial,$this->borders,0,'L',false);
				$this->Ln(6);
			}
		}

	}
	
	// Instanciation of inherited class
	//$pdf = new PDF('P','mm',array(100,170));
	$pdf = new PDF('P','mm','A5');
	$pdf->setLeftMargin(1);
	$pdf->SetTitle(full_date($dt).'-DR');
	$pdf->setCompany($company);
	$pdf->setDateDeliver(shorten_date($dt));
	$pdf->setRequisitioner($requisitioner);
	$pdf->setAddress($address);
	$pdf->setTin($tin);
	$pdf->is_last_page = false;
	$pdf->AddPage('P');
	
	$rs = $db->getResults('SELECT * FROM '.$tb);
	if(count($rs)){
		$pdf->print_dr($rs,count($rs),$sp,$brand,$status);
		foreach($rs as $r){
			$id = $r['id'];
			$data['dr'] ='attachments/drs/'.$filename.'.pdf';
			if($db->exist($table,'serial_id',$id)){
				$db->update($table,$data,'serial_id='.$id);
			}
		}
	}	
	
	$pdf->is_last_page = true;
	$pdf->Ln();
	try{
		error_reporting(0);
		$pdf->Output(ATTACHMENTS.DS.'drs'.DS.$filename.'.pdf','F');
	}catch(Exception $e){
		
	}
	$pdf->Output();
?>