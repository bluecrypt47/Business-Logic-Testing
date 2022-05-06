<?php
header('Content-Type: text/html; charset=utf-8');
// Kết nối cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'bldv') or die('Connection fail!');
mysqli_set_charset($conn, "utf8");

//Upload file
if (isset($_POST['upload'])) {

    // lay thong tin file upload
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $destination = './uploads/' . $name;

    $extension = pathinfo($name, PATHINFO_EXTENSION);

    $file = $_FILES['file']['tmp_name'];
    $size = $_FILES['file']['size'];


    if (!in_array($extension, ['pdf', 'png', 'jpg', 'jpeg'])) {
        echo "File tail must be pdf, png, jpg, jpeg or gif";
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
