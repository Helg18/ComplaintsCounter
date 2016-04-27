<?php

/**
 * connecting with the MySQL database
 * @param string $HOST
 * @param string $USER
 * @param string $PASS
 * @param string $DB
 * @param string $PORT
 * @return db
 *  
 */
function phpmkr_db_connect($HOST, $USER, $PASS, $DB, $PORT){
    $conn = mysqli_connect($HOST, $USER, $PASS, $DB, $PORT);// or die("Unable to connect wing Database");
    return $conn;
}
/**
 * phpmkr_db_close()
 * Close the connection of database
 * @param db $conn
  */
function phpmkr_db_close($conn){
    mysqli_close($conn);
}

/**
 * phpmkr_query()
 * Performs a database query 
 * @param string $strsql
 * @param string $conn
 * @return recordset
 *  
 */
function phpmkr_query($strsql, $conn = ""){   
    $conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);
    if ($conn){
        $rs = mysqli_query($conn, $strsql) or die("fail executing line" . __LINE__ . ":  '<br>SQL: '" . $strsql);
        return $rs;
    }
    else{
        return false;
    }
        
}

/**
 * phpmkr_num_rows()
 * return the number of rows of the recordset
 * @param recordset $rs
 * @return integer
 */
 function phpmkr_num_rows($rs){
    return @mysqli_num_rows($rs);
}

/**
 * phpmkr_fetch_array()
 * Fetch next associative row of the result of recorset
 * @param recordset $rs
 * @return array
 */
function phpmkr_fetch_array($rs){
    return mysqli_fetch_array($rs);
}

/**
 * phpmkr_fetch_row()
 * Fetch next row of the result of recorset
 * @param recordset $rs
 * @return array
 *  
 */
function phpmkr_fetch_row($rs){
    return mysqli_fetch_row($rs);
}

/**
 * 
 * @param db $conn
 * @return string
 *  
 */
function phpmkr_error($conn)
{
    return mysqli_error($conn);
}

define("HOST", "localhost");
define("PORT", 3306);
define("USER", "root");
define("PASS", "casablanca_123");
define("DB", "complaintscounter");
define("EMAIL", "delstoneservices@gmail.com");
define("BROADCASTEMAIL", "reviewer@complaintbroadcaster.co.uk");
define("UPLOAD_DIR", "uploads");
define("SITEKEY", "6LfRzh0TAAAAAJHDX2cnrz6-1ilI9c8SH_VYJ14y");
define("CAPTCHASECRET", "6LfRzh0TAAAAAHBmml1oUzSIMTofrayVYJTsGC2u");
