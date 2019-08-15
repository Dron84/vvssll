<?php

namespace server;

//use server\PHPMailer\Exception;
use server\PHPMailer\PHPMailer;

//use server\PHPMailer\SMTP;
error_reporting(E_ALL);
ini_set('display_errors', 1);

//use server\PHPMailer\PHPMailer;
//use server\PHPMailer\SMTP;
//use server\PHPMailer\Exception;
require 'db.php';
require 'db_company.php';
//require 'Exception.php';
require 'PHPMailer.php';

//require 'SMTP.php';

class func
{
    private $db, $result, $db_company;

    public function __construct()
    {
    }

    private function sqlQuery($sqlQuery)
    {
        $this->db = new db();
        $this->db->con->set_charset('UTF8');
        $whatQuery = explode(' ', $sqlQuery);
        $whatQuery = $whatQuery[0];
        if ($whatQuery == 'SELECT') {
            if ($query = $this->db->con->query($sqlQuery)) {
                if ($query->num_rows > 0) {
                    while ($row = $query->fetch_assoc()) {
                        $result[] = $row;
                    }
                } else {
                    $result = "Sql is empty";
                }
            } else {
                $result = "Error: this sql is not correct: $sqlQuery";
            }
        } else if ($whatQuery == 'UPDATE' || $whatQuery == 'DELETE' || $whatQuery == 'INSERT') {
            if ($query = $this->db->con->query($sqlQuery)) {
                $result['mess'] = "Sql $whatQuery is ok";
                $result['id'] = $this->db->con->insert_id;
            } else {
                $result['error'] = "Error: this sql is not correct: $sqlQuery";
            }
        }
        return $result;
    }

    private function sqlQueryCompany($sqlQuery)
    {
        $this->db_company = new db_company();
        $whatQuery = explode(' ', $sqlQuery);
        $this->db_company->con->set_charset('UTF-8');
        $whatQuery = $whatQuery[0];
        if ($whatQuery == 'SELECT') {
            if ($query = $this->db_company->con->query($sqlQuery)) {
                if ($query->num_rows > 0) {
                    while ($row = $query->fetch_assoc()) {
                        $result[] = $row;
                    }
                } else {
                    $result = "Sql is empty";
                }
            } else {
                $result = "Error: this sql is not correct: $sqlQuery";
            }
        } else if ($whatQuery == 'UPDATE' || $whatQuery == 'DELETE' || $whatQuery == 'INSERT') {
            if ($query = $this->db_company->con->query($sqlQuery)) {
                $result = "Sql $whatQuery is ok";
            } else {
                $result = "Error: this sql is not correct: $sqlQuery";
            }
        }
        return $result;
    }

    private function loadJurisdictionInfoApp($id)
    {
        $sql = "SELECT * FROM `jurisdiction` WHERE id='{$id}';";
        $this->result = $this->sqlQuery($sql);
        $this->result = $this->result[0];
        return $this->result;
    }

    private function getGUID()
    {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }
//	private function emailHTML($whatProccess, $whatImg, $type, $header, $attentionMessage, $messBody, $gotolink, string $buttomText = null)
//	{
//		$this->result = '<!DOCTYPE html>
//    <html lang="ru">
//    <head>
//        <meta charset="UTF-8">
//        <meta name="viewport" content="width=device-width, initial-scale=1">
//        <meta name="description" content="">
//        <meta name="Keywords" content="">
//        <title>VVSSLL.com</title>
//        <style>
//            body {
//                background-color: rgba(135, 135, 135, 0.4);
//                margin: 0;
//                padding: 0;
//                font-size: 16px; }
//
//            .wrap {
//                display: grid;
//                grid-template-columns: 1fr;
//                grid-template-rows: 20vh auto 20vh;
//                grid-template-areas: "head" "body" "bottom"; }
//            .wrap .head {
//                grid-area: head;
//                background-color: transparent; }
//            .wrap .head .logoblock {
//                display: grid;
//                grid-template-columns: 4fr 9fr;
//                grid-template-areas: "logo after";
//                height: 100%; }
//            .wrap .head .logoblock img.logo {
//                grid-area: logo;
//                height: 40%;
//                width: auto;
//                position: relative;
//                top: 25%;
//                left: 8%; }
//            .wrap .head .logoblock div.after {
//                grid-area: after;
//                width: 96%;
//                height: 1.5%;
//                position: relative;
//                top: 46%;
//                background-color: #235E72; }
//            .wrap .head svg.worldmap {
//                width: 45%;
//                height: auto;
//                position: absolute;
//                right: 3%;
//                top: 3%; }
//            .wrap .head svg.worldmap path {
//                background-color: rgba(0, 0, 0, 0.1); }
//            .wrap .body {
//                grid-area: body;
//                background-color: #ffffff;
//                padding: 7%; }
//            .wrap .body_wrap {
//                display: grid;
//                grid-template-areas: "left right";
//                grid-template-columns: 30% 70%;
//                width: 100%;
//                height: 100%; }
//            .wrap .body_wrap .left {
//                grid-area: left;
//                position: relative; }
//            .wrap .body_wrap .left .payment, .wrap .body_wrap .left .password, .wrap .body_wrap .left .process {
//                display: block;
//                position: relative;
//                width: 65%;
//                height: 100%;
//                top: 0;
//                left: 0;
//                background-repeat: no-repeat;
//                background-size: contain;
//                opacity: 0.2; }
//            .wrap .body_wrap .left .payment {
//                background-image: url("http://vvssll.com/img/payment.svg"); }
//            .wrap .body_wrap .left .password {
//                background-image: url("http://vvssll.com/img/password.svg"); }
//            .wrap .body_wrap .left .process {
//                background-image: url("http://vvssll.com/img/process.svg"); }
//            .wrap .body_wrap .left .success, .wrap .body_wrap .left .notsuccess, .wrap .body_wrap .left .inprocess {
//                border-radius: 50%;
//                border: none;
//                width: 28%;
//                height: 85%;
//                background-repeat: no-repeat;
//                background-size: contain;
//                position: absolute;
//                top: 0%;
//                right: 20%;
//                opacity: 0.8; }
//            .wrap .body_wrap .right {
//                grid-area: right; }
//            .wrap .body_wrap .right h2 {
//                font-family: Arial, sans-serif;
//                font-weight: normal;
//                font-size: 1.3em;
//                text-align: left;
//                color: #1a1818; }
//            .wrap .body_wrap .right .success h3, .wrap .body_wrap .right .notsuccess h3, .wrap .body_wrap .right .inprocess h3 {
//                font-family: Arial, sans-serif;
//                font-weight: normal;
//                font-size: 1.3em;
//                text-align: left;
//                text-transform: uppercase; }
//            .wrap .body_wrap .right .success .data p, .wrap .body_wrap .right .notsuccess .data p, .wrap .body_wrap .right .inprocess .data p {
//                font-family: Arial, sans-serif;
//                font-weight: normal;
//                font-size: 1.2em;
//                text-align: left;
//                color: #878787; }
//            .wrap .body_wrap .right .success .data p span, .wrap .body_wrap .right .notsuccess .data p span, .wrap .body_wrap .right .inprocess .data p span {
//                font-family: Arial, sans-serif;
//                font-weight: normal;
//                font-size: 0.8em;
//                text-align: left; }
//            .wrap .body_wrap .right .success .data a, .wrap .body_wrap .right .notsuccess .data a, .wrap .body_wrap .right .inprocess .data a {
//                text-decoration: underline;
//                color: #6C9EBB; }
//            .wrap .body_wrap .right .success a.button, .wrap .body_wrap .right .notsuccess a.button, .wrap .body_wrap .right .inprocess a.button {
//                display: flex;
//                align-items: center;
//                justify-content: center;
//                text-decoration: none;
//                cursor: pointer;
//                width: 191.83px;
//                height: 31.05px;
//                background: #6c9ebb;
//                font-family: Arial, sans-serif;
//                font-weight: normal;
//                font-size: 1em;
//                text-align: center;
//                color: #fff; }
//            .wrap .body_wrap .right .success h3 {
//                color: #5b8852; }
//            .wrap .body_wrap .right .success .data p {
//                color: #6c9ebb; }
//            .wrap .body_wrap .right .success .data p span .caption {
//                color: #6c9ebb; }
//            .wrap .body_wrap .right .success .data p span .info {
//                color: #6c9ebb; }
//            .wrap .body_wrap .right .notsuccess h3 {
//                color: #DB3B32; }
//            .wrap .body_wrap .right .notsuccess .data p {
//                color: #bb9281; }
//            .wrap .body_wrap .right .notsuccess .data p span .caption {
//                color: #DB3B32; }
//            .wrap .body_wrap .right .notsuccess .data p span .info {
//                color: #DB3B32; }
//            .wrap .body_wrap .right .inprocess h3 {
//                color: #235E72; }
//            .wrap .body_wrap .right .inprocess .data p {
//                color: #235E72; }
//            .wrap .body_wrap .right .inprocess .data p span .caption {
//                color: #235E72; }
//            .wrap .body_wrap .right .inprocess .data p span .info {
//                color: #235E72; }
//            .wrap .bottom {
//                grid-area: bottom;
//                background-color: transparent;
//                padding: 3%; }
//            .wrap .bottom p {
//                font-family: Arial, sans-serif;
//                font-weight: normal;
//                font-size: 1em;
//                text-align: left;
//                color: #535453; }
//        </style>
//    </head>
//    <body>
//    <div class="wrap">
//        <div class="head">
//            <div class="logoblock">
//                <img src="http://vvssll.com/img/logo.svg" alt="logo by vvssll.com" class="logo">
//                <div class="after"></div>
//            </div>
//                <img src="http://vvssll.com/img/world.png" alt="" class="worldmap">
//        </div>
//        <div class="body">
//            <div class="body_wrap">
//                <div class="left">';
//
//		if ($whatProccess == 'payment') {
//			$this->result .= '<div class="payment"></div>';
//		} else if ($whatProccess == 'password') {
//			$this->result .= '<div class="password"></div>';
//		} else if ($whatProccess == 'process') {
//			$this->result .= '<div class="process"></div>';
//		}
//		if ($whatImg == 'atention') {
//			$this->result .= '<img src="http://vvssll.com/img/atention.svg" class="success" alt="">';
//		} else if ($whatImg == 'process') {
//			$this->result .= '<img src="http://vvssll.com/img/checkedprocess.svg" class="success" alt="">';
//		} else if ($whatImg == 'checked') {
//			$this->result .= '<img src="http://vvssll.com/img/checked.svg" class="success" alt="">';
//		}
//
//		$this->result .= '</div>
//                <div class="right">
//                    <h2>' . $header . '</h2>';
//		if ($type == "success") {
//			$this->result .= '<div class="success">';
//		} else if ($type == "process") {
//			$this->result .= '<div class="process">';
//		} else if ($type == "notsuccess") {
//			$this->result .= '<div class="notsuccess">';
//		}
//		$this->result .= '<h3>' . $attentionMessage . '</h3>
//                        <div class="data">
//                            <p class="caption">' . $messBody . '</p>
//                        </div>
//                        <a href="' . $gotolink . '" class="button" target="_blank">Go to</a>
//                    </div>
//                </div>
//            </div>
//        </div>
//        <div class="bottom">
//            <p>' . $buttomText . '</p>
//        </div>
//    </div>
//    </body>
//    </html>';
//		return $this->result;
//	} //depricated
    private function sendEmail(string $toAddress, string $toAddressName = null, string $subject = null, $htmlBody, array $attachmentsWhitFullPath = null)
    {
        $mail = new PHPMailer(true);                             // Passing `true` enables exceptions
        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->SMTPDebug = 0; // Set mailer to use SMTP
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Host = "ssl://mail.comformo.com";
            $mail->Port = 465;
            $mail->Username = "no-replay@comformo.com";
            $mail->Password = 'Vn+WT{\4"[5';                        // SMTP password
//        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//        $mail->Port = 587;         // TCP port to connect to

            //Recipients
            $mail->setFrom('no-replay@comformo.com', 'no-replay Comformo LTD');
            if ($toAddressName != null) {
                $mail->addAddress($toAddress, $toAddressName);
            } else {
                $mail->addAddress($toAddress);
            }

            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->msgHTML($htmlBody);

            if (is_array($attachmentsWhitFullPath)) {
                foreach ($attachmentsWhitFullPath as $value) {
                    $mail->addAttachment($value);
                }
            }

            $mail->send();
            $this->result = 'Message has been sent';
        } catch (Exception $e) {
            $this->result = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
        return $this->result;
    }

    private function postToUpdate(array $data, $toSelect = false)
    {
        $strArray = [];
        foreach ($data as $key => $value) {
            $strArray[] = $key . "='{$value}'";
        }
        if ($toSelect == false) {
            return implode(', ', $strArray);
        } else if ($toSelect == true) {
            return implode(' AND ', $strArray);
        }
    }

    private function postToInsert(array $data)
    {
        foreach ($data as $key => $value) {
            $keys[] = $key;
            $values[] = "'" . str_replace(';', '\;', str_replace('"', '\"', str_replace("'", "\'", $value))) . "'";
        }
        $strKeys = implode(',', $keys);
        $strValues = implode(',', $values);
        return array('keys_string' => $strKeys, 'values_string' => $strValues);
    }

    private function statusMessUpd($id)
    {
        $sql = "UPDATE `messages` SET status='read' WHERE id={$id};";
        $res = $this->sqlQuery($sql);
        if ($res == 'Sql UPDATE is ok') {
            $this->result = 'ok';
        } else {
            $this->result = "Error: DB is OUT";
        }
        return $this->result;
    }

    private function setCookie($name, $value, $hourExpiriesTime = 2)
    {
        $path = '/';
        $secure = false;
        $httponly = false;
        $site = $_SERVER['SERVER_NAME'];
        setcookie($name, $value, time() + ($hourExpiriesTime * 3600), $path, $site, $secure, $httponly);
    }

    // HTML EMAIL TEMPLATES
    private function htmlApproveDocs(array $manager, array $company)
    {
        return "<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\"
          content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
    <meta http-equiv=\"Content-Type\" content=\"text/html\" />
    <title>Approve Documents</title>
</head>
<body style=\"background-color: #d6d6d6; margin:0; font-family: 'Arial', Sans-serif;\">
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0 auto; padding:0; max-width: 500px; width: 100%; background-color: #ffffff;\">
    <tr>
        <td>
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 15px 40px 15px;\">
                <tr>
                    <td style=\"padding: 5px; text-align:center;\">
                        <a href=\"https://comformo.com/\"><img src=\"https://comformo.com/wp-content/uploads/2019/04/logo-comformo.png\" alt=\"Comformo\" width=\"140\" height=\"58\" style=\"max-width: 100%; height: auto;\"></a>
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%;
            background-image: url(https://comformo.com/wp-content/uploads/2019/07/documents-shipped.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;\">
                <tr>
                    <td style=\"height: 220px;\">
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 40px 45px 0 45px; border-bottom: 1px solid #efeded;
              background-image: url(https://comformo.com/wp-content/uploads/2019/04/paper-boat.png);
              background-repeat: no-repeat;
              background-size: 24%;
              background-position: bottom 7% right 8%;\">

                <tr>
                    <td>
                      <h1 style=\"text-align:center; font-weight: 600; font-size: 33px; color: #e68024; margin: 0;\">Approve documents</h1>

                        <p style=\"text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;\">
                          <b>Hello " . $manager['firstName'] . " " . $manager['lastName'] . "</b>
                        </p>
                        <p style=\"text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;\">
                          Please approve documents by company: " . $company['companyName'] . "<br> <a href='https://cabinet.comformo.com/manager/approve'>Go to cabinet</a>
                        </p>
                                              <p style=\"text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;\">
                          Let us know if you have any questions. <br>Feel free to contact us with number <span style=\"color: #fd8e2a\">+44 203 290 0530</span> <br>or email <span style=\"color: #fd8e2a\">office@comformo.com</span>
                        </p>
                        <p style=\"text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;margin-bottom: 30px;\">
                          With best regards,<br>
                          Comformo
                        </p>
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 35px 45px 20px;\">
                <tr>
                    <td style=\"padding-right: 15px;\">
                        <a href=\"https://comformo.com/\"><img src=\"https://comformo.com/wp-content/uploads/2019/04/logo-comformo.png\" alt=\"Comformo\" width=\"140\" height=\"58\" style=\"max-width: 100%; height: auto;\"></a>
                    </td>
                    <td style=\"float:right;\">
                      <ul style=\"margin: 0; padding: 0; list-style: none; margin: 15px 0 10px;\">
                          <li style=\"margin: 0 5px 5px;\">
                              <a href=\"tel:+442032900530\" style=\"color: #908074; font-size: 13px; text-decoration: none; color: #ff810f; font-size: 12px; font-weight: 700; display: flex; align-items: center;\">
                                <img src=\"https://comformo.com/wp-content/uploads/2019/04/phone-call-.png\" alt=\"number\" width=\"12\" height=\"auto\" style=\"margin-right: 10px; vertical-align: bottom;\"> +44 203 290 0530
                              </a>
                          </li>
                          <li style=\"margin: 0 5px 5px;\">
                              <a href=\"mailto:office@comformo.com\" style=\"color: #908074; font-size: 13px; text-decoration: none; color: #ff810f;  font-size: 12px; font-weight: 700; display: flex; align-items: center;\">
                                <img src=\"https://comformo.com/wp-content/uploads/2019/04/envelope.png\" alt=\"number\" width=\"12\" height=\"auto\" style=\"margin-right: 10px; vertical-align: bottom;\"> office@comformo.com
                              </a>
                          </li>
                          <li style=\"margin: 0 5px 5px;\">
                              <a href=\"comformo.com\" style=\"color: #908074; font-size: 13px; text-decoration: none; color: #ff810f;  font-size: 12px; font-weight: 700; display: flex; align-items: center;\">
                                <img src=\"https://comformo.com/wp-content/uploads/2019/04/skype.png\" alt=\"number\" width=\"12\" height=\"auto\" style=\"margin-right: 10px; vertical-align: bottom;\"> comformo.com
                              </a>
                          </li>
                      </ul>
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 0 45px;\">
                <tr>
                    <td>
                        <ul style=\"margin: 0; padding: 0; list-style: none; text-align: center; margin: 15px 0 10px;\">
                            <li style=\"display: inline-block; margin: 0 10px 5px;\">
                                <a href=\"https://comformo.com/privacy-policy/\" style=\"text-decoration: none; color: #948e8e; font-size: 11px;\">Privacy Policy</a>
                            </li>

                            <li style=\"display: inline-block;\"><span style=\"color: #948e8e;\">|</span></li>

                            <li style=\"display: inline-block; margin: 0 10px 5px;\">
                                <a href=\"https://comformo.com/refund-policy/\" style=\"text-decoration: none; color: #948e8e; font-size: 11px;\">Returns & Refunds</a>
                            </li>

                            <li style=\"display: inline-block;\"><span style=\"color: #948e8e;\">|</span></li>

                            <li style=\"display: inline-block; margin: 0 10px 5px;\">
                                <a href=\"https://comformo.com/terms-and-conditions/\" style=\"text-decoration: none; color: #948e8e; font-size: 11px;\">Terms & Conditions</a>
                            </li>

                        </ul>
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 15px 45px 20px;\">
                <tr>
                    <td>
                      <p style=\"font-size: 9px; color: #9e9998; font-weight: 500; line-height: 1.7;max-width: 200px;\">
                        Copyright 2019 © Comformo Ltd, trading as one of the top Quality Company formations
                      </p>
                    </td>
                    <td>
                      <p style=\"float: right;\">
                        <img src=\"https://comformo.com/wp-content/uploads/2019/07/flagss.png\" alt=\"Payments\" width=\"100\" height=\"20\" style=\"max-width: 100%; height: auto; \">
                      </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>";
    }

    private function htmlChangeManager($company)
    {
        return "<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\"
          content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
    <meta http-equiv=\"Content-Type\" content=\"text/html\" />
    <title>Approve Documents</title>
</head>
<body style=\"background-color: #d6d6d6; margin:0; font-family: 'Arial', Sans-serif;\">
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0 auto; padding:0; max-width: 500px; width: 100%; background-color: #ffffff;\">
    <tr>
        <td>
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 15px 40px 15px;\">
                <tr>
                    <td style=\"padding: 5px; text-align:center;\">
                        <a href=\"https://comformo.com/\"><img src=\"https://comformo.com/wp-content/uploads/2019/04/logo-comformo.png\" alt=\"Comformo\" width=\"140\" height=\"58\" style=\"max-width: 100%; height: auto;\"></a>
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%;
            background-image: url(https://comformo.com/wp-content/uploads/2019/07/documents-shipped.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;\">
                <tr>
                    <td style=\"height: 220px;\">
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 40px 45px 0 45px; border-bottom: 1px solid #efeded;
              background-image: url(https://comformo.com/wp-content/uploads/2019/04/paper-boat.png);
              background-repeat: no-repeat;
              background-size: 24%;
              background-position: bottom 7% right 8%;\">

                <tr>
                    <td>
                      <h1 style=\"text-align:center; font-weight: 600; font-size: 33px; color: #e68024; margin: 0;\">Your manager is changed</h1>

                        <p style=\"text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;\">
                          <b>Hello</b>
                        </p>
                        <p style=\"text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;\">
                          Good day. You've been assigned a new Manager by company: " . $company['companyName'] . "<br> <a href='https://cabinet.comformo.com/login'>Go to cabinet</a>
                        </p>
                                              <p style=\"text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;\">
                          Let us know if you have any questions. <br>Feel free to contact us with number <span style=\"color: #fd8e2a\">+44 203 290 0530</span> <br>or email <span style=\"color: #fd8e2a\">office@comformo.com</span>
                        </p>
                        <p style=\"text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;margin-bottom: 30px;\">
                          With best regards,<br>
                          Comformo
                        </p>
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 35px 45px 20px;\">
                <tr>
                    <td style=\"padding-right: 15px;\">
                        <a href=\"https://comformo.com/\"><img src=\"https://comformo.com/wp-content/uploads/2019/04/logo-comformo.png\" alt=\"Comformo\" width=\"140\" height=\"58\" style=\"max-width: 100%; height: auto;\"></a>
                    </td>
                    <td style=\"float:right;\">
                      <ul style=\"margin: 0; padding: 0; list-style: none; margin: 15px 0 10px;\">
                          <li style=\"margin: 0 5px 5px;\">
                              <a href=\"tel:+442032900530\" style=\"color: #908074; font-size: 13px; text-decoration: none; color: #ff810f; font-size: 12px; font-weight: 700; display: flex; align-items: center;\">
                                <img src=\"https://comformo.com/wp-content/uploads/2019/04/phone-call-.png\" alt=\"number\" width=\"12\" height=\"auto\" style=\"margin-right: 10px; vertical-align: bottom;\"> +44 203 290 0530
                              </a>
                          </li>
                          <li style=\"margin: 0 5px 5px;\">
                              <a href=\"mailto:office@comformo.com\" style=\"color: #908074; font-size: 13px; text-decoration: none; color: #ff810f;  font-size: 12px; font-weight: 700; display: flex; align-items: center;\">
                                <img src=\"https://comformo.com/wp-content/uploads/2019/04/envelope.png\" alt=\"number\" width=\"12\" height=\"auto\" style=\"margin-right: 10px; vertical-align: bottom;\"> office@comformo.com
                              </a>
                          </li>
                          <li style=\"margin: 0 5px 5px;\">
                              <a href=\"comformo.com\" style=\"color: #908074; font-size: 13px; text-decoration: none; color: #ff810f;  font-size: 12px; font-weight: 700; display: flex; align-items: center;\">
                                <img src=\"https://comformo.com/wp-content/uploads/2019/04/skype.png\" alt=\"number\" width=\"12\" height=\"auto\" style=\"margin-right: 10px; vertical-align: bottom;\"> comformo.com
                              </a>
                          </li>
                      </ul>
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 0 45px;\">
                <tr>
                    <td>
                        <ul style=\"margin: 0; padding: 0; list-style: none; text-align: center; margin: 15px 0 10px;\">
                            <li style=\"display: inline-block; margin: 0 10px 5px;\">
                                <a href=\"https://comformo.com/privacy-policy/\" style=\"text-decoration: none; color: #948e8e; font-size: 11px;\">Privacy Policy</a>
                            </li>

                            <li style=\"display: inline-block;\"><span style=\"color: #948e8e;\">|</span></li>

                            <li style=\"display: inline-block; margin: 0 10px 5px;\">
                                <a href=\"https://comformo.com/refund-policy/\" style=\"text-decoration: none; color: #948e8e; font-size: 11px;\">Returns & Refunds</a>
                            </li>

                            <li style=\"display: inline-block;\"><span style=\"color: #948e8e;\">|</span></li>

                            <li style=\"display: inline-block; margin: 0 10px 5px;\">
                                <a href=\"https://comformo.com/terms-and-conditions/\" style=\"text-decoration: none; color: #948e8e; font-size: 11px;\">Terms & Conditions</a>
                            </li>

                        </ul>
                    </td>
                </tr>
            </table>

            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0; padding:0; width: 100%; padding: 15px 45px 20px;\">
                <tr>
                    <td>
                      <p style=\"font-size: 9px; color: #9e9998; font-weight: 500; line-height: 1.7;max-width: 200px;\">
                        Copyright 2019 © Comformo Ltd, trading as one of the top Quality Company formations
                      </p>
                    </td>
                    <td>
                      <p style=\"float: right;\">
                        <img src=\"https://comformo.com/wp-content/uploads/2019/07/flagss.png\" alt=\"Payments\" width=\"100\" height=\"20\" style=\"max-width: 100%; height: auto; \">
                      </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>";
    }

    private function htmlUBOSign(string $link, array $user = array('firstName' => '', 'lastName' => ''))
    {
        return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html" />
    <title>Document</title>
</head>
<body style="background-color: #d6d6d6; margin:0; font-family: \'Arial\', Sans-serif;">
<table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto; padding:0; max-width: 500px; width: 100%; background-color: #ffffff;">
    <tr>
        <td>
            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 15px 40px 15px;">
                <tr>
                    <td style="padding: 5px; text-align:center;">
                        <a href="https://comformo.com/"><img src="https://comformo.com/wp-content/uploads/2019/04/logo-comformo.png" alt="Comformo" width="140" height="58" style="max-width: 100%; height: auto;"></a>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%;
            background-image: url(http://comformo.com/wp-content/uploads/2019/07/shareholder-mailer.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;">
                <tr>
                    <td style="height: 220px;">

                    </td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 40px 45px 0 45px; border-bottom: 1px solid #efeded;
              background-image: url(https://comformo.com/wp-content/uploads/2019/04/paper-boat.png);
              background-repeat: no-repeat;
              background-size: 24%;
              background-position: bottom 7% right 8%;">
                <tr>
                    <td>
                      <h1 style="text-align:center; font-weight: 600; font-size: 33px; color: #e68024; margin: 0;">Director / Shareholder</h1>
                        <p style="text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;">
                          <b>Dear ' . $user['firstName'] . ' ' . $user['lastName'] . '</b>
                        </p>
                        <p style="text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;">
                          You have been registered as a Director or Shareholder in a newly incorporated company.
<br>Go to this <a href="https://cabinet.comformo.com/link/?link=' . $link . '" target="_blank">site</a> to fill out the declination form.

                        </p>
                        <p style="text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;">
                          Let us know if you have any questions by calling <br><span style="color: #fd8e2a">+44 203 290 0530</span> or emailing <span style="color: #fd8e2a">office@comformo.com.</span>
                        </p>
                        <p style="text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;margin-bottom: 30px;">
                          Best regards,<br>
                          Comformo
                        </p>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 35px 45px 20px;">
                <tr>
                    <td style="padding-right: 15px;">
                        <a href="https://comformo.com/"><img src="https://comformo.com/wp-content/uploads/2019/04/logo-comformo.png" alt="Comformo" width="140" height="58" style="max-width: 100%; height: auto;"></a>
                    </td>
                    <td style="float:right;">
                      <ul style="margin: 0; padding: 0; list-style: none; margin: 15px 0 10px;">
                          <li style="margin: 0 5px 5px;">
                              <a href="tel:+442032900530" style="color: #908074; font-size: 13px; text-decoration: none; color: #ff810f; font-size: 12px; font-weight: 700; display: flex; align-items: center;">
                                <img src="https://comformo.com/wp-content/uploads/2019/04/phone-call-.png" alt="number" width="12" height="auto" style="margin-right: 10px; vertical-align: bottom;"> +44 203 290 0530
                              </a>
                          </li>
                          <li style="margin: 0 5px 5px;">
                              <a href="mailto:office@comformo.com" style="color: #908074; font-size: 13px; text-decoration: none; color: #ff810f;  font-size: 12px; font-weight: 700; display: flex; align-items: center;">
                                <img src="https://comformo.com/wp-content/uploads/2019/04/envelope.png" alt="number" width="12" height="auto" style="margin-right: 10px; vertical-align: bottom;"> office@comformo.com
                              </a>
                          </li>
                          <li style="margin: 0 5px 5px;">
                              <a href="comformo.com" style="color: #908074; font-size: 13px; text-decoration: none; color: #ff810f;  font-size: 12px; font-weight: 700; display: flex; align-items: center;">
                                <img src="https://comformo.com/wp-content/uploads/2019/04/skype.png" alt="number" width="12" height="auto" style="margin-right: 10px; vertical-align: bottom;"> comformo.com
                              </a>
                          </li>
                      </ul>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 0 45px;">
                <tr>
                    <td>
                        <ul style="margin: 0; padding: 0; list-style: none; text-align: center; margin: 15px 0 10px;">
                            <li style="display: inline-block; margin: 0 10px 5px;">
                                <a href="https://comformo.com/privacy-policy/" style="text-decoration: none; color: #948e8e; font-size: 11px;">Privacy Policy</a>
                            </li>

                            <li style="display: inline-block;"><span style="color: #948e8e;">|</span></li>

                            <li style="display: inline-block; margin: 0 10px 5px;">
                                <a href="https://comformo.com/refund-policy/" style="text-decoration: none; color: #948e8e; font-size: 11px;">Returns & Refunds</a>
                            </li>

                            <li style="display: inline-block;"><span style="color: #948e8e;">|</span></li>

                            <li style="display: inline-block; margin: 0 10px 5px;">
                                <a href="https://comformo.com/terms-and-conditions/" style="text-decoration: none; color: #948e8e; font-size: 11px;">Terms & Conditions</a>
                            </li>

                        </ul>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 15px 45px 20px;">
                <tr>
                    <td>
                      <p style="font-size: 9px; color: #9e9998; font-weight: 500; line-height: 1.7;max-width: 200px;">
                        Copyright 2019 © Comformo Ltd, trading as one of the top Quality Company formations
                      </p>
                    </td>
                    <td>
                      <p style="float: right;">
                        <img src="https://comformo.com/wp-content/uploads/2019/07/flagss.png" alt="Payments" width="100" height="20" style="max-width: 100%; height: auto; ">
                      </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
';
    }

    private function htmlRegisterUser(array $userData = array('name' => '', 'email' => '', 'pass' => ''))
    {
        return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html" />
    <title>Document</title>
</head>
<body style="background-color: #d6d6d6; margin:0; font-family: \'Arial\', Sans-serif;">
<table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto; padding:0; max-width: 500px; width: 100%; background-color: #ffffff;">
    <tr>
        <td>
            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 15px 40px 15px;">
                <tr>
                    <td style="padding: 5px; text-align:center;">
                        <a href="https://comformo.com/"><img src="https://comformo.com/wp-content/uploads/2019/04/logo-comformo.png" alt="Comformo" width="140" height="58" style="max-width: 100%; height: auto;"></a>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%;
            background-image: url(https://comformo.com/wp-content/uploads/2019/07/handshake-pano.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;">
                <tr>
                    <td style="height: 220px;">

                    </td>
                </tr>
            </table>


            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 40px 45px 0 45px; border-bottom: 1px solid #efeded;
              background-image: url(https://comformo.com/wp-content/uploads/2019/04/paper-boat.png);
              background-repeat: no-repeat;
              background-size: 24%;
              background-position: bottom 7% right 8%;">
                <!-- <tr>
                    <td>
                        <h1 style="text-align:center; font-weight: 600; font-size: 18px; color: #000000; margin: 0 0 20px;">3. Lorem ipsum dolor</h1>
                    </td>
                </tr> -->
                <tr>
                    <td>
                      <h1 style="text-align:center; font-weight: 600; font-size: 33px; color: #e68024; margin: 0;">Thanks for signing up</h1>
                        <p style="text-align: center; font-size: 16px; color: #000000; font-weight: 500; line-height: 1.7;">
                          Thanks you for signing up, <b>' . $userData['name'] . '</b>. We really appreciate it
                        </p>
                        <p style="text-align: center; font-size: 16px; color: #000000; font-weight: 500; line-height: 1.7;">
                          We built <a style="text-decoration:none;color:#fd8e2a;" href="https://comformo.com/">Comformo.com</a> to help people and agents work together on a completely new level.
                          We have tried many tools over the years, and none of them can solve your problems with the automatic creation of the company.
                          Just go <a style="text-decoration:none;color:#fd8e2a;" href="https://cabinet.comformo.com">here</a> and make sure it takes just 10 minutes to complete the form.
                        </p>
                        <p style="text-align: center; font-size: 16px; color: #000000; font-weight: 500; line-height: 1.7;">
                          Your Login: ' . $userData['email'] . '
                        </p>
                        <p style="text-align: center; font-size: 16px; color: #000000; font-weight: 500; line-height: 1.7;">
                          Your password: ' . $userData['pass'] . '
                        </p>
                        <p style="text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;">
                          If you have any questions please call <span style="color: #fd8e2a">+44 203 290 0530</span> <br>or email <span style="color: #fd8e2a">office@comformo.com</span>
                        </p>
                        <p style="text-align: center; font-size: 16px; color: #9e9998; font-weight: 500; line-height: 1.7;margin-bottom: 30px;">
                          With best regards,<br>
                          Comformo
                        </p>
                        <!-- <p style="text-align: center; margin-top: 50px; margin-bottom: 60px;">
                            <a style="color:#ffffff;text-decoration: none; padding: 16px 28px;background-color: #fd8e2a; border-radius: 3px; letter-spacing: 1px;" href="https://comformo.com/">VISIT</a>
                        </p> -->
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 35px 45px 20px;">
                <tr>
                    <td style="padding-right: 15px;">
                        <a href="https://comformo.com/"><img src="https://comformo.com/wp-content/uploads/2019/04/logo-comformo.png" alt="Comformo" width="140" height="58" style="max-width: 100%; height: auto;"></a>
                    </td>
                    <td style="float:right;">
                      <ul style="margin: 0; padding: 0; list-style: none; margin: 15px 0 10px;">
                          <li style="margin: 0 5px 5px;">
                              <a href="tel:+442032900530" style="color: #908074; font-size: 13px; text-decoration: none; color: #ff810f; font-size: 12px; font-weight: 700; display: flex; align-items: center;">
                                <img src="https://comformo.com/wp-content/uploads/2019/04/phone-call-.png" alt="number" width="12" height="auto" style="margin-right: 10px; vertical-align: bottom;"> +44 203 290 0530
                              </a>
                          </li>
                          <li style="margin: 0 5px 5px;">
                              <a href="mailto:office@comformo.com" style="color: #908074; font-size: 13px; text-decoration: none; color: #ff810f;  font-size: 12px; font-weight: 700; display: flex; align-items: center;">
                                <img src="https://comformo.com/wp-content/uploads/2019/04/envelope.png" alt="number" width="12" height="auto" style="margin-right: 10px; vertical-align: bottom;"> office@comformo.com
                              </a>
                          </li>
                          <li style="margin: 0 5px 5px;">
                              <a href="comformo.com" style="color: #908074; font-size: 13px; text-decoration: none; color: #ff810f;  font-size: 12px; font-weight: 700; display: flex; align-items: center;">
                                <img src="https://comformo.com/wp-content/uploads/2019/04/skype.png" alt="number" width="12" height="auto" style="margin-right: 10px; vertical-align: bottom;"> comformo.com
                              </a>
                          </li>
                      </ul>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 0 45px;">
                <tr>
                    <td>
                        <ul style="margin: 0; padding: 0; list-style: none; text-align: center; margin: 15px 0 10px;">
                            <li style="display: inline-block; margin: 0 10px 5px;">
                                <a href="https://comformo.com/privacy-policy/" style="text-decoration: none; color: #948e8e; font-size: 11px;">Privacy Policy</a>
                            </li>

                            <li style="display: inline-block;"><span style="color: #948e8e;">|</span></li>

                            <li style="display: inline-block; margin: 0 10px 5px;">
                                <a href="https://comformo.com/refund-policy/" style="text-decoration: none; color: #948e8e; font-size: 11px;">Returns & Refunds</a>
                            </li>

                            <li style="display: inline-block;"><span style="color: #948e8e;">|</span></li>

                            <li style="display: inline-block; margin: 0 10px 5px;">
                                <a href="https://comformo.com/terms-and-conditions/" style="text-decoration: none; color: #948e8e; font-size: 11px;">Terms & Conditions</a>
                            </li>

                        </ul>
                    </td>
                </tr>
            </table>

            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; width: 100%; padding: 15px 45px 20px;">
                <tr>
                    <td>
                      <p style="font-size: 9px; color: #9e9998; font-weight: 500; line-height: 1.7;max-width: 200px;">
                        Copyright 2019 © Comformo Ltd, trading as one of the top Quality Company formations
                      </p>
                    </td>
                    <td>
                      <p style="float: right;">
                        <img src="https://comformo.com/wp-content/uploads/2019/07/flagss.png" alt="Payments" width="100" height="20" style="max-width: 100%; height: auto; ">
                      </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
';
    }
    // END HTML EMAIL TEMPLATES
    //test email function
    public function sendTestEmail($email, $nom)
    {
        if ($nom == 1) {
            $manager['firstName'] = 'TestFirstName';
            $manager['lastName'] = 'TestLastName';
            $company['companyName'] = 'TestCompanyName';
            $html = $this->htmlApproveDocs($manager, $company);
            $this->sendEmail($email, '', 'Test Email approve docs', $html);
        }
        if ($nom == 2) {
            $company['companyName'] = 'TestCompanyName';
            $html = $this->htmlChangeManager($company);
            $this->sendEmail($email, '', 'Test Email Change Manager', $html);
        }
        if ($nom == 3) {
            $html = $this->htmlUBOSign('', array('firstName' => 'TestFirstName', 'lastName' => 'TestLastName'));
            $this->sendEmail($email, '', 'Test Email UBO Sign declaration', $html);
        }
        if ($nom == 4) {
            $html = $this->htmlRegisterUser(array('name' => 'TestName', 'email' => $email, 'pass' => 'TestPass'));
            $this->sendEmail($email, '', 'Test Email register new user', $html);
        }
    }

    //end test email function

    public function loadJurisdiction()
    {
        $sql = "SELECT * FROM `jurisdiction`;";
        return $this->sqlQuery($sql);
    }

    public function loadAgentJurisdiction()
    {
        $jurisdictionsInfo = [];
        $sql = "SELECT DISTINCT jurisdiction_id FROM `agent`";
        $agents = $this->sqlQuery($sql);
        if (is_array($agents)) {
            foreach ($agents as $agent) {
//				$this->loadJurisdictionInfoApp($agent['jurisdiction_id']);
                $jurisdictionsInfo[] = $this->loadJurisdictionInfoApp($agent['jurisdiction_id']);
            }
        }
        return $jurisdictionsInfo;
    }

    public function loadUsers($premission_group = 'all', $userid = null)
    {
        if ($premission_group == 'all') {
            if ($userid == null) {
                $sql = "SELECT id,email,firstName,lastName,phone,City,zip_code,Country,State,billfirstname,billCity,billzip,billaddress1,billlastname,billCountry,billState,billaddress2,premission_group,agentsId,jurisdictionId,messangerGroupSort,messangerStatus,userId,regDate,phone_carrier,phone_country_code,phone_country_name,phone_country_prefix,phone_international_format,phone_line_type,phone_local_format,phone_location,phone_number,phone_valid,avatar,managerId,defaultmanager,type,status,description,instagram,facebook,twitter FROM `users`";
            } else if ($userid != '') {
                $sql = "SELECT id,email,firstName,lastName,phone,City,zip_code,Country,State,billfirstname,billCity,billzip,billaddress1,billlastname,billCountry,billState,billaddress2,premission_group,agentsId,jurisdictionId,messangerGroupSort,messangerStatus,userId,regDate,phone_carrier,phone_country_code,phone_country_name,phone_country_prefix,phone_international_format,phone_line_type,phone_local_format,phone_location,phone_number,phone_valid,avatar,managerId,defaultmanager,type,status,description,instagram,facebook,twitter FROM `users` WHERE id='{$userid}';";
            }
        } else {
            if ($userid == null) {
                $sql = "SELECT id,email,firstName,lastName,phone,City,zip_code,Country,State,billfirstname,billCity,billzip,billaddress1,billlastname,billCountry,billState,billaddress2,premission_group,agentsId,jurisdictionId,messangerGroupSort,messangerStatus,userId,regDate,phone_carrier,phone_country_code,phone_country_name,phone_country_prefix,phone_international_format,phone_line_type,phone_local_format,phone_location,phone_number,phone_valid,avatar,managerId,defaultmanager,type,status,description,instagram,facebook,twitter FROM `users` WHERE premission_group='{$premission_group}'";
            } else if ($userid != '') {
                $sql = "SELECT id,email,firstName,lastName,phone,City,zip_code,Country,State,billfirstname,billCity,billzip,billaddress1,billlastname,billCountry,billState,billaddress2,premission_group,agentsId,jurisdictionId,messangerGroupSort,messangerStatus,userId,regDate,phone_carrier,phone_country_code,phone_country_name,phone_country_prefix,phone_international_format,phone_line_type,phone_local_format,phone_location,phone_number,phone_valid,avatar,managerId,defaultmanager,type,status,description,instagram,facebook,twitter FROM `users` WHERE premission_group='{$premission_group}' AND id='{$userid}';";
            }
        }
        return $this->sqlQuery($sql);
    }

    public function loadCompanys($manager = 'all')
    {
        if ($manager == 'all') {
            $sql = "SELECT * FROM `companys`;";
            return $this->sqlQuery($sql);
        } else if ($manager != '') {
            $sql = "SELECT * FROM `companys` WHERE userid='{$manager}';";
            return $this->sqlQuery($sql);
        }
    }

    public function loadPeople()
    {
        $sql = "SELECT * FROM `people`;";
        return $this->sqlQuery($sql);
    }

    public function loginIn(array $postArray)
    {
        $email = trim(strtolower($postArray['email']));
        $password = hash('md5', (string)$email . $postArray['password']);
        $sql = "SELECT * FROM `users` WHERE email='{$email}' AND pass='{$password}';";
        $res = $this->sqlQuery($sql);
//			print_r($res);
        if (is_array($res)) {
            $row = $res[0];
            unset($row['pass']);
            if ($row['premission_group'] == '6') {
                if ($row['managerId'] == null || $row['managerId'] == '') {
                    $sql = "SELECT * FROM `users` WHERE defaultmanager='1';";
                    $manager = $this->sqlQuery($sql);
                    $managerData = $manager[0];
                } else {
                    $sql = "SELECT * FROM `users` WHERE id=" . $row['managerId'] . ";";
                    $manager = $this->sqlQuery($sql);
                    $managerData = $manager[0];
                }
                $Companys = $this->getCompanys($row['id']);
                if (is_array($Companys)) {
                    $myCompanys = [];
                    foreach ($Companys as $item) {
                        $docs = $this->getCompanyDocs($item['id']);
                        $item['docs'] = $docs;
                        $myCompanys[] = $item;
                    }
                } else {
                    $myCompanys = $Companys;
                }
                $sicCodes = $this->get_sicCodes(true);
            } else if ($row['premission_group'] == '9') {
                $allCompany = $this->loadCompanys('all');
                $allUsers = $this->loadUsers('6');
                $allLeads = $this->loadUsers('10');
            } else if ($row['premission_group'] == '3' || $row['premission_group'] == '4') {
                if ($row['premission_group'] == '3') {
                    $approveDocs = $this->getApprovDocs($row['id']);
                } else if ($row['premission_group'] == '4') {
                    $approveDocs = $this->getApprovDocs('ALL');
                }
            }
            $allCountry = $this->loadJurisdiction();
            $ourCountry = $this->loadAgentJurisdiction();

            $this->setCookie('login', 'true', 2);
            $this->setCookie('loginIn', $row['premission_group'], 2);
            $this->setCookie('email', $row['email'], 2);
            $this->setCookie('id', $row['id'], 2);
            $this->setCookie('phone', $row['phone'], 2);

            if ($row['premission_group'] == '6') {
                return array('login' => true, 'loginin' => $row['premission_group'], 'userdata' => $row, 'allCountry' => $allCountry, 'ourCountry' => $ourCountry, 'myCompanys' => $myCompanys, 'managerData' => $managerData, 'sicCode' => $sicCodes);
            } else if ($row['premission_group'] == '3' || $row['premission_group'] == '4') {
                return array('login' => true, 'loginin' => $row['premission_group'], 'userdata' => $row, 'allCountry' => $allCountry, 'ourCountry' => $ourCountry, 'approveDocs' => $approveDocs);
            } else if ($row['premission_group'] == '9') {
                return array('login' => true, 'loginin' => $row['premission_group'], 'userdata' => $row, 'allCountry' => $allCountry, 'ourCountry' => $ourCountry, 'allCompanys' => $allCompany, 'allUsers' => $allUsers, 'allLeads' => $allLeads);
            } else {
                return array('login' => true, 'loginin' => $row['premission_group'], 'userdata' => $row, 'allCountry' => $allCountry, 'ourCountry' => $ourCountry);
            }

        } else {
            return array('login' => false, 'error' => 'Check email or password');
        }
    }

    public function loginInSecond(array $postArray)
    {
        $email = str_replace('%40', '@', trim($postArray['email']));
        $phone = $postArray['phone'];
        $id = $postArray['id'];
        $sql = "SELECT * FROM `users` WHERE email='{$email}' AND phone='{$phone}' AND id='{$id}';";
        $res = $this->sqlQuery($sql);
//			print_r($res);
        if (is_array($res)) {
            $row = $res[0];
            unset($row['pass']);
            if ($row['premission_group'] == '6') {
                if ($row['managerId'] == null || $row['managerId'] == '') {
                    $sql = "SELECT * FROM `users` WHERE defaultmanager='1';";
                    $manager = $this->sqlQuery($sql);
                    $managerData = $manager[0];
                } else {
                    $sql = "SELECT * FROM `users` WHERE id=" . $row['managerId'] . ";";
                    $manager = $this->sqlQuery($sql);
                    $managerData = $manager[0];
                }
                $Companys = $this->getCompanys($row['id']);
                if (is_array($Companys)) {
                    $myCompanys = [];
                    foreach ($Companys as $item) {
                        $docs = $this->getCompanyDocs($item['id']);
                        $item['docs'] = $docs;
                        $myCompanys[] = $item;
                    }
                } else {
                    $myCompanys = $Companys;
                }
                $sicCodes = $this->get_sicCodes(true);
            } else if ($row['premission_group'] == '3' || $row['premission_group'] == '4') {
                if ($row['premission_group'] == '3') {
                    $approveDocs = $this->getApprovDocs($row['id']);
                } else if ($row['premission_group'] == '4') {
                    $approveDocs = $this->getApprovDocs('ALL');
                }
            } else if ($row['premission_group'] == '9') {
                $allCompany = $this->loadCompanys('all');
                $allUsers = $this->loadUsers('6');
                $allLeads = $this->loadUsers('10');
            }
            $premission_group = $row['premission_group'];
            $allCountry = $this->loadJurisdiction();
            $ourCountry = $this->loadAgentJurisdiction();

            if ($row['premission_group'] == '6') {
                return array('login' => true, 'loginin' => $premission_group, 'userdata' => $row, 'allCountry' => $allCountry, 'ourCountry' => $ourCountry, 'myCompanys' => $myCompanys, 'managerData' => $managerData, 'sicCode' => $sicCodes);
            } else if ($row['premission_group'] == '3' || $row['premission_group'] == '4') {
                return array('login' => true, 'loginin' => $premission_group, 'userdata' => $row, 'allCountry' => $allCountry, 'ourCountry' => $ourCountry, 'approveDocs' => $approveDocs);
            } else if ($row['premission_group'] == '9') {
                return array('login' => true, 'loginin' => $premission_group, 'userdata' => $row, 'allCountry' => $allCountry, 'ourCountry' => $ourCountry, 'allCompanys' => $allCompany, 'allUsers' => $allUsers, 'allLeads' => $allLeads);
            } else {
                return array('login' => true, 'loginin' => $premission_group, 'userdata' => $row, 'allCountry' => $allCountry, 'ourCountry' => $ourCountry);
            }
        } else {
            return array('login' => false, 'error' => 'Check email or password');
        }
    }

    public function registerUser(array $postArray, $premission_group = '6')
    {
        $postArray['email'] = trim(strtolower($postArray['email']));
        if (empty($postArray['pass'])) {
            $pass = uniqid();
        } else {
            $pass = $postArray['pass'];
        }
        $postArray['pass'] = hash('md5', (string)$postArray['email'] . $pass);
        $postArray['premission_group'] = $premission_group;
        $strPost = $this->PostToInsert($postArray);
        $sql = "INSERT INTO `users` (" . $strPost['keys_string'] . ") VALUES (" . $strPost['values_string'] . ");";
        if ($premission_group != '10') {
            $userData = array('name' => $postArray['firstName'], 'email' => $postArray['email'], 'pass' => $pass);
            $htmlBody = $this->htmlRegisterUser($userData);
            $res = $this->sqlQuery($sql);
            $res['email'] = $this->sendEmail($postArray['email'], $postArray['firstName'], 'You Are register', $htmlBody);
            return $res;
        } else {
            $res = $this->sqlQuery($sql);
            return $res;
        }

    }

    public function managerRegisterUser($postArray)
    {
        $postArray['email'] = str_replace('%40', '@', trim(strtolower($postArray['email'])));
        $pass = uniqid();
        $postArray['pass'] = hash('md5', (string)$postArray['email'] . $pass);
        $strPost = $this->PostToInsert($postArray);
        $sql = "INSERT INTO `users` (" . $strPost['keys_string'] . ") VALUES (" . $strPost['values_string'] . ");";
        $res = $this->sqlQuery($sql);
        $htmlBody = 'email = ' . $postArray['email'] . PHP_EOL . 'password = ' . $pass . PHP_EOL;
        $res['email'] = $this->sendEmail($postArray['email'], '', 'You Are register', $htmlBody);
        return $res;
    }

    public function setNewPass(array $data)
    {
        $id = $data['id'];
        $oldPass = hash('md5', trim(strtolower($data['email'])) . $data['oldPass']);
        $newPass = hash('md5', trim(strtolower($data['email'])) . $data['NewPass']);
        $sql = "UPDATE `users` SET pass='{$newPass}' WHERE id='{$id}' AND pass='{$oldPass}';";
        $result = $this->sqlQuery($sql);
        if ($result['mess'] == 'Sql UPDATE is ok') {
            $sql = "SELECT * FROM `users` WHERE id='{$id}' AND pass='{$newPass}'";
            $result2 = $this->sqlQuery($sql);
            if (is_array($result2)) {
                return array('mess' => 'Password changed');
            } else {
                return array('mess' => 'Error old password not match');
            }
        }
    }

    public function setUserData(array $PostArray)
    {
        $select = $this->postToUpdate($PostArray, true);
        $email = $PostArray['email'];
        $id = $PostArray['id'];
        unset($PostArray['email']);
        unset($PostArray['id']);
        $upDate = $this->postToUpdate($PostArray);
//		print_r($upDate);
        $sql = "UPDATE `users` SET " . $upDate . " WHERE id='{$id}' AND email='{$email}';";
        if ($this->sqlQuery($sql)) {
            $sql = "SELECT * FROM `users` WHERE " . $select . ";";
            $res = $this->sqlQuery($sql);
            if (is_array($res)) {
                return array('mess' => 'Update Success');
            } else {
                return array('mess' => 'Update ERROR');
            }
        }
    }

    public function checkCompanyName($companyName)
    {
        $this->db_company = new \server\db_company();
        $companyName = strtoupper(trim($companyName));
        $companyNameCurl = str_replace(' ', '+', $companyName);
        if ($response = shell_exec('curl -G https://api.opencorporates.com/v0.4/companies/search?q=' . $companyNameCurl)) {
            $response = json_decode($response, true);
            if (!isset($response['error'])) {
//				print_r($response);
                $responseCompany = $response['results']['companies'];
                $api_total_count = $response['results']['total_count'];
            } else {
                $responseCompany = null;
                $api_total_count = 0;
            }
        }
        $sql = "SELECT * FROM `company` WHERE md4hash='" . hash('md4', $companyName . ' LTD') . "' OR md4hash='" . hash('md4', $companyName . ' LIMITED') . "' OR md4hash='" . hash('md4', $companyName) . "';";
        $res = $this->sqlQueryCompany($sql);
        if (is_array($res)) {
            $result['server']['info'] = 'found';
            $result['server']['data'] = $res[0];
            unset($result['server']['data']['md4hash']);
        } else {
            $result['server']['info'] = 'not found';
        }
        $result['api']['data'] = $responseCompany;
        $result['api']['count'] = $api_total_count;
        return $result;
    }

    public function restorePassword(array $postArray)
    {
        $email = trim(strtolower($postArray['email']));
        $sql = "SELECT pass FROM `users` WHERE email='$email';";
        $res = $this->sqlQuery($sql);
        if (is_array($res)) {
            $pass = base64_decode($res[0]['pass']);
            $message = $this->emailHTML('password', 'attention', 'success', 'Hello', 'Remember your password', 'Your password is:' . $pass, '//cabinet.comformo.com');
            $this->sendEmail($email, '', 'Remember your password', $message);
            return array('mess' => 'Message send to email');
        } else {
            return array('mess' => 'Email is not correct');
        }
    }

    public function updateCompany($id, array $data)
    {
        $companyStatus = explode('=', $data['companyStatus']);
        unset($data['companyStatus']);
        $upDate = $this->postToUpdate($data);
        $sql = "SELECT companyStatus FROM `companys` WHERE id='{$id}';";
        if ($res = $this->sqlQuery($sql)) {
            $res = json_decode($res[0]['companyStatus'], true);
            foreach ($res as $key => $value) {
                if ($key == $companyStatus[0]) {
                    $newRes[$key] = $companyStatus[1];
                } else {
                    $newRes[$key] = $value;
                }
            }
            $newRes = json_encode($newRes);
            $sql = "UPDATE `companys` SET " . $upDate . ",companyStatus='{$newRes}' WHERE id='{$id}';";
//			echo $sql;
            return $this->sqlQuery($sql);
        }


    }

    public function updateCompanyStatus($id, array $data)
    {
        $companyStatus = explode('=', $data['companyStatus']);
        unset($data['companyStatus']);
        $sql = "SELECT companyStatus FROM `companys` WHERE id='{$id}';";
        if ($res = $this->sqlQuery($sql)) {
            $res = json_decode($res[0]['companyStatus'], true);
            foreach ($res as $key => $value) {
                if ($key == $companyStatus[0]) {
                    $newRes[$key] = $companyStatus[1];
                } else {
                    $newRes[$key] = $value;
                }
            }
            $newRes = json_encode($newRes);
            $sql = "UPDATE `companys` SET companyStatus='{$newRes}' WHERE id='{$id}';";
            return $this->sqlQuery($sql);
        }
    }

    public function createCompany(array $postArray)
    {
        $post = $this->postToInsert($postArray);
        $sql = "INSERT INTO `companys` (" . $post['keys_string'] . ",companyStatus) VALUES (" . $post['values_string'] . ",'{\"general\":0,\"ubo\":0,\"dillegance\":0,\"fatca\":100}');";
        return $this->sqlQuery($sql);
    }

    public function getCompanys($applicantId)
    {
        $sql = "SELECT * FROM `companys` WHERE applicantid='{$applicantId}';";
        return $this->sqlQuery($sql);
    }

    public function getCompany($companyId)
    {
        $sql = "SELECT * FROM `companys` WHERE id='{$companyId}';";
        return $this->sqlQuery($sql);
    }

    public function peopleAdd(array $postArray)
    {
        $result = array();
        $postArray['email'] = str_replace('%40', '@', $postArray['email']);
//		$date = explode('-',$postArray['dateBirth']);
//		$postArray['dateBirth'] = $date[1].' '.$date[2].' '.$date[3];
        $post = $this->PostToInsert($postArray);
        $sql = "INSERT INTO `people` (" . $post['keys_string'] . ") VALUES (" . $post['values_string'] . ")";
//		echo $sql;
        if ($res = $this->sqlQuery($sql)) {
            $result['people'] = 'added';
            $newLink = $this->getGUID();
            $sql = "INSERT INTO `maillink` (link,active,companyId,email,personId)	 VALUES ('{$newLink}','1','" . $postArray['companyId'] . "','" . $postArray['email'] . "','" . $res['id'] . "');";
            if ($result['mailLinkCreate'] = $this->sqlQuery($sql)) {
                if ($result['mailLinkCreate']['mess'] == 'Sql INSERT is ok') {
                    $htmlBody = $this->htmlUBOSign($newLink);
                    $result['sendingEmail'] = $this->sendEmail($postArray['email'], '', 'You need to sing the document of declanation ', $htmlBody);
                    return $result;
                }
            }
        } else {
            return array('error' => 'Can`t Add Person');
        }
    }

    public function peopleLoad($companyId)
    {
        $sql = "SELECT * FROM `people` WHERE companyId='{$companyId}';";
        $res = $this->sqlQuery($sql);
        $mandatoryPerson = [];
        $shares = [];
        if (is_array($res)) {
            foreach ($res as $item) {
                if ($item['Owner'] == 'true') {
                    $mandatoryPerson[] = 'Owner';
                }
                if ($item['Director'] == 'true') {
                    $mandatoryPerson[] = 'Director';
                }
                if ($item['Shareholder'] == 'true') {
                    $mandatoryPerson[] = 'Shareholder';
                    $shares[] = $item['share'];
                }
                if ($item['Secretary'] == 'true') {
                    $mandatoryPerson[] = 'Secretary';
                }
                if ($item['SignaturyAuthorized'] == 'true') {
                    $mandatoryPerson[] = 'SignaturyAuthorized';
                }
            }
            $mandatoryPerson = array_unique($mandatoryPerson);
        }

        $share = 0;
        for ($i = 0; $i < count($shares); $i++) {
            if ($i > 0) {
                $share = $shares[$i] + $share;
            } else {
                $share = $shares[$i];
            }
        }
        $result['persons'] = $res;
        $result['mandatoryPerson'] = $mandatoryPerson;
        $result['share'] = $share;
        return $result;
    }

    public function peopleUpdate(array $postArray)
    {
        $personId = $postArray['peopleUpdate'];
        unset($postArray['peopleUpdate']);
        $update = $this->postToUpdate($postArray);
        $sql = "UPDATE `people` SET " . $update . " WHERE id='{$personId}';";
        return $this->sqlQuery($sql);
    }

    public function avatarSave($imgBase, $id)
    {
        $sql = "UPDATE `users` SET avatar='{$imgBase}' WHERE id='{$id}';";
        return $this->sqlQuery($sql);
    }

    public function checkWebsite($website_name)
    {
        $ns = shell_exec('nslookup ' . $website_name);
        $ns = explode('Non-authoritative answer:', $ns);
        if (count($ns) >= 2) {
            return array('nsrecord' => 'exist');
        } else {
            return array('nsrecord' => 'notexist');
        }
    }

    public function loadMess($from_id, $my_id)
    {
        $sql = "UPDATE `messages` SET status='read' WHERE (from_id={$from_id} AND my_id={$my_id}) OR (from_id={$my_id} AND my_id={$from_id});";
        $this->sqlQuery($sql);
        $sql = "SELECT * FROM `messages` WHERE (from_id={$from_id} AND my_id={$my_id}) OR (from_id={$my_id} AND my_id={$from_id});";
        return $this->sqlQuery($sql);
    }

    public function saveMess($from_id, $my_id, $mess)
    {
        $sql = "INSERT INTO `messages` (from_id,my_id,mess,who_send,status) VALUES ('{$from_id}','{$my_id}','{$mess}','{$my_id}','send');";
        $res = $this->sqlQuery($sql);
        if ($res['mess'] == 'Sql INSERT is ok') {
            return array('status' => 'ok');
        } else {
            return array('status' => 'err');
        }
    }

    public function SendMessToSupport($postArray)
    {
        $name = $postArray['name'];
        $email = $postArray['email'];
        $mess = $postArray['MessToSupport'];

        $html = "NAME is: $name <br> EMAIL is:<a href:='mailto://$email'>$email</a> <br> TEXT is: $mess";
        return $this->sendEmail('info@comformo.com', '', 'Support request', $html);
    }

    public function saveCompanyFiles($files, $companyId)
    {
//		print_r($files);
        $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $companyId . '/';
        $result = [];
        $errors = [];
        foreach ($files as $key => $file) {
            $uniqid = uniqid('', true);
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_type = $file['type'];
            $file_size = $file['size'];
            $type = explode('/', $file_type);
            $file_name = str_replace(',', ' ', $file_name);
            $file_name = str_replace('.', '', $file_name);
            $file_name = str_replace('"', '', $file_name);
            $file_name = str_replace("'", '', $file_name);
            $file_name = $uniqid . substr($file_name, 0, -3);
            $base_name = base64_encode($file_name);
            $file_name = $file_name . '.' . $type[1];
//            echo '$file_name='.$file_name;
            $file = $path . $base_name . '.' . $type[1];
            if ($file_size > 41943040) {
                $errors = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
            }
            if (file_exists($file)) {
                $errors = 'File exsits ' . $file_name;
            }
            if (!file_exists($path)) {
                mkdir($path);
            }
            if (empty($errors)) {
                move_uploaded_file($file_tmp, $file);
                $sql = "INSERT INTO `userfiles` (key_name,file_name,base_name,type,companyId,status,uniqid) VALUES ('{$key}','{$file_name}','{$base_name}','" . $type[1] . "','{$companyId}','loaded','{$uniqid}');";
                $result['files'] = $this->sqlQuery($sql);
            } else {
                $result[] = $errors;
            }
        }
        $sql = "SELECT userid,applicantid,companyName FROM `companys` WHERE id='{$companyId}';";
        $company = $this->sqlQuery($sql);
        if ($company[0]['userid'] != null || $company[0]['userid'] != '') {
            $sql = "SELECT id,email,firstName,lastName FROM `users` WHERE id='" . $company[0]['userid'] . "'";
            $managers = $this->sqlQuery($sql);
            foreach ($managers as $manager) {
                $newTask = array('who' => $manager['id'], 'howSendTask' => $company[0]['applicantid'], 'whatdo' => base64_encode('Approve documents by company:' . $company[0]['companyName']), 'shortname' => base64_encode('Approve documents by company:' . $company[0]['companyName']), 'status' => 'Active', 'datepickerstart' => date("Y-m-d"));
                $files = [];
                $result['task'][] = $this->addTask($newTask, $files);
                $html = $this->htmlApproveDocs($manager, $company[0]);
                $result['email'][] = $this->sendEmail($manager['email'], '', 'Approve documents', $html);
            }
        } else {
            $sql = "SELECT id,email,firstName,lastName FROM `users` WHERE defaultmanager='1'";
            $managers = $this->sqlQuery($sql);
            foreach ($managers as $manager) {
                $newTask = array('who' => $manager['id'], 'howSendTask' => $company[0]['applicantid'], 'whatdo' => base64_encode('Approve documents by company:' . $company[0]['companyName']), 'shortname' => base64_encode('Approve documents by company:' . $company[0]['companyName']), 'status' => 'Active', 'datepickerstart' => date("Y-m-d"));
                $files = [];
                $result['task'][] = $this->addTask($newTask, $files);
                $html = $this->htmlApproveDocs($manager, $company[0]);
                $result['email'][] = $this->sendEmail($manager['email'], '', 'Approve documents', $html);
            }
        }

        return $result;
    }

    public function get_sicCodes($fromSelect = false)
    {
        if ($fromSelect == false) {
            $sql = "SELECT * FROM `sic`;";
            return $this->sqlQuery($sql);
        } else {
            $sql = "SELECT * FROM `sic`;";
            $res = $this->sqlQuery($sql);
            $newRes = [];
            foreach ($res as $value) {
                $newRes[] = array('index' => $value['sic_code'], 'label' => $value['description']);
            }
            return $newRes;
        }

    }

    public function addTask(array $assocArray, array $files)
    {
        $errors = [];
        $attach = [];
        if (isset($files) && is_array($files)) {
            $path = $_SERVER['DOCUMENT_ROOT'] . '/tasksDoc/' . $assocArray['howSendTask'] . '/';
            foreach ($files as $file) {
                $file_name = $file['name'];
                $file_tmp = $file['tmp_name'];
                $file_type = $file['type'];
                $file_size = $file['size'];
                $type = explode('/', $file_type);
                $file_name = str_replace(',', ' ', $file_name);
                $file_name = str_replace('.', '', $file_name);
                $file_name = str_replace('"', '', $file_name);
                $file_name = str_replace("'", '', $file_name);
                $file_name = substr($file_name, 0, -3);
                $base_name = base64_encode($file_name);
                $file_name = $file_name . '.' . $type[1];
//            echo '$file_name='.$file_name;
                $file = $path . $base_name . '.' . $type[1];

                if ($file_size > 41943040) {
                    $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
                }

                if (file_exists($file)) {
                    $errors[] = 'File exsits' . $file_name;
                }
                if (!file_exists($path)) {
                    mkdir($path);
                }
                if (empty($errors)) {
                    move_uploaded_file($file_tmp, $file);
                    $att = array('file_name' => $file_name, 'base_name' => $base_name, 'type' => $type[1], 'path' => $assocArray['howSendTask']);
                    $attach[] = json_encode($att);
                }
            }
            $assocArray['attach'] = '[' . implode(',', $attach) . ']';
        }
        $data = $this->postToInsert($assocArray);
        $sql = "INSERT INTO `tasks` (" . $data['keys_string'] . ") VALUES (" . $data['values_string'] . ")";
        return $this->sqlQuery($sql);
    }

    public function getMyTasks($myId, $my = false)
    {
        if ($my === false) {
            $sql = "SELECT * FROM `tasks` WHERE who='{$myId}';";
            return $this->sqlQuery($sql);
        } else if ($my === true) {
            $sql = "SELECT * FROM `tasks` WHERE howSendTask='{$myId}';";
            return $this->sqlQuery($sql);
        }
    }

    public function getAllTasks()
    {
        $sql = "SELECT * FROM `tasks`;";
        return $this->sqlQuery($sql);
    }

    public function changeTaskStatus($id, $status)
    {
        $sql = "UPDATE `tasks` SET status='{$status}' WHERE id='{$id}';";
        return $this->sqlQuery($sql);
    }

    public function loadCompanion()
    {
        $sql = "SELECT id,email,firstName,lastName,premission_group FROM `users`;";
        $res = $this->sqlQuery($sql);
//		$worker[]= array('index'=>null,'label'=> 'Workers');
        $worker = [];
//		$applicant[]= array('index'=>null,'label'=> 'Applicants');
        $applicant = [];
//		$genManager[]= array('index'=>null,'label'=> 'General Managers');
        $genManager = [];
//		$agent[]= array('index'=>null,'label'=> 'Agents');
        $agent = [];
//		$admin[]= array('index'=>null,'label'=> 'Admins');
        $admin = [];
//		$defaultManager[]= array('index'=>null,'label'=> 'Default Manager');
        $defaultManager = [];
        if (is_array($res)) {
            foreach ($res as $item) {
                if ($item['premission_group'] == '3') {
                    $worker[] = array('index' => $item['id'], 'label' => $item['firstName'] . ' ' . $item['lastName'] . ' (' . $item['email'] . ') Worker');
                } else if ($item['premission_group'] == '1') {
                    $admin[] = array('index' => $item['id'], 'label' => $item['firstName'] . ' ' . $item['lastName'] . ' (' . $item['email'] . ') Admin');
                } else if ($item['premission_group'] == '4') {
                    $genManager[] = array('index' => $item['id'], 'label' => $item['firstName'] . ' ' . $item['lastName'] . ' (' . $item['email'] . ') General Manager');
                } else if ($item['premission_group'] == '5') {
                    $agent[] = array('index' => $item['id'], 'label' => $item['firstName'] . ' ' . $item['lastName'] . ' (' . $item['email'] . ') Agent');
                } else if ($item['premission_group'] == '6') {
                    $applicant[] = array('index' => $item['id'], 'label' => $item['firstName'] . ' ' . $item['lastName'] . ' (' . $item['email'] . ') Applicant');
                } else if ($item['premission_group'] == '7') {
                    $defaultManager[] = array('index' => $item['id'], 'label' => $item['firstName'] . ' ' . $item['lastName'] . ' (' . $item['email'] . ') Default Manager');
                }
            }
        }
        $result = array_merge($applicant, $agent, $defaultManager, $worker, $genManager, $admin);
        return $result;
    }

    public function getUsersCompanysPeoples()
    {
        $users = $this->loadUsers(6);
        $companys = $this->loadCompanys();
        $peoples = $this->loadPeople();
        return array('users' => $users, 'companys' => $companys, 'peoples' => $peoples);
    }

    public function getCompanyDocs($companyId, $approve = false)
    {
        if ($approve == true) {
            $sql = "SELECT * FROM `userfiles` WHERE companyId='{$companyId}' AND status='loaded';";
        } else {
            $sql = "SELECT * FROM `userfiles` WHERE companyId='{$companyId}';";
        }
        return $this->sqlQuery($sql);
    }

    public function getApprovDocs($managerId, $accordion = false)
    {
        $sql = "SELECT premission_group FROM `users` WHERE id='{$managerId}';";
        $res = $this->sqlQuery($sql);
        $users = [];
        if (is_array($res)) {
            if ($res[0]['premission_group'] == '4') {
                $sql = "SELECT id,firstName,lastName,email FROM `users` WHERE premission_group='6'";
                $users = $this->sqlQuery($sql);
            } else {
                $sql = "SELECT id,firstName,lastName,email FROM `users` WHERE managerId='{$managerId}' AND premission_group='6'";
                $users = $this->sqlQuery($sql);
            }
        }
        if (is_array($users)) {
            $companyDocs = [];
            foreach ($users as $user) {
                $companys = $this->getCompanys($user['id']);
                if (is_array($companys)) {
                    foreach ($companys as $company) {
                        if ($this->getCompanyDocs($company['id'], true) != 'Sql is empty') {
                            $docs = $this->getCompanyDocs($company['id'], true);
                            if (is_array($docs)) {
                                if ($accordion != false) {
                                    $companyDocs[] = array('user' => array('firstName' => $user['firstName'], 'lastName' => $user['lastName'], 'email' => $user['email']), 'company' => $company, 'doc' => $docs);
                                } else {
                                    foreach ($docs as $doc) {
                                        $companyDocs[] = array('user' => array('firstName' => $user['firstName'], 'lastName' => $user['lastName'], 'email' => $user['email']), 'company' => $company, 'doc' => $doc);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $companyDocs;
        } else {
            return array('error' => 'You don`t have a users');
        }
    }

    public function getAllDocs()
    {
        $sql = "SELECT id,firstName,lastName,email FROM `users` WHERE premission_group='6'";
        $users = $this->sqlQuery($sql);
        if (is_array($users)) {
            $companyDocs = [];
            foreach ($users as $user) {
                $companys = $this->getCompanys($user['id']);
                if (is_array($companys)) {
                    foreach ($companys as $company) {
                        if ($this->getCompanyDocs($company['id']) != 'Sql is empty') {
                            $docs = $this->getCompanyDocs($company['id']);
                            if (is_array($docs)) {
                                foreach ($docs as $doc) {
                                    $companyDocs[] = array('user' => array('firstName' => $user['firstName'], 'lastName' => $user['lastName'], 'email' => $user['email']), 'company' => $company, 'doc' => $doc);
                                }
                            }
                        }
                    }
                }
            }
            return $companyDocs;
        }
    }

    public function setDocStatus($DocStatus, $docID)
    {
        $sql = "UPDATE `userfiles` SET status='{$DocStatus}' WHERE id='{$docID}' ;";
        return $this->sqlQuery($sql);
    }

    public function setTaskAccompanies(array $data)
    {
        $who = $data['who'];
        $changeAccompanies = $data['changeAccompanies'];
        if ($data['whoAgent'] != 'undefined') {
            $whoAgent = $data['whoAgent'];
            $sql = "UPDATE `tasks` SET who='{$who}', whoAgent='{$whoAgent}' WHERE id='{$changeAccompanies}';";
            return $this->sqlQuery($sql);
        } else {
            $sql = "UPDATE `tasks` SET who='{$who}' WHERE id='{$changeAccompanies}';";
            return $this->sqlQuery($sql);
        }


    }

    public function setCompanyManager(array $data)
    {
        if ($data['Agent'] != '' && $data['Agent'] != 'undefined') {
            $sql = "UPDATE `companys` SET userid='" . $data['userid'] . "', Agent='" . $data['Agent'] . "' WHERE id='" . $data['changeManager'] . "'";
        } else {
            $sql = "UPDATE `companys` SET userid='" . $data['userid'] . "' WHERE id='" . $data['changeManager'] . "'";
        }
        $result = $this->sqlQuery($sql);
        $sql = "SELECT CompanyEmail,companyName FROM `companys` WHERE id='" . $data['changeManager'] . "';";
        $company = $this->sqlQuery($sql);
        if ($company[0]['CompanyEmail'] != '' && $company[0]['CompanyEmail'] != NULL && $company[0]['CompanyEmail'] != null) {
            $html = $this->htmlChangeManager($company[0]);
            $result['email'] = $this->sendEmail($company[0]['CompanyEmail'], '', 'Change Manager', $html);
        }
        return $result;
    }

    public function getClients($managerId, $premissionGroup = '6')
    {
        if ($managerId != 'all') {
            $companys = $this->loadCompanys($managerId);
            $users = $this->loadUsers($premissionGroup);
            if (is_array($companys)) {
                $newCompany = [];
                foreach ($companys as $company) {
                    $docs = $this->getCompanyDocs($company['id']);
                    $newCompany[] = array('company' => $company, 'user' => $company['applicantid'], 'docs' => $docs);
                }
                return array('users' => $users, 'companys' => $newCompany);
            } else {
                return array('error' => 'No company');
            }
        } else {
            $companys = $this->loadCompanys('all');
            $users = $this->loadUsers($premissionGroup);
            if (is_array($companys)) {
                $newCompany = [];
                foreach ($companys as $company) {
                    $docs = $this->getCompanyDocs($company['id']);
                    $newCompany[] = array('company' => $company, 'user' => $company['applicantid'], 'docs' => $docs);
                }
                return array('users' => $users, 'companys' => $newCompany);
            } else {
                return array('error' => 'No company');
            }
        }
    }

    public function checkPassportStatus($companyId)
    {
        $sql = "SELECT * FROM `userfiles` WHERE companyId='{$companyId}' AND status='loaded' AND key_name='passportFile_0';";
        $result['loaded'] = $this->sqlQuery($sql);
        $sql = "SELECT * FROM `userfiles` WHERE companyId='{$companyId}' AND status='Confirm' AND key_name='passportFile_0';";
        $result['Confirm'] = $this->sqlQuery($sql);
        $sql = "SELECT * FROM `userfiles` WHERE companyId='{$companyId}' AND status='Cancel' AND key_name='passportFile_0';";
        $result['Cancel'] = $this->sqlQuery($sql);
        return $result;
    }

    public function getMaillinkInfo($link)
    {
        $sql = "SELECT * FROM `maillink` WHERE link='{$link}';";
        $res['link'] = $this->sqlQuery($sql);
        $companyId = ($res['link'][0]['companyId']);
        $res['company'] = $this->getCompany($companyId);
        $this->setLinkUnactive($link);
        return $res;
    }

    public function setLinkUnactive($link)
    {
        $sql = "UPDATE `maillink` SET active='0' WHERE link='{$link}';";
        return $this->sqlQuery($sql);
    }

    public function genNewLink(array $postArray)
    {
        $newLink = $this->getGUID();
        $sql = "INSERT INTO `maillink` (link,active,companyId,email,personId) VALUES ('{$newLink}','1','" . $postArray['companyId'] . "','" . $postArray['email'] . "','" . $postArray['personId'] . "');";
        $htmlBody = $this->htmlUBOSign($newLink);
        $this->sendEmail($postArray['email'], '', 'You need to sing the document of declanation ', $htmlBody);
        return $this->sqlQuery($sql);
    }

    public function getFooterComformo()
    {
        $doc = new \DOMDocument();
        $doc->validateOnParse = true;
        $file = shell_exec('curl https://comformo.com');
        return $file;
    }

    public function createZip($filelist, $fileName = 'Archive')
    {
        $zippath = $_SERVER['DOCUMENT_ROOT'] . '/ziptmp/';
        $link = '/ziptmp/';
        $filelist = json_decode($filelist, true);
        $list = [];
        foreach ($filelist as $file) {
            $path = $_SERVER['DOCUMENT_ROOT'] . '/tasksDoc/' . $file['path'] . '/';
            $name = $file['base_name'];
            $list[] = $path . $name . '.' . $file['type'];
        }
        $list = implode(' ', $list);
        $zipFileName = $fileName . '_' . uniqid() . '_' . date("d-m-Y_H:i:s") . '.zip';
        if ($result = shell_exec('zip -D
			 ' . $zippath . $zipFileName . ' ' . $list)) {
            return array('link' => $link . $zipFileName);
        } else {
            return array('error' => 'Somthing Wrong');
        }
    }

    public function addLead(array $postArray)
    {
        return $this->registerUser($postArray, '10');
    }

    public function addInvoce(array $postArray)
    {
        $sql = "INSERT INTO `companys` (companyName,CompanyWebsite,jurisdiction,applicantid,package,companyStatus) VALUES ('" . $postArray['companyName'] . "','" . $postArray['CompanyWebsite'] . "','" . $postArray['jurisdictionId'] . "','" . $postArray['userId'] . "','offline','{\"general\":0,\"ubo\":0,\"dillegance\":0,\"fatca\":100}');";
        $res = $this->sqlQuery($sql);
//		print_r($res);

        if ($res['mess'] == 'Sql INSERT is ok') {
            $sql = "INSERT INTO `invoce` (num,sum,description,companyId,userId) VALUES ('{$postArray['num']}','{$postArray['sum']}','{$postArray['description']}','{$res['id']}','{$postArray['userId']}')";
            $res2 = $this->sqlQuery($sql);
            if ($res2['mess'] == 'Sql INSERT is ok') {
                $sql = "UPDATE `users` SET premission_group='6' WHERE id='{$postArray['userId']}';";
                $res3 = $this->sqlQuery($sql);
                return array('company' => $res, 'invoce' => $res2, 'user' => $res3);
            } else {
                return array('company' => $res, 'invoce' => $res2, 'user' => 'ERR');
            }
        } else {
            return array('company' => $res, 'invoce' => 'ERR', 'user' => 'ERR');
        }

    }

    public function getAllInvoce()
    {
        $sql = 'SELECT * FROM `invoce`;';
        return $this->sqlQuery($sql);
    }

    public function loadUsersStatus()
    {
        return $this->sqlQuery('SELECT * FROM `usersStatus`;');
    }


//	public function getUser($id)
//	{
//		$sql = "SELECT * FROM `users` WHERE id='{$id}'";
//		return $this->sqlQuery($sql);
//	}
//	public function removeUser($id, $tableWhere)
//	{
//		$sql = "SELECT * FROM `$tableWhere` WHERE id='{$id}';";
//		$res = $this->sqlQuery($sql);
//		$uniqid = $res[0]['uniqid'];
//		$sql = "DELETE FROM `maillink` WHERE uniqid='{$uniqid}';";
//		$this->sqlQuery($sql);
//		$sql = "DELETE FROM `$tableWhere` WHERE id='{$id}'";
//		$this->db = new db();
//		if ($query = $this->db->con->query($sql)) {
//			$this->result = 'People delete';
//		} else {
//			$this->result = "Error: DB is OUT";
//		}
//		return $this->result;
//	}
//
//	public function loadPremmisionGroup()
//	{
//		$sql = "SELECT * FROM `premision`";
//		return $this->sqlQuery($sql);
//	}
//
//	public function loadApplicants()
//	{
//		$sql = "SELECT * FROM `applicant`";
//		return $this->sqlQuery($sql);
//	}
//
//	public function pinApplicantToUser($userid, $applicantId, $CheckOrNot)
//	{
//		if ($CheckOrNot == 'true') {
//			$sql = "UPDATE `applicant` SET userid='$userid' WHERE id='$applicantId';";
//		} else {
//			$sql = "UPDATE `applicant` SET userid='0' WHERE id='$applicantId';";
//		}
//		$res = $this->sqlQuery($sql);
//		if($res =='Sql UPDATE is ok'){
//			echo "<br>ok";
//		}else{
//			echo "Error: DB is OUT";
//		}
//	}
//
//	public function loadApplicantsView($userid)
//	{
//		$applicants = $this->loadApplicants();
//		foreach ($applicants as $applicant) {
//			if ($applicant['userid'] == $userid) {
//				echo "<tr>
//                <td>
//                <input type='checkbox' name='add_applicant_id' data-id='" . $applicant['id'] . "'  id='applicant_id_" . $applicant['id'] . "' checked>
//                <label for='applicant_id_" . $applicant['id'] . "'>Add this</label>
//                </td>
//                <td class='search'>" . $applicant['lastName'] . "</td>
//                <td>" . $applicant['firstName'] . "</td>
//                <td class='searchEmail'>" . $applicant['email'] . "</td>
//                </tr>";
//			} else {
//				echo "<tr>
//                <td>
//                <input type='checkbox' name='add_applicant_id' data-id='" . $applicant['id'] . "'  id='applicant_id_" . $applicant['id'] . "'>
//                <label for='applicant_id_" . $applicant['id'] . "'>Add this</label>
//                </td>
//                <td class='search'>" . $applicant['lastName'] . "</td>
//                <td>" . $applicant['firstName'] . "</td>
//                <td class='searchEmail'>" . $applicant['email'] . "</td>
//                </tr>";
//			}
//		}
//	}
//
//	public function AddUser($email, $password, $lastname, $firstname, $premissionGroup)
//	{
//		$sql = "INSERT INTO `users` (email,pass,lastname,firstname,premission_group,admin)VALUES('$email','" . base64_encode($password) . "','$lastname','$firstname','$premissionGroup','0');";
//		$res = $this->sqlQuery($sql);
//		if ($res ) {
//			echo 'ok';
//		} else {
//			echo "Error: DB is OUT";
//		}
//	}
//
//	public function loadInJson($functionName)
//	{
//		return json_encode($functionName);
//	}
//
//	public function loadApplicantDoc($uniqid)
//	{
//		$path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $uniqid . '/';
//		if (file_exists($path)) {
//			$list = shell_exec("ls -m $path");
//			if (!empty($list)) {
//				$list = explode(',', $list);
//			}
//		} else {
//			echo "No files load";
//		}
////    echo $list;
//		return $list;
//	}
//
//	public function loadApplicantDocStatusCheck($uniqid, $filename)
//	{
//		$this->result = array();
////    echo '$filename='.$filename;
//		$sql = "SELECT status FROM `userfiles` WHERE uniqid='{$uniqid}' AND filename='" . base64_encode($filename) . "';";
//		$this->db = new db();
//		$this->db->con->set_charset('utf8');
//		if ($query = $this->db->con->query($sql)) {
//			if ($query->num_rows > 0) {
//				while ($row = $query->fetch_assoc()) {
//					$this->result = $row['status'];
//				}
//			} else {
//				$this->result = 'On checking';
//			}
//		} else {
//			$this->result = 'Error: DB is OUT';
//		}
//		return $this->result;
//	}
//
//	public function getApplicantDocsInDB($uniqid)
//	{
//		$this->result = array();
////    echo '$filename='.$filename;
//		$sql = "SELECT status,filename FROM `userfiles` WHERE uniqid='{$uniqid}';";
//		$this->db = new db();
//		$this->db->con->set_charset('utf8');
//		if ($query = $this->db->con->query($sql)) {
//			if ($query->num_rows > 0) {
//				while ($row = $query->fetch_assoc()) {
//					$this->result[] = $row;
//				}
//			} else {
//				$this->result = 'On checking';
//			}
//		} else {
//			$this->result = 'Error: DB is OUT';
//		}
//		return $this->result;
//	}
//	public function saveAvatar($filename, $filestatus, $uniqid){
//		$insert = "INSERT INTO `userfiles` (filename,status,uniqid) VALUES ('" . base64_encode($filename) . "','{$filestatus}','{$uniqid}');";
//		return $this->sqlQuery($insert);
//	}
//	public function saveFileStatus($filename, $filestatus, $uniqid)
//	{
//		$insert = "INSERT INTO `userfiles` (filename,status,uniqid) VALUES ('" . base64_encode($filename) . "','{$filestatus}','{$uniqid}');";
//		$check = "SELECT * FROM `userfiles` WHERE uniqid='{$uniqid}' AND filename='" . base64_encode($filename) . "';";
//		$update = "UPDATE `userfiles` SET status='{$filestatus}' WHERE uniqid='{$uniqid}' AND filename='" . base64_encode($filename) . "';";
//		$this->db = new db();
//		$this->db->con->set_charset('utf8');
//		if ($q = $this->db->con->query($check)) {
//			if ($q->num_rows == 0) {
//				$this->db->con->set_charset('utf8');
//				if ($q1 = $this->db->con->query($insert)) {
//					$this->result = "$filename is insert in DB";
//				} else {
//					$this->result = "$filename not insert in DB";
//				}
//			} else {
//				$this->db->con->set_charset('utf8');
//				if ($q1 = $this->db->con->query($update)) {
//					$this->result = "$filename is update in DB";
//				} else {
//					$this->result = "$filename not update in DB";
//				}
//			}
//		} else {
//			$this->result = 'Error: DB is OUT';
//		}
//		return $this->result;
//	}
//
//
//
////	public function createPDF($htmlString, $pathEnd, $filename = 'form')
////	{
////		//Параметры
////		$apikey = 'f5932e977cd69b0deb42692cdf6cc0c2'; //получить можно тут: https://www.pdf4b.ru/register
////		$value = $htmlString; //может быть HTML или URL, начинающийся с https://...
////
////		$postdata = http_build_query(
////			array(
////				'apikey' => $apikey,
////				'value' => $value,
////				'MarginBottom' => '20',
////				'MarginTop' => '20'
////			)
////		);
////
////		$opts = array('http' =>
////			array(
////				'method' => 'POST',
////				'header' => 'Content-type: application/x-www-form-urlencoded',
////				'content' => $postdata
////			)
////		);
////
////		$context = stream_context_create($opts);
////
//////Преобразовываем HTML в PDF посредством отправки данных методом POST в API с параметрами
////		$this->result = file_get_contents('https://api.pdf4b.ru/pdf', false, $context);
////		$path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $pathEnd;
////		if (!file_exists($path)) {
////			mkdir($path, 0755, true);
////		}
//////Сохраняем полученный файл на сервере
////		if (file_put_contents($path . '/' . $filename . '.pdf', $result)) {
////			return 'File saved';
////		}
////	}
//
////	public function imageToBase64($fileName)
////	{
////		$uniqid = $_COOKIE['uniqid'];
////		$path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $uniqid . '/' . $fileName;
////		$type = pathinfo($path, PATHINFO_EXTENSION);
////		$data = file_get_contents($path);
////		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
////		return $base64;
////	}
////
////
////
////	public function loadJurisdictionInfo($JurisdictionId)
////	{
////		$sql = "SELECT * FROM `jurisdiction` WHERE id='{$JurisdictionId}';";
////		return $this->sqlQuery($sql);
////	}
////
////	public function saveJurisdiction($jurisdictionName)
////	{
////		$sql = "SELECT id FROM `jurisdiction` WHERE jurisdictionname='$jurisdictionName';";
////		$this->db = new db();
////		if ($query = $this->db->con->query($sql)) {
////			if ($query->num_rows == 0) {
////				$sql = "INSERT INTO `jurisdiction` (jurisdictionname)values('$jurisdictionName');";
////				if ($query = $this->db->con->query($sql)) {
////					echo "Data is Add";
////				} else {
////					echo "Error: Can't insert in DB is OUT";
////				}
////			} else {
////				echo "This name is exist";
////			}
////		} else {
////			echo "Error: DB is OUT";
////		}
////	}
////
////	public function loadJurisdictionAgent($type = 'id', $filds = '*')
////	{
////		$sql = "SELECT {$filds} FROM `jurisdiction`;";
////		$this->db = new db();
////		$this->db->con->set_charset('UTF8');
////		if ($query = $this->db->con->query($sql)) {
////			if ($query->num_rows > 0) {
////				while ($row = $query->fetch_assoc()) {
////					if ($type == 'id') {
////						echo "<option value='" . $row['id'] . "'>" . $row['jurisdictionname'] . "</option>";
////					} else if ($type == 'array') {
////						$this->result[] = $row;
////					}
////
////				}
////			} else {
////				if ($type == 'id') {
////					echo "<tr><td colspan='3'>DB is empty</td></tr>";
////				} else if ($type == 'array') {
////					$this->result[] = 'DB is empty';
////				}
////			}
////		} else {
////			if ($type == 'id') {
////				echo "";
////			} else if ($type == 'array') {
////				$this->result[] = 'Error: DB is OUT';
////			}
////		}
////		return $this->result;
////	}
////
////	public function JurisdictionAgentload()
////	{
////		$sql = "SELECT * FROM `agent`;";
////		$this->db = new db();
////		if ($query = $this->db->con->query($sql)) {
////			if ($query->num_rows > 0) {
////				while ($row = $query->fetch_assoc()) {
////					$sql2 = "SELECT * FROM `jurisdiction` WHERE id='" . $row['jurisdiction_id'] . "';";
////					if ($query2 = $this->db->con->query($sql2)) {
////						if ($query2->num_rows > 0) {
////							while ($row2 = $query2->fetch_assoc()) {
////								echo "<tr>
////                                    <td>" . $row['id'] . "</td>
////                                    <td>" . $row2['jurisdictionname'] . "</td>
////                                    <td>" . $row['agentname'] . "</td>
////                                    <td><a href='/function/get/?removeagentid=" . $row['id'] . "'><span class='glyphicon glyphicon-remove'></span> Remove</a></td>
////                                </tr>";
////							}
////						}
////					}
////				}
////			} else {
////				echo "<tr><td colspan='3'>DB is empty</td></tr>";
////			}
////		} else {
////			echo "Error: DB is OUT";
////		}
////
////
////	}
////
////	public function Agents($sqlQuery)
////	{
////		$this->db = new db();
////		$whatQuery = explode(' ', $sqlQuery);
////		$whatQuery = $whatQuery[0];
////		if ($whatQuery == 'SELECT') {
////			if ($query = $this->db->con->query($sqlQuery)) {
////				if ($query->num_rows > 0) {
////					$this->result = 'true';
////				} else {
////					$this->result = 'false';
////				}
////			} else {
////				$this->result = "Error: this sql is not correct: $sqlQuery";
////			}
////		}
////		return $this->result;
////	}
////
////	public function saveAgent($jurisdiction_id, $agentname)
////	{
////		$sql = "SELECT id FROM `agent` WHERE agentname='$agentname' AND jurisdiction_id='$jurisdiction_id';";
////		$this->db = new db();
////		if ($query = $this->db->con->query($sql)) {
////			if ($query->num_rows == 0) {
////				$sql = "INSERT INTO `agent` (agentname,jurisdiction_id)values('$agentname','$jurisdiction_id');";
////				if ($query = $this->db->con->query($sql)) {
////					echo "Data is Add";
////				} else {
////					echo "Error: Can't insert in DB is OUT";
////				}
////			} else {
////				echo "This name is exist";
////			}
////		} else {
////			echo "Error: DB is OUT";
////		}
////	}
////
////	public function loadAgentInSelection($jurisdictionId)
////	{
////		$sql = "SELECT * FROM `agent` WHERE jurisdiction_id='$jurisdictionId';";
////		$this->db = new db();
////		$this->db->con->set_charset('UTF8');
////		if ($query = $this->db->con->query($sql)) {
////			if ($query->num_rows > 0) {
////				while ($row = $query->fetch_assoc()) {
////					echo "<option value='" . $row['id'] . "'>" . $row['agentname'] . "</option>";
////				}
////			} else {
////				echo "<option value='NULL'>No Agent in this Jurisdiction</option>";
////			}
////		} else {
////			echo "Error: DB is OUT";
////		}
////	}
////
////	public function removeMyFile($uniqid, $removefile)
////	{
////		$path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $uniqid . '/';
////		$sql = "DELETE FROM `userfiles` WHERE uniqid='{$uniqid}' AND filename='" . base64_encode($removefile) . "';";
////		if ($query = $this->db->con->query($sql)) {
////			if (file_exists($path . $removefile)) {
////				unlink($path . $removefile);
////				header("Location: /?page=docs");
////			}
////		} else {
////			if (file_exists($path . $removefile)) {
////				unlink($path . $removefile);
////				header("Location: /?page=docs");
////			}
////		}
////	}
////
////	public function removePeople($removedId)
////	{
////		$sql = "DELETE FROM `people` WHERE id='$removedId'";
////		$this->db = new db();
////		if ($query = $this->db->con->query($sql)) {
////			header('Location: /?page=form');
////		} else {
////			echo 'Error: remove record people';
////		}
////	}
////
////	public function getCheckingFiles($status = 'On Checking')
////	{
////		$sql = "SELECT * FROM `userfiles` WHERE status='{$status}';";
////		return $this->sqlQuery($sql);
////	}
////
////	public function getApplicantInfo($uniqid)
////	{
////		$sql = "SELECT * FROM `applicant` WHERE uniqid='{$uniqid}';";
////		return $this->sqlQuery($sql);
////	}
////
////	public function getApplicantInfoById($id)
////	{
////		$sql = "SELECT * FROM `applicant` WHERE id='{$id}';";
////		return $this->sqlQuery($sql);
////	}
////
////
////
////	public function getCompanyInfo($id)
////	{
////		$sql = "SELECT * FROM `companyinfo` WHERE id='{$id}';";
////		return $this->sqlQuery($sql);
////	}
////
//////	public function notesMassage(string $type, string $warningText, string $message, string $link, string $linkCaption)
//////	{
//////		$type = strtolower($type);
//////		switch ($type) {
//////			case 'danger':
//////				echo "<div class='alert alert-danger'>
//////                    <strong>$warningText!</strong> $message! <a href='$link' class='alert-link'>$linkCaption</a>.
//////                </div>";
//////				break;
//////			case 'success':
//////				echo "<div class='alert alert-success'>
//////                    <strong>$warningText!</strong> $message! <a href='$link' class='alert-link'>$linkCaption</a>.
//////                </div>";
//////				break;
//////			case 'warning':
//////				echo "<div class='alert alert-warning'>
//////                    <strong>$warningText!</strong> $message! <a href='$link' class='alert-link'>$linkCaption</a>.
//////                </div>";
//////				break;
//////		}
//////	}
////
//////	public function getSteper(string $step, string $status)
//////	{
//////		echo "<li class='StepProgress-item $status'><strong>step&nbsp$step</strong></li>";
//////	}
////
//////	function allSteps(int $whatStepNow, int $allStep)
//////	{
//////		echo '<div class="process">
//////            <ul class="StepProgress">';
//////		for ($s = 1; $s < $allStep + 1; $s++) {
//////			if ($s < $whatStepNow) {
//////				getSteper($s, 'is-done');
//////			} else if ($s == $whatStepNow) {
//////				getSteper($s, 'current');
//////			} else if ($s > $whatStepNow) {
//////				getSteper($s, '');
//////			}
//////		}
//////		echo '</ul>
//////        </div>';
//////	}
////
////	public function dbQuery(string $type, $keys, $values, $whatTable)
////	{
////		$this->db = new db();
////		$type = strtolower($type);
////		if ($type == 'insert') {
////			$name = '';
////			$value = '';
////			for ($s = 0; $s < count($keys); $s++) {
////				if ($keys[$s] != 'uniqid' || $keys[$s] != 'applicantid') {
////					if ($s == count($keys) - 1) {
////						$name .= $keys[$s];
////						$value .= '"' . base64_encode(trim($values[$s])) . '"';
////					} else {
////						$name .= $keys[$s] . ',';
////						$value .= '"' . base64_encode(trim($values[$s])) . '",';
////					}
////				} else {
////					if ($s == count($keys) - 1) {
////						$name .= $keys[$s];
////						$value .= '"' . trim($values[$s]) . '"';
////					} else {
////						$name .= $keys[$s] . ',';
////						$value .= '"' . trim($values[$s]) . '",';
////					}
////				}
////
////			}
//////    echo '$name='.$name.'<br>';
//////    echo '$value='.$value.'<br>';
////			$sql = "INSERT INTO `$whatTable` ($name) VALUES ($value);";
//////        echo $sql;
////			if ($query = $this->db->con->query($sql)) {
////				$this->result = "Insert in db is OK";
////			} else {
////				$this->result = "Error: DB is OUT";
////			}
////			return json_encode($this->result);
////		}
////		if ($type == 'update') {
////			if (is_array($keys)) {
////				$set = '';
//////            echo 'is array';
////				for ($s = 0; $s < count($keys); $s++) {
////					if ($s == count($keys) - 1) {
////						$set .= $keys[$s] . '="' . base64_encode(trim($values[$s])) . '"';
////					} else {
////						$set .= $keys[$s] . '="' . base64_encode(trim($values[$s])) . '",';
////					}
////				}
////				$sql = "UPDATE `$whatTable` SET $set;";
////			} else {
////				$sql = "UPDATE `$whatTable` SET $keys='" . base64_encode(trim($values)) . "';";
////			}
//////        echo $sql;
////			if ($query = $this->db->con->query($sql)) {
////				$this->result = "Update in db is OK";
////			} else {
////				$this->result = "Error: DB is OUT";
////			}
////			return json_encode($this->result);
////		}
////	}
////
////	public function formGeneralStatusCheck($uniqid)
////	{
////		$sql = "SELECT id,status FROM `companyinfo` WHERE uniqid='$uniqid'; ";
////		return $this->sqlQuery($sql);
////	}
////
////
////
////
////
////	public function CounterpartiesSave($sql)
////	{
////		$res = $this->sqlQuery($sql);
////		if($res == 'Sql INSERT is ok'){
////			return $this->result = 'ok';
////		}else{
////			return $this->result = "ERROR: DB is OUT";
////		}
////	}
////
////	public function getPrincipal($companyId, $applicantid)
////	{
////		$Principal = base64_encode('Principal');
////		$sql = "SELECT Counterparty FROM `counterparty` WHERE companyId='{$companyId}' AND applicantid='{$applicantid}' AND Counterparty='{$Principal}';";
////		$this->db = new db();
////		if ($query = $this->db->con->query($sql)) {
////			$PrincipalCount = $query->num_rows;
////			$this->setCookies('Principal', $PrincipalCount);
////		}
////	}
////
////	public function getBeneficiaries($companyId, $applicantid)
////	{
////
////		$Beneficiaries = base64_encode('Beneficiaries');
////		$sql = "SELECT Counterparty FROM `counterparty` WHERE companyId='{$companyId}' AND applicantid='{$applicantid}' AND Counterparty='{$Beneficiaries}';";
////		$this->db = new db();
////		if ($query = $this->db->con->query($sql)) {
////			$BeneficiariesCount = $query->num_rows;
////			$this->setCookies('Beneficiaries', $BeneficiariesCount);
////		}
////	}
////
////
////
////	public function loadMess($from_id, $my_id)
////	{
////		$this->db=new db();
////		$sql = "SELECT * FROM `messages` WHERE (from_id={$from_id} AND my_id={$my_id}) OR (from_id={$my_id} AND my_id={$from_id});";
////		if ($query = $this->db->con->query($sql)) {
////			if ($query->num_rows > 0) {
////				while ($row = $query->fetch_assoc()) {
//////                print_r($row);
////					if ($row['from_id'] == $my_id) {
////						$this->statusMessUpd($row['id']);
////					}
////					$this->result[] = $row;
////				}
////			} else {
////				$this->result = 'empty';
////			}
////		} else {
////			$this->result = "Error: DB is OUT";
////		}
////		return $this->result;
////	}
////
////	public function saveMess($from_id, $my_id, $mess)
////	{
////		$sql = "INSERT INTO `messages` (from_id,my_id,mess,who_send,status) VALUES ('{$from_id}','{$my_id}','{$mess}','{$my_id}','send');";
////		$res = $this->sqlQuery($sql);
////		if ($res=='Sql INSERT is ok') {
////			$this->result = 'ok';
////		} else {
////			$this->result = "Error: DB is OUT";
////		}
////		return $this->result;
////	}
////
////	private function statusMessUpd($id)
////	{
////		$sql = "UPDATE `messages` SET status='read' WHERE id={$id};";
////		$res = $this->sqlQuery($sql);
////		if ($res=='Sql UPDATE is ok') {
////			$this->result = 'ok';
////		} else {
////			$this->result = "Error: DB is OUT";
////		}
////		return $this->result;
////	}
////
////	public function checkMess($userId)
////	{
////		$sql = "SELECT * FROM `messages` WHERE who_send={$userId} AND status='send';";
////		$res = $this->sqlQuery($sql);
////		if (is_array($res)) {
////			$this->result = count($res);
////		} else {
////			$this->result = $res;
////		}
////		return $this->result;
////	}
////
////	public function checkAllMess($myId)
////	{
////		$sql = "SELECT * FROM `messages` WHERE from_id={$myId} AND status='send';";
////		$res = $this->sqlQuery($sql);
////		if (is_array($res)) {
////			$this->result = count($res);
////		} else {
////			$this->result = $res;
////		}
////		return $this->result;
////	}
////
////	public function getAllActiveTasks()
////	{
////		$sql = "SELECT * FROM `tasks` WHERE status='active' OR status='depend';";
////		return $this->sqlQuery($sql);
////	}
////
////	public function saveTask(array $AssocDataArray)
////	{
////		$errors = array();
////		$attach = array();
////		if (isset($_FILES['files'])) {
////			if ($_FILES['files']['name'][0] != '') {
////				$path = $_SERVER['DOCUMENT_ROOT'] . '/tasksDoc/';
////				$extensions = ['jpg', 'jpeg', 'png', 'pdf', 'page', 'numbers', 'docx', 'doc', 'xlsx', 'xls', 'ppt', 'pptx', 'csv', 'x-iwork-pages-sffpages'];
////				$all_files = count($_FILES['files']['tmp_name']);
////				for ($i = 0; $i < $all_files; $i++) {
////					$file_name = $_FILES['files']['name'][$i];
////					$file_tmp = $_FILES['files']['tmp_name'][$i];
////					$file_type = $_FILES['files']['type'][$i];
////					$file_size = $_FILES['files']['size'][$i];
////					$file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));
////					$type = explode('/', $file_type);
////					$file_name = str_replace(',', ' ', $file_name);
////					$file_name = str_replace('.', '', $file_name);
////					$file_name = str_replace('"', '', $file_name);
////					$file_name = str_replace("'", '', $file_name);
////					$file_name = substr($file_name, 0, -3);
////					$base_name = base64_encode($file_name);
////					$file_name = $file_name . '.' . $type[1];
//////            echo '$file_name='.$file_name;
////					$file = $path . $base_name . '.' . $type[1];
////
////					if (!in_array($file_ext, $extensions)) {
////						$errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
////					}
////
////					if ($file_size > 41943040) {
////						$errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
////					}
////
////					if (file_exists($file)) {
////						$errors[] = 'File exsits' . $file_name;
////					}
////					if (!file_exists($path)) {
////						mkdir($path);
////					}
////					if (empty($errors)) {
////						move_uploaded_file($file_tmp, $file);
////						$att = array('file_name' => $file_name, 'base_name' => $base_name, 'type' => $type[1]);
////						$attach[] = array_merge($attach, $att);
////					}
////				}
////			} else {
////				$attach = [];
////			}
////		}
////		if (is_array($AssocDataArray)) {
////			$AssocDataArray['attach'] = base64_encode(json_encode($attach));
////			if ($AssocDataArray['dependTask'] == 'depend') {
////				$AssocDataArray['status'] = 'depend';
////				unset($AssocDataArray['datepickerstart']);
////			} else {
////				unset($AssocDataArray['dependTaskSelect']);
////				$AssocDataArray['status'] = 'active';
////			}
////			$keys = '';
////			$values = '';
////			foreach ($AssocDataArray as $key => $value) {
////				end($AssocDataArray);
////				if ($key === key($AssocDataArray)) {
////					if ($key == 'shortname' || $key == 'whatdo') {
////						$keys .= "{$key}";
////						$values .= "'" . base64_encode($value) . "'";
////					} else {
////						$keys .= "{$key}";
////						$values .= "'{$value}'";
////					}
////
////				} else {
////					if ($key == 'shortname' || $key == 'whatdo') {
////						$keys .= "{$key},";
////						$values .= "'" . base64_encode($value) . "',";
////					} else {
////						$keys .= "{$key},";
////						$values .= "'{$value}',";
////					}
////				}
////			}
////			$sql = "INSERT INTO `tasks` ($keys) VALUES ($values);";
////			if ($query = $this->db->con->query($sql)) {
////				$this->result = 'insert';
////			} else {
////				$this->result = "Error: DB is OUT, {$sql}";
////			}
////		} else {
////			$this->result = "Error: Your data is not Array";
////		}
////		if (is_array($errors)) {
////			header('Location: /tasks/?error=' . base64_encode(json_encode($errors)));
////		} else {
////			header('Location: /tasks/');
////		}
////		$errors = array();
////	}
////
////	public function checkAllTasks($myId)
////	{
////		$sql = "SELECT * FROM `tasks` WHERE who='{$myId}' AND status='active';";
////		$res = $this->sqlQuery($sql);
////		if (is_array($res)) {
////			$this->result = count($res);
////		} else {
////			$this->result = "Error: DB is OUT";
////		}
////		return $this->result;
////	}
////
////	public function getMyTasks($myId, $my = false)
////	{
////		if ($my === false) {
////			$sql = "SELECT * FROM `tasks` WHERE who='{$myId}';";
////			return $this->sqlQuery($sql);
////		} else if ($my === true) {
////			$sql = "SELECT * FROM `tasks` WHERE howSendTask='{$myId}';";
////			return $this->sqlQuery($sql);
////		}
////	}
////
////	public function changeTaskStatus($id, $status)
////	{
////		$sql = "UPDATE `tasks` SET status='{$status}' WHERE id='{$id}';";
////		$res = $this->sqlQuery($sql);
////		if ($res=="Sql UPDATE is ok") {
////			$this->result = 'Status update';
////		} else {
////			$this->result = "Error: DB is OUT";
////		}
////		return $this->result;
////	}
//
////	public function viewTasks($whoTask = false)
////	{
////		$tasks = $this->getMyTasks(base64_decode($_COOKIE['id']), $whoTask);
////		if (is_array($tasks)) {
////			foreach ($tasks as $task) {
////				echo "<div class='task " . $task['status'] . "'>";
////				if ($whoTask === false) {
////					if ($task['status'] == 'active') {
////						echo "<div class='status' onmouseover=statusMousOver('status_" . $task['id'] . "') onmouseout=statusMouseOut('status_" . $task['id'] . "') id='status_" . $task['id'] . "'>" . $task['status'];
////					} else {
////						echo "<div class='status'>" . $task['status'];
////					}
////				} else if ($whoTask === true) {
////					echo "<div class='status' onmouseover=statusMousOver('status_" . $task['id'] . "') onmouseout=statusMouseOut('status_" . $task['id'] . "') id='status_" . $task['id'] . "'>" . $task['status'];
////				}
////				echo "  <div class='status_menu'>
////                        <ul>";
////				if ($_COOKIE['loginin'] != 'girls' || $_COOKIE['loginin'] != 'agent') {
////					echo "<li><button onclick=statusChange('" . $task['id'] . "','active')>active</button></li>";
////					echo "<li><div class='panel-group'>
////													<div class='panel panel-default'>
////														<div class='panel-heading'>
////															<h4 class='panel-title'>
////																<a data-toggle='collapse' href='#collapse" . $task['id'] . "'>send to</a>
////															</h4>
////														</div>
////														<div id='collapse" . $task['id'] . "' class='panel-collapse collapse'>";
////					$girls = $this->getUserPremission_group(3);
////					$manager = $this->getUserPremission_group(4);
////					foreach ($girls as $value) {
////						echo "<div class='panel-body' onclick=sendTo('" . $task['id'] . "','" . $value['id'] . "')>" . $value['firstname'] . "</div>";
////					}
////					foreach ($manager as $value) {
////						echo "<div class='panel-body' onclick=sendTo('" . $task['id'] . "','" . $value['id'] . "')>" . $value['firstname'] . "</div>";
////					}
////					echo "</div>
////													</div>
////												</div></li>";
////					echo "<li><button onclick=statusChange('" . $task['id'] . "','closed')>close</button></li>";
////					echo "<li><button onclick=statusChange('" . $task['id'] . "','completed')>completed</button></li>";
////					echo "<li><button onclick=statusChange('" . $task['id'] . "','cancel')>cancel</button></li>";
////
////				} else {
////					echo "<li><button onclick=statusChange('" . $task['id'] . "','completed')>completed</button></li>";
////					echo "<li><button onclick=statusChange('" . $task['id'] . "','unable')>unable to execute</button></li>";
////				}
////				echo "</ul>
////                    </div>
////                </div>
////                <div class='name'>" . base64_decode($task['shortname']) . "</div>
////                <div class='dateStart'>" . $task['datepickerstart'] . "</div>
////                <div class='dateEnd'>" . $task['datepickerend'] . "</div>
////                <div class='timeEnd'>" . $task['time'] . "</div>
////                <div class='whatDo'>" . base64_decode($task['whatdo']) . "</div>
////                <div class='attach'>";
////				$attach = json_decode(base64_decode($task['attach']), true);
////				if (is_array($attach)) {
////					foreach ($attach as $value) {
//////                            print_r($value);
////						echo "<a href='?loadmyfile=" . $value['base_name'] . "." . $value['type'] . "' class='attach_href'><img src='/img/" . $value['type'] . ".png' alt='' > <span class='attach_href_caption'>" . $value['file_name'] . "</span></a>";
////					}
////				} else {
////					echo 'No Attacments';
////				}
////				$commit = $this->getCommit($task['id']);
////				echo "</div>";
////				echo "<div class='form-group commit_add_form' id='commit_form_" . $task['id'] . "'>
////                        <div class='comments'>";
////				if (is_array($commit)) {
////					foreach ($commit as $val) {
////						$user = $this->getUser($val['userIdCommit']);
//////                            print_r($user);
////						echo "<div class='comment'>
////                                    <div class='comment_header'>
////                                        <div class='who'>" . $user[0]['email'] . "</div>
////                                    </div>
////                                    <div class='comment_body'>
////                                        " . $val['commit'] . "
////                                    </div>
////                                    <div class='timestamp'>" . $val['timestamp'] . "</div>
////                                </div>";
////					}
////				}
//////                    print_r($commit);
////
////				echo "</div><hr>
////                        <h4>Add Comment</h4>
////                        <textarea id='commitText_" . $task['id'] . "' cols='30' rows='10' class='textarea form-control' onkeyup=commitLenght('" . $task['id'] . "')></textarea>
////                        <button class='btn btn-success' onclick=addComment('" . $task['id'] . "') id='commit_button_" . $task['id'] . "'><i class='glyphicon glyphicon-plus'></i> Add comment</button>
////                    </div>";
////				echo "<div class='commit' data-toggle='tooltip' title='Comments' onclick=openComment('" . $task['id'] . "')><i class='glyphicon glyphicon-comment'></i>";
////				if (count($commit) > 0) {
////					echo "<i class='bage' style='font-size: 0.6em;right: -15px;top: -11px;position: absolute;'>" . count($commit) . "</i>";
////				}
////
////				echo "</div>
////            </div>";
////			}
////		} else {
////			echo "<div class='notask'>You don't have a task</div>";
////		}
////	}
//
//
//
//	private function getCommit($taskid)
//	{
//		$sql = "SELECT * FROM `tasksCommit` WHERE taskId='{$taskid}';";
//		return $this->sqlQuery($sql);
//	}
//
//
//
//	public function checkApiKey($ApiKey){
//		$this->db_company = new \server\db_company();
//		$sql = "SELECT id FROM `api_keys` WHERE apikey='{$ApiKey}';";
//		$datenow = strtotime(date("d-m-Y"));
//		$res = $this->sqlQueryCompany($sql);
//		if(is_array($res)){
//			$res = true;
//		}else{
//			$res = false;
//		}
//		return $res;
//	}
//
//	public function addApiKey(string $CompanyName, string $startDate, string $endDate){
//		$this->db_company = new \server\db_company();
//		$ApiKey = $this->getGUID();
//		$sql = "INSERT INTO `api_keys` ﻿(apikey,CompanyName,startDate,endDate) VALUES ('{$ApiKey}','{$CompanyName}','{$startDate}','{$endDate}');";
////		echo $sql;
//		$res = $this->sqlQueryCompany($sql);
////		print_r($res);
//		return $res;
//	}
//
//	public function loadAvatar(string $user_id, string $user_table)
//	{
//		$sql = "SELECT href FROM `avatar` WHERE user_id='{$user_id}' AND user_table='{$user_table}';";
//		return $this->sqlQuery($sql);
//	}
//
//	public function getApplicantCompany($applicantId)
//	{
//		$applicantId = base64_decode($applicantId);
//		$sql = "SELECT * FROM `companyinfo` WHERE applicantid='{$applicantId}';";
//		return $this->sqlQuery($sql);
//	}
//
//	public function strPostToArray(string $postString)
//	{
//		$posts = explode('&', $postString);
//		foreach ($posts as $post) {
//			$post = explode('=', $post);
//			$title[] = $post[0];
//			$value[] = "'" . strtolower($post[1]) . "'";
//		}
//		$strTitle = implode(',', $title);
//		$strValue = implode(',', $value);
//		return $this->result = array('titleArray' => $title, 'valueArray' => $value, 'titleString' => $strTitle, 'valueString' => $strValue);
//	}
//
//	public function getCountry($country)
//	{
//		$sql = "SELECT * FROM `jurisdiction` WHERE jurisdictionname LIKE '%" . $country . "%'";
//		return $this->sqlQuery($sql);
//	}
//
//	public function getPackage($id = null)
//	{
//		if ($id == null) {
//			$sql = "SELECT * FROM `package`;";
//			return $this->sqlQuery($sql);
//		} else {
//			$sql = "SELECT * FROM `package` WHERE id='{$id}';";
//			return $this->sqlQuery($sql);
//		}
//	}
//
//
//
//
//
////
//
//	public function getAgentComapany()
//	{
//		$sql = "SELECT * FROM `agent`;";
//		return $this->sqlQuery($sql);
//	}
//
//	public function getAgentComapanyInfo($id)
//	{
//		$sql = "SELECT * FROM `agent` WHERE id='{$id}';";
//		return $this->sqlQuery($sql);
//	}
//
//	public function getUserPremission_group($premission_group = '5')
//	{
//		$sql = "SELECT * FROM `users` WHERE premission_group='$premission_group'";
//		return $this->sqlQuery($sql);
//	}
//
//
//
//	public function messangerGroupSortUpdate($changeIdSelect, $dataInfo)
//	{
//		$sql = "UPDATE `users` SET messangerGroupSort='{$dataInfo}' WHERE id='{$changeIdSelect}';";
//		return $this->sqlQuery($sql);
//	}
//
//
//
//
//
//	public function saveCompanyAndApplicant($assocArray)
//	{
//		$this->db=new db();
//		$assocArray['uniqid'] = uniqid();
//		$sql = "SELECT id FROM `applicant` WHERE email='{$assocArray['email']}'";
//		$res = $this->sqlQuery($sql);
//		if (is_array($res)) {
//			$this->result['error'] = 'This email exists';
//		} else {
////			print_r($assocArray);
//			foreach ($assocArray as $key => $val) {
//				if ($key == 'password') {
//					$postKey[] = $key;
//					$postVal[] = "'" . base64_encode($val) . "'";
//				} else if ($key == 'email') {
//					$postKey[] = $key;
//					$postVal[] = "'" . mysqli_real_escape_string($this->db->con, strtolower($val)) . "'";
//				} else {
//					$postKey[] = $key;
//					$postVal[] = "'" . mysqli_real_escape_string($this->db->con, strtolower($val)) . "'";
//					$companyPostKey[] = $key;
//					$companyPostVal[] = "'" . mysqli_real_escape_string($this->db->con, strtolower($val)) . "'";
//				}
//			}
//			$title = implode(',', $postKey);
//			$value = implode(',', $postVal);
//			$companyTitle = implode(',', $companyPostKey);
//			$companyValue = implode(',', $companyPostVal);
////        echo $companyTitle.'</hr>';
////				echo $companyValue.'</hr>';
//			$sql1 = "INSERT INTO `applicant` (firstName,lastName,email,phone,password,uniqid) VALUES ('" . $assocArray['billingFirstName'] . "','" . $assocArray['billingLastName'] . "','" . $assocArray['email'] . "','" . $assocArray['billingPhone'] . "','" . base64_encode($assocArray['password']) . "','" . $assocArray['uniqid'] . "');";
//			$this->result['applicant'] = sqlQuery($sql1);
//			$sql3 = "SELECT * FROM `applicant` WHERE email='{$assocArray['email']}';";
//			$res = $this->sqlQuery($sql3);
//			$res = $res[0];
////        print_r($res);
//			$crmValue2 = "'" . mysqli_real_escape_string($this->db->con, $assocArray['companyName']) . "','" . $res['id'] . "','" . $res['uniqid'] . "','new','" . $assocArray['Jurisdiction'] . "'";
//			$sql4 = "INSERT INTO `companyinfo` (" . $companyTitle . ",applicantid) VALUES (" . $companyValue . ",'" . $res['id'] . "');";
//			$this->result['company'] = $this->sqlQuery($sql4);
//			$this->result['crm'] = $this->saveCRMVessel($title, $value, $crmValue2);
//			$this->setCookies('companyName', $assocArray['companyName'], 2);
//			$this->setCookies('applicantid', $res['id'], 2);
//			$this->setCookies('uniqid', $res['uniqid'], 2);
//			$this->setCookies('companyId', $this->result['company']['id'], 2);
//			$html = "You Email: <a href='mailto:" . str_replace('%40', '@', $res['email']) . "'>" . str_replace('%40', '@', $res['email']) . "</a><br>
//            You enter the Password: " . base64_decode($res['password']) . "<br>
//            You select a company name: " . $assocArray['companyName'] . "<br>";
//			$bodyHTML = $this->emailHTML('password', 'success', 'success', 'Hello!', 'We created your account', $html, 'http://cabinet.vvssll.com', 'All rights reserved in 2018©');
//			$this->result['applicant']['mail'] = $this->sendEmail(str_replace('%40', '@', $res['email']), null, 'You are register on VVSSLL.COM', $bodyHTML, null);
//		}
//		if (is_array($this->result)) {
//			echo json_encode($this->result);
//		} else {
//			echo $this->result;
//		}
//	}
//
//	public function saveCRMVessel(string $applicantTitle, string $applicantValue, string $companyValue)
//	{
//		$applicantGUID = strtolower($this->getGUID());
//		$taskGUID = strtolower($this->getGUID());
//		$contastGUID = strtolower($this->getGUID());
//		$account_contacts = strtolower($this->getGUID());
//		$applicantTitle = explode(',', $applicantTitle);
//		$applicantValue = str_replace("'", '', explode(',', $applicantValue));
//		$companyValue = str_replace("'", '', explode(',', $companyValue));
//
//		$today = date("Y-m-d H:i:s");
//		$accountTitle = 'id,';
//		$accountValue = "'" . $applicantGUID . "',";
//		$accountTitle_cstm = 'id_c,';
//		$accountValue_cstm = "'" . $applicantGUID . "',";
//		$contactsTitle = 'id,';
//		$contactsValue = "'" . $contastGUID . "',";
//		$contactsTitle_cstm = 'id_c';
//		$contactsValue_cstm = "'" . $contastGUID . "'";
//		for ($i = 0; $i < count($applicantTitle); $i++) {
//			if ($applicantTitle[$i] == 'billingFirstName') {
//				$accountTitle .= 'name,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$accountTitle_cstm .= 'billing_address_first_name_c,';
//				$accountValue_cstm .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'first_name,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'billingLastName') {
//				$accountTitle_cstm .= 'billing_address_last_name_c,';
//				$accountValue_cstm .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'last_name,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'billingPhone') {
//				$accountTitle .= 'phone_fax,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$accountTitle .= 'phone_office,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'phone_work,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'billingCountry') {
//				$accountTitle .= 'billing_address_country,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'primary_address_country,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'billingAddress') {
//				$accountTitle .= 'billing_address_street,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'primary_address_street,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'billingCity') {
//				$accountTitle .= 'billing_address_city,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'primary_address_city,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'billingZipcode') {
//				$accountTitle .= 'billing_address_postalcode,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'primary_address_postalcode,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'addressPhone') {
//				$accountTitle .= 'phone_alternate,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'phone_mobile,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'addressCountry') {
//				$accountTitle .= 'shipping_address_country,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'alt_address_country,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'addressAddress') {
//				$accountTitle .= 'shipping_address_street,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'alt_address_street,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'addressCity') {
//				$accountTitle .= 'shipping_address_city,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'alt_address_city,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'addressZipcode') {
//				$accountTitle .= 'shipping_address_postalcode,';
//				$accountValue .= "'" . $applicantValue[$i] . "',";
//				$contactsTitle .= 'alt_address_postalcode,';
//				$contactsValue .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'addressFirstName') {
//				$accountTitle_cstm .= 'shiping_address_first_name_c,';
//				$accountValue_cstm .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'addressLastName') {
//				$accountTitle_cstm .= 'shiping_address_last_name_c,';
//				$accountValue_cstm .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'uniqid') {
//				$accountTitle_cstm .= 'uniqid_c,';
//				$accountValue_cstm .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'Jurisdiction') {
//				$accountTitle_cstm .= 'jurisdiction_c,';
//				$accountValue_cstm .= "'" . $applicantValue[$i] . "',";
//			}
//			if ($applicantTitle[$i] == 'companyName') {
//				$tasksTitle = 'name,description,';
//				$tasksValue = "'Open a company called {$applicantValue[$i]}','Open a company called {$applicantValue[$i]} in country " . $_COOKIE['country'] . "',";
//			}
//
//		}
//		$accountTitle .= 'date_entered,date_modified,modified_user_id,created_by,description,deleted,assigned_user_id,account_type';
//		$accountValue .= "'" . $today . "','" . $today . "','1','1','Created by vvssll.com','0','ee49e8b1-23f1-9772-952f-5c7e275028a5','Customer'";
//		$contactsTitle .= 'date_entered,date_modified,modified_user_id,created_by,description,deleted,assigned_user_id,salutation,portal_user_type';
//		$contactsValue .= "'" . $today . "','" . $today . "','1','1','Created by vvssll.com','0','ee49e8b1-23f1-9772-952f-5c7e275028a5','Mr.','Single'";
//		$accountTitle_cstm .= 'applicantid_c';
//		$accountValue_cstm .= "'" . $companyValue[1] . "'";
//		$tasksTitle .= "id,modified_user_id,created_by,deleted,assigned_user_id,status,date_due_flag,date_due,parent_type,parent_id,priority,date_entered,date_modified";
//		$tasksValue .= "'" . $taskGUID . "','1','1','0','ee49e8b1-23f1-9772-952f-5c7e275028a5','In Progress',1,'" . $today . "','Accounts','" . $applicantGUID . "','Medium','" . $today . "','" . $today . "'";
//		$sql = "INSERT INTO `accounts` ($accountTitle) VALUES ($accountValue);";
//		$this->result['sql'] = $sql . '\n\r';
//		$this->result['account'] = $this->sqlQuery($sql, 'xnsevdbd_crmvessel');
//		$sql = "INSERT INTO `accounts_cstm` ($accountTitle_cstm) VALUES ($accountValue_cstm);";
//		$this->result['sql'] .= $sql . '\n\r';
//		$this->result['account_cstm'] = $this->sqlQuery($sql, 'xnsevdbd_crmvessel');
//		$sql = "INSERT INTO `contacts` ($contactsTitle) VALUES ($contactsValue);";
//		$this->result['sql'] .= $sql . '\n\r';
//		$this->result['contacts'] = $this->sqlQuery($sql, 'xnsevdbd_crmvessel');
//		$sql = "INSERT INTO `contacts_cstm` ($contactsTitle_cstm) VALUES ($contactsValue_cstm);";
//		$this->result['sql'] .= $sql . '\n\r';
//		$this->result['contacts_cstm'] = $this->sqlQuery($sql, 'xnsevdbd_crmvessel');
//		$sql = "INSERT INTO `tasks` ($tasksTitle) VALUES ($tasksValue);";
//		$this->result['sql'] .= $sql . '\n\r';
//		$this->result['tasks'] = $this->sqlQuery($sql, 'xnsevdbd_crmvessel');
//		$sql = "INSERT INTO `accounts_contacts` (id,contact_id,account_id,date_modified, deleted) VALUES ('" . $account_contacts . "','" . $contastGUID . "','" . $applicantGUID . "','" . $today . "','0');";
//		$this->result['sql'] .= $sql . '\n\r';
//		$this->result['accounts_contacts'] = $this->sqlQuery($sql, 'xnsevdbd_crmvessel');
//		return $this->result;
//	}
//
//	public function GetAgents($jurisdiction_id){
//		$sql = "SELECT id FROM `agent` WHERE jurisdiction_id='{$jurisdiction_id}';";
//		$res = $this->sqlQuery($sql);
//		if(is_array($res)){
//			$this->result = 'true';
//		}else{
//			$this->result = 'false';
//		}
//		return $this->result;
//	}
//
//	public function updateApplicantAndAddCompany($assocArray){
//		$this->db=new db();
//		$assocArray['uniqid']=$this->getGUID();
////    print_r($assocArray);
//		$email = mysqli_real_escape_string($this->db->con,strtolower($assocArray['email']));
//		$pass = base64_encode($assocArray['password']);
//		$sql = "SELECT * FROM `applicant` WHERE email='{$email}' AND password='{$pass}';";
//		$res = $this->sqlQuery($sql);
//		if(is_array($res)){
//			foreach ($assocArray as $key => $val){
//				if($key=='password'){
//					$postKey[]= $key;
//					$postVal[]= "'".base64_encode($val)."'";
//				}else if($key=='email'){
//					$postKey[]= $key;
//					$postVal[]= "'".mysqli_real_escape_string($this->db->con, strtolower($val))."'";
//				}else{
//					$postKey[]= $key;
//					$postVal[]= "'".mysqli_real_escape_string($this->db->con, $val)."'";
//					$companyPostKey[]= $key;
//					$companyPostVal[]= "'".mysqli_real_escape_string($this->db->con, $val)."'";
//				}
//			}
//			$res = $res[0];
//			$title = implode(',',$postKey);
//			$value = implode(',',$postVal);
//			$companyTitle = implode(',',$companyPostKey);
//			$companyValue = implode(',',$companyPostVal);
//			$crmValue2 = "'" . mysqli_real_escape_string($this->db->con, $res['companyName']) . "','" . $res['id'] . "','" . $res['uniqid'] . "','new','" . $res['Jurisdiction'] . "'";
//			$sql4 = "INSERT INTO `companyinfo` ($companyTitle,applicantid) VALUES (".$companyValue.",'".$res['id']."');";
//			$result['company'] = $this->sqlQuery($sql4);
//			$result['crm'] = $this->saveCRMVessel($title, $value, $crmValue2);
//			$this->setCookies('companyName', $res['companyName'], 2);
//			$this->setCookies('applicantid', $res['id'], 2);
//			$this->setCookies('uniqid', $res['uniqid'], 2);
//			$this->setCookies('companyId', $result['company']['id'], 2);
//			$html = "You are register a new company to Email: <a href='mailto:" . str_replace('%40', '@', $res['email']) . "'>" . str_replace('%40', '@', $res['email']) . "</a><br>
//            You select a company name as  " . $res['companyName'] . "<br>
//            <br><br>
//            go to site <a href='//cabinet.vvssll.com'>cabinet.vvssll.com</a>
//            ";
//			$result['applicant']['mail'] = $this->sendEmail(str_replace('%40', '@', $res['email']), null, 'You are register a new company on VVSSLL.COM', $html, null);
//
//		}else{
//			$result['error'] = $res;
//		}
//		if(is_array($result)){
//			echo json_encode($result);
//		}else{
//			echo $result;
//		}
//	}
//
//	public function ava($ava){
//		if(is_array($ava)){
//			echo "<div class=\"messManagerAvatar\" style=\"background-image: url('".$ava[0]['href']."')\"></div>";
//		}else{
//			echo "<div class=\"messManagerAvatar\" style=\"background-image: url('/img/simpleAvatar.svg')\"></div>";
//		}
//	}
}