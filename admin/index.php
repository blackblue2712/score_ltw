<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sheet</title>
    <link rel="stylesheet" type="text/css" href="../asset/css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="box-form" style="width: 500">
            <h2>Import file excel to db</h2>
            <form action="process.php" method="POST" enctype="multipart/form-data" id="main-form">
                <div class="inputBox">
                    <!-- <label for="password">File</label> -->
                    <input type="file" name="fileEx" id="fileEx">
                </div>
                <div class="form-group">
                    <label for="gender" class="title">Type</label>
                    <label style="color: #fff"><input type="radio" name="type" value="insertAll" checked="checked"> Insert in one query</label>
                    <label style="color: #fff"><input type="radio" name="type" value="insertSequence"> Insert in for loop</label>
                    <label style="color: #fff"><input type="radio" name="type" value="update"> Update</label>
                </div>
                <div style="margin-top: 20px; display: flex; align-items: center">
                    <input type="submit" name="btnSubmit" value="Submit" style="margin-right: 10px" id="submit-form" onclick="onSubmitForm()"/>
                    <input type="reset" name="" value="Reset"/>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script>
        window.onload = () => {
            let form = document.getElementById("main-form");

        }
        let onSubmitForm = async () => {
            window.event.preventDefault();
            try {
                let fileURL = await asyncSubmitFile();
                let fileData = await readFileAfterSubmit(fileURL);
                let finalRes = await writeDataToDb(fileData);
                
                console.log(fileURL, fileData, finalRes)
                alert("Done, check the console");
            } catch( err ) {
                console.log(err);
            }
            
        }

        

    </script>
</body>
</html>