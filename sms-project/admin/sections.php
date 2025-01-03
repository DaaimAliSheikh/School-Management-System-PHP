<?php include('../includes/config.php') ?>
<?php include('header.php') ?>
<?php include('sidebar.php') ?>

<?php

  if(isset($_POST['submit']))
  {
    $title = $_POST['title'];

    $query = mysqli_query($db_conn, "INSERT INTO `posts`(`author`, `title`, `description`, `type`, `status`,`parent`) VALUES ('1','$title','description','section','publish',0)") or die('DB error');
  }

?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Sections</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Sections</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class='col-lg-8'>
            
            <!-- Info boxes -->
            <div class="card">
              <div class="card-header py-2">
                <h3 class="card-title">
                  Sections
                </h3>
                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive bg-white">
                  <table class="table table-bordered" id="sections-table">
                    <thead>
                      <tr>
                        <th>S.No.</th>
                        <th>Title</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <!-- Info boxes -->
            <div class="card">
              <div class="card-header py-2">
                <h3 class="card-title">
                  Add New Section
                </h3>
              </div>
              <div class="card-body">
                <form action="" id="section-registration" method="POST">
                  <div class="form-group" >
                    <label for="title">Title</label>
                    <input type="text" name="title" placeholder="Title" required class="form-control">
                  </div>
                  
                  <button name="submit" class="btn btn-success float-right">
                    Submit
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>   

      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

<script>
  jQuery(document).ready(function(){
    const table= jQuery('#sections-table').DataTable({
      searching: false,
      ajax: {
        url: 'sections-data.php',
        type: 'POST'
      },
      columns: [
          { data: 'serial' },
          { data: 'title' },
          { data: 'action' ,orderable: false}
      ],
      processing: true,
      serverSide: true,
      
    });
    // Event listener for Edit button
    let row_clicked = false;
    jQuery('#sections-table').on('click', '.edit-row', function (e) {
        e.preventDefault();
        const row = jQuery(this).closest('tr'); // Get the row
        const rowData = table.row(row).data(); // Get the row data from DataTables
        const rowId = jQuery(this).data('id'); // Unique row identifier

        // Convert row cells to editable inputs
        if(!row_clicked){
          
        row.find('td').each(function (index) {
            if (index < 2 && index > 0) { // Exclude the action column
                const originalValue = jQuery(this).text();
                jQuery(this).html(`<input type="text" class="form-control edit-input" value="${originalValue}" />`);
            }
        });
      }
      row_clicked = true;

        // Handle Enter key press to save
        row.on('keydown', 'input.edit-input', function (event) {

            if (event.key === 'Enter') {
               row_clicked = false;
              
                const updatedData = {
                    serial: row.find('td:eq(0)').text(),
                    title: row.find('td:eq(1) input').val(),
                };
                // Send AJAX PATCH request
                jQuery.ajax({
                    url: '../actions/update-section-data.php', // Update this to your update endpoint
                    type: 'PATCH',
                    data: updatedData,
                    success: function (response) {
                        // Replace inputs with updated values
                        row.find('td').each(function (index) {
                            if (index < 2 && index > 0) { // Exclude the action column
                                const inputValue = jQuery(this).find('input').val();
                                jQuery(this).html(inputValue);
                            }
                        });
                        // Optionally reload the table to reflect changes
                        table.ajax.reload(null, false); // Reload without resetting pagination
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                   
                });
            }
        });

    })

    // Event listener for Delete button
    jQuery('#sections-table').on('click', '.delete-row', function (e) {
        e.preventDefault();
        const row = jQuery(this).closest('tr'); // Get the row
        const rowData = table.row(row).data(); // Get the row data from DataTables
        const rowId = jQuery(this).data('id'); // Unique row identifier
        // Send AJAX DELETE request
        jQuery.ajax({
            url: '../actions/delete-section-row.php', // Update this to your delete endpoint
            type: 'DELETE',
            data: { serial: rowId },
            success: function (response) {
                // Optionally reload the table to reflect changes
                table.ajax.reload(null, false); // Reload without resetting pagination
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    })
  })
  jQuery('#section-registration').on('submit', function() {
    if (true) {
      var formdata = jQuery(this).serialize();

      jQuery.ajax({
        type: "post",
        url: "http://localhost/sms-project/actions/section-registration.php",
        data: formdata,
        dataType: 'json',
        complete: function() {
          location.reload();
        }
      
      });
    }
    return false;
  });
</script>
<?php include('footer.php') ?>
