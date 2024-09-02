<?php
// Get the path from the URL
$path = isset($_GET['path']) ? $_GET['path'] : '';

// Remove any leading or trailing slashes
$path = trim($path, '/');

// Route the request based on the path
switch ($path) {
    case '':
        include 'view/home.php';
        break;
    case 'home':
        include 'view/home.php';
        break;
    case 'view-record':
        include 'view/view_record.php';
        break;
    case 'login':
        include 'view/login.php';
        break;
    case 'register':
        include 'view/register.php';
        break;
    case 'logout':
        include 'controller/logoutUser.php';
        break;
    case 'action':
        include 'model/travelling_detailsModel.php';
        break;
    case 'utm-travel-record':
        include 'view/utm_travel_record.php';
        break;
    case 'token-expired':
        include 'view/404.php';
        break;
    case 'tic-tac-toe':
        include 'view/tictactoe.php';
        break;
    case 'view-resume':
        include 'view/resume/pdf.php';
        break;
    case 'view-resume-tcpdf':
        include 'view/resume/tcpdf.php';
        break;
    case 'resume-setup':
        include 'view/resume/resume_setup.php';
        break;
    case 'resume-controller':
        include 'controller/resumeController.php';
        break;
    case 'dashboard-config':
        include 'view/dashboard/dashboard_config.php';
        break;
    case 'dashboardController':
        include 'controller/dashboardController.php';
        break;
    case 'dashboard-portfolio':
        include 'view/dashboard/portfolio.php';
        break;
    case 'dashboard-timeline':
        include 'view/dashboard/timeline.php';
        break;
    default:
        http_response_code(404);
        include 'view/404.php';
        break;
}
