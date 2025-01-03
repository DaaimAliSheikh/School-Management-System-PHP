<?php include('../includes/config.php') ?>
<?php include('header.php') ?>
<?php include('sidebar.php') ?>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Profile</h1>
            </div><!-- /.col -->
         
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        
           
            <div class="col-lg-4">
            <!-- Info boxes -->
            <div class="card">
              <div class="card-header py-2">
                <h3 class="card-title">
                 Peronal details
                </h3>
              </div>
              <div class="card-body">
            
                 <table class="table table-bordered">
           
            <tbody>
                <?php
                $metaData = get_user_metadata($_GET['id']);
                foreach ($metaData as $key => $value): ?>
                    <tr>
                        <td><?= htmlspecialchars($key) ?></td>
                        <td><?= htmlspecialchars($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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