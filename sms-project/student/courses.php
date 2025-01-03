<?php include('../includes/config.php') ?>
<?php include('header.php') ?>
<?php include('sidebar.php') ?>

<section class="content">
      <div class="container-fluid">
      <div class="card">
        <div class="card-header py-2">
          <h3 class="card-title">Courses</h3>
          <div class="card-tools">
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive bg-white">
          <table class="table table-bordered" id="courses-table">
              <thead>
                <tr>
                <th>S.No.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Duration</th>
                    <th>Date</th>
                </tr>
              </thead>
              
            </table>
          </div>

        </div>
      </div>

      </div><!--/. container-fluid -->
    </section>
    <script>
  jQuery(document).ready(function(){
    const table= jQuery('#courses-table').DataTable({
      searching: false,

      ajax: {
        url: './courses-data.php',
        type: 'POST'
      },
      columns: [
          { data: 'serial' },
          { data: 'image' },
          { data: 'name' },
          { data: 'category' },
          { data: 'duration' },
          { data: 'date' },
      ],
      processing: true,
      serverSide: true,
      
    });
  })
  </script>
  
<?php include('footer.php') ?>