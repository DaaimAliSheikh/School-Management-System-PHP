<?php include('../includes/config.php') ?>
<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>

<?php
if (isset($_POST['submit'])) {
  $title = $_POST['title'];

  $sections = $_POST['section'];
  // $added_date = date('Y-m-d');
  $query = mysqli_query($db_conn, "INSERT INTO `posts`(`author`, `title`, `description`, `type`, `status`,`parent`) VALUES ('1','$title','description','class','publish',0)") or die('DB error');

  if($query)
  {
    $post_id = mysqli_insert_id($db_conn);
  }
  foreach ($sections as $key => $value) {
    mysqli_query($db_conn, "INSERT INTO `metadata` (`item_id`,`meta_key`,`meta_value`) VALUES ('$post_id','section','$value')") or die(mysqli_error($db_conn));
  }
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Manage Classes</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="">Admin</a></li>
          <li class="breadcrumb-item active">Classes</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Info boxes -->
    <?php
    if (isset($_REQUEST['action'])) { ?>
      <div class="card">
        <div class="card-header py-2">
          <h3 class="card-title">
            Add New class</h3>
        </div>
        <div class="card-body">
          <form action="" id="class-registration" method="POST">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" name="title" id="title" placeholder="Title" required class="form-control">
            </div>
            <div class="form-group">
              <label for="title">Sections</label>
              <?php
              
              $sections = get_sections();
              foreach ($sections as $index => $title) {
                 ?>
                <div>
                  <label for="<?php echo $title ?>">
                  <input type="checkbox" name="sections[]" value="<?php echo strtoupper(str_replace('Section ', '', $title)); ?>">
                    <?php echo $title?>
                  </label>
                </div>
              <?php
              } ?>
            </div>
            <button name="submit" class="btn btn-success">Submit</button>
          </form>
        </div>
      </div>
    <?php } else { ?>
      <div class="card">
        <div class="card-header py-2">
          <h3 class="card-title">Classes</h3>
          <div class="card-tools">
            <a href="?action=add-new" class="btn btn-success btn-xs"><i class="fa fa-plus mr-2"></i>Add New</a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive bg-white">
            <table class="table table-bordered" id="classes-table">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Name</th>
                  <th>section</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              
            </table>
          </div>

        </div>
      </div>
    <?php } ?>
  </div>
</section>

<script>
  jQuery(document).ready(function(){
    const table= jQuery('#classes-table').DataTable({
      searching: false,

      ajax: {
        url: 'classes-data.php',
        type: 'POST'
      },
      columns: [
          { data: 'serial' },
          { data: 'title' },
          { data: 'sections' },
          { data: 'added-date' },
          { data: 'action' ,orderable: false}
      ],
      processing: true,
      serverSide: true,
      
    });
    // Event listener for Edit button
    let row_clicked = false;
    jQuery('#classes-table').on('click', '.edit-row', function (e) {
        e.preventDefault();
        const row = jQuery(this).closest('tr'); // Get the row
        const rowData = table.row(row).data(); // Get the row data from DataTables
        const rowId = jQuery(this).data('id'); // Unique row identifier

        // Convert row cells to editable inputs
        if(!row_clicked){
          
        row.find('td').each(function (index) {
            if (index < 4 && index > 0) { // Exclude the action column
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
                    sections: row.find('td:eq(2) input').val(),
                    added_date: row.find('td:eq(3) input').val()
                };
                // Send AJAX PATCH request
                jQuery.ajax({
                    url: '../actions/update-class-data.php', // Update this to your update endpoint
                    type: 'PATCH',
                    data: updatedData,
                    success: function (response) {
                        // Replace inputs with updated values
                        row.find('td').each(function (index) {
                            if (index < 4 && index > 0) { // Exclude the action column
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
    jQuery('#classes-table').on('click', '.delete-row', function (e) {
        e.preventDefault();
        const row = jQuery(this).closest('tr'); // Get the row
        const rowData = table.row(row).data(); // Get the row data from DataTables
        const rowId = jQuery(this).data('id'); // Unique row identifier
        // Send AJAX DELETE request
        jQuery.ajax({
            url: '../actions/delete-class-row.php', // Update this to your delete endpoint
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
  jQuery('#class-registration').on('submit', function() {
    if (true) {
       // Get all selected sections
       var selectedSections = [];
        $("input[name='sections[]']:checked").each(function() {
            selectedSections.push($(this).val());
        });

        // Concatenate the selected sections into a string (e.g., "A,B,C")
        var selectedSectionsString = selectedSections.join(',');
        var title = $('#title').val();
      jQuery.ajax({
        type: "post",
        url: "http://localhost/sms-project/actions/class-registration.php",
        data: {sections: selectedSectionsString, title },
        dataType: 'json',
        complete: function() {
          location.href = "http://localhost/sms-project/admin/classes.php";
        }
      
      });
    }
    return false;
  });
</script>
<?php include('footer.php'); ?>