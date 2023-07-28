<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'members';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array(
        'db' => 'date_registered',
        'dt' => 0,
        'formatter' => function( $d, $row ) {
            return date("D, j M Y g:i a", strtotime($d));
        }
    ),
    array( 'db' => 'fname',   'dt' => 1 ),
    array( 'db' => 'lname',     'dt' => 2 ),
    array( 'db' => 'email',     'dt' => 3 ),
    array( 'db' => 'phone',     'dt' => 4 ),
    array(
        'db'        => 'user_status',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            if($d=="1"){
                $status="<span class='label label-success'>Active</span>";
            }elseif($d=="0"){
                $status="<span class='label label-default'>Pending</span>";
            }elseif($d=="2"){
                $status="<span class='label label-warning'>Blocked</span>";
            }elseif($d=="3"){
                $status="<span class='label label-danger'>Deleted</span>";
            }
            return $status;
        }
    ),
    array(
        'db'        => 'email_slug',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
            return "<a href='?m=".$d."'><button class='fa fa-edit btn btn-success' title='Manage'></button></a>";
        }
    )
);

// SQL server connection information
$sql_details = array(
    'user' => 'xservico_store',
    'pass' => 'Xservico@1914',
    'db'   => 'xservico_store',
    'host' => 'mysql.xservico.com'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );
$where = "roles is null";
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where )
);