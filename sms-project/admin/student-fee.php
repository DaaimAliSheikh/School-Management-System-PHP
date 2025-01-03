<?php include('../includes/config.php') ?>
<?php include('header.php') ?>
<?php include('sidebar.php') ?>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Manage Student Fee Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Student Fee Details</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        
            <table class="table table-bordered" id="fee-table">
                <thead>
                    <tr>
                        <th>S.no.</th>
                        <th>Student Name</th>
                        <th>Last Payment</th>
                        <th>Due Payment</th>
                        <th>Fee Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $fees = get_all_fees();
                foreach ($fees as $index => $fee) : ?>
                    <tr>
                        <td><?= htmlspecialchars($fee->id) ?></td>
                        <td><?= htmlspecialchars($fee->student_name) ?></td>
                        <td><?= htmlspecialchars($fee->last_payment_date ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($fee->due_payment) ?></td>
                        <td><?= htmlspecialchars($fee->fee_status) ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-danger delete-row" ><i class="fa fa-trash"></i></a>
                            </td>
                    </tr>
                <?php endforeach; ?>
                  
                </tbody>
            </table>
            <div class="col-lg-4">
            <!-- Info boxes -->
            <div class="card">
              <div class="card-header py-2">
                <h3 class="card-title">
                  Add New Fee Voucher
                </h3>
              </div>
              <div class="card-body">
                <form action="" id="fee-registration" method="POST">
                  <div class="form-group" >
                    <label for="name">Student Name</label>
                    <input type="text" name="name" placeholder="name" required class="form-control">

                    <label for="last_payment">Last Payment Date</label>
                    <input type="text" name="last_payment" placeholder="last_payment" required class="form-control">

                    <label for="due_payment">Due Payment</label>
                    <input type="text" name="due_payment" placeholder="due_payment" required class="form-control">

                    <label for="fee_status">Fee Status</label>
                    <input type="text" name="fee_status" placeholder="fee_status" required class="form-control">
                  </div>
                  
                  <button name="submit" class="btn btn-success float-right">
                    Submit
                  </button>
                </form>
              </div>
            </div>
          </div>
    </div><!--/. container-fluid -->
</section>
<script>
jQuery('#fee-registration').on('submit', function() {
    if (true) {
      var formdata = jQuery(this).serialize();

      jQuery.ajax({
        type: "post",
        url: "http://localhost/sms-project/actions/fee-registration.php",
        data: formdata,
        dataType: 'json',
      
        complete: function() {
            location.reload();

        }
      });
    }
    return false;
  });

   // Event listener for Delete button
   jQuery('#fee-table').on('click', '.delete-row', function (e) {
        e.preventDefault();
        const row = jQuery(this).closest('tr'); // Get the row
        const rowId = row.find('td:first').text().trim();  // Unique row identifier
        // Send AJAX DELETE request
        jQuery.ajax({
            url: '../actions/delete-fee-row.php', // Update this to your delete endpoint
            type: 'DELETE',
            data: { serial: rowId },
            complete: function (response) {
              
                location.reload();
            },
            
        });
    })
</script>
<?php include('footer.php') ?>