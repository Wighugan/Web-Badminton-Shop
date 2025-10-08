<?php
include "database/connect.php";
$data = new database();
$data->select('SELECT * FROM users');
$i = 0;
while($r = $data->fetch()){
    $i++;
    echo "<tr>";
    echo "<td>".$r['id']."</td>";
    echo "<td>".$r['username']."</td>";
    echo "</tr>";
    echo "<br>";
}
?>