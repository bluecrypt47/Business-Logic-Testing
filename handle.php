<?php
if (!isset($_SESSION)) {
    session_start();
}
header('Content-Type: text/html; charset=utf-8');
// Kết nối cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'bldv') or die('Connection fail!');
mysqli_set_charset($conn, "utf8");

// Login
if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    if (empty($username)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Two password do not match");
    }

    // Kiểm tra email và password có trong DB không
    $sql = "SELECT * FROM accounts WHERE username = '$username' AND password = '$password'";

    // Thực thi câu truy vấn
    $result = mysqli_query($conn, $sql);

    // Nếu kết quả trả về lớn hơn 1 thì nghĩa là username hoặc email đã tồn tại trong CSDL
    if (mysqli_num_rows($result) > 0) {

        echo '<script language="javascript">alert("Login Successfully!"); window.location="index.php";</script>';
    } else {
        echo '<script language="javascript">alert("Email has existed!"); window.location="login.php";</script>';
        die();
    }
    $_SESSION['username'] = $username;
    die();
}

//Upload file
if (isset($_POST['upload'])) {

    // lay thong tin file upload
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $destination = './uploads/' . $name;

    $extension = pathinfo($name, PATHINFO_EXTENSION);

    $file = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];


    if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
        echo "File tail must be png, jpg or jpeg ";
    } else {
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO upload (name, size) VALUES ('$name',  $size)";

            if (mysqli_query($conn, $sql)) {
                echo $destination . ' file Successfully!';
            } else {
                echo "Upload file Fail!";
                echo '<script>window.location="upload.php";</script>';
                die();
            }
        }
    }
}

// Transfer Money
if (isset($_POST['send'])) {
    $name = trim($_POST['receiver']);
    $num = $_POST['money'];
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM accounts WHERE name = '$name' ";
    $sql2 = "SELECT * FROM accounts WHERE username = '$username' ";

    $result = mysqli_query($conn, $sql);


    $result2 = mysqli_query($conn, $sql2);


    if (mysqli_num_rows($result) > 0) {
        $account = mysqli_fetch_assoc($result);
        $balance =  $account['balance'];
        $total = $balance + $num;

        $account2 = mysqli_fetch_assoc($result2);
        $balance2 =  $account2['balance'];
        $total2 = $balance2 - $num;

        $update = "UPDATE `accounts` SET `balance`= '$total' WHERE name='$name'";
        $update2 = "UPDATE `accounts` SET `balance`= '$total2' WHERE username='$username'";

        mysqli_query($conn, $update);
        mysqli_query($conn, $update2);
        echo '<script>alert("Transfer money Successfully!"); window.location="index.php";</script>';
        die();
    } else {
        echo '<script language="javascript">alert("Name has existed!"); window.location="index.php";</script>';
        die();
    }
}
