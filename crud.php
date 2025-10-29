<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer-master\src\Exception.php';
    require 'PHPMailer-master\src\PHPMailer.php';
    require 'PHPMailer-master\src\SMTP.php';
    
    include "db.php";

$flag = $_POST['flag'];

if(isset($_POST['email'])){
    $email = $_POST['email'];
}
if(isset($_POST['datereturned'])){
    $datereturned = $_POST['datereturned'];
}
if(isset($_POST['barcode_id'])){
 $barcode_id = $_POST['barcode_id'];
}
if(isset($_POST['item_name'])){
    $item_name = $_POST['item_name'];
}
if(isset($_POST['quantity'])){
      $quantity = $_POST['quantity'];
}
if(isset($_POST['qty_borrow'])){
      $qty_borrow = $_POST['qty_borrow'];
}
if(isset($_POST['date_borr'])){
      $date_borr = $_POST['date_borr'];
}
if(isset($_POST['date_ret'])){
      $date_ret = $_POST['date_ret'];
}

if(isset($_POST['schoolid'])){
    $schoolid = $_POST['schoolid'];
}

if(isset($_POST['studname'])){
    $studname = $_POST['studname'];
}

if(isset($_POST['firstname'])){
    $firstname = $_POST['firstname'];
}

if(isset($_POST['lastname'])){
$lastname = $_POST['lastname'];
}


if(isset($_POST['yearlevel'])){
  $yearlevel = $_POST['yearlevel'];  
}

if(isset($_POST['course'])){
$course = $_POST['course'];
}

if($flag == 'add'){
    $query = "Insert into tbl_register VALUES (null, '$firstname', '$lastname', '$schoolid', '$course', '$yearlevel', '$email')"; // for inserting values to the SQL
if(mysqli_query($Con, $query)){
    echo "Yes";
}
else{
    echo "not recorded";
}
}
if($flag == 'addItem'){
    $query = "Insert into tbl_items VALUES (null, '$item_name', '$quantity')"; // for inserting values to the SQL
if(mysqli_query($Con, $query)){
    echo "Yes";
}
else{
    echo "not recorded";
}
}

else if($flag == 'edit'){
     $query = "UPDATE tbl_register SET fname = '$firstname', lname = '$lastname', course = '$course', yearlevel = '$yearlevel', email = '$email' WHERE idschool = '$schoolid'"; // for inserting values to the SQL
if(mysqli_query($Con, $query)){
    echo "Yes";
}
else{
    echo "not recorded";
}
}
else if($flag == 'edit_item'){
     $query = "UPDATE tbl_items SET item_name = '$item_name', quantity = '$quantity' WHERE barcode_id = '$barcode_id'"; // for inserting values to the SQL
if(mysqli_query($Con, $query)){
    echo "Yes";
}
else{
    echo "not recorded";
}
}

else if($flag == 'delete'){
     $query = "DELETE FROM tbl_register WHERE idschool = '$schoolid'"; // for DELETING values to the SQL
        if(mysqli_query($Con, $query)){
             echo "Yes";
}
else{
    echo "not recorded";
}
}
else if($flag == 'delete_item'){
     $query = "DELETE FROM tbl_items WHERE barcode_id = '$barcode_id'"; // for DELETING values to the SQL
        if(mysqli_query($Con, $query)){
             echo "Yes";
        }
    }
else if($flag == 'borrow'){
    $query = "INSERT INTO tbl_borrowers VALUES(null, '$barcode_id', '$item_name', '$qty_borrow', '$schoolid', '$studname', '$date_borr', '$date_ret', '$email')";
    $query_dec = "UPDATE tbl_items SET quantity = quantity - '$qty_borrow' WHERE barcode_id = '$barcode_id'";
    mysqli_query($Con, $query_dec);
        
    
    if(mysqli_query($Con, $query)){
        echo "Yes";
    }
    else{
        echo "Not Recorded";
    }
}

else if($flag == 'return'){
    $query = "INSERT INTO tbl_transaction VALUES(null, '$barcode_id', '$item_name', '$qty_borrow', '$schoolid', '$studname', '$date_borr', '$date_ret', '$datereturned', '$email')";
    $query_borr_del = "DELETE FROM tbl_borrowers WHERE barcode_id = '$barcode_id' AND school_id = '$schoolid'";
    $query_inc = "UPDATE tbl_items SET quantity = quantity + '$qty_borrow' WHERE barcode_id = '$barcode_id'";
    mysqli_query($Con, $query_borr_del);
    mysqli_query($Con, $query_inc);
    if(mysqli_query($Con, $query)){
        echo "Yes";
    }
    else{
        echo "Not Recorded";
    }
}

// SEND AUTOMATED EMAIL FOR LATE BORROWERS
else if($flag == 'email') {

    $mail = new PHPMailer(true);

    try {
        //  SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mestidio.ianmcpe1996@gmail.com'; 
        $mail->Password   = 'iuoizicqgypyguhy'; //app password for gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //  Email Content
        $mail->setFrom('mestidio.ianmcpe1996@gmail.com', 'Borrowed Item Notice');
        $mail->addAddress($email);

        $mail->Subject = 'WIT COMPUTER ENGINEERING:Late Borrowed Item Notice';
        $mail->Body    = "You currently have an overdue borrowed item at WIT MicroLab. Please return it immediately.";

        $mail->send();
        echo "Email Sent";

    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }

    exit();
}
?>