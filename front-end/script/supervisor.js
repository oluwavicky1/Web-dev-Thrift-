//create schedule
function create_schedule() {
  const data = JSON.stringify({
    supervisorId: "",
    studentLimit: document.getElementById("num_of_students").value,
    day: document.getElementById("daySelector").value,
    timeStart: document.getElementById("input1").value,
    timeEnd: document.getElementById("input2").value,
    semesterId: document.getElementById("semesterSelector").value,
    message: document.getElementById("message").value,
    name: document.getElementById("meeting_name").value,
  });

  console.log(data);
}
