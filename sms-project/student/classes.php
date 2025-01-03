<?php include('../includes/config.php') ?>
<?php include('header.php') ?>
<?php include('sidebar.php') ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="card">
        <div class="card-header py-2">
          <h3 class="card-title">Classes</h3>
          <div class="card-tools">
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
    const table= jQuery('#classes-table').DataTable({
      searching: false,
      ajax: {
        url: './classes-data.php',
        type: 'POST'
      },
      columns: [
          { data: 'serial' },
          { data: 'title' },
          { data: 'sections' },
          { data: 'added-date' },
      ],
      processing: true,
      serverSide: true,
      
    });
  })
    </script>
<?php include('footer.php') ?>