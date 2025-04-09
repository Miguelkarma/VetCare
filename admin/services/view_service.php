<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `service_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
$cat_arr = [];
if(!empty($category_ids)){
    $categories = $conn->query("SELECT * FROM `category_list` where id in ({$category_ids})");
    $cat_arr= array_column($categories->fetch_all(MYSQLI_ASSOC),'name','id');
}
$for = '';
foreach(explode(',',$category_ids) as $v){
    if(isset($cat_arr[$v])){
        if(!empty($for)) $for .= ", ";
        $for.= $cat_arr[$v];
    }
}
if(empty($for)){
    $for = "N/A";
}

?>
<style>
    #uni_modal .modal-footer{
        display:none !important;
    }
    body{
        font-family: "Abel", sans-serif;
  font-weight: 400;
  font-style: normal;
  }
</style>
<div class="container-fluid">
    <dl>
        <dt class="">Service</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($name) ? $name : '' ?></dd>
        <dt class="">Service For:</dt>
        <dd class='pl-4'>
            <p class=""><small><?= isset($for) ? ($for) : '' ?></small></p>
        </dd>
        <dt class="">Description</dt>
        <dd class='pl-4'>
            <p class=""><small><?= isset($description) ? html_entity_decode($description) : '' ?></small></p>
        </dd>
        <dt class="">Fee</dt>
        <dd class='pl-4 fs-4 fw-bold'><?= isset($fee) ? number_format($fee,2) : '0.00' ?></dd>
    </dl>
    <div class="col-12 text-right">
        <button class="btn btn-flat btn-sm btn-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>