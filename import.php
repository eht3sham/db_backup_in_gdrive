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
    <div class="container d-flex  justify-content-left mt-5">
        <div class="row">
            <form id="myForm" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="sql_imp">Select Sql</label>
                    <input type="file" class="form-control" id="sql_imp" name="sql_imp">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>

</body>
<script>
// function import_database() {
//     $.ajax({
//         url: "import_database.php",
//         success: function(result) {
//             $("#result").text(result);
//         }
//     })
// }
$('#sql_imp').change(() => {
    let ext = $('#sql_imp').val().split('.').pop().toLowerCase();
    let imagename = document.getElementById('sql_imp');
    if (jQuery.inArray(ext, ['sql']) == -1) {
        alert('Please Select SQL File!');
        $('#sql_imp').val('');
        $('#sql_imp').focus();
    }
});

$("#myForm").on("submit", function(event) {
    event.preventDefault();
    // let formData = new FormData(document.getElementById('myForm'));
    if ($('#sql_imp').val() == '') {
        swal({
            text: "Choose SQL file to continue!",
        })
        return false;
    }
    swal({
        text: "Do you want to Import this sql?",
        buttons: true,
        dangerMode: false,
    }).then((Confirmatn) => {
        if (Confirmatn) {
            var formData = new FormData();
            formData.append('file', $('#sql_imp')[0].files[0]);
            jQuery.ajax({
                type: 'POST',
                url: 'import_database.php',
                data: formData,

                cache: false,
                contentType: false,
                processData: false,
                dataType: 'html',
                success: function(data) {
                    // console.log(data);
                    if (data == 1)
                        myResp = swal(
                            "database Impoted successfully !");
                    else
                        myResp = swal("something Went Wrong !");

                }
            }); //ajax close
        }
    });
})
</script>

</html>