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
<?php
$sql = "SELECT * FROM cart";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<body>
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

    <!-- <table>
        <thead>
            <th>No.</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Update</th>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo '$' . $product['price']; ?></td>
                    <td><input type="number" value="<?php echo $product['quantity']; ?>"></td>
                    <?php $total = $product['quantity'] * $product['price']; ?>
                    <td><?php echo  '$' . $total; ?></td>
                    <td>
                        <a class="btn btn-primary" href="index.php?idUpdate=<?php echo $product['id'] ?>">Update</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table> -->
</body>

</html>