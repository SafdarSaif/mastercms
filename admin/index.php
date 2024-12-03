<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-top.php');
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-bottom.php');
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/top-menu.php');
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/menu.php');
?>

<div class="row justify-content-center vh-100" style="align-items: flex-start; padding-top: 10vh;">
    <div class="col-12">
        <!-- Full-Screen Welcome Card -->
        <div class="card shadow-lg border-0 h-100" style="
            background: linear-gradient(to bottom right, rgba(0, 123, 255, 0.8), rgba(0, 200, 255, 0.6)), url('/admin/admin-assets/images/welcome-bg.jpg'); 
            background-size: cover; 
            background-position: center; 
            color: white; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center;
            height: calc(100vh - 10vh);">
            <div class="card-body text-center">
                <h1 class="font-weight-bold mb-4" style="font-size: 3em;">Welcome</h1>
                <p id="welcome-message" class="font-weight-bold" style="font-size: 2.5em; transition: color 0.3s, transform 0.3s;">
                    <?= isset($_SESSION['selectedUniversity']) ? "Welcome to " . ($_SESSION['selectedUniversity']) : 'Welcome to Knowledge Nest CMS platform!' ?>
                </p>
                <!-- <button class="btn btn-light btn-lg rounded-pill mt-4 px-5 py-3" style="font-weight: bold; box-shadow: 0 4px 12px rgba(0,0,0,0.3); transition: transform 0.3s;"
                    onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    Get Started
                </button> -->
            </div>
        </div>
    </div>
</div>

</div>
</div>
<style>
    #welcome-message:hover {
        color: #ffd700;
        transform: scale(1.1);
    }
</style>

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-top.php');
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-bottom.php');
?>