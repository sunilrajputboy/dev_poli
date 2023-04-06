<?php
/*
  	@project    CSV Visual Mapping  
  	@author     Gianluca Di Battista
  	@copyright  Webmio.it
	@year 		2020
  	@version    1.0.0
  	@file  		Database.php
  	@site		https://www.csvxlsvisualmapping.com/
*/

class Database extends PDO
{

    public function __construct()
    {
        //parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$options = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"
		);
        parent::__construct('mysql:host=localhost;dbname=visualisationpol_dev','visualisationpol_stage','visualisationpol_stage',$options);
    }

    /**
     * INSERT
     * @param $table
     * @param $data
     */
    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value)
        {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }

    /**
     * UPDATE
     * @param $table
     * @param $data
     * @param $where
     */

    public function update($table, $data, $where)
    {
        ksort($data);

        $fieldDetails = NULL;
        foreach ($data as $key => $value)
        {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value)
        {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }

    /**
     * INSERT BULK
     * @param $table
     * @param $data
     * @return bool
     */
    public function insert_bulk($table, $data)
    {
        if (isset($data))
        {
            ksort($data);
            $fieldNames = implode('`, `', array_keys($data[0]));
            $field_values = [];
            foreach ($data as $kk => $vv)
            {
                $values = [];
                foreach (array_keys($data[0]) as $fields)
                {
                    $values[] = ":{$fields}_$kk";
                }
                $field_values[] = '(' . implode(',', $values) . ')';
            }
            $query = "INSERT INTO $table (`$fieldNames`) VALUES " . implode(',', $field_values);
            $sth = $this->prepare($query);
            foreach ($data as $key => $value)
            {
                foreach (array_keys($data[0]) as $fields)
                {
                    $sth->bindValue(":{$fields}_$key", $value[$fields]);
                }
            }
            return $sth->execute();
        }
    }

}

