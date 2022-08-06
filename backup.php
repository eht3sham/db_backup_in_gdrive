<?php
// phpinfo();


 echo OPENSSL_VERSION_NUMBER
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Download</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <div class="container d-flex  justify-content-center mt-5">
        <form id="myForm">
            <div class="form-group">
                <label for="" class="form-label">Database name</label>
                <input type="text" class="form-control" name="db_name" id="db_name" required placeholder="mydatabase">

            </div>

            <button class="btn btn-primary" type="submit">Backup</button>
        </form>
    </div>
    <div class="container d-flex  justify-content-center mt-5" id="result">
    </div>
</body>
<script>
$("#myForm").on("submit", function(event) {
    event.preventDefault();
    let formData = new FormData(document.getElementById('myForm'));
    let db_name = $('#db_name').val().trim();
    if (db_name == '') {
        swal({
            text: "Enter database name to  continue!",
        })
        return false;
    }
    swal({
        text: "Do you want to take backup of  this database?",
        buttons: true,
        dangerMode: false,
    }).then((Confirmatn) => {
        if (Confirmatn) {
            // var formData = new FormData();
            // formData.append('file', $('#sql_imp')[0].files[0]);
            jQuery.ajax({
                type: 'POST',
                url: 'download_database.php',
                data: formData,

                cache: false,
                contentType: false,
                processData: false,
                dataType: 'html',
                success: function(data) {
                    console.log(data);
                    if (data == 1)
                        myResp = swal(
                            "database backup successfully !");
                    else
                        myResp = swal("something Went Wrong !");

                }
            }); //ajax close
        }
    });
})
</script>

</html>