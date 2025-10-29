<?php
session_start();
if(!isset($_SESSION["username"])){
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Logout Confirmation</title>
<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #0b0b10;
    font-family: 'Poppins', sans-serif;
    color: white;
  }

  /* Confirmation Modal */
  .modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(10px);
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow: 0 0 25px rgba(255, 255, 255, 0.2);
    text-align: center;
    animation: fadeIn 0.5s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translate(-50%, -60%); }
    to { opacity: 1; transform: translate(-50%, -50%); }
  }

  .modal button {
    margin: 15px 10px 0;
    padding: 10px 25px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: 0.2s ease;
  }

  .yes {
    background-color: #4CAF50;
    color: white;
  }

  .yes:hover {
    background-color: #45a049;
  }

  .no {
    background-color: #f44336;
    color: white;
  }

  .no:hover {
    background-color: #d73833;
  }

  /* Logged Out Modal */
  .logout-success {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    padding: 30px 60px;
    border-radius: 15px;
    box-shadow: 0 0 25px rgba(255, 255, 255, 0.2);
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

<div class="modal" id="confirmModal">
  <h2>Do you want to log out?</h2>
  <button class="yes" onclick="logoutConfirm()">Yes</button>
  <button class="no" onclick="cancelLogout()">No</button>
</div>

<script>
function logoutConfirm() {
  document.getElementById('confirmModal').remove();

  // Show "Logged out successfully" modal
  const successModal = document.createElement('div');
  successModal.classList.add('logout-success');
  successModal.textContent = '✅ Logged out successfully!';
  document.body.appendChild(successModal);

  // After animation, destroy session & redirect
  setTimeout(() => {
    fetch('logout_process.php')  // session_destroy() handled separately
      .then(() => window.location.href = 'index.php');
  }, 1500);
}

function cancelLogout() {
  window.history.back(); // Go back if user cancels
}
</script>

</body>
</html>
<?php
session_unset();
session_destroy();
?>


