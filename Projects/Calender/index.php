<?php
session_start();
$isloggedin = false;
$user = 'GUEST';
if(isset($_SESSION['user'])) {
  $isloggedin = true;
  $user = $_SESSION['user'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Calender</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./style.css" />
</head>

<body>
  <div class="container mt-2">
    <div id="topnav" class="row bg-light">
      <h2 class="mt-2">
        Welcome <span><?= $user ?></span>!
        <?php if($isloggedin): ?>
        <a class="float-end btn btn-outline-warning btn-sm" href="./logout.php">
          Log out
        </a>
        <?php else: ?>
        <a class="float-end btn btn-outline-warning btn-sm" href="./login.php">
          Log in
        </a>
        <?php endif; ?>
      </h2>
    </div>
    <hr />
    <h4 id="clock"></h4>
    <hr />
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-Calender-tab" data-bs-toggle="tab" data-bs-target="#nav-Calender"
          type="button" role="tab" aria-controls="nav-Calender" aria-selected="true">
          Calender
        </button>
        <button class="nav-link" id="nav-Events-tab" data-bs-toggle="tab" data-bs-target="#nav-Events" type="button"
          role="tab" aria-controls="nav-Events" aria-selected="false">
          Events
        </button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-Calender" role="tabpanel" aria-labelledby="nav-Calender-tab">
        <!-- #################################### Calender #################################### -->
        <div class="row mt-3" id="controlpanel">
          <div class="col-4 pe-1 col-md-3">
            <select class="form-select" id="monthselect"></select>
          </div>
          <div class="col-4 px-1 col-md-3">
            <select class="form-select" id="yearselect"></select>
          </div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th class="daytext">Sun</th>
              <th class="daytext">Mon</th>
              <th class="daytext">Tue</th>
              <th class="daytext">Wed</th>
              <th class="daytext">Thu</th>
              <th class="daytext">Fri</th>
              <th class="daytext">Sat</th>
            </tr>
          </thead>
          <tbody id="calenderbody"></tbody>
        </table>
        <!-- #################################### Calender #################################### -->
      </div>
      <div class="tab-pane fade" id="nav-Events" role="tabpanel" aria-labelledby="nav-Events-tab">
        <!-- #################################### Events #################################### -->
        <p class="text-center mt-2">
          <button class="btn w-100 btn-outline-info" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Add event
          </button>
        </p>
        <div class="collapse" id="collapseExample">
          <div class="card card-body">
            <form id="tabeventform" method="POST" action="">
              <div class="mb-3">
                <label for="eventtitle" class="form-label">Event title</label>
                <input type="text" name="title" class="form-control" id="eventtitle" />
              </div>
              <div class="mb-3">
                <label for="eventdesc" class="form-label">Event description (Optional)</label>
                <textarea class="form-control" name="e_desc" id="eventdesc" rows="3"></textarea>
              </div>
              <div class="mb-3">
                <label for="eventstartdate" class="form-label">Event start date & time</label>
                <input type="datetime-local" name="e_s_dt" class="form-control" id="eventstartdate" />
              </div>
              <div class="mb-3">
                <label for="eventenddate" class="form-label">Event end date & time</label>
                <input type="datetime-local" name="e_e_dt" class="form-control" id="eventenddate" />
              </div>
              <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-outline-success" type="button" onclick="addEvent('tabeventform')">
                  Add Event
                </button>
              </div>
            </form>
          </div>
        </div> <!-- collapse end -->
        <hr>
        <div class="">
          <h3 class="mb-0">Today's schedule</h3>
          <hr class="mt-1">
          <div class="" id="todayeventlist">
            Nothing to do today..<i class="far fa-laugh-wink"></i>
          </div>
          <hr>
          <h3 class="mb-0">Up coming events</h3>
          <hr class="mt-1">
          <div class="" id="upcomingeventlist">
            Nothing to show.. <i class="far fa-laugh"></i></i>
          </div>
        </div>
        <!-- #################################### Events #################################### -->
      </div>
    </div>
    <hr>
    <div class="">
      <h2 class="ms-2">Instructions</h2>
      <ul>
        <li>Login to add events</li>
        <li>Click on a date to add an event or go to the event tab</li>
        <li>You can add or remove an event</li>
      </ul>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="
          modal-dialog
          modal-dialog-scrollable
          modal-dialog-centered
          modal-fullscreen-sm-down
        ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addEventModalLabel">Add Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="modalform" method="POST">
            <div class="mb-3">
              <label for="modaletitle" class="form-label">Event title</label>
              <input type="text" name="title" class="form-control" id="modaletitle" />
            </div>
            <div class="mb-3">
              <label for="modaledesc" class="form-label">Event description (Optional)</label>
              <textarea class="form-control" name="e_desc" id="modaledesc" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label for="modalesdt" class="form-label">Event start date & time</label>
              <input type="datetime-local" name="e_s_dt" class="form-control" id="modalesdt" />
            </div>
            <div class="mb-3">
              <label for="modaleedt" class="form-label">Event end date & time</label>
              <input type="datetime-local" name="e_e_dt" class="form-control" id="modaleedt" />
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
              <button class="btn btn-outline-success" onclick="addEvent('modalform')" type="button">
                Add Event
              </button>
            </div>
          </form>
        </div>
        <!-- <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary">Save</button>
          </div> -->
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
  <script src="./main.js"></script>
</body>

</html>