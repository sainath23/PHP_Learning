<?php
$db_server_name;

if (!isset($argv[1])) {
    echo "Please pass database server name!\n";
    exit;
} else {
    $db_server_name = $argv[1];
    echo "Database Server Name: " . $db_server_name."\n";
}

$db_server_dbs = get_db_server_databases($db_server_name);

if ($db_server_dbs) {
    echo "\nSUCCESSFULLY FETCHED ". $db_server_dbs . " SERVER DATABASE NAMES!\n";
    create_temp_table($db_server_dbs);
    echo "\n\nSCRIPT EXECUTED SUCCESSFULLY!\n\n";
} else {
    echo "\nFAILED TO EXECUTE SCRIPT SUCCESSFULLY!\n";
}

function get_db_server_databases($db_server) {
    $con = mysqli_connect($db_server, "root") or die(" Failed to connect ".$db_server." MySql");
    $query = "show databases";
    $result = mysqli_query($con, $query);
    $db_names = array();
    $exclude_db_pattern = "/stm|ftp|schema|information|mysql|sys|performance/";
    while($row = mysqli_fetch_array($result)) {
        if(!preg_match($exclude_db_pattern, $row['Database'], $matches)) {
            echo $row['Database'] . "\n";
            array_push($db_names, $row['Database']);
        } else {
            continue;
        }
    }
    echo "\n\n";
    print_r($db_names);
    echo "\n\n";
    //$db_names = "'" . implode("', '", $db_names) . "'";
    //echo $db_names;
    mysqli_close($con);
    return $db_names;
}

function create_temp_table($dbs) {
    $con = mysqli_connect("localhost", "root", "", "reports");
    $query = "CREATE TEMPORARY TABLE database_list(db_name varchar(255))";
    $result = mysqli_query($con, $query);
    if(!$result) {
        die("Error: " . mysqli_error($con));
        exit;
    } else {
        echo "\n\nSUCCESSFULLY CREATED TEMP TABLE\n\n";
        foreach($dbs as $db) {
            $query = "INSERT INTO database_list VALUES('$db')";
            $result = mysqli_query($con, $query);
            if($result) {
                echo $query . "\n";
            } else {
                die("Error: " . mysqli_error($con));
                exit;
            }
        }
        // Query to get app server names from server master table
        $query = "SELECT server_name FROM server_master WHERE db_server = '" . $GLOBALS['db_server_name'] ."'";
        echo "\n\n" . $query . "\n\n";
        $result = mysqli_query($con, $query);
        $app_server_names = array();
        while($row = mysqli_fetch_array($result)) {
            echo $row['server_name'] . "\n";
            array_push($app_server_names, $row['server_name']);
        }
        echo "\n\n";
        print_r($app_server_names);
        echo "\n\n";
        $app_server_names = "'" . implode("', '", $server_names) . "'";
        echo "\n" . $app_server_names . "\n\n";
        // Query to get active client names from client details
        $query = "SELECT client_name FROM client_details WHERE server in ($app_server_names)";
        $result = mysqli_query($con, $query);
        if(!$result) {
            die("Error: " . mysqli_error($con) . " " . __LINE__);
        } else {
            echo "\n\nSUCCESSFULLY FETCHED CLIENT NAMES\n\n";
            $active_clients = array();
            while($row = mysqli_fetch_array($result)) {
                echo $row['client_name'] . "\n";
                array_push($active_clients, $row['client_name']);
            }
            print_r($active_clients);
            $active_clients = "'" . implode("', '", $active_clients) . "'";
            echo "\n" . $active_clients . "\n\n";
            // Query to delete active clients from db list
            $query = "DELETE FROM database_list WHERE db_name in ($active_clients)";
            $result = mysqli_query($con, $query);
            if(!$result) {
                die("Error: " . mysqli_error($con) . " " . __LINE__);
                exit;
            } else {
                echo "\n\nSUCCESSFULLY DELETED ACTIVE CLIENT DATABASES FROM TEMP TABLE\n\n";
                $final_db_names = "/tmp/" . $GLOBALS['db_server_name'] . "_final_db_list.csv";
                $query = "SELECT db_name FROM database_list";
                $result = mysqli_query($con, $query);
                if(!$result) {
                    die("Error: " . mysqli_error($con) . " " . __LINE__);
                    exit;
                }
                file_put_contents($final_db_names, "db_name\n", FILE_APPEND);
                while($row = mysqli_fetch_array($result)) {
                    echo "\n\nADDING TO CSV: " . $row['db_name'];
                    file_put_contents($final_db_names, '"' . $row['db_name'] . '"' . "\n", FILE_APPEND);
                }
                echo "\n\nOUTPUT FILE: " . $final_db_names . "\n\n";
            }
        }
    }
    mysqli_close($con);
}

?>