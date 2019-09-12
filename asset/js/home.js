let onOpenNewTab = uri => {
    let win = window.open(uri, "_blank")
    win.forcus();
}
window.onload = function() {

    // crawl content from ctu site
    getContentFromCtu();
    getContentFromElcit();

    // Scroll on top
    window.onscroll = () => {
        let gotop = document.getElementById("scrollTop");
        if(window.scrollY > 100) {
            gotop.classList.add("show");
            gotop.classList.remove("hide")
        } else {
            gotop.classList.add("hide");
            gotop.classList.remove("show")
        }
    }

    // show/hide message
    let boxShowMes = document.getElementById("show-message");
    if(boxShowMes) {
        if(boxShowMes.classList[0] === "show-mess") {
            setTimeout( () => {
                boxShowMes.classList.remove("show-mess");
                boxShowMes.classList.add("strict-hide");
            }, 4000)
        }
    }
    closeBox = () => {
        let boxShowMes = document.getElementById("show-message");
        boxShowMes.classList.add("strict-hide");
    }

}


let scrollToTop = () => {
    window.scrollTo(0, 0)
}

let changeUI = () => {
    let btnSt = document.getElementsByClassName("btn-st");
    let wSt = document.getElementById("setting");
    if(btnSt[0].classList[1] === 'close') {
        document.getElementById("setting-pic").src = "./icon/cogs-solid.svg";
        Array.from(btnSt).map( bt => {
            bt.classList.remove("close");
            bt.classList.add("open");
        })
        wSt.classList.add("setting-click");
        wSt.classList.remove("setting-click-again");
    } else {
        document.getElementById("setting-pic").src = "./icon/cog-solid.svg";
        Array.from(btnSt).map( bt => {
            bt.classList.remove("open");
            bt.classList.add("close");
        })
        wSt.classList.remove("setting-click");
        wSt.classList.add("setting-click-again");
    }
}

// let toggleModel = id => {
//     let listBox = document.getElementById('list');
//     let formBox = document.getElementById('form');
//     if(id === 'list') {
//         listBox.classList.add('show-model-box');
//         listBox.classList.remove('hide-model-box');
//         formBox.classList.add('hide-model-box');
//     } else {
//         formBox.classList.add('show-model-box');
//         formBox.classList.remove('hide-model-box');
//         listBox.classList.add('hide-model-box');
//     }
// }


// let popupOpen = (e, src) => {
//     setTimeout( () => {
//         let ele = document.getElementById('popup');
//         ele.classList.add("show");
//         ele.classList.remove("hide");
//         ele.style.top = e.clientY - 100 + "px";
//         ele.style.left = e.clientX + 60 + "px";
//         ele.innerHTML = `<img src=${src}  style="max-width: 300px"/>`;
//     }, 1)
// }

// let popupLeave = e => {
//     let ele = document.getElementById('popup');
//     ele.classList.add("hide");
//     ele.classList.remove("show");
// }

let initFind = async () => {
    let plainText = document.getElementById("idstudent").value;
    if(plainText.length !== 8) {
        document.getElementById("idstudent").style.borderBottom = "1px solid rgb(243, 99, 116)"
        return;
    }
    document.getElementById("idstudent").style.borderBottom = "1px solid rgb(62, 239, 107)"
    let captcha = document.getElementById("captcha").value;

    let wrapList = document.getElementById("wrap-table");

    try {
        let isVerify = await checkCaptcha(captcha);
        if(isVerify.message === "success") {
            data = await ajaxFind(plainText);
        } else {
            data = isVerify;
        }

        createTableFind(data, wrapList);
        // change captcha when fetch
        document.getElementById('imgCaptcha').src= './captcha/captcha.php';
    } catch(err) {
        console.log(err)
    }
}

let checkCaptcha = code => {
    let ipCaptcha = document.getElementById("captcha");

    let promise = new Promise( (resolve, reject) => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if(this.status === 200 && this.readyState === 4) {
                if(this.response) {
                    let res = JSON.parse(this.response);
                    if(res.message !== "success") {
                        ipCaptcha.style.borderBottom = "1px solid rgb(243, 99, 116)";
                        reject(res);
                    } else {
                        ipCaptcha.style.borderBottom = "1px solid rgb(62, 239, 107)";
                        resolve(res);
                    }
                }
            }
        }
        xmlhttp.open("GET", "./captcha/verify.php?code=" + code, true);
        xmlhttp.send();
    })
    return promise;
}

let ajaxFind = (plainText) => {
    let promise = new Promise( (resolve, reject) => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if(this.readyState === 4 && this.status === 200) {
                if(this.response) {
                    resolve(JSON.parse(this.response));
                } else {
                    reject("Empty record");
                }
            }
        }
        xmlhttp.open("GET", "./getScore.php?role=getQuery&q=" + plainText, true);
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

        setTimeout( () => {
            wrapList.innerHTML = xhtml;
        },500);
    } else {
        wrapList.innerHTML = res.message;
    }
}

// let onChangeConfig = (element, styleType, value) => {
//     let eNode = document.querySelector(element);
//     console.log(value)
//     if(eNode) {
//         if(styleType === "background") {
//             eNode.style.background = value;
//         } else if(styleType === "color") {
//             eNode.style.color = value;
//         } else if(styleType === "font-family") {
//             eNode.style.fontFamily = value;
//         } else if(styleType === "font-size") {
//             eNode.style.fontSize = value + "px";
//         }
//     }
// }

// let defaultConfig = () => {
//     document.querySelector("section.body").style = "";
//     document.getElementById("bg-color").value = "#151313"
//     document.getElementById("text-color").value = "#ffffff"
//     document.getElementById("text-size").value = "16px";

//     let xmlhttp = new XMLHttpRequest();
//     xmlhttp.onreadystatechange = function() {
//         if(this.status === 200 && this.readyState === 4) {
//             let res = JSON.parse(this.response);
//             let mess = `<div id=show-message class="show-mess">
//                                 <div class="wrap-mess">
//                                     <div class="mess">
//                                         <p class="success">${res.message}</p>
//                                     </div>
//                                     <div class="close-mess" onclick="closeBox()">X</div>
//                                 </div>
//                             </div>`;
//             document.getElementById("notifi").innerHTML = mess;
//         }
//     }

//     xmlhttp.open("GET", `./controllers/config.php?default=true`, true);
//     xmlhttp.send();
// }

let closeConfig = () => {
    let modelConfig = document.getElementsByClassName("modal-config-font")[0]
    setTimeout( () => {
        modelConfig.classList.add("hide");
        modelConfig.classList.remove("show");
    }, 300)
    modelConfig.classList.add("hide-config");
    modelConfig.classList.remove("show-config");
}
 
let showConfig = () => {
    let modelConfig = document.getElementsByClassName("modal-config-font")[0];
    modelConfig.classList.remove("hide");
    modelConfig.classList.remove("hide-config");
    modelConfig.classList.add("show");
    modelConfig.classList.add("show-config");
}

// let saveConfig = () => {
//     let confBg = document.getElementById("bg-color").value.replace("#", "");
//     let confCl = document.getElementById("text-color").value.replace("#", "");
//     let confSz = document.getElementById("text-size").value;

//     let xmlhttp = new XMLHttpRequest();
//     xmlhttp.onreadystatechange = function() {
//         if(this.status === 200 && this.readyState === 4) {
//             let res = JSON.parse(this.response);
//             let mess = `<div id=show-message class="show-mess">
//                                 <div class="wrap-mess">
//                                     <div class="mess">
//                                         <p class="success">${res.message}</p>
//                                     </div>
//                                     <div class="close-mess" onclick="closeBox()">X</div>
//                                 </div>
//                             </div>`;
//             document.getElementById("notifi").innerHTML = mess;
//         }
//     }

//     xmlhttp.open("GET", `./controllers/config.php?confBg=${confBg}&confCl=${confCl}&confSz=${confSz}`, true);
//     xmlhttp.send();
// }

let changeCaptcha = () => {
    document.getElementById('imgCaptcha').src= './captcha/captcha.php';
}

let getContentFromCtu = () => {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if(this.status === 200 && this.readyState === 4 ) {
            if(this.response) {
                let res = JSON.parse(this.response);
                let xhtml = `<p><span style="font-size: medium;"><strong><span style="font-family: verdana, arial, helvetica, sans-serif; color: #ff0000;">THÔNG BÁO TỪ HTQL</span></strong></span></p><hr><ul>`;
                res.map( el => {
                    xhtml += `<li><a href='https://htql.ctu.edu.vn/htql/${el.links}'>${el.contents}</a>`;
                })
                xhtml += "</ul>";
                document.getElementById("notify").innerHTML = xhtml;
            }
        }
    }
    xmlhttp.open("GET", "./utils/getContentFromCtu.php", true);
    xmlhttp.send();
}

let getContentFromElcit = () => {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if(this.status === 200 && this.readyState === 4 ) {
            if(this.response != null) {
                let res = JSON.parse(this.response);
                document.getElementById("announcement").innerHTML = res;
            }
        }
    }
    xmlhttp.open("GET", "./utils/getContentElcit.php", true);
    xmlhttp.send();
}

