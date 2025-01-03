<?php include('../includes/config.php') ?>


<?php include('header.php') ?>
<?php include('sidebar.php') ?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Periods</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Periods</li>
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
                Periods
                </h3>
                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive bg-white">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>S.No.</th>
                        <th>Title</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $count = 1;
                      $args = array(
                        'type' => 'period',
                        'status' => 'publish',
                      );
                      $periods = get_posts($args);
                      foreach($periods as $period) {
                        $from = get_metadata($period->id, 'from')[0]->meta_value;
                        $to = get_metadata($period->id, 'to')[0]->meta_value;
                        ?>
                      <tr>
                        <td><?=$period->id?></td>
                        <td><?=$period->title?></td>
                        <td><?php echo date('h:i A',strtotime($from)) ?></td>
                        <td><?php echo date('h:i A',strtotime($to)) ?></td>
                        <td><a href="#" class="btn btn-sm btn-danger delete-row" data-id="<?=$period->id?>"><i class="fa fa-trash"></i></a></td>
                      </tr>

                      <?php } ?>

                    </toby>


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
                  Add New Period
                </h3>
              </div>
              <div class="card-body">
                <form  id="period-registration" >
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" placeholder="Title" required class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="title">From</label>
                    <input type="time" name="from" placeholder="From" required class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="title">To</label>
                    <input type="time" name="to" placeholder="To" required class="form-control">
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
$(document).ready(function () {
  // Listen for click on delete button
  $(document).on('click', '.delete-row', function (e) {
    e.preventDefault(); // Prevent the default link action

    // Get the period ID from the button's data attribute
    var periodId = $(this).data('id');
    console.log(periodId)
    // Confirm delete action
      // Make an AJAX request to the server
      $.ajax({
        url: '../actions/delete_period.php', // Replace with your delete handler script
        type: 'DELETE',
        data: { serial: periodId },
        complete: function (response) {
          location.href = "http://localhost/sms-project/admin/periods.php";
        },
     
      });
  });
});


    jQuery('#period-registration').on('submit', function(e) {
      e.preventDefault()
       let formData = new FormData(this); // Create FormData object
       console.log(formData)
      jQuery.ajax({
        type: "post",
        url: "http://localhost/sms-project/actions/add-period.php",
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        complete: function(response) {
          location.href = "http://localhost/sms-project/admin/periods.php";
        }
      
      });
    return false;
  });
      
    </script>
<?php include('footer.php') ?>