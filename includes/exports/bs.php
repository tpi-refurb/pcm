<?php
	require_once('mc_table.php');
	require_once('../setup.php');
	
	$filename = "bs_".date("Y-m-d");
	
	class PDF extends FPDF{		
		public $is_last_page = false;
		//public $borders ='LTRB';
		public $borders ='';
	
		// Page header
		function Header(){
			$this->Ln(6);	
			
			$widths = array(10,70,15,15,15);
			$aligns = array('C','C','C','C','C');
			$bolds = array('B','B','B','B','B');	
			$border = array('LTB','LTB', 'LTB', 'LTB', 'LTBR');
			$header = array('NO','Brand/Model', 'Total','Repaired', 'Un-Repair');
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(66);
			$this->SetTextColor(255);		
			
			$this->Cell(10);
			for($i=0;$i<count($header);$i++){
				$this->Cell($widths[$i],5,$header[$i],$border[$i],0,$aligns[$i],true);
			}
			$this->Ln(5);
		}
		
		function print_row($index, $brand, $total, $repaired, $under_repair){
			
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255);
			$this->SetTextColor(3);
			$widths = array(10,70,15,15,15);
			$aligns = array('C','C','C','C','C');
			$bolds = array('B','B','B','B','B');	
			$border = array('LTB','LTB', 'LTB', 'LTB', 'LTBR');
			$this->Cell(10);
			$this->Cell($widths[0],5,$index,$border[0],0,$aligns[0],true);
			$this->set_fontbrand($brand);
			$this->Cell($widths[1],5,$brand,$border[1],0,$aligns[1],true);
			$this->SetFont('Arial','',8);
			$this->Cell($widths[2],5,$total,$border[2],0,$aligns[2],true);
			$this->Cell($widths[3],5,$repaired,$border[3],0,$aligns[3],true);
			$this->Cell($widths[4],5,$under_repair,$border[4],0,$aligns[4],true);
			
			$this->Ln(5);
		}
		
		function set_fontbrand($brand){
			$lngth = intval(strlen($brand));
			if($lngth>=39 and $lngth<=40){
				$this->SetFont('Arial','',7);
			}else if($lngth>=41 and $lngth<=42){
				$this->SetFont('Arial','',6.8);
			}else if($lngth>=43 and $lngth<=44){
				$this->SetFont('Arial','',6.4);
			}else if($lngth>=45 and $lngth<=46){
				$this->SetFont('Arial','',5.8);
			}else if($lngth>=47 and $lngth<=49){
				$this->SetFont('Arial','',5);
			}else if($lngth>=50 and $lngth<=52){
				$this->SetFont('Arial','',4.6);
			}else if($lngth>=53 and $lngth<=55){
				$this->SetFont('Arial','',4);
			}else{
				$this->SetFont('Arial','',8);
			}
		}
	}
	
	// Instanciation of inherited class
	//$pdf = new PDF('P','mm',array(100,170));
	$pdf = new PDF('P','mm','A5');
	$pdf->setLeftMargin(1);
	$pdf->SetTitle('Brand Summary');
	$pdf->AddPage('P');
	$pdf->is_last_page = false;
	
	$bran_query ="SELECT * FROM pcm_brands ORDER BY brand_name ASC";
	$rs = $db->getResults($bran_query);
	$index=1;
	foreach($rs as $r){
		$id= $r['id'];
		$brand_name= $r['brand_name'];
		$total_query ="SELECT * FROM pcm_list WHERE active =1 AND brand=".$id;
		$repaired_query ="SELECT * FROM pcm_statistics_repaired WHERE brand=".$id;
		$for_repair_query ="SELECT * FROM pcm_statistics_notrepaired WHERE brand=".$id;

		$summary_link = 'index.php?p='.encode_url('23').'&s='.encode_url('v').'&l='.encode_url('Brands').'&i='.encode_url($id);
		$total_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('All '.$brand_name).'&b='.encode_url($id).'&pss='.encode_url("ALL").'&i='.encode_url($total_query);
		$repair_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('Repaired '.$brand_name).'&b='.encode_url($id).'&pss='.encode_url("REPAIRED").'&i='.encode_url($repaired_query);
		$forrepair_link = 'index.php?p='.encode_url('11').'&s='.encode_url('v').'&l='.encode_url('For Repair '.$brand_name).'&b='.encode_url($id).'&pss='.encode_url("UNDER REPAIR").'&i='.encode_url($for_repair_query);

		$total          = $db->getResults($total_query);
		$repaired       = $db->getResults($repaired_query);
		$under_repair   = $db->getResults($for_repair_query);
		
		$pdf->print_row($index,$brand_name,count($total),count($repaired),count($under_repair));
		$index++;
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