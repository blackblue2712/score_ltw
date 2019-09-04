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

        let asyncSubmitFile = () => {
            let data = new FormData();
            let fileUpload = document.getElementById("fileEx").files[0];
            data.append("file", fileUpload);
            let promise = new Promise( (resolve, reject) => {
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST" ,"./process.php", true);
                xmlhttp.send(data);
                xmlhttp.onreadystatechange = function () {
                    if(this.status === 200 && this.readyState === 4) {
                        if(this.response) {
                            let res = JSON.parse(this.response);
                            resolve(res);
                        } else {
                            reject("can not upload file");
                        }
                    }
                }

            });
            return promise;
        }

        let readFileAfterSubmit = (url) => {
            let fetchURL = url.des_file;
            let promise = new Promise( (resolve, reject) => {
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.responseType = "arraybuffer";
                xmlhttp.onreadystatechange = function(e) {
                    if(this.status === 200 && this.readyState === 4) {
                        if(this.response) {
                            let arraybuffer = this.response;
                
                            /* convert data to binary string */
                            let data = new Uint8Array(arraybuffer);
                            let arr = new Array();
                            for (let i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
                            let bstr = arr.join("");
                            /* Call XLSX */
                            let workbook = XLSX.read(bstr, {
                                type: "binary"
                            });
                
                            let first_sheet_name = workbook.SheetNames[0];
                            let worksheet = workbook.Sheets[first_sheet_name];
                            resolve(XLSX.utils.sheet_to_json(worksheet, {raw: true}));
                        } else {
                            reject("Can not read file");
                        }
                    }
                }

                xmlhttp.open("GET", fetchURL, true);
                xmlhttp.send();
            }) 
            return promise;
        }

        let writeDataToDb = (data) => {
            let formData = new FormData();
            let type = document.querySelector("input[type=radio]:checked").value;
            formData.append("json", JSON.stringify(data));
            formData.append("type", type);
            
            let promise = new Promise( (resolve, reject) => {
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if(this.status === 200 && this.readyState === 4) {
                        console.log(this.response)
                        if(this.response) {
                            let res = JSON.parse(this.response);
                            resolve(res);
                        } else {
                            reject("Can not write file to DB");
                        }
                    }
                }
                xmlhttp.open("POST", "./write.php", true);
                xmlhttp.send(formData);
            })
            return promise;
        }
        

    </script>
</body>
</html>