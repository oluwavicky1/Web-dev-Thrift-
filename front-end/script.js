let xhr = new XMLHttpRequest();
// xhr.setRequestHeader("Content-type", "application/json; charset=utf-8");
const baseUrl = "http://192.168.8.102/Web Project/api/";

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

  console.log(data);

  xhr.open("POST", `http://192.168.8.102/Web Project/api/user/register.php`);
  xhr.send(data);

  xhr.onload = function () {
    // if (xhr.status != 200) {
    // HTTP error?
    // handle error
    //   alert( 'Error: ' + xhr.status);
    console.log(xhr.response);
    return;
    // }

    // get the response from xhr.response
  };
}
