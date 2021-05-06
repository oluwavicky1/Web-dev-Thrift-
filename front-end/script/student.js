function get_schedules() {
  xhr.open(
    "GET",
    `http://localhost:80/Web Project/api/meeting/schedule.php?supervisorId=${sessionStorage.getItem(
      "id"
    )}&semesterId=${document.getElementById("semesterSelector").value}`
  );
  xhr.send();

  xhr.onload = function () {
    let resp = JSON.parse(xhr.response);
    console.log(resp);

    let table = document.getElementById("student_meetings");

    resp.data.forEach((data) => {
      let tr = document.createElement("tr");

      tr.innerHTML =
        "<td>" +
        data.name +
        "</td>" +
        "<td>" +
        data.timeStart +
        " - " +
        data.timeEnd +
        "</td>" +
        "<td>" +
        data.day +
        "</td>" +
        "<td>" +
        data.studentLimit +
        "</td>" +
        "<td>" +
        data.studentCount +
        // {

        //     "</td>" +
        //     "<td>" +
        //     "<button " +
        //     "class = btn-btn-black  " +
        //     "type = submit " +
        //     "name = button " +
        //     "onclick = " +
        //     `cancel_meeting(${data.id})` +
        //     ">" +
        //     "Join meeting" +
        //     "</button>" +
        //     "</td>"
        // }

        table.appendChild(tr);
    });
  };
}
