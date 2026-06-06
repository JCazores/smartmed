<?php
require_once('../../config.php');

if (isset($_GET['id'])) {
    // Fix query to include record_type
    $qry = $conn->query("SELECT a.*, a.record_type FROM `admission_history` a 
                         WHERE a.id = '{$_GET['id']}'");
    
    if ($qry && $qry->num_rows > 0) {
        $res = $qry->fetch_assoc();
        // Assign the variables directly
        $date_admitted = isset($res['date_admitted']) ? $res['date_admitted'] : null;
        $date_discharged = isset($res['date_discharged']) ? $res['date_discharged'] : null;
        $record_type = isset($res['record_type']) ? $res['record_type'] : 'N/A'; // Set the record type
        $id = isset($res['id']) ? $res['id'] : null;  // Add the ID of the current record
        $patient_id = isset($res['patient_id']) ? $res['patient_id'] : null; // Add the patient ID
    } else {
        // Handle case where query has no result
        echo "Record not found.";
    }
}
?>

<style>
    #uni_modal .modal-footer {
        display: none;
    }
</style>

<div class="container-fluid">
    <dl>
        <dt class="text-primary"><b>Admission Date</b></dt>
        <dd class="pl-4"><?= isset($date_admitted) && !empty($date_admitted) ? date("Y-m-d H:i", strtotime($date_admitted)) : 'N/A' ?></dd>
        <dt class="text-primary"><b>Date Discharged</b></dt>
        <dd class="pl-4"><?= isset($date_discharged) && !empty($date_discharged) && strtotime($date_discharged) > 0 ? date("Y-m-d H:i", strtotime($date_discharged)) : 'N/A' ?></dd>
        <dt class="text-primary"><b>Record Type</b></dt>
        <dd class="pl-4"><?= $record_type ?></dd> <!-- Display record type here -->
    </dl>
    <div class="col-12 text-right">
        <?php if ($_settings->userdata('type') == 1): ?>
            <!-- Pass the id and patient_id correctly to the buttons -->
            <button class="btn btn-danger btn-flat btn-sm" id="delete_admission" data-id="<?= $id ?>"><i class="fa fa-trash"></i> Delete</button>
            <button class="btn btn-primary btn-flat btn-sm" id="edit_admission" data-id="<?= $id ?>" data-pid="<?= $patient_id ?>"><i class="fa fa-edit"></i> Edit</button>
        <?php endif; ?>
        <button class="btn btn-dark btn-flat btn-sm" type="button" data-dismiss='modal'><i class="fa fa-times"></i> Close</button>
    </div>
</div>

<script>
    $(function(){
        // Delete button functionality
        $('#uni_modal #delete_admission').click(function(){
            var id = $(this).data('id');  // Get the id from the button's data-id attribute
            _conf("Are you sure to delete this patient admission record history?", 'delete_admission', [id]);
        });

        // Edit button functionality
        $('#edit_admission').click(function(){
            var id = $(this).data('id');  // Get the id from the button's data-id attribute
            var patient_id = $(this).data('pid'); // Get the patient_id from the button's data-pid attribute
            uni_modal("Edit Record Details", "patients/manage_admission.php?pid=" + patient_id + "&id=" + id, 'mid-large');
        });
    });

    function delete_admission(id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_patient_admission",
            method:"POST",
            data:{id: id},  // Pass the correct id
            dataType:"json",
            error:err=>{
                console.log(err);
                alert_toast("An error occurred.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp === 'object' && resp.status === 'success'){
                    location.reload(); // Reload the page after deletion
                }else{
                    alert_toast("An error occurred.",'error');
                    end_loader();
                }
            }
        });
    }
</script>
