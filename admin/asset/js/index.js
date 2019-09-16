window.onload = async () => {
    let form = document.getElementById("main-form");

    let signoutElement = document.getElementById("signmeout");
    signoutElement.addEventListener("click", signoutAjax);
    // let wrapList = document.getElementById("wrap-list");

    // try {
    //     let data = await ajaxShowInDB();
    //     createTableReview(data, wrapList);
    // } catch(err) {  
    //     console.log(err);
    // }
}
let onSubmitForm = async () => {
    window.event.preventDefault();
    let bar = document.getElementById("process-bar");
    try {
        let currentWidth = parseInt(bar.style.width) || 0;
        t = setInterval( () => {
            let increaseWidth = 1;
            if(currentWidth < 100) {
                currentWidth += increaseWidth;
                bar.style.width = currentWidth + "%";
                // bar.innerHTML = currentWidth + "%";
            } else {
                clearInterval(t);
            }
        },10)


        let fileURL = await asyncSubmitFile();
        let fileData = await readFileAfterSubmit(fileURL);
        let finalRes = await writeDataToDb(fileData);
        
        console.log(fileURL, fileData, finalRes)
        // bar.innerHTML = `Done: ${finalRes.done} - Fail: ${finalRes.fail}`;
        alert("Done, check the console");
    } catch( err ) {
        alert(err);
        clearInterval(t);
        bar.style.width = "auto";
        bar.style.background = "transparent";
        bar.style.borderTop = "3px solid red";
        // bar.innerHTML = err;
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
                    console.log(this.response);
                    let res = JSON.parse(this.response);
                    increaseProcess(33, true);
                    let rand = Date.now();
                    let fileName = res.des_file.split("/")[res.des_file.split("/").length -1];
                    let newEx = `<div id="${rand}"><a href="${res.des_file}">${fileName}</a>&nbsp;|&nbsp;<a href="javascript:previewEx('${res.des_file}')">view</a></div>`
                    document.getElementById("preview-area").innerHTML = newEx + document.getElementById("preview-area").innerHTML;
                    setTimeout( () => {
                        resolve(res);
                    }, 500);
                } else {
                    reject("can not upload file");
                }
            }
        }

    });
    return promise;
}

let readFileAfterSubmit = (url) => {
    console.log(url)
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
                    setTimeout( () => {
                        resolve(XLSX.utils.sheet_to_json(worksheet, {raw: true}));
                    }, 500);
                    
                    increaseProcess(66, true);
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
                    increaseProcess(100, true);
                    setTimeout( () => {
                        resolve(res);
                    }, 500);
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

let signoutAjax = () => {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if(this.status === 200 && this.readyState === 4) {
            window.location = "../index.php";
        }
    }
    xmlhttp.open("GET", "./controllers/user/signout.php", true);
    xmlhttp.send();
}

let increaseProcess = (num, flag) => {
    let t = null;
    let bar = document.getElementById("process-bar");
    if(!flag) {
        let currentWidth = parseInt(bar.style.width) || 0;
        t = setInterval( () => {
            let increaseWidth = 1;
            if(currentWidth < num) {
                currentWidth += increaseWidth;
                bar.style.width = currentWidth + "%";
                // bar.innerHTML = currentWidth + "%";
            } else {
                clearInterval(t);
            }
        },10)
    } else if(flag === true) {
        clearInterval(t);
        bar.style.width = num + "%";
        // bar.innerHTML = num + "%";
    }
}

let ajaxShowInDB = () => {
    let promise = new Promise( (resolve, reject) => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if(this.readyState === 4 && this.status === 200) {
                if(this.response) {
                    let res = JSON.parse(this.response);
                    createTableReview(res, document.getElementById("wrap-list"));
                    resolve(res);
                } else {
                    reject("Empty record");
                }
            }
        }
        xmlhttp.open("GET", "../getScore.php?role=getall", true);
        xmlhttp.send();
    })
    return promise;
}

let createTableReview = (res, wrapList) => {
    let xpr = "";
    if(res.length > 0) {
        res.map( (pr, index) => {
            xpr += `<tr class="odd">
                        <td>${pr.id}</td>
                        <td>${pr.name}</td>
                        <td>${pr.gender}</td>
                        <td>${pr.score}</td>
                    </tr>`;
        })
        let xhtml = `<table class="table-list"  style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: 38%;">Name</th>
                                <th style="width: 27%;">Gender</th>
                                <th style="width: 15%;">Score</th>
                                
                                </tr>
                        </thead>
                        <tbody>
                            ${xpr}
                        </tbody>
                    </table>`;

        document.getElementById("preview-area").style.top = "689px";
        wrapList.innerHTML = xhtml;

    } else {
        wrapList.innerHTML = res.message;
    }
}
