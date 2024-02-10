<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

    $user_name = $_POST['user_name'];
    $user_mail = $_POST['user_mail'];
    $user_number = $_POST['user_number'];
    $user_address = $_POST['user_address'];
    $user_city = $_POST['user_city'];
    $preferreddays = $_POST['preferreddays'];
    $zip_code = $_POST['zip_code'];
    $skills = $_POST['skills'];
    $volunteerlocation = $_POST['volunteerlocation'];

    //Database connection
    $conn = new mysqli( 'localhost:8889','root','root','test_index');
    if ($conn->connect_error) {
        die('Connection failed: ' .$conn->connect_error);
    } else {
        $stmt = $conn->prepare('insert into index_data(user_name, user_mail, user_number, user_address, user_city, preferreddays, zip_code, skills, volunteerlocation)
        values(?,?,?,?,?,?,?,?,?)');
        $response = implode(', ', $_POST['skills']);
        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt ->bind_param('ssisssiss', $user_name, $user_mail, $user_number, $user_address, $user_city, $preferreddays, $zip_code, $response, $volunteerlocation);
        $stmt -> execute();
        echo "Thank you for signing up! Registration successful!";
        $stmt -> close();
        $conn ->close();
    }
    echo '<button onclick="window.location.href = \'homepage.html\';">Back to Homepage</button>';

?>