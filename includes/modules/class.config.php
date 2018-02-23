<?php

class Config
{
    private $dbh;
    private $config;

    public function __construct(\PDO $dbh)
    {
        $this->dbh = $dbh;

        $this->config = array();

        $query = $this->dbh->prepare("SELECT * FROM config");
        $query->execute();

        while($row = $query->fetch()) {
            $this->config[$row['setting']] = $row['value'];			
			
        }
    }

    public function __get($setting)
    {
        return $this->config[$setting];
    }

    public function __set($setting, $value)
    {
        $query = $this->dbh->prepare("UPDATE config SET value = ? WHERE setting = ?");

        if($query->execute(array($value, $setting))) {
            $this->config[$setting] = $value;
            return true;
        } else {
            return false;
        }
    }
	
	public function generateSettings(){
		$query = $this->dbh->prepare("SELECT * FROM config");
        $query->execute();
		
		$groups = array();
		$index=0;
		while($row = $query->fetch()) {
           
			$exgroup = explode('_',$row['setting']);
			$group =  $exgroup[0];
			if (!in_array($group, $groups)){
				$groups[] = $group;				
			}			
        }
		
		echo ' <ul class="nav nav-tabs m-b-n-xxs">';
		foreach($groups as $key =>$gr){
			$active = ($index===(count($groups)-1) ? 'class="active"': '');
			echo '<li '.$active.'>
					<a data-toggle="tab" href="#tab_'.$gr.'">'.ucwords($gr).'</span></a>
                </li>';
			$index = $index +1;
		}
		echo '</ul>';		
		echo '<div class="panel panel-default tab-content">';
        
		$index=0;
		foreach($groups as $k =>$group){
			$active = ($index===(count($groups)-1) ? 'active': '');
			echo '<ul class="list-group tab-pane '.$active.'" id="tab_'.$group.'" style="padding: 10px 50px 0px 50px;">';
			$query->execute();
		
			while($r = $query->fetch()) {
				$key= $r['setting'];
				$val= $r['value'];
				$typ= $r['type'];
				
				$exgroup = explode('_',$key);
				$grp =  $exgroup[0];
				$label =  empty($exgroup[1])? $grp: $exgroup[1];
				
				if($grp===$group){
					
					if($typ==='BOOLEAN'){						
						/*
						echo '<div class="form-group">
								<label class="col-sm-2 control-label">'.ucwords($label).'<span class="text-danger">   *</span></label>
								<div class="col-sm-2">
									<input type="text" class="form-control" data-required="true" id="'.$key.'" name="'.$key.'" value="'.$val.'">
								</div>
							</div>';
						*/
						/*
						echo '<div class="form-group">
								<label class="col-sm-2 control-label">'.ucwords($label).'<span class="text-danger">   *</span></label>
								<div class="col-sm-2">
									<button class="btn btn-default btn-success active" id="btn-1" href="#btn-1" data-toggle="class:btn-success"> 
										<i class="fa fa-cloud-upload text"></i> 
											<span class="text">Upload</span> 
										<i class="fa fa-check text-active"></i> 
											<span class="text-active">Success</span> 
									</button>
								</div>
							</div>';
						*/
						
						$check = ($val==='1') ? 'checked': '';
						echo '<div class="form-group">
								<label class="col-sm-2 control-label">'.ucwords($label).'<span class="text-danger">   *</span></label>
								<div class="col-sm-2">
									<label class="switch"><input type="checkbox" id="chk_'.$key.'" name="chk_'.$key.'" '.$check.' > <span></span></label>
									<input hidden type="hidden" id="'.$key.'" name="'.$key.'" value="'.$val.'"> 
								</div>
								
							</div>';
						
						
					}else{
						echo '<div class="form-group">
							<label class="col-sm-2 control-label">'.ucwords($label).'<span class="text-danger">   *</span></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" data-required="true" id="'.$key.'" name="'.$key.'" value="'.$val.'">
							</div>
						</div>';
					}
					
					
						

				}				
			}
			echo '</ul>';
			$index = $index +1;
		}
		
		echo '</div>';
	}
}

?>
