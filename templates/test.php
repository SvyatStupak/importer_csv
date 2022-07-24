<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Import CSV</title>
</head>

<body>
    <form action="index.php" method="POST">
        <div class="form-control">
            <table class="table">
                <thead>
                    <?php for ($i = 0; $i < count($result[0]); $i++) : ?>
                        <th>
                            <select class="form-control" name="fields[<?= $i; ?>]" id="">
                                <option value="no">Skip</option>
                                <?php foreach ($fields as $key => $value) : ?>
                                    <option value="<?= $key; ?>"><?= $value; ?></option>
                                <?php endforeach ?>
                            </select>
                        </th>
                    <?php endfor; ?>
                </thead>
                <tbody>
                    <?php foreach ($result as $key => $value) : ?>
                        <tr <?php if ($key == 0) echo 'class="alert alert-success"'; ?>>
                            <?php foreach ($value as $k => $v) : ?>
                                <td>
                                    <?php echo $v ?>
                                </td>
                            <?php endforeach ?>

                        </tr>
                    <?php endforeach ?>
                </tbody>

            </table>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>

</body>

</html>