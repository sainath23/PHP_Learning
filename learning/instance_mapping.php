<?php

if(isset($_POST['btn_get_details'])) {
    $con = mysqli_connect("localhost", "root", "", "reports") or die(header("Location: index.php?msg=3"));
    $ta_instance_names = trim(mysqli_real_escape_string($con, $_POST['ta_instance_names']));
    //echo $ta_instance_names . "<br>";
    $instance_array = array_map("trim", explode(",", $ta_instance_names));
    $instance_names = "'" . implode("', '", $instance_array) . "'";
    //echo "$instance_names<br>";
    $query = "SELECT client_name, acc_mgr FROM client_details WHERE client_name in ($instance_names) ORDER BY clientid";
    //echo "\n $query \n";
    $result = mysqli_query($con, $query);
    if(!$result) {
        //echo "Something wrong!<br>";
        header("Location: index.php?msg=3");
    } else {
        //echo "Success!<br>";
        $instance_array = array();
        while($row = mysqli_fetch_array($result)) {
            $row_arr['instance_name'] = $row['client_name'];
            $row_arr['acc_mgr'] = $row['acc_mgr'];
            array_push($instance_array, $row_arr);
        }
        //var_dump($instance_array);
    }
    mysqli_close($con);
} elseif(isset($_POST['btn_map_instance'])) {
    $con = mysqli_connect("localhost", "root", "", "reports") or die(header("Location: index.php?msg=3"));
    $ip_acc_mgr = trim(mysqli_real_escape_string($con, $_POST['ip_acc_mgr']));
    $instance_names = trim(mysqli_real_escape_string($con, $_POST['ip_instance_hidden']));
    //echo $ip_acc_mgr;
    //echo $instance_names;
    $instance_names = stripslashes($instance_names);
    $query = "UPDATE client_details SET acc_mgr = '$ip_acc_mgr' WHERE client_name IN ($instance_names)";
    $query_success = "SELECT client_name, acc_mgr FROM client_details WHERE client_name in ($instance_names) ORDER BY clientid";
    $result = mysqli_query($con, $query);
    $result_success = mysqli_query($con, $query_success);
    if(!$result) {
        //echo "Something wrong!<br>";
        //echo mysqli_error($con);
        header("Location: index.php?msg=2");
    } else {
        //echo "Updated!<br>";
        $instance_success_array = array();
        while($row = mysqli_fetch_array($result_success)) {
            $row_arr['instance_name'] = $row['client_name'];
            $row_arr['acc_mgr'] = $row['acc_mgr'];
            array_push($instance_success_array, $row_arr);
        }
        //print_r($instance_success_array);
        $instance_success_string = "";
        foreach($instance_success_array as $key => $array) {
            foreach($array as $k => $v) {
                $instance_success_string .= "item[" . urlencode($key) . "][" . urlencode($k) . "]=" . urlencode($v) . "&";
            }
        }
        
        $url = 'index.php?msg=1&' . rtrim($instance_success_string, "&");
        header("Location: $url");
        //header("Location: index.php?msg=1");
    }
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instance Mapping</title>
    <style>
    html{box-sizing:border-box}*,*:before,*:after{box-sizing:inherit}
    html{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}
    html,body{font-family:Verdana,sans-serif;font-size:15px;line-height:1.5}html{overflow-x:hidden}
    .content {
        width: 800px;
        margin-left: auto;
        margin-right: auto;
        padding-bottom: 10px;
    }
    h1{font-size:36px}h2{font-size:30px}h3{font-size:24px}h4{font-size:20px}h5{font-size:18px}h6{font-size:16px}.w3-serif{font-family:serif}
    h1,h2,h3,h4,h5,h6{font-family:"Segoe UI",Arial,sans-serif;font-weight:400;margin:10px 0}.w3-wide{letter-spacing:4px}
    .w3-input {padding:8px;display:block;border:none;border-bottom:1px solid #ccc;width:100%}
    .w3-border-0{border:0!important}
    .w3-border{border:1px solid #ccc!important}
    .w3-border-top{border-top:1px solid #ccc!important}.w3-border-bottom{border-bottom:1px solid #ccc!important}
    .w3-border-left{border-left:1px solid #ccc!important}.w3-border-right{border-right:1px solid #ccc!important}
    .w3-container,.w3-panel{padding:0.01em 16px}.w3-panel{margin-top:16px;margin-bottom:16px}
    .w3-card-4,.w3-hover-shadow:hover{box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19)}
    .w3-light-grey,.w3-hover-light-grey:hover,.w3-light-gray,.w3-hover-light-gray:hover{color:#000!important;background-color:#f1f1f1!important}
    .w3-btn,.w3-button{border:none;display:inline-block;outline:0;padding:8px 16px;vertical-align:middle;overflow:hidden;text-decoration:none;color:inherit;background-color:inherit;text-align:center;cursor:pointer;white-space:nowrap}
    .w3-btn:hover{box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19)}
    .w3-btn,.w3-button{-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}   
    .w3-disabled,.w3-btn:disabled,.w3-button:disabled{cursor:not-allowed;opacity:0.3}.w3-disabled *,:disabled *{pointer-events:none}
    .w3-btn.w3-disabled:hover,.w3-btn:disabled:hover{box-shadow:none}
    .w3-blue,.w3-hover-blue:hover{color:#fff!important;background-color:#2196F3!important}
    .w3-table,.w3-table-all{border-collapse:collapse;border-spacing:0;width:100%;display:table}.w3-table-all{border:1px solid #ccc}
    .w3-bordered tr,.w3-table-all tr{border-bottom:1px solid #ddd}.w3-striped tbody tr:nth-child(even){background-color:#f1f1f1}
    .w3-table-all tr:nth-child(odd){background-color:#fff}.w3-table-all tr:nth-child(even){background-color:#f1f1f1}
    .w3-hoverable tbody tr:hover,.w3-ul.w3-hoverable li:hover{background-color:#ccc}.w3-centered tr th,.w3-centered tr td{text-align:center}
    .w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th{padding:8px 8px;display:table-cell;text-align:left;vertical-align:top}
    .w3-table th:first-child,.w3-table td:first-child,.w3-table-all th:first-child,.w3-table-all td:first-child{padding-left:16px}
    .w3-card-4,.w3-hover-shadow:hover{box-shadow:0 4px 10px 0 rgba(0,0,0,0.2),0 4px 20px 0 rgba(0,0,0,0.19)}
    .w3-medium{font-size:15px!important}.w3-large{font-size:18px!important}
    .w3-green,.w3-hover-green:hover{color:#fff!important;background-color:#4CAF50!important}
    .w3-red,.w3-hover-red:hover{color:#fff!important;background-color:#f44336!important}
    .w3-yellow,.w3-hover-yellow:hover{color:#000!important;background-color:#ffeb3b!important}
    .w3-tooltip,.w3-display-container{position:relative}.w3-tooltip .w3-text{display:none}.w3-tooltip:hover .w3-text{display:inline-block}
    .w3-display-container:hover .w3-display-hover{display:block}.w3-display-container:hover span.w3-display-hover{display:inline-block}.w3-display-hover{display:none}
    .w3-display-topleft{position:absolute;left:0;top:0}.w3-display-topright{position:absolute;right:0;top:0}
    </style>
</head>
<body>
    <div class="content w3-card-4 w3-light-grey">
    <form class="w3-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h1 style="text-align: center;">Instance Mapping</h1>
    <p><label for="client_names">Instances (Comma Separated):</label>
    <textarea name="ta_instance_names" id="instance_names" cols="30" rows="10" class="w3-input w3-border" required></textarea></p>
    <p><input type="submit" value="Get Details &raquo;" name="btn_get_details" id="get_details" class="w3-btn w3-blue"></p>
    </form>
    <?php 
    if(isset($instance_array) && isset($instance_names)) { ?>
        <h3 style="margin-left: 20px;">Before Mapping Instances:</h3>
        <table class="w3-table-all w3-medium" style="width: 770px; margin: 0 auto;">
        <?php
        echo "<tr><th>Instance Name</th><th>Account Manager</th></tr>";
        foreach($instance_array as $key => $val) {
            //echo $val['instance_name'] . " , " . $val['acc_mgr'] . "<br>";
            echo "<tr><td>" . $val['instance_name'] . "</td><td>" . $val['acc_mgr'] . "</td></tr>";
        } ?>
        </table>
        <form class="w3-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="ip_instance_hidden" value="<?php echo $instance_names; ?>">
        <p><label for="acc_mgr">Account Manager Email:</label>
        <input type="text" name="ip_acc_mgr" id="acc_mgr" class="w3-input w3-border" required></p>
        <p><input type="submit" value="Map &raquo;" name="btn_map_instance" id="map_instance" class="w3-btn w3-blue"></p>
        </form>
    <?php } elseif(isset($_GET['msg'])) {
        if($_GET['msg'] == 1 && isset($_GET['item'])) { ?>
            <div class="w3-panel w3-green w3-display-container" style="width:770px; margin: 0 auto;">
            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-green w3-large w3-display-topright">&times;</span>
            <h3>Success!</h3>
            <p>Successfully updated mapped instances.</p>
            </div>
            <h3 style="margin-left: 20px;">After Mapping Instances:</h3>
            <table class="w3-table-all w3-medium" style="width: 770px; margin: 0 auto;">
            <?php
            echo "<tr><th>Instance Name</th><th>Account Manager</th></tr>";
            //$instances_success = explode("", $_GET['instances']);
            //var_dump($instances_success);
            
            foreach($_GET['item'] as $key => $val) {
                //echo $val['instance_name'] . " , " . $val['acc_mgr'] . "<br>";
                echo "<tr><td>" . $val['instance_name'] . "</td><td>" . $val['acc_mgr'] . "</td></tr>";
            } ?>
            </table>
        <?php } elseif($_GET['msg'] == 2) { ?>
            <div class="w3-panel w3-yellow w3-display-container" style="width:770px; margin: 0 auto;">
            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-yellow w3-large w3-display-topright">&times;</span>
            <h3>Failed!</h3>
            <p>Something went wrong, unable to map instances.</p>
            </div>
        <?php } elseif($_GET['msg'] == 3) { ?>
            <div class="w3-panel w3-red w3-display-container" style="width:770px; margin: 0 auto;">
            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-red w3-large w3-display-topright">&times;</span>
            <h3>Failed!</h3>
            <p>Something went wrong, unable to connect database.</p>
            </div>
        <?php }
    }
    ?>
    </div>
</body>
</html>
