<?php
// echo "<pre>"; print_r($_SESSION); 

if($_SESSION['Role']=='Accountant'){
    include('navigation/accountant.php');
  }elseif($_SESSION['Role']=='Administrator'){
    include('navigation/admin.php');
  }elseif($_SESSION['Role']=='University Head' || $_SESSION['Role']=='Operations'){
    include('navigation/head.php');
  }elseif($_SESSION['Role']=='Online Center'){
    include('navigation/online-center.php');
  }
?>
