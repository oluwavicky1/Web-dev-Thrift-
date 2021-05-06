//for all user tables to get the schedules
function get_schedules(data = null) {
  if (data == 1) {
    xhr.open(
      "GET",
      ` http://localhost:80/Web Project/api/meeting/schedule.php?semesterId=${
        document.getElementById("semesterSelector").value
      }`
    );
    xhr.send();

    xhr.onload = function () {
      let resp = JSON.parse(xhr.response);
      console.log(resp);

      let table = document.getElementById("student_new_meetings");

      resp.data.forEach((data) => {
        let tr = document.createElement("tr");

        tr.innerHTML =
          "<td>" +
          data.scheduleName +
          "</td>" +
          "<td>" +
          data.owner +
          "</td>" +
          "<td>" +
          data.timeSpan +
          "</td>" +
          "<td>" +
          data.day +
          "</td>" +
          "<td>" +
          "<button " +
          "class = 'btn btn-black'  " +
          "type = submit " +
          "name = button " +
          "onclick = " +
          `join_meeting(${data.id})` + // put data.id here when bolu has added id
          ">" +
          "Join meeting" +
          "</button>" +
          "</td>";

        table.appendChild(tr);
      });
    };
  } else if (data == 2) {
    xhr.open(
      "GET",
      `http://localhost:80/Web Project/api/meeting/appointment_history.php?userId=${sessionStorage.getItem(
        "id"
      )}&semesterId=${document.getElementById("semesterSelector").value}`
    );
    xhr.send();

    xhr.onload = function () {
      let resp = JSON.parse(xhr.response);
      console.log(resp);

      let table = document.getElementById("student_history");

      resp.data.forEach((data) => {
        let tr = document.createElement("tr");
        let p = document.createElement("p");
        p.innerText = data.status;
        let td = document.createElement("td");
        td.appendChild(p);

        tr.innerHTML =
            "<td>" +
            data.scheduleName +
            "</td>" +
            "<td>" +
            data.name +
            "</td>" +
            "<td>" +
            data.timeSpan +
            "</td>" +
            "<td>" +
            data.day +
            "</td>";
          tr.appendChild(td);
          table.appendChild(tr);
      });
    };
  } else {
    xhr.open(
      "GET",
      `http://localhost:80/Web Project/api/meeting/appointment.php?userId=${sessionStorage.getItem(
        "id"
      )}&semesterId=${document.getElementById("semesterSelector").value}`
    );
    xhr.send();

    xhr.onload = function () {
      let resp = JSON.parse(xhr.response);
      console.log(resp);

      if (!resp) {
        resp = [];
      }

      let table = document.getElementById("student_meetings");

      resp.data.forEach((data) => {
        let tr = document.createElement("tr");
        let p = document.createElement("p");
        p.innerText = data.status;
        let tdParagraph = document.createElement("td");
        tdParagraph.appendChild(p);

        tr.innerHTML =
            "<td>" +
            data.scheduleName +
            "</td>" +
            "<td>" +
            data.supervisorName +
            "</td>" +
            "<td>" +
            data.timeSpan +
            "</td>" +
            "<td>" +
            data.day +
            "</td>";
        tr.appendChild(tdParagraph);
        let button = document.createElement('button');
        button.setAttribute('id', data.id);
        button.classList.add("btn");
        button.classList.add("btn-black");
        button.addEventListener('click', function() {cancel_meeting(data.id)});
        button.innerText = 'Cancel Meeting';
        let td = document.createElement("td");
        td.appendChild(button);
        tr.appendChild(td);
        table.appendChild(tr);
      });
    };
  }
}

//user cancel a meeting
function cancel_meeting(id) {
  const data = JSON.stringify({
    id: id,
    supervisorId: sessionStorage.getItem("id"),
    status: false,
    message: "test",
  });

  xhr.open("POST", `http://localhost:80/Web Project/api/meeting/cancel.php`);
  xhr.send(data);
  xhr.onload = function () {
    let resp = JSON.parse(xhr.response);

    console.log(resp);

    alert(resp.message);
    location.reload();
  };
}

//user join a meeting
function join_meeting(id) {
  const data = JSON.stringify({
    scheduleId: id,
    userId: sessionStorage.getItem("id"),
  });

  xhr.open(
    "POST",
    `http://localhost:80/Web Project/api/meeting/appointment.php`
  );
  xhr.send(data);
  xhr.onload = function () {
    let resp = JSON.parse(xhr.response);

    console.log(resp);

    alert(resp.message);
  };
}
