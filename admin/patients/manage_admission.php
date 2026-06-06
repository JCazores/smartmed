<?php
require_once('../../config.php');
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `admission_history` WHERE id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k)) $$k = $v;
        }
    }
}
?>
<style>
    #cimg {
        object-fit: scale-down;
        object-position: center center;
        height: 200px;
        width: 200px;
    }
</style>
<div class="container-fluid">
    <form action="" id="patient-history-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="patient_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">

        <div class="row">
            <div class="form-group col-md-12">
                <label for="record_type" class="control-label">Record Type</label>
                <div>
                    <label class="mr-3">
                        <input type="radio" name="record_type" value="confinement" 
                            <?php echo (isset($record_type) && $record_type == 'confinement') ? 'checked' : ''; ?> required> Confinement
                    </label>
                    <label>
                        <input type="radio" name="record_type" value="checkup" 
                            <?php echo (isset($record_type) && $record_type == 'checkup') ? 'checked' : ''; ?> required> Check-up
                    </label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="date_admitted" class="control-label">Admission Date</label>
                <input type="datetime-local" name="date_admitted" id="date_admitted" class="form-control form-control-border" 
                       value="<?= isset($date_admitted) ? date("Y-m-d\TH:i", strtotime($date_admitted)) : "" ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="date_discharged" class="control-label">Date Discharged</label>
                <input type="datetime-local" name="date_discharged" id="date_discharged" class="form-control form-control-border" 
                       value="<?= isset($date_discharged) && strtotime($date_discharged) > 0 ? date("Y-m-d\TH:i", strtotime($date_discharged)) : "" ?>">
            </div>
        </div>
    </form>
</div>
<script>
    $(function () {
        $('#uni_modal').on('shown.bs.modal', function () {
            $(".select2").select2({
                placeholder: "Please Select Here",
                width: '100%',
                dropdownParent: $('#uni_modal')
            });
        });

        $('#uni_modal #patient-history-form').submit(function (e) {
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();
            start_loader();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_patient_admission",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function (resp) {
                    if (resp.status == 'success') {
                        location.reload();
                    } else if (!!resp.msg) {
                        el.addClass("alert-danger");
                        el.text(resp.msg);
                        _this.prepend(el);
                    } else {
                        el.addClass("alert-danger");
                        el.text("An error occurred due to unknown reason.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    $('html,body,.modal').animate({ scrollTop: 0 }, 'fast');
                    end_loader();
                }
            });
        });
    });
</script>
