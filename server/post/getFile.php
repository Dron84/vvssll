<?php
if (isset($_GET['loadmyfile'])) {
    $loadfile = $_GET['loadmyfile'];
    $companyId = $_GET['companyId'];
    $type = $_GET['type'];
    $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $companyId . '/' . $loadfile . '.' . $type;
    if (file_exists($path)) {
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
            ob_end_clean();
        }
        // заставляем браузер показать окно сохранения файла
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        // читаем файл и отправляем его пользователю
        readfile($path);
        exit;
    } else {
        echo 'Can`t load a file: ' . $_GET['loadmyfile'] . ' companyId is: ' . $_GET['companyId'];
    }
} else if (isset($_GET['showmyfile'])) {
    $loadfile = $_GET['showmyfile'];
    $companyId = $_GET['companyId'];
    $type = $_GET['type'];
    $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $companyId . '/' . $loadfile . '.' . $type;
    if (file_exists($path)) {
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Description: File Transfer');
        if ($type == 'jpg' || $type == 'jpeg' || $type == 'png' || $type == 'bmp') {
            header('Content-Type: image/' . $type);
        } else {
            header('Content-Type: application/' . $type);
        }
        header('Content-Disposition: attachment; filename=' . basename($path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        // читаем файл и отправляем его пользователю
        readfile($path);
        exit;
    } else {
        echo 'Can`t load a file: ' . $_GET['showmyfile'] . ' companyId is: ' . $_GET['companyId'];
    }
}