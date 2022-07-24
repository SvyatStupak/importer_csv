<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
</head>

<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $('#myTable tr').filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    })
                })
            });
        </script>
    </head>

    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <div class="navbar-form navbar-left">
                        <div class="form-group">
                            <!-- <input type="text" class="form-control" placeholder="Search"> -->
                            <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search">
                        </div>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/index.php">Import data</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>


        <div id="wrap">
            <div class="container">
                <?php
                $con = new mysqli(HOST, USER, PASSWORD, DB);
                $Sql = "SELECT * FROM users";
                $result = mysqli_query($con, $Sql);
                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                                <thead><tr><th>UID</th>
                                             <th>Name</th>
                                             <th>Age Name</th>
                                             <th>Email</th>
                                             <th>Phone</th>
                                             <th>Gender Date</th>
                                           </tr></thead><tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $row['UID'] . "</td>
                                      <td>" . $row['Name'] . "</td>
                                      <td>" . $row['Age'] . "</td>
                                      <td>" . $row['Email'] . "</td>
                                      <td>" . $row['Phone'] . "</td>
                                      <td>" . $row['Gender'] . "</td></tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<h1>You have no records</h1>";
                }
                ?>
            </div>
        </div>
        <div id="wrap">
            <div class="container">
                <div class="row">
                    <form class="form-horizontal" action="show.php" method="post" name="upload_excel" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Export CSV FILES</legend>

                            <!-- Button -->
                            <div>
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-4">
                                        <input type="submit" name="Export" class="btn btn-success" value="export to excel" />
                                    </div>
                                </div>
                            </div>


                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </body>

    </html>
</body>



</html>