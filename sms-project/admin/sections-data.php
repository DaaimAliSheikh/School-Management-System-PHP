<?php include('../includes/config.php') ?>
<?php

$query = mysqli_query($db_conn,"SELECT * FROM `sections`");

$data = [
    "draw"=> $_POST['draw'],
    "recordsTotal"=> mysqli_num_rows($query),
    "recordsFiltered"=> mysqli_num_rows($query),
    "data" => []
];


$limit = $_POST['length'];
$offset = $_POST['start'];
$column = $_POST['order'][0]['column'];
$dir = $_POST['order'][0]['dir'];
$order_by = ($column == 0)? 'id': $_POST['columns'][$column]['data'];
$query = mysqli_query($db_conn,"SELECT * FROM `sections` ORDER BY `$order_by` $dir LIMIT $offset,$limit ");

while ($row = mysqli_fetch_object($query)) {
    $data['data'][] = [
        'serial' => $row->id,
        'title' =>$row->title,
        'action' => 
        '<a href="#" class="btn btn-sm btn-info edit-row" data-id="' . $row->id . '"><i class="fa fa-pencil-alt"></i></a>
        <a href="#" class="btn btn-sm btn-danger delete-row" data-id="' . $row->id . '"><i class="fa fa-trash"></i></a>',
    ];
}
echo json_encode($data);die;