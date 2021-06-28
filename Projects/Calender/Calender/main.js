var SELECTED_YEAR = 2021;
var SELECTED_MONTH = "May";
var LOGGED_IN = false;

var week = {
  0: "Sun",
  1: "Mon",
  2: "Tue",
  3: "Wed",
  4: "Thu",
  5: "Fri",
  6: "Sat",
};

var months = {
  jan: "Jan",
  feb: "Feb",
  mar: "Mar",
  apr: "Apr",
  may: "May",
  jun: "Jun",
  jul: "Jul",
  aug: "Aug",
  sep: "Sep",
  oct: "Oct",
  nov: "Nov",
  dec: "Dec",
};

var monthsNum = {
  jan: "01",
  feb: "02",
  mar: "03",
  apr: "04",
  may: "05",
  jun: "06",
  jul: "07",
  aug: "08",
  sep: "09",
  oct: "10",
  nov: "11",
  dec: "12",
};

function loginCheck() {
  $.ajax({
    type: "GET",
    url: "/logincheck.php",
  }).done(function (resp) {
    if (resp == "loggedin") {
      LOGGED_IN = true;
      loadEvents();
    } else {
      LOGGED_IN = false;
    }
  });
}

$(document).ready(function () {
  startTime();
  loginCheck();
  loadMonth(months);
  loadYear();
  loadCalender(SELECTED_YEAR, SELECTED_MONTH);
  $("td").click(function () {
    if (LOGGED_IN) {
      var eventModal = new bootstrap.Modal(
        document.getElementById("addEventModal"),
        {}
      );
      eventModal.show();
      let dt = new Date();
      let hr = checkTime(dt.getHours());
      let min = checkTime(dt.getMinutes());
      let date = checkTime($(this).find("p").html());
      let mnt = monthsNum[SELECTED_MONTH.toLowerCase()];
      let dtstring = `${SELECTED_YEAR}-${mnt}-${date}T${hr}:${min}`;
      document.getElementById("modalesdt").value = dtstring;
    }
  });
});

$("#monthselect").change(function () {
  SELECTED_MONTH = this.value;
  loadCalender(SELECTED_YEAR, months[SELECTED_MONTH]);
});

$("#yearselect").change(function () {
  SELECTED_YEAR = this.value;
  loadCalender(SELECTED_YEAR, months[SELECTED_MONTH]);
});

function loadMonth(months) {
  for (month in months) {
    $("#monthselect").append($("<option>").val(month).text(months[month]));
  }
  $("#monthselect").val('may');
}

function loadYear() {
  let startyear = 1980;
  let endyear = 2030;
  let selectedyear = 2021;
  for (let i = startyear; i <= endyear; i++) {
    $("#yearselect").append($("<option>").val(i).text(i));
  }
  $("#yearselect").val(`${selectedyear}`);
}

function loadCalender(year, month) {
  $("#calenderbody").html("");
  let firstDay = new Date(`${month} 01, ${year}`);
  var lastDay = new Date(year, firstDay.getMonth() + 1, 0);
  var monthEnd = lastDay.getDate();
  let [day, weekrow] = generateWeek(firstDay.getDay(), monthEnd, 1);
  $("#calenderbody").append(weekrow);
  for (let w = 1; w < 6; w++) {
    [day, weekrow] = generateWeek(0, monthEnd, day);
    $("#calenderbody").append(weekrow);
  }
}

function generateWeek(startday, monthend, day) {
  var row = document.createElement("tr");
  for (let d = 0; d < 7; d++) {
    let dayofweek = document.createElement("td");
    let mth = monthsNum[SELECTED_MONTH.toLowerCase()];
    dayofweek.id = `cal-${SELECTED_YEAR}-${mth}-${day}`;
    if (d >= startday && day <= monthend) {
      dayofweek.className = "position-relative";
      dayofweek.innerHTML = '<p class="daytext">' + day + "</p>";
      day++;
    }
    row.appendChild(dayofweek);
  }
  return [day, row];
}

function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById("clock").innerHTML =
    week[today.getDay()] +
    " " +
    today.getDate() +
    "/" +
    (today.getMonth() + 1) +
    "/" +
    today.getFullYear() +
    " - " +
    h +
    ":" +
    m +
    ":" +
    s;
  var t = setTimeout(startTime, 1000);
}

function checkTime(i) {
  if (i < 10) {
    i = "0" + i;
  } // add zero in front of numbers < 10
  return i;
}

function addEvent(formid) {
  var formdata = $(`#${formid}`).serialize();
  let err = false;
  $(`#${formid}`)
    .find("input")
    .each(function () {
      if ($(this).val() == "" && $(this).attr("name") != "e_desc") {
        $(this).removeClass("is-valid").addClass("is-invalid");
        err = true;
      } else {
        $(this).removeClass("is-invalid").addClass("is-valid");
      }
    });
  if (err) {
    return;
  }
  $.ajax({
    type: "POST",
    url: "/addevent.php",
    data: formdata,
  }).done(function (resp) {
    $(`#${formid}`)
      .find("input")
      .each(function () {
        $(this).removeClass("is-valid is-invalid");
      });
    if (resp == "loginfirst") {
      $(`#${formid}`).each(function () {
        this.reset();
      });
      alert("Login first!");
    } else if (resp == "error") {
      alert("Some error occured, try later");
    } else if (resp == "inputerror") {
      alert("Input error, fill details carefully!");
    } else if (resp == "eventadded") {
      $(`#${formid}`).each(function () {
        this.reset();
      });
      alert("Event added successfully!");

      loadEvents();
      return true;
    }
    return false;
  });
}

function getFormattedDate(date) {
    let dt = date.getDate();
    let month = date.getMonth();
    let year = date.getFullYear();
    let hrs = date.getHours();
    let mm = date.getMinutes();
    let day = week[date.getDay()];
    return `${day} ${dt}/${month}/${year} - ${hrs}:${mm}`;
}

function removeEvent(id) {
    if(!confirm("Are you sure you want to remove this event?")) {
        return;
    }
    $.ajax({
        type: "GET",
        url: "/delevent.php?id="+id,
      }).done(function (resp) {
        if (resp == "notloggedin") {
          alert("Login first!");
        } else if (resp == "error") {
          alert("Some error occured, try later");
        } else if (resp == "deleted"){
            $(`#eventrow-${id}`).remove();
            alert("Event removed!");
        }
    });
}

function loadEvents() {
  let eventlist = [];
  $.ajax({
    type: "GET",
    url: "/getevents.php",
  }).done(function (resp) {
    if (resp == "notloggedin") {
      alert("Login first!");
    } else if (resp == "error") {
      alert("Some error occured, try later");
    } else {
      eventlist = JSON.parse(resp);
      eventlist.sort(function (a, b) {
        return new Date(a.startdt) - new Date(b.startdt);
      });
      let curr_month = parseInt(monthsNum[SELECTED_MONTH.toLowerCase()]);
      curr_month -= 1;
      const today = new Date();
      let tomorrow = new Date();
      tomorrow.setDate(today.getDate() + 1);
      tomorrow.setHours(0);
      tomorrow.setMinutes(0);
      tomorrow.setSeconds(0);
      let monthstart = new Date();
      monthstart.setDate(1);
      monthstart.setHours(0);
      monthstart.setMinutes(0);
      monthstart.setSeconds(0);
      monthstart.setMonth(curr_month);
      let monthend = new Date(SELECTED_YEAR, curr_month + 1, 0);
      monthend.setHours(23);
      monthend.setMinutes(59);
      monthend.setSeconds(59);
      $("#todayeventlist").html("");
      var event_track = {};
      for (let i = 0; i < eventlist.length; i++) {
        console.log(eventlist[i]);
        var row = document.createElement("div");
        row.id = "eventrow-"+eventlist[i].id;
        row.className = "row mt-1 mb-3 border-bottom";
        let eventsdt = new Date(eventlist[i].startdt);
        let eventedt = new Date(eventlist[i].enddt);
        row.innerHTML = `
            <div class="col-12 bg-dark text-center text-white position-relative">
                <button class="removeEventbtn" onclick="removeEvent(${eventlist[i].id})">
                    <h4><i class="far fa-times-circle"></i><h4>
                </button>
                <h4>${eventlist[i].title}</h4>
            </div>
            <div class="col-6 bg-light">
                ${getFormattedDate(eventsdt)}
            </div>
            <div class="col-6 bg-light">
                ${getFormattedDate(eventedt)}
            </div>
            <div class="col-12 bg-light">
                ${eventlist[i].detail}
            </div>
        `;
        if (eventsdt < tomorrow) {
            $("#todayeventlist").append(row);
        } else {
            $("#upcomingeventlist").append(row);
        }
        if(eventsdt > monthstart && eventsdt < monthend) {
          while(eventsdt < eventedt && eventsdt < monthend ) {
            console.log("marked");
            let eventtag = document.createElement('p');
            eventtag.className = 'eventtag';
            let id = `cal-${SELECTED_YEAR}-${checkTime(curr_month+1)}-${checkTime(eventsdt.getDate())}`;
            console.log(event_track);
            if(id in event_track) {
              event_track[id] += 1;
            } else {
              event_track[id] = 1;
            }
            eventtag.innerText = event_track[id] + ' event(s)';
            $(`#${id}`).find('.eventtag').remove();
            $(`#${id}`).append(eventtag);
            eventsdt.setDate(eventsdt.getDate() + 1);
          }
        }
      }
    }
  });
}
