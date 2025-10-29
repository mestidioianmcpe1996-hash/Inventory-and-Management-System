<?php
// include "db.php";

// session_start();

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     // Encrypt password to match stored one
//     $hashed_pass = md5($password);

//     $query = "SELECT * FROM admin WHERE username='$username' AND password='$hashed_pass'";
//     $result = mysqli_query($Con, $query);

//     if (mysqli_num_rows($result) > 0) {
//         $_SESSION['username'] = $username;
//         echo <script>alert('Login Successful!'); window.location='welcome.php';</script>;
//     } else {
//         echo <script>alert('Invalid Username or Password!'); window.location='index.html';</script>;
//     }
// }
session_start();
include 'db.php';

$user = $_POST['username'];
$pass = $_POST['password'];


$query = "SELECT * FROM admin WHERE username='$user' AND password='$pass'";
$result = mysqli_query($Con, $query);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['username'] = $user;
    echo " <html>
    <head>
      <style>
        body {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          background-color: #0b0b10;
          margin: 0;
        }

        .modal {
          position: fixed;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          background: rgba(255, 255, 255, 0.1);
          color: #fff;
          padding: 30px 60px;
          border-radius: 15px;
          box-shadow: 0 0 25px rgba(255, 255, 255, 0.2);
          font-family: 'Poppins', sans-serif;
          font-size: 1.2rem;
          opacity: 0;
          animation: fadeInOut 3s ease forwards;
          backdrop-filter: blur(8px);
        }

        @keyframes fadeInOut {
          0% { opacity: 0; transform: translate(-50%, -60%); }
          20% { opacity: 1; transform: translate(-50%, -50%); }
          80% { opacity: 1; transform: translate(-50%, -50%); }
          100% { opacity: 0; transform: translate(-50%, -40%); }
        }
      </style>
    </head>
    <body>
      <div class='modal'>✅ Login Successful!</div>
      <script>
        setTimeout(() => {
          window.location.href = 'homepage.php';
        }, 1500);
      </script>
    </body>
    </html>";
} else {
    echo " <html>
    <head>
      <style>
        body {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          background-color: #0b0b10;
          margin: 0;
        }

        .modal {
          position: fixed;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          background: rgba(255, 255, 255, 0.1);
          color: #fff;
          padding: 30px 60px;
          border-radius: 15px;
          box-shadow: 0 0 25px rgba(255, 255, 255, 0.2);
          font-family: 'Poppins', sans-serif;
          font-size: 1.2rem;
          opacity: 0;
          animation: fadeInOut 3s ease forwards;
          backdrop-filter: blur(8px);
        }

        @keyframes fadeInOut {
          0% { opacity: 0; transform: translate(-50%, -60%); }
          20% { opacity: 1; transform: translate(-50%, -50%); }
          80% { opacity: 1; transform: translate(-50%, -50%); }
          100% { opacity: 0; transform: translate(-50%, -40%); }
        }
      </style>
    </head>
    <body>
      <div class='modal'>❌ Invalid Username or Password!</div>
      <script>
        setTimeout(() => {
          window.location.href = 'index.php';
        }, 1500);
      </script>
    </body>
    </html>";
}
?>


