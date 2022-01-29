<?php

declare(strict_types=1);

class Server
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
            $config['password'],
            $config['username'],
            $config['dbname']);
    }

    /**
     * @param string $table
     * @param array $columns
     * @param array $params
     * @param string $orderBy
     *
     * @return array
     */
    public function getByColumns(string $table,array $columns = [0],array $params = [], string $orderBy = "")
    {
        $sql = sprintf("SELECT * FROM %s", $table);

        if (count($columns) > 0){
            $sql = $sql . ' WHERE ';
            if (count($columns) > 1){
                foreach($columns as $key => $value){
                    if($key != count($columns) - 1){
                        $sql =$sql . $this->condition($value, $params) . 'AND';

                    }else{
                        $sql = $sql . $this->condition($value, $params);
                    }
                }
            }
        }

        if ($orderBy != ""){
            $sql = $sql . sprintf("ORDER BY %s", $orderBy);
        }

        return $this->query($sql);
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
            $sql = sprintf("%s = %s", $column, $params);
        }else{
            $sql = sprintf("%s in (%s", $column, $params);
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
    private function query(string $sql): array
    {
        $result = mysqli_query($this->connect, $sql);

        while($row = mysqli_fetch_assoc($result)){
            $tablesRows[] = $row;
        }

        return $tablesRows;
    }
}