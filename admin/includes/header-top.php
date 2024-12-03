<?php
function session_error_function()
{
	header("Location: /");
}

set_error_handler('session_error_function');
session_start();
if (!isset($_SESSION['Role'])) {
	header("Location: /admin/login");
}
restore_error_handler();
date_default_timezone_set('Asia/Kolkata');
header('Content-Type: text/html; charset=utf-8');

include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/db-config.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Knowledge ">
	<meta property="og:title" content="Knowledge ">
	<meta property="og:description" content="Knowledge ">
	<meta property="og:image" content="">
	<meta name="format-detection" content="telephone=no">

	<!-- admin path  -->
	<?php  //define('ADMIN_PATH', $_SERVER['SERVER_NAME']."/admin/");
	?>
	<!-- end admin path -->

	<!-- PAGE TITLE HERE -->
	<title>Admin | Knowledge Nest</title>
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="/admin/admin-assets/images/gku-fav.jpeg">
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
	<link href="/admin/admin-assets/vendor/swiper/css/swiper-bundle.min.css" rel="stylesheet">
	<link href="/admin/admin-assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

	<!-- <link href="/admin/admin-assets/vendor/toastr/css/toastr.min.css"> -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<link href="/admin/admin-assets/vendor/tagify/dist/tagify.css" rel="stylesheet">
	<link href="/admin/admin-assets/css/style.css" rel="stylesheet">
	<link href="/admin/admin-assets/css/pages.css" rel="stylesheet">
	<link href="/admin/admin-assets/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
	<link href="/admin/admin-assets/plugins/bootstrap-datepicker/css/datepicker3.css">
	
    <link href="/admin/admin-assets/plugins/bootstrap/css/bootstrap.min.css">
    <link href="/admin/admin-assets/plugins/select2/css/select2.min.css">


<!-- sumoselect -->
<!-- <link href="/admin/admin-assets/css/sumo-select.css" rel="stylesheet"> -->
<link rel="stylesheet" href="/admin/admin-assets/plugins/sumo-select/css/sumoselect.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="/admin/admin-assets/plugins/sumo-select/css/sumoselect.min.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />



<!-- ********************* -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">



 <!-- ************************** -->
	<script>
		function isNumberKey(evt) {
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			return true;
		}
	</script>
	

