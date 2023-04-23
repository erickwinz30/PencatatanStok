<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="hasil" method="POST">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
        <label>Masukkan nilai yang akan ditambahkan</label>
        <br>
        <input type="number" name="txtJumlah">
        <br>
        <input type="submit" name="proses" value="Proses">
    </form>
</body>
</html>