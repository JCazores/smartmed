<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT p.*, d.fullname as doctor FROM `patient_history` p 
                         INNER JOIN `doctor_list` d ON p.doctor_id = d.id 
                         WHERE p.id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)) $$k = $v;
        }
    }
}
?>


<style>
    #uni_modal .modal-footer{
        display:none;
    }
    /* Container that holds the image */
#zoom-container {
    display: flex;                /* Enable Flexbox */
    justify-content: center;      /* Center horizontally */
    align-items: center;          /* Center vertically */
    height: 100%;                 /* Ensure the container takes full height */
    position: relative;           /* Relative positioning to allow for zooming effect */
}

#zoom-image {
    max-width: 300px;             /* Max width to prevent the image from becoming too large */
    cursor: zoom-in;              /* Change cursor to indicate zooming is possible */
    transition: transform 0.3s ease; /* Smooth zoom transition */
}

#zoom-image.zoomed {
    transform: scale(2);          /* Apply zoom effect when clicked */
    cursor: zoom-out;             /* Change cursor to indicate zoom out */
}

</style>
<div class="container-fluid">
    <dl>
        <dt class="text-primary"><b>X-ray Image</b></dt>
        <dd class="pl-4">
            <?php if (isset($xray_image) && !empty($xray_image)): ?>
                <img id="zoom-image" src="../../uploads/xray_images/<?= $xray_image ?>" alt="X-ray Image" class="img-fluid" style="max-width: 300px;"/>
            <?php else: ?>
                N/A
            <?php endif; ?>
        </dd>
        <dt class="text-primary"><b>Illness</b></dt>
        <dd class="pl-4"><?= isset($illness) && !empty($illness) ? $illness : 'N/A' ?></dd>
        <dt class="text-primary"><b>Diagnosis</b></dt>
        <dd class="pl-4"><?= isset($diagnosis) && !empty($diagnosis) ? $diagnosis : 'N/A' ?></dd>
        <dt class="text-primary"><b>Treatment</b></dt>
        <dd class="pl-4"><?= isset($treatment) && !empty($treatment) ? $treatment : 'N/A' ?></dd>
        <dt class="text-primary"><b>Assigned Doctor</b></dt>
        <dd class="pl-4"><?= isset($doctor) && !empty($doctor) ? $doctor : 'N/A' ?></dd>
        <dt class="text-primary"><b>Remarks</b></dt>
        <dd class="pl-4"><?= isset($remarks) && !empty($remarks) ? $remarks : 'N/A' ?></dd>
    </dl>
    <div class="col-12 text-right">
        <?php if($_settings->userdata('type') == 1): ?>
            <button class="btn btn-danger btn-flat btn-sm" id="delete_history"><i class="fa fa-trash"></i> Delete</button>
            <button class="btn btn-primary btn-flat btn-sm" id="edit_history"><i class="fa fa-edit"></i> Edit</button>
        <?php endif; ?>
        <button class="btn btn-dark btn-flat btn-sm" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>

<script>
    $(function(){
        // Confirm deletion of history
        $('#delete_history').click(function(){
            _conf("Are you sure you want to delete this patient record history?", 'delete_history', ['<?= isset($id) ? $id : '' ?>']);
        });

        // Open edit modal with correct parameters
        $('#edit_history').click(function(){
            uni_modal("Edit Record Details", "patients/manage_history.php?pid=<?= isset($patient_id) ? $patient_id : '' ?>&id=<?= isset($id) ? $id : '' ?>", 'mid-large');
        });
    });

    // Function to delete patient history
    function delete_history(id){
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_patient_history",
            method: "POST",
            data: {id: id},
            dataType: "json",
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    location.reload();  // Reload the page after successful deletion
                } else {
                    alert_toast("An error occurred while deleting.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        var zoomed = false;

        // Trigger zoom effect on click
        $('#zoom-image').click(function() {
            if (!zoomed) {
                $(this).addClass('zoomed');  // Apply zoom
                zoomed = true;
            } else {
                $(this).removeClass('zoomed'); // Reset zoom
                zoomed = false;
            }
        });

        // Optional: Show zoom window when clicked (for extra zoom effect)
        $('#zoom-image').click(function() {
            var img = $(this);
            var imgOffset = img.offset();
            var imgWidth = img.width();
            var imgHeight = img.height();

            var zoomWindow = $('<div class="zoom-window"></div>').appendTo('body');

            // Move the zoom window with mouse position
            $(document).mousemove(function(e) {
                var mouseX = e.pageX - imgOffset.left;
                var mouseY = e.pageY - imgOffset.top;
                var xPos = (mouseX / imgWidth) * 100;
                var yPos = (mouseY / imgHeight) * 100;

                zoomWindow.css({
                    top: mouseY - 150, // Adjust the position as necessary
                    left: mouseX - 150, // Adjust the position as necessary
                    background: 'url(' + img.attr('src') + ') no-repeat ' + xPos + '% ' + yPos + '%',
                    backgroundSize: imgWidth * 2 + 'px ' + imgHeight * 2 + 'px', // Zoom level
                    display: 'block'
                });
            });

            // Hide the zoom window when mouse moves out
            img.mouseleave(function() {
                zoomWindow.remove();
                $(document).off('mousemove');
            });
        });
    });
</script>
