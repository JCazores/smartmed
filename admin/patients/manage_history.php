<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `patient_history` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    #cimg{
        object-fit:scale-down;
        object-position:center center;
        height:200px;
        width:200px;
    }
</style>
<div class="container-fluid">
    <form action="" id="patient-history-form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="patient_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
        
        <!-- Illness Information -->
        <div class="row">
            <div class="form-group col-md-12">
                <label for="illness" class="control-label">Illness Information</label>
                <textarea rows="3" name="illness" id="illness" class="form-control form-control-sm rounded-0" required><?php echo isset($illness) ? $illness : '' ?></textarea>
            </div>
        </div>

        <!-- Diagnosis Information -->
        <div class="row">
            <div class="form-group col-md-12">
                <label for="diagnosis" class="control-label">Diagnosis Information</label>
                <textarea rows="3" name="diagnosis" id="diagnosis" class="form-control form-control-sm rounded-0"><?php echo isset($diagnosis) ? $diagnosis : '' ?></textarea>
            </div>
        </div>

        <!-- Treatment Information -->
        <div class="row">
            <div class="form-group col-md-12">
                <label for="treatment" class="control-label">Treatment Information</label>
                <textarea rows="3" name="treatment" id="treatment" class="form-control form-control-sm rounded-0"><?php echo isset($treatment) ? $treatment : '' ?></textarea>
            </div>
        </div>

        <!-- Assigned Doctor -->
        <div class="row">
            <div class="form-group col-lg-6 col-md-8 cols-sm-12">
                <label for="doctor_id" class="control-label">Assigned Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control form-control-border select2">
                    <option value="" disabled <?= !isset($doctor_id) ? "selected" : "" ?>></option>
                    <?php 
                    $qry = $conn->query("SELECT * FROM `doctor_list` where delete_flag = 0 ".(isset($doctor_id) ? " or id = '{$doctor_id}' " : "")." order by `fullname` asc ");
                    while($row = $qry->fetch_assoc()):
                    ?>
                        <option <?= $row['delete_flag'] == 1 ? "disabled" : "" ?> <?= isset($doctor_id) && $doctor_id == $row['id'] ? "selected" : '' ?> value="<?= $row['id'] ?>"><?= $row['fullname'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <!-- Remarks Information -->
        <div class="row">
            <div class="form-group col-md-12">
                <label for="remarks" class="control-label">Remarks</label>
                <textarea rows="3" name="remarks" id="remarks" class="form-control form-control-sm rounded-0"><?php echo isset($remarks) ? $remarks : '' ?></textarea>
            </div>
        </div>

        <!-- Image Upload -->
        <div class="row">
            <div class="form-group col-md-12">
                <label for="xray_image" class="control-label">Upload X-ray Image</label>
                <input type="file" name="xray_image" id="xray_image" class="form-control form-control-sm rounded-0" accept="image/*">
                <?php if (isset($xray_image) && !empty($xray_image)): ?>
                    <div class="mt-2">
                        <img id="cimg" src="<?= $xray_image ? '../../uploads/xray_images/' . $xray_image : '' ?>" alt="X-ray Image"/>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

<script>
    $(function(){
        $('#uni_modal').on('shown.bs.modal', function(){
            $(".select2").select2({
                placeholder: "Please Select Here",
                width: '100%',
                dropdownParent: $('#uni_modal')
            });
        });

        $('#patient-history-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>').addClass("pop-msg alert").hide();
            start_loader();
            
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_patient_history",
                data: new FormData($(this)[0]), // Use FormData to handle file upload
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    } else {
                        el.addClass("alert-danger").text(resp.msg || "An error occurred due to unknown reasons.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    $('html, body, .modal').animate({scrollTop: 0}, 'fast');
                    end_loader();
                }
            });
        });
    });
</script>
