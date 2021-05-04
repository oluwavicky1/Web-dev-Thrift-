let xhr = new XMLHttpRequest();
// xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");
const baseUrl = "http://192.168.8.102/Web Project/api/";

//Function to register a user
async function Register() {
  let type;
  var ele = document.getElementsByName("type");

  for (i = 0; i < ele.length; i++) {
    if (ele[i].checked) {
      type = ele[i].value;
    }
  }
  const data = JSON.stringify({
    firstName: document.getElementById("Firstname").value,
    surname: document.getElementById("Lastname").value,
    type: type,
    email: document.getElementById("Email").value,
    password: document.getElementById("Password").value,
  });

  xhr.open("POST", `http://192.168.8.102/Web Project/api/user/register.php`);
  xhr.send(data);

  xhr.onload = function () {
    let resp = JSON.parse(xhr.response);
    if (xhr.status == 200) {
      alert(resp.message);
      window.location.replace("http://127.0.0.1:5500/front-end/signin.html");
    } else {
      // handle error
      // get the response from xhr.response

      alert("Error: " + resp.message);
    }
  };
}

//sign in
async function SignIn() {
  const data = JSON.stringify({
    email: document.getElementById("Email").value,
    password: document.getElementById("Password").value,
  });

  xhr.open("POST", `http://192.168.8.102/Web Project/api/user/login.php`);
  xhr.send(data);

  xhr.onload = function () {
    let resp = JSON.parse(xhr.response);
    if (xhr.status == 200) {
      alert(resp.message);
      //   window.location.replace("http://127.0.0.1:5500/front-end/meetings.html");
      //   save user's details in a session
      sessionStorage.setItem("user", resp.data);
    } else {
      // handle error
      // get the response from xhr.response

      alert("Error: " + resp.message);
    }
  };
}
