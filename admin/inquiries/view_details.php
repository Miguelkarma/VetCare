<style>
    body{
        font-family: "Abel", sans-serif;
  font-weight: 400;
  font-style: normal;
  }
</style>
<?php 
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `message_list` where id ='{$_GET['id']}' ");
    if($qry->num_rows > 0 ){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k=$v;
            }
        }
        if(isset($id) && isset($status) && $status != 1)
        $conn->query("UPDATE `message_list` set status = 1 where id = '{$id}'");
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <dl>
                <dt class="">Inquirer</dt>
                <dd class="pl-4"><?= isset($fullname) ? $fullname : "" ?></dd>
                <dt class="">Email</dt>
                <dd class="pl-4"><?= isset($email) ? $email : "" ?></dd>
                <dt class="">Contact Number</dt>
                <dd class="pl-4"><?= isset($contact) ? $contact : "" ?></dd>
                <dt class="">Message</dt>
                <dd class="pl-4"><?= isset($message) ? $message : "" ?></dd>
            </dl>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
            <button class="btn btn-flat btn-sm " type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
    </div>
</div>