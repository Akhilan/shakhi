<?php 

require 'cnn.php';
require 'calculate_class.php';
require 'hash.php';

// Initialize all the values
$name = "";
$name_ml = "";
$sex = "";
$bgroup = "";
$weight = 50;
$phone = "";
$email = "";
$password="";
$district="";
$state = "";
$country = "";
$address="";
$last="";
$publish1=0;
$designation = "";
$organization = "";

$sql="select * from user ";
$result=mysql_query($sql,$link);

// Rewite thee code to use search from the database
while($detail = mysql_fetch_array($result,MYSQL_ASSOC)) {
    @$usr=$detail['UserID'];
    if($usr == $_POST["email"]) {
        header("Location: ./index.php?msg=Username already exists,Please login here");
        die(mysql_error($link));
    }
}

if(isset($_POST["email"])){
    if( trim($_POST["name"]) != "" ) $name = trim($_POST["name"]);
    if( trim($_POST["name_ml"]) != "" ) $name_ml = trim($_POST["name_ml"]);
    $sex = $_POST["sex"];
    $bgroup = $_POST["bloodgroup"];
    if( trim($_POST["phone"]) != "" ) $phone = trim($_POST["phone"]);
    if( trim($_POST["email"]) != "" ) $email = trim($_POST["email"]);
    $email = strtolower($email);
    $password = $_POST["password"];
    if( trim($_POST["address"]) != "" ) $address = trim($_POST["address"]);
    $district = $_POST["district"];
    $state = $_POST["state"];
    $country = $_POST["country"];
    $designation = $_POST["designation"];
    $organization = $_POST["organization"];
    if( trim($_POST["weight"]) != "" ) $weight = trim($_POST["weight"]);
    $publish1 = $_POST["publish"];
    //DOB
    $dd = $_POST["dd"];
    $dm = $_POST["dm"];
    $dy = $_POST["dy"];
    // Last date of donation.
    $ld = $_POST["ld"];
    $lm = $_POST["lm"];
    $ly = $_POST["ly"];

    $dob = dmy2mysql($dd, $dm, $dy);
    $last = dmy2mysql($ld, $lm, $ly);

    $hashed_password = superHash($password);

    if($publish1 == "on")
        $publish=1;

    $sql="INSERT INTO registration (Name, name_ml, DOB, Gender, Bloodgroup, Weight, Designation, ContactNo, Emailid, LastDonation, Publish, District, Post, state, Organization)
    VALUES ('$name', '$name_ml', '$dob',$sex,'$bgroup','$weight','$designation','$phone','$email','$last', '$publish','$district','$address', '$state', '$organization')";
    $sql2="INSERT INTO user (UserID, PWD)VALUES ('$email' , '$hashed_password')";
    echo $sql;
    mysql_query($sql2,$link);

    if(!mysql_query($sql,$link))
            die ('Error' . mysql_error());
    else {
        mysql_query($result1,$link);
        $_SESSION['key1']='$email';
        header("Location: ./index.php?msg=Please login here");
    }
 }
 ?>