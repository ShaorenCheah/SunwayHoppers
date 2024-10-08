<?php
session_start();
if (!isset($_SESSION['user'])) {
?>
  <script>
    alert("Please login first before finding carpool!");
    window.location.href = "./index.php";
  </script>
<?php
  session_destroy();
} else if (($_SESSION['user']['type']) == "Admin") {
?>
  <script>
    alert("You are not allowed to access this page!");
    window.location.href = "./dashboard.php?navPage=dashboard";
  </script>
<?php }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="./styles/findCarpool.css">
  <!-- Include icon link here -->
  <title>SunwayHoppers</title>
  <link rel="icon" type="image/x-icon" href="images/logo/tab.ico">

  <script src="scripts/findCarpool.js"></script>
</head>


<body>
  <?php
  if (isset($_SESSION['user'])) {
    include './includes/sessionTimeOut.inc.php';
    include './includes/notification.inc.php';
    include './includes/rating.inc.php';
  }
  include './includes/header.inc.php';
  require_once './backend/connection.php';

  include './includes/modals/newCarpoolModal.inc.php';
  ?>
  <div class="m-5 mb-4">


    <div class="d-flex position-relative justify-content-center">
      <h2 class="text-center pt-5 pb-3 w-100 z-0"><b>List of Available <span style="color:var(--secondary)">Carpool</span> Requests</b></h2>
      <?php
      if ($_SESSION['user']['type'] == 'Driver') {
        echo '<button type="button" class="btn btn-primary shadow px-3 mt-2 new-carpool z-1" style="padding-top: 0.1rem;padding-bottom: 0.1rem; " data-bs-toggle="modal" data-bs-target="#newCarpoolModal" ><span class="d-flex align-items-center">New Carpool <i class="ms-2 mt-1 bi bi-plus create-carpool" style="font-size: 1.5em;"></i></span></button>';
      }
      ?>

    </div>

    <div class="row gx-5 m-0">
      <!-- Filter Section -->
      <form id="filterCarpool" class="col-3 h-auto d-flex flex-column ps-0">
        <div class="card shadow text-center p-2 py-3">
          <h4 class="m-0"><b>Filter Carpool</b><i class="bi bi-search ms-3"></i></h3>
        </div>
        <!-- First Section -->
        <p class="text-center my-3  fw-semibold" style="font-size:1rem;">Step <span style="color:var(--secondary)">1</span> : Select Travel Direction</p>
        <div class="card shadow p-3">
          <h5 style="color:var(--primary)"><b>Direction</b> <i class="bi bi-arrow-left-right ms-1"></i></h5>
          <div class="card bg-body-tertiary d-flex p-2 py-3">
            <div class="d-flex justify-content-center align-items-center">
              <p class="m-0">Going</p>
              <select id="filterDirection" class="form-select mx-2" style="width:40%" aria-label="Default select example">
                <option selected value="" disabled>to / from</option>
                <option value="to">to</option>
                <option value="from">from</option>
              </select>
              <p class="m-0"> Bandar Sunway</p>
            </div>
            <div class="d-flex justify-content-center mt-3">
              <i class="d-flex align-items-center bi bi-house-fill" style="font-size: 1.5rem; color:var(--primary);"></i>
              <i id="direction1" class="d-flex align-items-center bi bi-dot mx-3" style="font-size: 1.5rem;"></i>
              <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="var(--primary)" class="bi bi-car-front-fill" style="font-size: 2rem;" viewBox="0 0 16 16">
                <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679c.033.161.049.325.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.807.807 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2H6ZM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17 1.247 0 3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z" />
              </svg>
              <i id="direction2" class="d-flex align-items-center bi bi-dot mx-3" style="font-size: 1.5rem;"></i>
              <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="var(--primary)" class="bi bi-buildings-fill" style="font-size: 2rem;" viewBox="0 0 16 16">
                <path d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V.5ZM2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-1 2v1H2v-1h1Zm1 0h1v1H4v-1Zm9-10v1h-1V3h1ZM8 5h1v1H8V5Zm1 2v1H8V7h1ZM8 9h1v1H8V9Zm2 0h1v1h-1V9Zm-1 2v1H8v-1h1Zm1 0h1v1h-1v-1Zm3-2v1h-1V9h1Zm-1 2h1v1h-1v-1Zm-2-4h1v1h-1V7Zm3 0v1h-1V7h1Zm-2-2v1h-1V5h1Zm1 0h1v1h-1V5Z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Second Section -->
        <p class="text-center my-3 fw-semibold" style="font-size:1rem;">Step <span style="color:var(--secondary)">2</span> : Enter Carpool Details</p>
        <div class="card shadow p-3">
          <!-- Driver Section -->
          <div class="d-flex justify-content-between">
            <h5 style="color:var(--primary)"><b>Driver</b> <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="currentColor" class="bi bi-car-front-fill ms-1" style="font-size: 2rem;" viewBox="0 0 16 16">
                <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679c.033.161.049.325.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.807.807 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2H6ZM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17 1.247 0 3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z" />
              </svg></h5>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="filterWomenOnly">
              <label class="form-check-label p-0 fw-semibold" for="filterWomenOnly">Women-Only</label>
            </div>
          </div>
          <div class="card bg-body-tertiary d-flex p-3">
            <div>
              <label for="filterName" class="form-label fw-semibold">Name</label>
              <input type="text" class="form-control" id="filterName" placeholder="Search by driver name">
            </div>
          </div>

          <!-- Schedule Section -->
          <h5 class="mt-3" style="color:var(--primary)"><b>Schedule</b> <i class="bi bi-calendar-week-fill ms-1"></i></h5>
          <div class="card bg-body-tertiary d-flex p-3">
            <div>
              <label for="filterDate" class="form-label fw-semibold">Date</label>
              <input type="date" class="form-control" id="filterDate">
            </div>
            <div class="mt-3">
              <label for="filterStartTime" class="form-label fw-semibold">Time</label>
              <div class="d-flex">
                <input type="time" class="form-control" id="filterStartTime">
                <p class="m-0 mx-2 d-flex align-items-center" style="font-size:1rem"> to </p>
                <input type="time" class="form-control" id="filterEndTime">
              </div>
            </div>
          </div>

          <!-- Location Section -->
          <h5 class="mt-3" style="color:var(--primary)"><b>Location</b> <i class="bi bi-geo-alt-fill ms-1"></i></h5>
          <div class="card bg-body-tertiary d-flex p-3 mb-4">
            <div>
              <label for="pickupAreas" class="form-label fw-semibold">Pickup Area</label>
              <div class="d-flex flex-column" id="filterPickup">
                <select id='filterDistrict' name='district' class='form-select' placeholder='Select District'>
                  <!-- Fetch from findCarpool.js -->
                </select>

                <select id="filterNeighborhood" name="neighborhood" class="form-select mt-3" disabled>
                  <option value='' disabled selected>Select Neighborhood</option>
                  <!-- Fetch from findCarpool.js -->
                </select>
              </div>
            </div>
            <div class="mt-3">
              <label for="filterLocation" class="form-label fw-semibold">Destination</label>
              <div class="d-flex flex-column" id="filterDestination">
                <select id="filterLocation" name="filterLocation" class="form-select">
                  <option value='' disabled selected>Select Location</option>
                  <!-- Fetch from findCarpool.js -->
                </select>
              </div>
            </div>
          </div>
          <button type="button" id="resetFilterBtn" class="btn btn-primary mt-3 px-4">Reset Filter</button>
        </div>
      </form>

      <!-- Carpool Section -->
      <div class="col-9 card shadow p-0 d-flex align-self-stretch" id="carpoolList">
        <!-- Carpool List is fetched from  findCarpool.js -->
      </div>

      <!-- Pagination Section-->
      <div class="col-12 d-flex justify-content-center mt-4">
        <nav>
          <ul class="pagination pagination-lg">

          </ul>
        </nav>
      </div>

      <div id="carpoolModals">
        <!-- Carpool Modals is fetched from  findCarpool.js -->
      </div>
    </div>
  </div>

  <?php include './includes/footer.inc.php'; ?>
</body>


</html>