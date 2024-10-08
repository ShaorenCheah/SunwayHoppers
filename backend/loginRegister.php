<?php
require_once 'connection.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$formJSON = $_POST['formData'];
$data = json_decode($formJSON, true);

$action = $data['action'];

// Login Process
if ($action == 'login') {
  $email_temp = $data['email'];
  $pw_temp = $data['password'];

  $stmt = $pdo->prepare('SELECT * FROM account WHERE email = :email');
  $stmt->bindParam(':email', $email_temp, PDO::PARAM_STR);
  $stmt->execute();

  // Fetch the result
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $rowCount = $stmt->rowCount();

  if ($rowCount > 0) {
    $success = true;

    $email = $result['email'];
    $pw = $result['password'];

    if (password_verify($pw_temp, $pw)) {
      // Password is correct
      $accountID = $result['accountID'];
      $type = $result['type'];


      if ($type == 'Admin') {
        $stmt = $pdo->prepare('SELECT * FROM admin WHERE accountID = :accountID');
        $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user'] = [
          'accountID' => $accountID,
          'name' => $result['name'],
          'email' => $email,
          'type' => $type,
        ];
        $message = "Welcome, " . $_SESSION['user']['name'] . ". You are now logged in as an admin.";
      } else {
        $stmt = $pdo->prepare('SELECT * FROM user WHERE accountID = :accountID');
        $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user'] = [
          'accountID' => $accountID,
          'name' => $result['name'],
          'email' => $email,
          'type' => $type,
          'profilePic' => $result['profilePic'],
          'gender' => $result['gender'], //might need it to validate carpool session
        ];
        $message = "Welcome, " . $_SESSION['user']['name'] . ". Hop on a carpool now!";
      }

      $_SESSION['login_time'] = time(); // Store login time
      $success = true;
    } else {
      $success = false;
      $message = "Wrong email/password. Please try again.";
    }
  } else {
    $success = false;
    $message = "Account does not exist. Please register.";
  }
}


// Register Process
else if ($action == 'register') {
  $username = $data['username'];
  $email = $data['email'];
  $pwd = $data['userPwd'];
  $phoneNo = $data['phoneNo'];
  $dob = $data['dob'];
  $gender = $data['gender'];

  $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

  // Generate new accountID
  // Get the last accountID from database
  $query = "SELECT accountID FROM Account ORDER BY accountID DESC LIMIT 1;";

  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $lastId = $stmt->fetchColumn();
  // Extract the numerical part and increment it
  $lastIdDigit = intval(substr($lastId, 1));
  $newIdDigit = $lastIdDigit + 1;

  // Format the new code with leading zeros
  $accountID = "A" . str_pad($newIdDigit, strlen($lastId) - 1, '0', STR_PAD_LEFT);

  // Insert new account
  $query   = "INSERT INTO account (accountID, email, password, type) VALUES (:accountID, :email, :password, 'Passenger')";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->bindParam(':password', $hashedPwd, PDO::PARAM_STR);
  $stmt->execute();

  // Fetch the new accountID from DB
  $query   = "SELECT accountID FROM account WHERE email = :email";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->setFetchMode(PDO::FETCH_OBJ);
  $stmt->execute();
  $result = $stmt->fetch();

  if ($result) {
    $accountID = $result->accountID;

    // Insert new user
    $query   = "INSERT INTO user (accountID, name, phoneNo, gender, dob, bio, rewardPoints, rating, carRules, profilePic) 
    VALUES (:accountID, :name, :phoneNo, :gender, :dob, null, 0, 0, null, './images/person.png')";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':accountID', $accountID, PDO::PARAM_STR);
    $stmt->bindParam(':name', $username, PDO::PARAM_STR);
    $stmt->bindParam(':phoneNo', $phoneNo, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
    $stmt->execute();

    $success = true;
    $message = "Account created successfully! Please login with your credentials to proceed.";
  } else {
    $success = false;
    $message = "Account created failed. Please try again.";
  }
} else {
  $success = false;
  $message = "Network error. Please try again.";
}


$stmt = null;

$response = [
  'success' => $success,
  'action' => $action,
  'message' => $message,
];
// Send a JSON response indicating success or failure

echo json_encode($response);
