<?php

namespace server;
class db_company extends \mysqli
{
    public $con;

    private $host = 'localhost'; // db name from local and internet server
    private $user = 'xnsevdbd_elect';// user from internet server
//		private $user   = 'root'; // user from local
    private $pass = 'Nfw7h4gL73sg'; //pass form internet server
//		private $pass   = 'pWNMof4TZaQUWRt2hsRPpL8a7GyPfy'; // pass from local
    private $sqldb = 'xnsevdbd_checkname'; // db name from local and internet server

    function __construct()
    {
        $this->con = new \mysqli($this->host, $this->user, $this->pass, $this->sqldb);
        if ($this->con->connect_errno) {
            printf("Соединение не удалось: %s\n", $this->con->connect_error);
            exit();
        }
    }
}