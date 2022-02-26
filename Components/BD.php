<?php

declare(strict_types=1);

namespace components;

use mysqli_result;

class BD
{
    /**
     * @var string
     */
    private $connect;

    public function __construct()
    {
        $config = include(ROOT."/config/serverData.php");

        $this->connect = mysqli_connect(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['dbname']);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     *
     * @return bool|mysqli_result
     */
    public function addUser(string $username, string $password, string $email){

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $dateRegister = date('Y-m-d');

        $sql = 'INSERT INTO `users` (`username`, `hashpassword`,`date_registration`, `email`) ';

        return $this->queryAdd($sql . sprintf(
            "VALUES ('%s', '%s', '%s', '%s')",
            $username,
            $hashPassword,
            $dateRegister,
            $email));
    }

    /**
     * @param string $table
     * @param ...$columns
     *
     * @return array
     */
    public function getByColumn(string $table, ...$columns): array
    {
        $sql = 'SELECT ';

        foreach($columns as $key => $column){
            if(!end($columns)==$key) {
                $sql = $sql . " `" . $column . '`,';
            }else{
                $sql = $sql . " `" . $column . '`';
            }
        }

        $sql = sprintf("%s FROM `%s`", $sql,  $table);

        return $this->queryGet($sql);
    }

    /**
     * @param string $table
     * @param string $columns
     * @param array $params strings
     *
     * @return array
     */
    public function getSelection(string $table,string $columns, ...$params) : array
    {
        $sql = sprintf("SELECT * FROM `%s`", $table);

        $columns = explode(' ', $columns);
        $i = 0;

        if (count($columns) > 0){

            $sql = $sql . ' WHERE ';

            if (count($columns) > 1){

                foreach($columns as $key => $value){

                    if($key != count($columns) - 1){

                        $sql =$sql . $this->condition($value, explode(' ', $params[$i])) . ' AND';
                        $i++;

                    }else{
                        $sql = $sql . $this->condition($value, $params);
                    }
                }
            }
        }

        return $this->queryGet($sql);
    }

    /**
     * @param string $column
     * @param $params
     *
     * @return string
     */
    private function condition(string $column, $params): string
    {
        if (count($params) == 1){
            $sql = sprintf(" %s = %s", $column, $params);
        }else{
            $sql = sprintf(" %s in (%s", $column, $params);
            foreach($params as $key => $value){

                if ($key != 0 and $key != count($params) - 1) {
                    $sql = $sql . sprintf(", %s", $value);
                }elseif($key == count($params) - 1){
                    $sql = $sql . sprintf(", %s)", $value);
                }
            }
        }
        return $sql;
    }

    /**
     * @param string $sql
     *
     * @return array
     */
    private function queryGet(string $sql): array
    {
        $result = mysqli_query($this->connect, $sql);

        printf("$sql");

        if (!mysqli_query($this->connect, $sql)) {
            printf("Сообщение ошибки: %s\n", $this->connect->error);
            // todo Убрать на стадии готовности. return mysqli_query
        }

        while($row = mysqli_fetch_assoc($result)){
            $tablesRows[] = $row;
        }

        return $tablesRows;
    }

    /**
     * @param string $sql
     *
     * @return bool|string
     */
    private function queryAdd(string $sql){
        echo "$sql";
        if (!mysqli_query($this->connect, $sql)) {
            return sprintf("Сообщение ошибки: %s\n", $this->connect->error);
            // todo Убрать на стадии готовности. return mysqli_query
        }
        return True;
    }
}