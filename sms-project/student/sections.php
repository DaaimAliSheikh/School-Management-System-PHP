<?php include('../includes/config.php') ?>
<?php include('header.php') ?>
<?php include('sidebar.php') ?>

<section class="content">
      <div class="container-fluid">
      <div class="card">
        <div class="card-header py-2">
          <h3 class="card-title">Sections</h3>
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
    const table= jQuery('#sections-table').DataTable({
      searching: false,

      ajax: {
        url: 'sections-data.php',
        type: 'POST'
      },
      columns: [
          { data: 'serial' },
          { data: 'title' },
      ],
      processing: true,
      serverSide: true,
      
    });})
    </script>
<?php include('footer.php') ?>