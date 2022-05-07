<?php
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
    echo "Xin chào " . $username;
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

    $sql = "SELECT * FROM accounts WHERE name = '$name' ";
    $result = mysqli_query($conn, $sql);

    $account = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0) {

        $total = $account['balance'] + $num;

        $update1 = "UPDATE `accounts` SET `balance`='$total' WHERE name='$name'";
        $use = $_SESSION['username'];
        $sql1 = "SELECT * FROM accounts WHERE username = '$use' ";
        $result1 = mysqli_query($conn, $sql1);

        $account1 = mysqli_fetch_assoc($result1);
        $total1 = $account1['balance'] - $num;

        echo '<script> window.location="index.php";</script>';
    } else {
        echo '<script language="javascript">alert("Email has existed!"); window.location="login.php";</script>';
        die();
    }
}
