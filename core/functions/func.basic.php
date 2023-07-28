<?php


function connectDb() {
    global $global_pdo_user;
    global $global_pdo_pass;
    global $global_pdo_db;

    $conn = mysqli_connect("mysql.xservico.com", $global_pdo_user, $global_pdo_pass, $global_pdo_db);
    if(!$conn) {
        die('Error'.mysqli_connect_error());
    }
    return $conn;
}

function selectQuery($query) {
    return mysqli_query(connectDb(),$query);
}

function otherQuery($query) {
    return mysqli_query(connectDb(), $query);
}
function html_sanitize($input){ //For sanitizing html content before being saved into the database. Useful against Cross-site Scripting Attacks
    $input = htmlspecialchars($input);
    return $input;
}

function html_array_sanitize($array){
    foreach ($array as $key => $value) {
        $array[$key] = html_sanitize($array[$key]);
    }
    return $array;
}

function imagecreatefromfile($filename, $type, $name){
    switch ($type) {
        case '2':
            return imagejpeg(imagecreatefromjpeg($filename), $name);
            break;

        case '3':
            return imagepng(imagecreatefrompng($filename), $name);
            break;

        default:
            return false;
            break;
    }
}

function generateProdCode(){
    do{
        $characters = '2345678923456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $query = selectQuery("select * from prods where product_code = '$randomString'");
    }while (mysqli_num_rows($query)>0);
    return $randomString;
}

function generateUserPassword($phone) {
    $characters = '2345678923456789abcdefghijlkmnopqrstuvwxy'.$phone;
    $charactersLength = strlen($characters);
    $new_pass = '';
    for($i = 0; $i < 8; $i++) {
        $new_pass .= $characters[rand(0, $charactersLength -1 )];
    }
    return $new_pass;
}

function generateOrderRef(){
    do{
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 2; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString.=time();
        $query = selectQuery("select * from orders where reference = '$randomString'");
    }while (mysqli_num_rows($query)>0);
    return $randomString;
}

function getUserInfo($email, $type){
    $info = null;
    $query = selectQuery("select $type from members where email='$email'");
    while($row=mysqli_fetch_assoc($query)){
        $info = $row[$type];
    }
    return $info;
}
function getUserID($email_slug){
    $query = selectQuery("select * from members where email_slug =  '$email_slug'");
    $row=mysqli_fetch_assoc($query);
    return $row['id'];
}

function verify_password($password, $hash) {
    return md5($password) == $hash;
}

function validateUser() {
    $query = selectQuery("select * from members where roles is NULL  and email_slug = '{$_SESSION['xservico_slug'][0]}'");
    if(mysqli_num_rows($query)==0) {
        header("Location: {$GLOBALS['path']}res/administrator/index");
        exit;
    }
}

function validateAdmin($role_str) {
    $query = selectQuery("select * from members where roles is not NULL and email_slug = '{$_SESSION['xservico_slug'][0]}'");
    $row = mysqli_fetch_assoc($query);
    $roles = explode(",", $row['roles']);
    $roles_arr = explode(",", $role_str);
    $x = $found = 0;
    do {
        if(in_array($roles_arr[$x], $roles)) {
            $found++;
        }
        $x++;
    }while($x<sizeof($roles_arr));
    if($found==0 && $roles[0]<>"1") {
        header("Location: {$GLOBALS['path']}res/administrator/index");
        exit;
    }
}

function createLog($user_id, $activity) {
    $date = date("Y-m-d H:i:s");;
    $sql = "INSERT INTO audit_trail (user_id,activity,date_posted) VALUES ('$user_id','$activity','$date')";
    otherQuery($sql);
}

function sendEmail($email, $subject, $message){
    $to = $email;
    $message = wordwrap($message, 70, "\n");
    $message = "<body>".$message."</body>";
    $headers = 'Content-type: text/html; charset=iso-8859-1; charset=utf-8'."\n".
        'From: Xservico Online <enterprise@xservico.com>' . "\n" .
        'Reply-To: enterprise@xservico.com' . "\n" .
        'Return-Path: enterprise@xservico.com' . "\n" .
        'Organization: Xservico Online' . "\n" .
        'MIME-Version: 1.0' . "\n" .
        'X-Priority: 1' . "\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
}

function manageOrders($type=null){
    if($type=="completed"){
        $where = "where status = '1'";
    }elseif($type=="canceled"){
        $where = "where status = '2'";
    }elseif($type=="pending"){
        $where = "where status = '0'";
    }else{
        $where = "";
    }
    $query = selectQuery("select * from orders {$where} order by date_posted desc");
    $string = "";$sn=1;
    while($row=mysqli_fetch_assoc($query)){
        $query2 = selectQuery("select * from members where id = '{$row['member_id']}'");
        $row2=mysqli_fetch_assoc($query2);
        $date_posted = date("M d, Y g:i a", strtotime($row['date_posted']));
        $date_modified = date("M d, Y g:i a", strtotime($row['date_modified']));
        if($row['status']=="0"){
            $status = "Pending";
        }elseif($row['status']=="1"){
            $status = "Completed";
        }elseif($row['status']=="2"){
            $status = "Canceled";
        }
        $amount = number_format($row['amount'], 2);
        $query3=selectQuery("select * from ordertracks where order_ref = '{$row['reference']}' order by date_posted desc limit 1");
        $row3=mysqli_fetch_assoc($query3);
        $string .= "<tr>
                        <td>{$sn}</td>
                        <td>#{$row['reference']}</td>
                        <td>{$row2['email']}</td>
                        <td>{$date_posted}</td>
                        <td>&#8358; {$amount} for {$row['quantity']} item(s)</td>
                        <td>{$row3['remarks']}</td>
                        <td>{$status}</td>
                        <td>{$date_modified}</td>
                        <td><a href='manage-trxns?x={$row['reference']}' class='btn btn-fill-out btn-sm'>Manage</a></td>
                    </tr>";
        $sn++;
    }
    $string = $string=="" ? "<tr><td colspan='9' align='center'>Nothing to show</td></tr>" : $string;
    return $string;
}

function allAdmins(){
    $string = "";$sn=0;
    $query = selectQuery("select * from members where roles is not null order by date_registered desc");
    while($row=mysqli_fetch_assoc($query)){
        $sn++;
        if($row['user_status']=="1"){
            $status="<span class='label label-success'>Active</span>";
        }elseif($row['user_status']=="0"){
            $status="<span class='label label-default'>Pending</span>";
        }elseif($row['user_status']=="2"){
            $status="<span class='label label-warning'>Blocked</span>";
        }elseif($row['user_status']=="3"){
            $status="<span class='label label-danger'>Deleted</span>";
        }

        $roles = "";
        $role = explode(",", $row['roles']);
        if(in_array("1", $role)){$roles.="<span class='label label-default'>Super Admin</span><br/>";}
        if(in_array("2", $role)){$roles.="<span class='label label-default'>Members</span><br/>";}
        if(in_array("3", $role)){$roles.="<span class='label label-default'>Stocks</span><br/>";}
        if(in_array("4", $role)){$roles.="<span class='label label-default'>Transactions</span><br/>";}
        if(in_array("5", $role)){$roles.="<span class='label label-default'>Tickets</span><br/>";}
        if(in_array("6", $role)){$roles.="<span class='label label-default'>Blogs & Pages</span><br/>";}
        $date_registered = date("D, j M Y g:i a", strtotime($row['date_registered']));
        $string .= "
                    <tr>
                        <td>{$sn}</td>
                        <td>{$row['fname']} {$row['lname']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$status}</td>
                        <td>{$roles}</td>
                        <td>{$date_registered}</td>
                        <td align='center'>
                            <a href='?m={$row['email_slug']}'><button class='fa fa-edit btn btn-success' title='Manage'></button></a>
                        </td>
                    </tr>";
    }
    return $string;
}

function allUsers(){
    $string = "";$sn=0;
    $query = selectQuery("select * from members where roles is null order by date_registered desc");
    while($row=mysqli_fetch_assoc($query)){
        $sn++;
        if($row['user_status']=="1"){
            $status="<span class='label label-success'>Active</span>";
        }elseif($row['user_status']=="0"){
            $status="<span class='label label-default'>Pending</span>";
        }elseif($row['user_status']=="2"){
            $status="<span class='label label-warning'>Blocked</span>";
        }elseif($row['user_status']=="3"){
            $status="<span class='label label-danger'>Deleted</span>";
        }

        $date_registered = date("D, j M Y g:i a", strtotime($row['date_registered']));
        $string .= "
                    <tr>
                        <td>{$sn}</td>
                        <td>{$row['fname']} {$row['lname']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$status}</td>
                        <td>{$date_registered}</td>
                        <td align='center'>
                            <a href='?m={$row['email_slug']}'><button class='fa fa-edit btn btn-success' title='Manage'></button></a>
                        </td>
                    </tr>";
    }
    return $string;
}

function allMyActivities($user_id) {
    $string = "";$sn=0;
    $query = selectQuery("select * from audit_trail where user_id='$user_id' order by date_posted asc limit 9");
    $count = mysqli_num_rows(selectQuery("select * from audit_trail where user_id='$user_id'"));
    while($row=mysqli_fetch_assoc($query)) {
        $date_posted = date("g:i a", strtotime($row['date_posted']));
        $string .= "<div class='timeline-item align-items-start'>
                        <div class='timeline-label font-weight-bolder text-dark-75' style='font-size: 0.7rem'>{$date_posted}</div>
                        <div class='timeline-badge'>
                            <i class='fa fa-genderless text-warning icon-xl'></i>
                        </div>
                        <div class='font-weight-mormal font-size-lg timeline-content text-muted pl-3'>{$row['activity']}</div>
                    </div>";
    }
    return array($count, $string);
}

function allProductCategories() {
    $string = "";$sn=0;
    $query = selectQuery("select * from prod_cats");
    while ($row=mysqli_fetch_assoc($query)) {
        $sn++;
        $status = $row['status']=="1"?"Active":"Disabled";
        $string .= "
                    <tr>
                        <td>{$sn}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['slug']}</td>
                        <td><i class='{$row['icon']}'></i></td>
                        <td>{$status}</td>
                        <td align='center'>
                            <a href='?m={$row['id']}'><button class='fa fa-edit btn btn-success' title='Manage'></button></a>
                        </td>
                    </tr>";
    }
    $string = $string=="" ? "<tr><td colspan='6' align='center'>Nothing to show</td></tr>" : $string;
    return $string;
}

function allBankAccounts($merchants){
    $string = "";$sn=0;
    $query = selectQuery("select * from bank_accounts where merchants = '$merchants'");
    while($row=mysqli_fetch_assoc($query)){
        $sn++;
        $posted = date("D, j M Y g:i a", strtotime($row['date_posted']));
        $modified = date("D, j M Y g:i a", strtotime($row['date_modified']));
        $string .= "
                    <tr>
                        <td>{$sn}</td>
                        <td>{$row['bank_name']}</td>
                        <td>{$row['account_name']}</td>
                        <td>{$row['account_number']}</td>
                        <td>{$row['account_type']}</td>
                        <td>{$posted}</td>
                        <td>{$modified}</td>
                        <td align='center'>
                            <a href='?m={$row['id']}'><button class='fa fa-edit btn btn-success' title='Manage'></button></a>
                        </td>
                    </tr>";
    }
    $string = $string=="" ? "<tr><td colspan='8' align='center'>Nothing to show</td></tr>" : $string;
    return $string;
}

function allBrands(){
    $string = "";$sn=0;
    $query = selectQuery("select * from brands");
    while($row=mysqli_fetch_assoc($query)){
        $sn++;
        $status = $row['status']=="1"?"Active":"Disabled";
        $string .= "
                    <tr>
                        <td>{$sn}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['slug']}</td>
                        <td>{$status}</td>
                        <td align='center'>
                            <a href='?m={$row['id']}'><button class='fa fa-edit btn btn-success' title='Manage'></button></a>
                        </td>
                    </tr>";
    }
    $string = $string=="" ? "<tr><td colspan='5' align='center'>Nothing to show</td></tr>" : $string;
    return $string;
}

function allFAQs(){
    $string = "";$sn=0;
    $query = selectQuery("select * from faq");
    while($row=mysqli_fetch_assoc($query)){
        $sn++;
        $date_posted = date("D, j M Y g:i a", strtotime($row['date_posted']));
        $string .= "
                    <tr>
                        <td>{$sn}</td>
                        <td>{$row['question']}</td>
                        <td>{$date_posted}</td>
                        <td align='center'>
                            <a href='?m={$row['id']}'><button class='fa fa-edit btn btn-success' title='Manage'></button></a>
                        </td>
                    </tr>";
    }
    $string = $string=="" ? "<tr><td colspan='4' align='center'>Nothing to show</td></tr>" : $string;
    return $string;
}

function listProdCategories(){
    $string = "";
    $query = selectQuery("select * from prod_cats where status = '1'");
    while($row=mysqli_fetch_assoc($query)){
        $string .= "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    return $string;
}

function updateProdCategories($cat_id){
    $string = "";
    $query = selectQuery("select * from prod_cats where status = '1'");
    while($row=mysqli_fetch_assoc($query)){
        $selected = $row['id']==$cat_id ? "selected" : "";
        $string .= "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
    }
    return $string;
}

function listBrands(){
    $string = "";
    $query = selectQuery("select * from brands where status = '1'");
    while($row=mysqli_fetch_assoc($query)){
        $string .= "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    return $string;
}

function updateBrands($brand_id){
    $string = "";
    $query = selectQuery("select * from brands where status = '1'");
    while($row=mysqli_fetch_assoc($query)){
        $selected = $row['id']==$brand_id ? "selected" : "";
        $string .= "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
    }
    return $string;
}

function getProdId($slug){
    $id = null;
    $query = selectQuery("select * from prods where slug = '$slug'");
    while($row=mysqli_fetch_assoc($query)){
        $id = $row['id'];
    }
    return $id;
}

function getProdCat($cat_id){
    $cat = null;
    $query = selectQuery("select * from prod_cats where id = '$cat_id'");
    while($row=mysqli_fetch_assoc($query)){
        $cat = $row['name'];
    }
    return $cat;
}

function getProdBrand($brand_id){
    $brand = null;
    $query = selectQuery("select * from brands where id = '$brand_id'");
    while($row=mysqli_fetch_assoc($query)){
        $brand = $row['name'];
    }
    return $brand;
}



function indexStats(){
    $total = $pending = 0;
    $query = selectQuery("select * from orders");
    while($row=mysqli_fetch_assoc($query)){
        if($row['status']=="1"){
            $total += (float)$row['amount'];
        }
        if($row['status']=="0"){
            $pending+=1;
        }
    }
    return array($total, mysqli_num_rows($query), $pending);
}

function totalMembers(){
    $query = selectQuery("select * from members where roles is null");
    return mysqli_num_rows($query);
}
?>