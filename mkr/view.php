<?php
include "index.php";

displayTableProducts($_SESSION['Products']);
?>
<style>
    table,td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th{
        border: 1px solid black;
    }
</style>
