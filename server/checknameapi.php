<?php
require $_SERVER['DOCUMENT_ROOT'] . '/server/function.php';
$func = new \server\func();

if (isset($_GET['ApiKey']) && isset($_GET['Country']) && $_GET['CompanyName']) {
    $Country = $_GET['Country'];
    $CompanyName = $_GET['CompanyName'];
    $ApiKey = $_GET['ApiKey'];
    if ($func->checkApiKey($ApiKey) == true) {
        $res = $func->checkCompanyName($CompanyName);
    }
    echo json_encode($res);
} elseif (isset($_POST['ApiKey']) && isset($_POST['Country']) && $_POST['CompanyName']) {
    $Country = $_POST['Country'];
    $CompanyName = $_POST['CompanyName'];
    $ApiKey = $_POST['ApiKey'];
    if ($func->checkApiKey($ApiKey) == true) {
        $res = $func->checkCompanyName($CompanyName);
    }
    echo json_encode($res);
} else if (isset($_GET['ApiKey']) && $_GET['ApiKey'] == 'Generate' && isset($_GET['CompanyName']) && isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $CompanyName = $_GET['CompanyName'];
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);
//		echo $startDate.'<br><hr>'.$endDate;
    $res = $func->addApiKey($CompanyName, $startDate, $endDate);
//		print_r($res);
    echo json_encode($res);
} else if (isset($_POST['ApiKey']) && $_POST['ApiKey'] == 'Generate' && isset($_POST['CompanyName']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {
    $CompanyName = $_POST['CompanyName'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);
//		echo $startDate.'<br><hr>'.$endDate;
    $res = $func->addApiKey($CompanyName, $startDate, $endDate);
//		print_r($res);
    echo json_encode($res);
}