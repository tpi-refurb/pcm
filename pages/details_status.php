<?php
/**
 * Created by PhpStorm.
 * User: TARSIER
 * Date: 11/26/2016
 * Time: 11:04 AM
 */

$serial = $sn;
$status_id =
$status =
$technician =
$date_repaired =
$repaired_portion =
$replaced_parts = '';


    if(!empty($id)){
        $rs = $db->getResults("SELECT * FROM pcm_list WHERE id =".$id);
        if(count($rs) >0){
            foreach($rs as $r){
                $serial = $r['serial'];
                $date_repaired = $r['date_repaired'];
                $repaired_portion = $r['repaired_portion'];
                $replaced_parts = $r['replaced_parts'];
                $status_id = $r['status_id'];
                $status = $r['status'];
                $technician = $r['firstname'].' '.$r['lastname'];
            }
        }
        if(empty($replaced_parts)){
            $replaced_parts = $db->getLastValue('pcm_repair_history','repairs_done','serial_id='.$id, 'id');
        }
        if(empty($date_repaired)){
            $date_repaired = $db->getLastValue('pcm_repair_history','date_done','serial_id='.$id, 'id');
        }
    }
$status_link = 'index.php?p='.encode_url('11').'&s='.encode_url('u').'&i='.encode_url($id).'&sn='.encode_url($serial);
?>

<div class="content">
    <div class="content-heading">
        <div class="container container-full">
            <h1 class="heading"><?php echo $title; ?></h1>
        </div>
    </div>
    <div class="content-inner">
        <div class="container container-full">
            <div class="row row-fix">
                    <div class="col-md-8">
                        <form id="changestatus_form" class="form">
                            <input hidden type="hidden" id="r" name="r" value="<?php echo 'index.php?p='.encode_url('11');?>">
                            <input hidden type="hidden" id="s" name="s" value="<?php echo encode_url('cs'); ?>">
                            <input hidden type="hidden" id="i" name="i" value="<?php echo encode_url($id); ?>">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-label">Technician:</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="form-control-static"><strong class="text-alt"><?php echo $technician;?></strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-label">Remark:</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="form-control-static"><strong class="text-alt"><?php echo $status;?></strong></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-label">Date Repaired:</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="form-control-static"><strong class="text-alt"><?php echo $date_repaired;?></strong></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-label">Repaired Portion:</label>
                                    </div>
                                    <div class="col-lg-4">
                                        <p class="form-control-static"><strong class="text-alt"><?php echo $repaired_portion;?></strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-label">Replaced Parts:</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="form-control-static"><strong class="text-alt"><?php echo $replaced_parts;?></strong></p>
                                    </div>
                                </div>
                            </div>

                            <?php if($global_isAdmin){ ?>
                            <div class="form-group-btn">
                                <div class="row">
                                    <div class="col-lg-8 col-lg-4 col-lg-push-2 col-md-6 col-md-push-3 col-sm-8 col-sm-push-4">
                                        <a class="btn btn-alt waves-button waves-effect waves-light pull-right"  href="<?php echo $status_link; ?>"><span class="icon icon-edit"></span>Edit</a>
                                        <a class="btn btn-flat waves-button waves-effect waves-light pull-right"  href="javascript: history.go(-1)"><span class="icon icon-arrow-back"></span>Back</a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                        </form>

                    </div>
                    <div class="col-md-3 col-md-4 content-fix">
                        <div class="content-fix-scroll">
                            <div class="content-fix-wrap">
                                <div class="content-fix-inner">
                                    <?php if($is_mobile) { ?>
                                        <p><a class="btn btn-block btn-alt collapsed waves-button waves-effect" data-toggle="collapse" href="#collapsible-region"><span class="collapsed-hide">Hide Info</span><span class="collapsed-show">Show Info...</span></a></p>
                                        <div class="collapsible-region collapse" id="collapsible-region">
                                            <?php $units->print_item_info($id,$global_isAdmin, 'logs'); ?>
                                        </div>
                                    <?php }else { ?>
                                        <h2 class="content-sub-heading"><strong class="text-black"><?php echo $serial;?></strong> Information</h2>
                                        <?php $units->print_item_info($id,$global_isAdmin, 'logs'); ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </div>
</div>
