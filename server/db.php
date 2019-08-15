<?php

namespace server;
class db extends \mysqli
{
    public $con;

    private $host = 'localhost';
    private $user = 'xnsevdbd_elect'; //server
//		private $user   = 'root'; //local
    private $pass = 'Nfw7h4gL73sg'; //server
//		private $pass   = 'pWNMof4TZaQUWRt2hsRPpL8a7GyPfy'; //local
    private $sqldb = 'xnsevdbd_cabinetcomformo'; //server

//		private $sqldb  = 'xnsevdbd_bankform';// local


    function __construct()
    {
        $this->con = new \mysqli($this->host, $this->user, $this->pass, $this->sqldb);
        if ($this->con->connect_errno) {
            printf("Соединение не удалось: %s\n", $this->con->connect_error);
            exit();
        }
    }

    function createUserTable()
    {
        $sql = "CREATE TABLE `users` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`email` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`pass` Text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`firstName` VarChar( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`lastName` VarChar( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`phone` VarChar( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`City` VarChar( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`zip_code` VarChar( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`Country` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`State` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`billfirstname` VarChar( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`billCity` VarChar( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`billzip` VarChar( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`billaddress1` Text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`billlastname` VarChar( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`billCountry` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`billState` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`billaddress2` Text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`premission_group` VarChar( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`agentsId` Int( 11 ) NULL,
	`jurisdictionId` Int( 11 ) NULL,
	`messangerGroupSort` Text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	`messangerStatus` Int( 11 ) NULL,
	`userId` Int( 11 ) NULL,
	`regDate` Timestamp NULL ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY ( `id` ) )
	CHARACTER SET = utf8
	COLLATE = utf8_general_ci
	ENGINE = InnoDB
	AUTO_INCREMENT = 1;";
        $this->sqlQuery($sql);
    }

    function sqlQuery($sql)
    {
        return $this->con->query($sql);
    }
}