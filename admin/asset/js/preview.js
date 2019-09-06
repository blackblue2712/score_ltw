async function previewEx(url) {
    let wrapList = document.getElementById("wrap-list");
    try {
        let fileConent =  await readFile(url);
        console.log(fileConent)
        createTableFind(fileConent, wrapList);
    } catch(err) {
        console.log(err);
    }
}

function deleteEx(url, key) {
    let check = window.confirm("Are you suer to delete this file?");
    if(check) {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if(this.status === 200 && this.readyState === 4) {
                let element = document.getElementById(key);
                element.style.display = "none";
            }
        }
        xmlhttp.open("GET", "./preview.php?role=delete&des="+url, true);
        xmlhttp.send();
    }
}

let readFile = (url) => {
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
                    }, 50);
                } else {
                    reject("Can not read file");
                }
            }
        }
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }) 
    return promise;
}

let createTableFind = (res, wrapList) => {
    console.log(res)
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

        document.getElementById("preview-area").style.bottom = "-1069px";
        wrapList.innerHTML = xhtml;

    } else {
        wrapList.innerHTML = res.message;
    }
}