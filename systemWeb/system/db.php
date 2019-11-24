<?php



//    @mysql_connect (DB_HOST,DB_USER,DB_PASS);
//    mysql_select_db (DB_NAME);


    function fun_insert($table, $keys, $values)
    {
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $str = "INSERT INTO {$table} ({$keys}) VALUES ({$values})";

        echo '<script>alert("'.$str.'");</script>';

        //$retry = mysqli_query($link, $str);

        $retry = $link->real_query($str);

        mysqli_close($link);

        return $retry;
//        return mysql_query($str);

    }

?>