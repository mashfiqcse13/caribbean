<?php

/*
  Author		: MD. Mashfiqur Rahman
  website		: http://mashfiqnahid.com
  mail		: mashfiqnahid@gmail.com

  Intruduction	:
  =================
  This is database . Here will be the useful DB tools

 */

class DBClass {

    private $db_link, $servername, $username, $password, $dbname;

    function __construct($servername, $username, $password, $dbname) {
        // $servername = "localhost";
        // $username = "rhasan_roki";
        // $password = "9Oy#)@(EF7)r";
        // $dbname = "rhasan_work";
        // Create connection
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $connection = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $this->db_link = $connection;
        return TRUE;
    }

    /* this function will insert data to database(s)
      example : $data_to_insert=array(
      'ID'=>'Data of ID',
      'partial_url'=>'Data of partial_url',
      'extention'=>'Data of extention',
      'type'=>'Data of type',
      );
     */

    public function db_insert($table_name, $data_to_insert) {
        $db_link = $this->db_link;
        $sql = "INSERT INTO `$table_name`";
        $sql.="(";
        foreach ($data_to_insert as $index => $value) {
            $sql.="`$index`,";
        }
        $sql.=") VALUES (";
        foreach ($data_to_insert as $index => $value) {
            $value = mysqli_real_escape_string($db_link,$value);
            $sql.="'$value',";
        }
        $sql.=")";
        $sql = str_replace(',)', ')', $sql);
        //echo $sql.'\n';
        if (!mysqli_query($db_link, $sql)) {
            $erro_msg = 'Error: ' . mysqli_error($db_link);
            echo '
			<script>
				alert("' . $erro_msg . '");
				window.location = "' . $_SERVER['HTTP_REFERER'] . '";
			</script>
			';
            die($erro_msg);
        }
        return true;
    }

    /* this function will delete data from database(s)
     */

    public function db_delete($table_name, $condition = 1) {
        $db_link = $this->db_link;
        $sql = "DELETE FROM `$table_name` WHERE $condition";
        //echo $sql.'\n';
        if (!mysqli_query($db_link, $sql)) {
            $erro_msg = 'Error: ' . mysqli_error($db_link);
            echo '
			<script>
				alert("' . $erro_msg . '");
				window.location = "' . $_SERVER['HTTP_REFERER'] . '";
			</script>
			';
            die($erro_msg);
        }
        return true;
    }

    /* this function will update data to database(s)
      example : $data_to_insert=array(
      'ID'=>'Data of ID',
      'partial_url'=>'Data of partial_url',
      'extention'=>'Data of extention',
      'type'=>'Data of type',
      );
     */

    public function db_update($table_name, $data_to_insert, $condition = 1) {
        $db_link = $this->db_link;


        $sql = "UPDATE `$table_name`";
        $sql.=" SET";
        foreach ($data_to_insert as $index => $value) {
            $value = str_replace("'", "\'", $value);
            $sql.=" `$index`='$value' ,";
        }
        $sql.=" WHERE $condition";
        $sql = str_replace(', WHERE', ' WHERE', $sql);
        //echo $sql.'\n';
        if (!mysqli_query($db_link, $sql)) {
            $erro_msg = 'Error: ' . mysqli_error($db_link);
            echo '
			<script>
				alert("' . $erro_msg . '");
				window.location = "' . $_SERVER['HTTP_REFERER'] . '";
			</script>
			';
            die($erro_msg);
        }
        return true;
    }

    /*
      select a table form Database as an 2D array
     */

    public function db_select_as_array($table_name, $condition = 1) {
        $db_link = $this->db_link;

        $sql = "SELECT * FROM `$table_name` WHERE $condition";
        $result = mysqli_query($db_link, $sql);

        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $data[$i] = $row;
            $i++;
        }
        if ($i == 0)
            return false;
        else
            return $data;
    }

    /*
      will execute LAST_INSERT_ID()
     */

    public function last_insert_id($table_name) {
        $db_link = $this->db_link;

        $sql = "SELECT LAST_INSERT_ID() FROM `$table_name`";
        $result = mysqli_query($db_link, $sql);

        if ($row = mysqli_fetch_array($result)) {
            return $row[0];
        } else
            return false;
    }

    /*
     * auto increament id
     */

    public function auto_increment_id($table_name) {
        $db_link = $this->db_link;

        $sql = "SELECT `AUTO_INCREMENT`
                FROM  INFORMATION_SCHEMA.TABLES
                WHERE TABLE_SCHEMA = '" . $this->dbname . "'
                AND   TABLE_NAME   =  '$table_name'";
        $result = mysqli_query($db_link, $sql);

        if ($row = mysqli_fetch_array($result)) {
            return $row['AUTO_INCREMENT'];
        } else {
            return false;
        }
    }

}
