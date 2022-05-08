<?php session_start() ?>
<?php require 'handle.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dash Board</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="styles.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        table {
            width: 60%;
            border-collapse: collapse;
            margin: 100px auto;
        }

        th,
        td {
            width: 18%;
            height: 50px;
            vertical-align: center;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        $sql = "SELECT * FROM accounts WHERE username = '$username'";

        $result = mysqli_query($conn, $sql);
        $account = mysqli_fetch_assoc($result);
    } ?>
    <a href="logout.php" class="btn btn-lg btn-primary btn-block">Logout</a>
    <h1 align="center">Welcome <?php echo $account['name'] ?>!!! - Balance: $ <?php echo $account['balance'] ?></h1>

    <!-- Upload -->
    <form action="index.php" class="form" method="POST" enctype="multipart/form-data">
        <h2 class="form-heading">Upload File</h2>
        <div class="form-group">
            <label for="InputFile">File input</label>
            <input type="file" name="file" id="InputFile">
        </div>
        <input class="btn btn-lg btn-primary btn-block" type="submit" name="upload" value="Upload" style="width: 100px;" />
        <?php require 'handle.php'; ?>
    </form>

    <!-- Transfer Money -->
    <div align="center">
        <form action="index.php" method="POST">
            <h2>Transfer Money</h2>
            <label>Receiver: <input type="text" name="receiver" placeholder="Chương"></label> <br>
            <label>Amount: <input type="number" name="money" placeholder="0"></label><br>
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="send" value="Send" style="width: 100px;">
        </form>
    </div>
</body>

</html>