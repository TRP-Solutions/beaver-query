<?php
require_once "../lib/BeaverQuery.php";

use \TRP\BeaverQuery\BeaverQuery as BQ;

BQ::setDefaultDatabase('test');

$query = BQ::select(['id','name','username','birthday'], 'staff');
echo "<pre>$query</pre>";

$staff = BQ::table('staff');
$staff->fields('id','name','username','birthday');
$query = $staff->select();
$query->where($staff->birthday->date()->is('TODAY()',constant: false));
$query->order_by($staff->name, 'ASC');

echo "<pre>$query</pre>";
