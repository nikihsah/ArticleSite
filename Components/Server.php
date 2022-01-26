<?php


class Server
{
    private $servername;
    private $password;
    private $username;
    private $dbname;

    public function __construct()
    {
        $config = include(ROOT."/config/serverData.php");

        $this -> servername = $config['servername'];
        $this -> password = $config['password'];
        $this -> username = $config['username'];
        $this -> dbname = $config['dbname'];
    }

    Public function connect()
    {
        return mysqli_connect(
            $this -> servername,
            $this -> username,
            $this -> password,
            $this -> dbname);
    }
}