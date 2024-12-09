<?PHP error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); ?>
<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  $con = new mysqli ("localhost","root","","kelompok__1") or die(mysqli_error($con));



   
            
