<?php
include './includes/modals/addAdminModal.inc.php';
require './backend/connection.php';

?>
<link rel="stylesheet" href="./styles/dashView.css">
<div class="row">
    <div class="w-75">
        <h2>Accounts</h2>
    </div>
    <div class="w-25">
        <div class="input-group">
            <input type="text" class="form-control search-input" id="txtSearchAccounts" placeholder="Filter users">
            <button class="btn btn-primary search-btn" type="button" id="button-addon2">Search <i class="bi bi-search"></i></button>
        </div>
    </div>
</div>
<div class="row">
    <div class="w-75">
        <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-user-tab" data-bs-toggle="pill" data-bs-target="#pills-user" type="button" role="tab" aria-controls="pills-user" aria-selected="true">User</button>
            </li>
            <li class="nav-item mx-4" role="presentation">
                <button class="nav-link" id="pills-driver-tab" data-bs-toggle="pill" data-bs-target="#pills-driver" type="button" role="tab" aria-controls="pills-driver" aria-selected="false">Driver</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-admin-tab" data-bs-toggle="pill" data-bs-target="#pills-admin" type="button" role="tab" aria-controls="pills-admin" aria-selected="false">Admin</button>
            </li>
        </ul>
    </div>
    <div class="w-25 d-flex align-items-center justify-content-end" id="addAdminBtn">
        <i class="bi bi-plus-circle" data-bs-toggle="modal" data-bs-target="#addAdminModal" id="circle"></i>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
            <table id="userTable" class="" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Points Collected</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $stmt = $pdo->prepare('SELECT user.*, account.email
                FROM user
                JOIN account ON user.accountID = account.accountID;');
                    $stmt->execute();

                    // Fetch the result
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($result as $user) {
                        $name = $user['name'];
                        $email = $user['email'];
                        $phoneNo = $user['phoneNo'];
                        $gender = $user['gender'];
                        $dob = $user['dob'];
                        $rewardPoints = $user['rewardPoints'];
                        echo "<tr>
                      <td>{$name}</td>
                      <td>{$email}</td>
                      <td>{$phoneNo}</td>
                      <td>{$gender}</td>
                      <td>{$dob}</td>
                      <td>{$rewardPoints}</td>
                      </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="pills-driver" role="tabpanel" aria-labelledby="pills-driver-tab">
            <table id="driverTable" class="" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Points Collected</th>
                        <th>Rating</th>
                        <th>Vehicle No</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->prepare("SELECT user.*, account.email, application.vehicleNo
                    FROM user
                    JOIN account ON user.accountID = account.accountID
                    LEFT JOIN application ON user.accountID = application.accountID
                    WHERE account.type = 'Driver';");
                    $stmt->execute();

                    // Fetch the result
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($result as $driver) {
                        $name = $driver['name'];
                        $email = $driver['email'];
                        $phoneNo = $driver['phoneNo'];
                        $gender = $driver['gender'];
                        $dob = $driver['dob'];
                        $rewardPoints = $driver['rewardPoints'];
                        $rating = $driver['rating'];
                        $vehicleNo = $driver['vehicleNo'];

                        echo "<tr>
                      <td>{$name}</td>
                      <td>{$email}</td>
                      <td>{$phoneNo}</td>
                      <td>{$gender}</td>
                      <td>{$dob}</td>
                      <td>{$rewardPoints}</td>
                      <td>{$rating}</td>
                      <td>{$vehicleNo}</td>
                      </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="pills-admin" role="tabpanel" aria-labelledby="pills-admin-tab">
            <table id="adminTable" class="" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $stmt = $pdo->prepare('SELECT admin.*, account.email
                FROM admin
                JOIN account ON admin.accountID = account.accountID;');
                    $stmt->execute();

                    // Fetch the result
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($result as $user) {
                        $name = $user['name'];
                        $email = $user['email'];
                        $phoneNo = $user['phoneNo'];
                        echo "<tr>
                      <td>{$name}</td>
                      <td>{$email}</td>
                      <td>{$phoneNo}</td>
                  </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>