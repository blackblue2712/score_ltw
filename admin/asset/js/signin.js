window.onload = function () {
    // validate
    let btnSubmit = document.getElementById("submit-form");
    btnSubmit.addEventListener("click", event => {
        event.preventDefault();
        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        if(password !== "" && username !== "") {
            // document.getElementById("login-form").submit();
            let formData = new FormData();
            formData.append("username", username);
            formData.append("password", password);
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if(this.status === 200 && this.readyState === 4) {
                    console.log(this.response)
                    if(this.response) {
                        let res = JSON.parse(this.response);
                        if(res.message !== "success") {
                            alert(res.message);
                        } else {
                            window.location = "./index.php";
                        }
                    }
                }
            }

            xmlhttp.open("POST", "./controllers/user/signin.php");
            xmlhttp.send(formData);
        } else {
            alert("You must enter username and password");
        }
    })

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
        boxShowMes.classList.add("strict-hide");
    }
}