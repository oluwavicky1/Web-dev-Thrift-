function Register(e) {
  e.preventDefault();
  const data = JSON.stringify({
    firstname: document.getElementById("Firstname").innerHTML,
    surname: document.getElementById("Lastname").innerHTML,
    type: document.getElementById("Type").innerHTML,
    email: document.getElementById("Email").innerHTML,
    password: document.getElementById("Password").innerHTML,
  });

  console.log(data);
}
