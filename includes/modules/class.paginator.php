<?php
class Paginator {
 
    private $_db;
	private $_limit;
	private $_page;
	private $_query;
	private $_total;
	private $_start_pos;
	private $_end_pos;
	
	public function __construct($db, $query){
		$this->_db = $db;
		$this->_query = $query;
		
		$stmt = $this->_db->prepare($this->_query);
		$stmt->execute();
		$this->_total = $stmt->rowCount();
	}
	
	
	public function paging_query($query,$page, $limit){
		$this->_start_pos=0;
		
		if(isset($_GET["page"])){
			$this->_start_pos = ($_GET["page"]-1)*$limit;
		}
		
		$this->_end_pos= $this->_start_pos + $limit;
		
		$nquery =$query." limit ".$this->_start_pos." ,".$limit;
		return $nquery;
	}
	
	public function printRows($page, $query){
		$this->_limit = 10;
		$newquery = $this->paging_query($query,$page, $this->_limit);
		
		$this->_query  =$newquery;
		
		//echo $newquery.'   start pos: '.$this->_start_pos.' total: '.$this->_total;
		
		$stmt = $this->_db->prepare($query);
		$stmt->execute();
		$this->_total = $stmt->rowCount();
		
		
		//$this->printListRows($newquery);
		$rs = $this->_db->getResults( $newquery );
		return $rs;
	}
	
	
	public function pagination($self_page, $showPrevNext = true) {		
		$query =$this->_query;
		$self = $self_page;
		$stmt = $this->_db->prepare($query);
		$stmt->execute();
		$itemCount = $stmt->rowCount();
		$itemsPerPage=10;
		$adjacentCount=2;
		
		
		//if($itemCount >= $itemsPerPage){
			$firstPage = 1;
			//$lastPage  = ceil($itemCount / $itemsPerPage);
			$lastPage  = ceil($itemCount / $itemsPerPage)-1;
			
			if ($lastPage == 1) {
				return;
			}
			
			$currentPage=1;
			if(isset($_GET["page"])){
				$currentPage=$_GET["page"];
			}
			if ($currentPage <= $adjacentCount + $adjacentCount) {
				$firstAdjacentPage = $firstPage;
				$lastAdjacentPage  = min($firstPage + $adjacentCount + $adjacentCount, $lastPage);
			} elseif ($currentPage > $lastPage - $adjacentCount - $adjacentCount) {
				$lastAdjacentPage  = $lastPage;
				$firstAdjacentPage = $lastPage - $adjacentCount - $adjacentCount;
			} else {
				$firstAdjacentPage = $currentPage - $adjacentCount;
				$lastAdjacentPage  = $currentPage + $adjacentCount;
			}

			if ($firstAdjacentPage > $firstPage) {		
				echo '<a class="btn btn-flat waves-attach" href="'.$self.'&page=1"><span class="icon">chevron_left</span></a>';			
			}
			
			if ($showPrevNext) {
				if ($currentPage == $firstPage) {
					//echo '<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>';
				} else {
					echo '<a class="btn btn-flat waves-attach" href="'.$self.'&page='.($currentPage-1).'"><span class="icon">chevron_left</span></a>';
				}
			}
			
			if ($firstAdjacentPage > $firstPage + 1) {
				//echo '<li><a href="#">...</a></li>';
				echo '<a class="btn btn-flat waves-attach" href="'.$self.'&page='.($currentPage-3).'">...</a>';
			}
			
			
			/*
			if ($firstAdjacentPage > $firstPage) {		
				echo '<li><a href="'.$self.'&page_no=1"><i class="fa fa-step-backward"></i></a></li>';
				if ($firstAdjacentPage > $firstPage + 1) {
					echo '<li><a href="#">...</a></li>';
				}
			}
			*/
			
			for ($i = $firstAdjacentPage; $i <= $lastAdjacentPage; $i++) {
				if ($currentPage == $i) {
					echo '<a class="btn btn-flat waves-attach" href="'.$self.'&page='.$i.'">'.$i.'</a>';
				} else {
					echo '<a class="btn btn-flat waves-attach" href="'.$self."&page=".$i."'>".$i."</a>";
				}
			}
			
			/*
			if ($lastAdjacentPage < $lastPage) {
				if ($lastAdjacentPage < $lastPage - 1) {
					echo '<li><a href="#">...</a></li>';
				}
				
				echo '<li><a href="'.$self.'&page_no='.($lastPage).'"><i class="fa fa-step-forward"></i></a></li>';
			}
			*/
			
			if ($lastAdjacentPage < $lastPage - 1) {
				//echo '<li><a href="#">...</a></li>';
				echo '<a class="btn btn-flat waves-attach" href="'.$self.'&page='.($currentPage+3).'">...</a>';
			}
				
				
			if ($showPrevNext) {
				if ($currentPage == $lastPage) {
					//echo '<li><a href="#"><i class="fa fa-chevron-right"></i></a></li>';
				} else {
					if(($this->_total-$this->_start_pos)>=10){
						echo '<a class="btn btn-flat waves-attach" href="'.$self.'&page='.($currentPage+1).'"><span class="icon">chevron_right</span></a>';
					}else{
						
					}
					
				}
			}
			
			if ($lastAdjacentPage < $lastPage) {
				
				echo '<a class="btn btn-flat waves-attach" href="'.$self.'&page='.($lastPage).'"><span class="icon">chevron_right</span></a>';
			}
		//}
		
		
	}
	
	
	
	public function getData($limit = 10, $page =1){
		$this->_limit = $limit;
		$this->_page = $page;
		
		$query = $this->_query;
		if($this->_limit !=='all'){		
			$query = $this->_query . " LIMIT  ". ( ( $this->_page - 1 ) * $this->_limit ).", " . $this->_limit  ;
		}
		
		echo $query;
		$rs = $this->_db->getResults($query);
		//$stmt = $this->_db->prepare($query);
		//$stmt->execute();
		//$rs = $stmt->fetchAll();
		
		/*
		$result = array();
		foreach($rs as $r){
			$results[] = $r;
		}
		$result =new stdClass();		
		$result->page = $this->_page;
		$result->limit = $this->_limit;
		$result->total = $this->_total;
		$result->data = $results;
		*/
		return $rs;
		
	}
	
	public function createLinks($url, $links) {
		if ( $this->_limit == 'all'){
			return '';
		}	 
		$last       = ceil( $this->_total / $this->_limit );	 
		$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;	 
		$html       = '<div class="card-action-btn pull-right">';
	 
		$class      = ( $this->_page == 1 ) ? "disabled" : "";
		$html       .= '<a class="btn btn-flat waves-attach" href="'.$url.'?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a>';
		if ( $start > 1 ) {
			$html   .= '<a class="btn btn-flat waves-attach" href="'.$url.'?limit=' . $this->_limit . '&page=1">1</a>';
			$html   .= '<a class="btn btn-flat waves-attach"class="disabled"><span>...</span></a>';
		}	 
		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? "active" : "";
			$html   .= '<a class="btn btn-flat waves-attach" href="'.$url.'?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a>';
		}	 
		if ( $end < $last ) {
			$html   .= '<a class="btn btn-flat waves-attach disabled"><span>...</span></a>';
			$html   .= '<a class="btn btn-flat waves-attach" href="'.$url.'?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a>';
		}
	 
		$class      = ( $this->_page == $last ) ? "disabled" : "";
		$html       .= '<a class="btn btn-flat waves-attach" href="'.$url.'?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a>';	 
		$html       .= '</div>';
	 
		return $html;
	}
 
}