<?php
include "db.php";
session_start();
if (!isset($_SESSION["username"])){
 header("Location: index.php");
 exit();
}

$students = [];
$query_reg = "SELECT * FROM tbl_register"; //for displaying the values from SQL
$exec_reg = mysqli_query($Con, $query_reg);
if(!$exec_reg){
    echo "Error";
}
else{
    if(mysqli_num_rows($exec_reg) > 0){
        while($row = mysqli_fetch_assoc($exec_reg)){
            array_push($students,$row);
        }
    }
    // else{
    //     echo "Empty";
    // }
}
$items = [];
$query_item = "SELECT * FROM tbl_items";
$exec_item = mysqli_query($Con, $query_item);
if(!$exec_item){
    echo "Error";
}
else{
    if(mysqli_num_rows($exec_item) > 0){
        while($row = mysqli_fetch_assoc($exec_item)){
            array_push($items,$row);
        }
    }
}

$borrowers = [];
$query_borrow = "SELECT * FROM tbl_borrowers";
$exec_borrow = mysqli_query($Con, $query_borrow);
if(!$exec_borrow){
    echo "Error";
}
else{
     if(mysqli_num_rows($exec_borrow) > 0){
        while($row = mysqli_fetch_assoc($exec_borrow)){
            array_push($borrowers,$row);
        }
    }
}

$transacs = [];
$query_transac = "SELECT * FROM tbl_transaction";
$exec_transac = mysqli_query($Con, $query_transac);
if(!$exec_transac){
    echo "Error";
}
else{
    if(mysqli_num_rows($exec_transac) > 0){
        while($row = mysqli_fetch_assoc($exec_transac)){
            array_push($transacs,$row);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src = "vendor/jquery/jquery.min.js"></script>
    <link href="bootstrap/bootstrap1/css/bootstrap.css" rel = "stylesheet">
    <!-- For icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Bootstrap CDN -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    <!-- Added Plexus Background Canvas -->
    <canvas id="plexus-bg"></canvas>
    <div class="d-flex">
  <!-- Sidebar Left -->
  <div id="sidebar" class="bg-dark text-white p-3 d-flex flex-column justify-content-between"
       style="width: 250px; height: 100vh; position: fixed;">

    <!-- Top Section -->
    <div>
      <!-- Burger icon + title -->
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">MENU</h4>
      <a id="btnhome"><i class="fa-solid fa-house"  style="cursor: pointer;"></i></a>
      </div>
        <hr class="bg-light">
      <ul class="menu">
        <li class="nav-item mb-2">
          <a class="nav-link text-white sidebar-btn" data-bs-toggle="modal" data-bs-target="#registerModal">
            <i class="fa-solid fa-user-plus"></i> Register Student
          </a>
        </li>

        <li class="nav-item mb-2">
          <a class="nav-link text-white sidebar-btn" data-bs-toggle="modal" data-bs-target="#scannerModal">
            <i class="fa-solid fa-qrcode"></i> Borrow Item
          </a>
        </li>

        <li class="nav-item mb-2">
          <a class="nav-link text-white sidebar-btn" data-bs-toggle="modal" data-bs-target="#returnModal">
            <i class="fa-solid fa-boxes-stacked"></i>Return Item</a>
        </li>

        <hr class="bg-light">

        <li class="nav-item mb-2">
          <a class="nav-link text-white sidebar-btn" id="regstud">
            <i class="fa-solid fa-user-plus"></i> Registered Students</a>
        </li>

        <li class="nav-item mb-2">
          <a class="nav-link text-white sidebar-btn" id="itemlist">
            <i class="fa-solid fa-boxes-stacked"></i> Items</a>
        </li>

        <li class="nav-item mb-2">
          <a class="nav-link text-white sidebar-btn" id="borrower_list">
            <i class="fa-solid fa-users"></i> Borrowers</a>
        </li>

        <li class="nav-item mb-2">
          <a class="nav-link text-white sidebar-btn" id="transac_list">
            <i class="fa-regular fa-clock"></i> Transactions</a>
        </li>
      </ul>
    </div>
    <hr id = "hr" class="bg-light">
    <!-- Bottom Logout Section -->
        <a href="logout.php" class="logout">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>

  </div>
</div>
   <!--  Main Content (push to the right) -->
      <h2 class="title">INVENTORY SYSTEM</h2>
</div>
<!-- MODALS -->
 <!-- Modal for adding items -->
    <!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header" style="background-color: #6c757d; color: white;">
        <h5 class="modal-title" id="addItemLabel">Add New Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" style="background-color: #ffffff;">

        <div class="mb-3">
          <label class="form-label">Item Name</label>
          <input type="text" class="form-control" id="new_itemname" placeholder="Enter item name">
        </div>

        <div class="mb-3">
          <label class="form-label">Quantity</label>
          <input type="number" class="form-control" id="new_quantity" placeholder="Enter quantity">
        </div>
      </div>

      <div class="modal-footer" style="background-color: #f8f9fa;">
        <button type="button" class="btn btn-success" id="btnAddItem">Add Item</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btncancel_additem">Cancel</button>
      </div>

    </div>
  </div>
</div>


 <!-- Modal for return of item -->
  <div class="modal" id="returnModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Return Item</h5>
        <button type="button" class="btn-close close-btn" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- BARCODE SCAN -->
        <div class="mb-3">
          <label class="form-label">Barcode ID</label>
          <input type="text" class="form-control" id="barcode_ret" autofocus>
        </div>

        <div class="mb-3">
          <label class="form-label">Item Name</label>
          <input type="text" class="form-control" id="itemname_ret" readonly>
        </div>

         <div class="mb-3">
          <label class="form-label">School ID</label>
          <input type="text" class="form-control" id="schoolid_ret" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,9)" >
        </div>
        
        <div id="student_info_ret" style="display:none;">
        <hr>
          <p><strong>Name:</strong> <span id="studname_ret"></span></p>
          <p><strong>Course:</strong> <span id="course_ret"></span></p>
          <p><strong>Year Level:</strong> <span id="year_ret"></span></p>
          <p><strong>Email:</strong> <span id="email_ret"></span></p>
        </div>
        <hr>

        <div class="mb-3">
            <label class="form-label">Quantity Borrowed</label>
            <input type="number" id="qtyborrow_ret" class="form-control" readonly>
        </div>
       
        <div id="datebor" class="mb-3">
            <label class="form-label">Date Borrowed</label>
          <input type="datetime-local" class="form-control" id="dateborrow_ret" readonly>
        </div>

        <div id="dateret" class="mb-3">
            <label class="form-label">Registered Return Date</label>
          <input type="datetime-local" class="form-control" id="datereturn_ret" readonly>
        </div>

         <div id="datereturned_ret" class="mb-3">
            <label class="form-label">Date Returned</label>
          <input type="datetime-local" class="form-control" id="datereturned">
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnreturn">Confirm Return</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btncancel_ret">Cancel</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal for registration-->
<div class="modal fade" id="registerModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">

      <form method="POST">
        <div class="modal-header modal-header-custom">
          <h5 class="modal-title">Registration Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

            <div class="mb-3">
                <label class="form-label">Firstname</label>
                <input type="text" class="form-control" name="firstname" required id="firstname">
            </div>

            <div class="mb-3">
                <label class="form-label">Lastname</label>
                <input type="text" class="form-control" name="lastname" required id="lastname">
            </div>

            <div class="mb-3">
                <label class="form-label">School ID</label>
                <input type="text" class="form-control" name="schoolid" required id="schoolid" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,9)">
            </div>

            <div class="mb-3">
                <label class="form-label">Course</label>
                <input type="text" class="form-control" name="course" required id="course">
            </div>

            <div class="mb-3">
                <label class="form-label">Year Level</label>
                <select class="form-select" name="yearlevel" required id="yearlevel">
                  <option value="">Select Year</option>
                  <option value="1st Year">1st Year</option>
                  <option value="2nd Year">2nd Year</option>
                  <option value="3rd Year">3rd Year</option>
                  <option value="4th Year">4th Year</option>
                  <option value="5th Year">5th Year</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required id="email">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="registerBtn" class="btn btn-success" id = "btnsubmit">Submit</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btncancel_reg">Cancel</button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- Barcode Scanner Modal Borrow Item-->
<div class="modal fade" id="scannerModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal-style">

      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Borrow Item</h5>
        <button type="button" class="btn-close close-btn" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- BARCODE SCAN -->
        <div class="mb-3">
          <label class="form-label">Barcode ID</label>
          <input type="text" class="form-control" id="scan_barcode" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,9)" autofocus>
        </div>

        <div class="mb-3">
          <label class="form-label">Item Name</label>
          <input type="text" class="form-control" id="scan_itemname" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Stock Available</label>
          <input type="number" class="form-control" id="scan_qty" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity to Borrow</label>
            <input type="number" id="qtyborrow" class="form-control">
        </div>
        <hr>

        <!-- SCHOOL ID SCAN -->
        <div class="mb-3">
          <label class="form-label">School ID</label>
          <input type="text" class="form-control" id="scan_schoolid" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,9)">
        </div>

        <div id="student_info" style="display:none;">
          <p><strong>Name:</strong> <span id="scan_studname"></span></p>
          <p><strong>Course:</strong> <span id="scan_course"></span></p>
          <p><strong>Year Level:</strong> <span id="scan_year"></span></p>
          <p><strong>Email:</strong> <span id="scan_email"></span></p>
        </div>
        <hr>

        <div id="datebor" class="mb-3">
            <label class="form-label">Date Borrowed</label>
          <input type="datetime-local" class="form-control" id="dateborrow">
        </div>

        <div id="dateret" class="mb-3">
            <label class="form-label">Return Date</label>
          <input type="datetime-local" class="form-control" id="datereturn">
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnborrow">Confirm Borrow</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btncancel_borr">Cancel</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal for Edit Registered Students-->
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content custom-modal-style">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title">Edit Information</h5>
        <button type="button" class="close close-btn" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="fullname">
          Fullname: <label id="fullnamelabel"></label>
        </div>
        <br>
        Last Name: <input type="text" id="lastnameedit" class="form-control mb-2">
        First Name: <input type="text" id="firstnameedit" class="form-control mb-2">
        Course: <input type="text" id="courseedit" class="form-control mb-2">
        Email: <input type="text" id="emailedit" class="form-control mb-2">

        <label >Year Level</label>
        <select class="form-select form-control" id="yearleveledit" required>
          <option value="">Select Year</option>
          <option value="1st Year">1st Year</option>
          <option value="2nd Year">2nd Year</option>
          <option value="3rd Year">3rd Year</option>
          <option value="4th Year">4th Year</option>
          <option value="5th Year">5th Year</option>
        </select>
       
       
      </div>
       
      <div class="modal-footer">
        <button type="button" id="btneditsave" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="main-content">
<!-- Table Display Codes -->
<?php
 $y = 1; // for the number in table only, does not follow with that on sql
 ?>
 <div class="tabledisp_transaction" style="display:none;">
     
    <table id="transactiontable" class = "table table-bordered">
        <thead>
            <tr class="table-primary">
                <td scope="col">No.</td>
                <td scope="col">BARCODE ID</td>
                <td scope="col">ITEM NAME</td>
                <td scope="col">QUANTITY</td>
                <td scope="col">SCHOOL ID</td>
                <td scope="col">NAME</td>
                <td scope="col">EMAIL</td>
                <td scope="col">DATE BORROWED</td>
                <td scope="col">RETURN DATE</td>
                <td scope="col">DATE RETURNED</td>
            </tr>
        </thead>
        <tbody>
           <?php 
                    foreach($transacs as $transac): extract($transac);
                    ?>
                    <tr class="table-secondary">
                        <td><?php echo $y ?></td>
                        <td> <?php echo $barcode_id ?> </td>
                        <td><?php echo $item_name ?></td>
                        <td><?php echo $qty_borrowed ?></td>
                        <td><?php echo $school_id ?></td>
                        <td><?php echo $studname ?></td>
                        <td><?php echo $email ?></td>
                        <td><?php echo $date_borrowed ?></td>
                        <td><?php echo $date_reg_return ?></td>
                        <td><?php echo $date_returned ?></td>
                    </tr>
                    <?php $y++; ?>
                    <?php endforeach; ?>
        </tbody>
    </table>
</div>


 <?php
 $x = 1; // for the number in table only, does not follow with that on sql
 ?>
 <div class="tabledisp_borrower" style="display:none;">
     
    <table id="borrowertable" class = "table table-bordered">
        <thead>
            <tr class = "table-primary">
                <td>No.</td>
                <td>BARCODE ID</td>
                <td>ITEM NAME</td>
                <td>QUANTITY BORROWED</td>
                <td>SCHOOL ID</td>
                <td>NAME</td>
                <td>EMAIL</td>
                <td>DATE BORROWED</td>
                <td>DATE TO RETURN</td>
                <td>STATUS</td>
            </tr>
        </thead>
        <tbody>
           <?php 
                    foreach($borrowers as $borrower): extract($borrower);
                    ?>
                    <tr class="table-secondary">
                        <td><?php echo $x ?></td>
                        <td> <?php echo $barcode_id ?> </td>
                        <td><?php echo $item_name ?></td>
                        <td><?php echo $qty_borrow ?></td>
                        <td><?php echo $school_id ?></td>
                        <td><?php echo $studname ?></td>
                        <td><?php echo $email ?></td>
                        <td><?php echo $date_borrow ?></td>
                        <td><?php echo $date_ret ?></td>
                        <td>
                            <?php
                                date_default_timezone_set('Asia/Manila'); // required for time checking

                                $now = date('Y-m-d H:i:s');
                                $status = (strtotime($now) > strtotime($date_ret)) ? 'LATE' : 'Not Yet Due';

                                echo $status;
                                ?>
                        </td> 
                    </tr>
                    <?php $x++; ?>
                    <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- for registered students table display -->
<div class="tabledisp_regstud" style="display:none;">
     
    <table id="regstudtable" class = "table table-bordered">
        <thead>
            <tr class = "table-primary">
                <td>SCHOOL ID</td>
                <td>LAST NAME</td>
                <td>FIRST NAME</td>
                <td>COURSE</td>
                <td>YEAR LEVEL</td>
                <td>EMAIL</td>
                <td>ACTION</td>
            </tr>
        </thead>
        <tbody>
           <?php 
                    foreach($students as $student): extract($student);
                    ?>
                    <tr class="table-secondary">
                        <td> <?php echo $idschool ?> </td>
                        <td><?php echo $lname ?></td>
                        <td><?php echo $fname ?></td>
                        <td><?php echo $course ?></td>
                        <td><?php echo $yearlevel ?></td>
                         <td><?php echo $email ?></td>
                        <td><button type = "button" id = "btnedit"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button type = "button" id = "btndelete"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                    <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Table for the item information but not to be displayed (hidden) -->
<div class="tabledisp_item" style="display:none;"> 
     
    <table id="itemtable" class = "table table-bordered">
        <thead>
            <tr class = "table-primary">
                <td>BARCODE ID</td>
                <td>ITEM NAME</td>
                <td>QUANTITY</td>   
                <td><i id="add"class="fa-solid fa-plus"></i></td>   
            </tr>
        </thead>
        <tbody>
           <?php 
                    foreach($items as $item): extract($item);
                    ?>
                    <tr class="table-secondary">
                        <td> <?php echo $barcode_id ?> </td>
                        <td><?php echo $item_name ?></td>
                        <td><?php echo $quantity ?></td>
                        <td>
                        <button type = "button" id = "btnedit_item"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button type = "button" id = "btndelete_item"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
        </tbody>        
    </table>
</div>
</div>

<!-- JQUERY CODES for all the functions-->
 <script>
//for opening modal of add item kay wala naka bootstrap
 document.addEventListener('DOMContentLoaded', () => {
  const addBtn = document.getElementById('add');
  const addItemModal = new bootstrap.Modal(document.getElementById('addItemModal'));

  // Show modal when "+" icon is clicked
  addBtn.addEventListener('click', () => {
    addItemModal.show();
  });

  // When the Add Item button inside the modal is clicked
  $('#btnAddItem').click(function() {
    // Get values
    
    var item_name = $('#new_itemname').val().trim();
    var quantity = $('#new_quantity').val().trim();

    // Validation
    if (item_name == '' || quantity == '') {
      alert('Please fill in all fields.');
      return;
    }
  
    flag = 'addItem';

    $.ajax({
      url: 'crud.php',
      method: 'POST',
      data: {
        flag: flag,
        item_name: item_name,
        quantity: quantity
      },
      success: function(response) {
        if (response.trim() === 'Yes') {
          alert('Item added successfully!');
          $('#addItemModal').modal('hide');
          $('#new_itemname, #new_quantity').val(''); // clear inputs
           localStorage.setItem("showItemTable", "true");
            location.reload();
        } else {
          alert('Error: ' + response);
        }
      },
      error: function() {
        alert('AJAX request failed.');
      }
    });
  });
});

      //Plexus JS Animation
    const canvas = document.getElementById('plexus-bg');
  const ctx = canvas.getContext('2d');
  let w, h;
  function resize() {
    w = canvas.width = window.innerWidth;
    h = canvas.height = window.innerHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  const dots = [];
  const numDots = 80;
  const repelRadius = 120;
  const repelStrength = 0.2;

  let mouse = { x: null, y: null };

  window.addEventListener('mousemove', e => {
    mouse.x = e.clientX;
    mouse.y = e.clientY;
  });

  window.addEventListener('mouseleave', () => {
    mouse.x = null;
    mouse.y = null;
  });

  for (let i = 0; i < numDots; i++) {
    dots.push({
      x: Math.random() * w,
      y: Math.random() * h,
      vx: (Math.random() - 0.5) * 0.6,
      vy: (Math.random() - 0.5) * 0.6
    });
  }

  function animate() {
    ctx.clearRect(0, 0, w, h);

    for (let i = 0; i < numDots; i++) {
      const d = dots[i];

      // Repel effect near cursor
      if (mouse.x && mouse.y) {
        const dx = d.x - mouse.x;
        const dy = d.y - mouse.y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < repelRadius) {
          const force = (1 - dist / repelRadius) * repelStrength;
          d.vx += (dx / dist) * force;
          d.vy += (dy / dist) * force;
        }
      }

      d.x += d.vx;
      d.y += d.vy;

      // Keep inside screen
      if (d.x < 0 || d.x > w) d.vx *= -1;
      if (d.y < 0 || d.y > h) d.vy *= -1;

      ctx.beginPath();
      ctx.arc(d.x, d.y, 2, 0, Math.PI * 2);
      ctx.fillStyle = "rgba(255,255,255,0.8)";
      ctx.fill();
    }

    // Draw lines between nearby dots
    for (let i = 0; i < numDots; i++) {
      for (let j = i + 1; j < numDots; j++) {
        const dx = dots[i].x - dots[j].x;
        const dy = dots[i].y - dots[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 120) {
          ctx.beginPath();
          ctx.moveTo(dots[i].x, dots[i].y);
          ctx.lineTo(dots[j].x, dots[j].y);
          ctx.strokeStyle = "rgba(255,255,255," + (1 - dist / 120) * 0.3 + ")";
          ctx.lineWidth = 1;
          ctx.stroke();
        }
      }
    }

    requestAnimationFrame(animate);
  }

  animate();
    //Stays the color of hover in nav
document.querySelectorAll('.nav-link').forEach(link => {
  link.addEventListener('click', function() {
    document.querySelectorAll('.nav-link').forEach(item => item.classList.remove('active'));
    this.classList.add('active');
  });
});

// Remove active highlight when clicking "Home" button
const homeButton = document.querySelector('#btnhome'); // use your home button ID or class
if (homeButton) {
  homeButton.addEventListener('click', function() {
    document.querySelectorAll('.nav-link').forEach(item => item.classList.remove('active'));
  });
}

    //For edit-items
$(document).ready(function(){

    // === Edit ===
    $(document).on("click", "#btnedit_item", function(){
        var row = $(this).closest("tr");

        // Make cells editable
        row.find("td").each(function(index){
            if(index > 0 && index < 3){  // skip ID and Action column
                var currentText = $(this).text();
                $(this).html('<input type="text" class="form-control form-control-sm" value="'+currentText+'">');
            }
        });

        // Change Edit → Save
        $(this).text("Save")
               .removeClass("btn-primary")
               .addClass("btn-success")
               .attr("id", "btnSave");

            
    });

    // === Save (Update) ===
    $(document).on("click", "#btnSave", function(){
        var row = $(this).closest("tr");
        var id = row.find("td:eq(0)").text();
        flag = 'edit_item';
        var updatedData = {flag: flag,
            barcode_id: id,
            item_name: row.find("td:eq(1) input").val(),
            quantity: row.find("td:eq(2) input").val(),
        };

        $.ajax({
            url: "crud.php",
            type: "POST",
            data: updatedData,
            success: function(response){
                alert("✅ Record updated successfully!");
                localStorage.setItem("showItemTable", "true");
                location.reload();
            },
            error: function(){
                alert("❌ Error updating data.");
            }
        });
    });

    // === Delete ===
 $("table tbody").on('click','#btndelete_item',function(){
            current_row = $(this).closest('tr');
            id = current_row.find('td:eq(0)').text();
            
            flag = 'delete_item';

            $.ajax({
            url: 'crud.php',
            method: 'POST',
            data:{flag: flag,
                barcode_id: id}, 
            success: function(data){
            
                if(data == "Yes"){
                  if(confirm("Are sure you want to delete this item?")){   
                  alert("Data Deleted Successfully!");
                     localStorage.setItem("showItemTable", "true");
                     location.reload();
                  }
                }
                else{
                    alert(data);
                }
            }

    });

    });

});
//for removing entered values when cancel button is pressed in add item modal
    $("#btncancel_additem").click(function(){
        $("#new_itemname").val("");
        $("#new_quantity").val("");
    });
    //for cancel button in modal register
    $("#btncancel_reg").click(function(){
        $("#firstname").val("");
        $("#lastname").val("");
        $("#schoolid").val("");
        $("#course").val("");
        $("#yearlevel").val("");
        $("#email").val("");
    });
    //for cancel button of modal item return
    $("#btncancel_ret").click(function(){
        $("#barcode_ret").val("");
        $("#itemname_ret").val("");
        $("#schoolid_ret").val("");
        $("#student_info_ret").hide();
        $("#qty_borrow_ret").val("");
        $("#dateborrow_ret").val("");
        $("#datereturn_ret").val("");
        $("#datereturned").val("");
       
    });
    //for cancel button of modal borrow item
     $("#btncancel_borr").click(function(){
        $("#scan_barcode").val("");
        $("#scan_itemname").val("");
        $("#scan_qty").val("");
        $("#qtyborrow").val("");
        $("#scan_schoolid").val("");
        $("#student_info").hide();
        $("#dateborrow").val("");
        $("#datereturn").val("");
        
       
    });
    //code for button to homepage
    $("#btnhome").click(function(){
        hideAllTables();
    });
    // code for autofocus
    $('#scannerModal').on('shown.bs.modal', function () {
    $('#scan_barcode').trigger('focus');
    });

// Focus for Return Modal
    $('#returnModal').on('shown.bs.modal', function () {
    $('#barcode_ret').trigger('focus');
    });
    //for automated email
    // Check each row and send email automatically if late
function checkLateAndSendEmail() {
    $("#borrowertable tbody tr").each(function () {
        let status = $(this).find('td:eq(9)').text().trim();  // Status column index
        let email = $(this).find('td:eq(6)').text().trim();   // Email column index
        flag = 'email';
        if (status === "LATE") {
            $.ajax({
                url: "crud.php",
                method: "POST",
                data:{ flag: flag, 
                    email: email 
                },
                success: function (response) {
                    console.log(response);
                }
            });
        }
    });
}

// run once when loaded
//checkLateAndSendEmail();

// auto check every 5 minutes
setInterval(checkLateAndSendEmail, 300000);

    //for status update in borrowers table
function updateBorrowerStatus() {
    $("#borrowertable tbody tr").each(function () {
    let dueDateString = $(this).find("td:eq(8)").text().trim(); // DATE TO RETURN column
    let dueDate = new Date(dueDateString);
    let currentdate_and_time = new Date();

    let statusText = "";
    let statusColor = "";

    if (currentdate_and_time > dueDate) {
        statusText = "LATE";
        statusColor = "red";
    } 
    else {
        statusText = "ACTIVE";
        statusColor = "green";
    }

    $(this).find("td:eq(9)").text(statusText).css("color", statusColor);
});
}
//for autoupdate when duedate is passed, no need to reload the page
$("#borrower_list").on("click", function(){
    updateBorrowerStatus();
    $(".tabledisp_borrower").show();
});

// Also update again every 30 seconds to auto-refresh Late values
setInterval(updateBorrowerStatus, 300);

  $("#btnreturn").click(function(){
    barcode_id = $('#barcode_ret').val();
    item_name = $('#itemname_ret').val();
    schoolid = $('#schoolid_ret').val();
    studname = $('#studname_ret').text();
    qty_borrow = $('#qtyborrow_ret').val();
    date_borr = $('#dateborrow_ret').val();
    date_ret = $('#datereturn_ret').val();
    datereturned = $('#datereturned').val();
    email = $('#email_ret').text();
    flag = 'return';

    $.ajax({
        url:'crud.php',
        method: 'POST',
        data:{flag: flag,
            barcode_id: barcode_id,
            item_name: item_name,
            schoolid: schoolid,
            studname: studname,
            qty_borrow: qty_borrow,
            date_borr: date_borr,
            date_ret: date_ret,
            datereturned: datereturned,
            email: email

        },
        success: function(data){
            if(data == "Yes"){
                alert("TRANSACTION COMPLETE!");
                let modal = bootstrap.Modal.getInstance(document.getElementById('returnModal'));
                    modal.hide();
                location.reload();
            }
            else{
                alert(data);
            }
        }
    });

  });
  //for return Modal
  //for automatch when barcode is scanned again
  $("#returnitem").click(function() {
    setTimeout(()=> $("#barcode_ret").focus(), 500);
});
  // AUTO MATCH BARCODE FOR BORROW TABLE
$("#barcode_ret").on("keyup", function () {
    let barcode = $(this).val().trim();
    let found2 = false;
   
    $("#borrowertable tbody tr").each(function () {
        let tableBarcode = $(this).find("td:eq(1)").text().trim();
        if (barcode === tableBarcode) {
            $("#itemname_ret").val($(this).find("td:eq(2)").text());
            found2 = true;
        }
    });

    if (!found2) {
        $("#itemname_ret").val("");
    
}
});

//autofill after schoolid in return 
$("#schoolid_ret").on("keyup", function () {
    let sid_ret = $(this).val().trim();
    let found1 = false;
    let found3 = false;
     $("#regstudtable tbody tr").each(function () {
        let tableSID_ret = $(this).find("td:eq(0)").text().trim();
        if (sid_ret === tableSID_ret) {
            let lname = $(this).find("td:eq(1)").text();
            let fname = $(this).find("td:eq(2)").text();
            $("#studname_ret").text(fname + " " + lname);
            $("#course_ret").text($(this).find("td:eq(3)").text());
            $("#year_ret").text($(this).find("td:eq(4)").text());
            $("#email_ret").text($(this).find("td:eq(5)").text());
            $("#student_info_ret").show();
            found1 = true;
        }
    });
     if (!found1) {
        $("#student_info_ret").hide();
        }

     $("#borrowertable tbody tr").each(function () {
        let tablesid = $(this).find("td:eq(4)").text().trim();
        if (sid_ret === tablesid) {
            $("#qtyborrow_ret").val($(this).find("td:eq(3)").text());
            $("#dateborrow_ret").val($(this).find("td:eq(7)").text());
            $("#datereturn_ret").val($(this).find("td:eq(8)").text());
            found3 = true;
        }
    });

    if (!found3) {   
        $("#qtyborrow_ret").val("");
        $("#dateborrow_ret").val("");
        $("#datereturn_ret").val("");
}
});

//for borrowing button (confirm borrow)
$("#btnborrow").click(function(){
    barcode_id = $('#scan_barcode').val();
    item_name = $('#scan_itemname').val();
    qty_borrow = $('#qtyborrow').val();
    schoolid = $('#scan_schoolid').val(); 
    studname = $('#scan_studname').text();
    date_borr = $('#dateborrow').val();
    date_ret = $('#datereturn').val();
    email = $('#scan_email').text();

    flag = 'borrow';
    $.ajax({
        url: 'crud.php',
        method:'POST',
        data:{flag: flag,
            barcode_id: barcode_id,
            item_name: item_name,
            qty_borrow: qty_borrow,
            schoolid: schoolid,
            studname: studname,
            date_borr: date_borr,
            date_ret: date_ret,
            email: email  
        },
        success: function(data){
            if(data == "Yes"){
                alert("Borrow Confirmed!");
                 let modal = bootstrap.Modal.getInstance(document.getElementById('scannerModal'));
                    modal.hide();
                location.reload();
            }
            else{
                alert(data);
            }
        }
    });
});

//for borrower modal
// Fetch Item When Barcode Scanner
$("#scanbar").click(function() {
    setTimeout(()=> $("#scan_barcode").focus(), 500);
});

// AUTO MATCH BARCODE FROM ITEM TABLE
$("#scan_barcode").on("keyup", function () {
    let barcode = $(this).val().trim();
    let found = false;

    $("#itemtable tbody tr").each(function () {
        let tableBarcode = $(this).find("td:eq(0)").text().trim();
        if (barcode === tableBarcode) {
            $("#scan_itemname").val($(this).find("td:eq(1)").text());
            $("#scan_qty").val($(this).find("td:eq(2)").text());
            found = true;
        }
    });

    if (!found) {
        $("#scan_itemname").val("");
        $("#scan_qty").val("");
    }
});

// AUTO MATCH SCHOOL ID FROM STUDENTS TABLE
$("#scan_schoolid").on("keyup", function () {
    let sid = $(this).val().trim();
    let found = false;

    $("#regstudtable tbody tr").each(function () {
        let tableSID = $(this).find("td:eq(0)").text().trim();
        if (sid === tableSID) {
            let lname = $(this).find("td:eq(1)").text();
            let fname = $(this).find("td:eq(2)").text();
            $("#scan_studname").text(fname + " " + lname);
            $("#scan_course").text($(this).find("td:eq(3)").text());
            $("#scan_year").text($(this).find("td:eq(4)").text());
            $("#scan_email").text($(this).find("td:eq(5)").text());

            $("#student_info").show();
            found = true;
        }
    });

    if (!found) {
        $("#student_info").hide();
    }
});


//for the submit button (register)
        $("#btnsubmit").click(function(){
            firstname = $('#firstname').val();
            lastname = $('#lastname').val();
            schoolid = $('#schoolid').val();
            course = $('#course').val();
            yearlevel = $('#yearlevel').val();
            email = $('#email').val();
            flag = 'add';

            $.ajax({
                url:'crud.php',
                method: 'POST',
                data:{flag: flag,
                    firstname: firstname,
                    lastname: lastname,
                    schoolid: schoolid,
                    course: course,
                    yearlevel: yearlevel,
                    email: email
                },
                success: function(data){
                    if(data == "Yes"){
                        alert("Registration Succesful!");
                        location.reload();
                    }
                    else{
                        alert("Invalid! Everything must be filled out, and that School ID and email is correct and/or unique/not copied.");
                      // alert(data);
                    }
                }

            });

        });
//for table edit and delete
      $(document).ready(function(){
       $("table tbody").on('click','#btnedit',function(){
            current_row = $(this).closest('tr');
            id = current_row.find('td:eq(0)').text();
            fullname = current_row.find('td:eq(1)').text() +', ' + current_row.find('td:eq(2)').text();
            lastname = current_row.find('td:eq(1)').text();
            firstname = current_row.find('td:eq(2)').text();
            course = current_row.find('td:eq(3)').text();
            yearlevel = current_row.find('td:eq(4)').text();
            email = current_row.find('td:eq(5)').text();
            var regstud_id = id;
            $("#fullnamelabel").text(fullname);
            $("#lastnameedit").val(lastname);
            $("#firstnameedit").val(firstname);
            $("#courseedit").val(course);
            $("#yearleveledit").val(yearlevel);
            $("#emailedit").val(email);
            $("#mymodal").modal("show");
          
        });
        $("table tbody").on('click','#btndelete',function(){
            current_row = $(this).closest('tr');
            idstudent = current_row.find('td:eq(0)').text();
            
            flag = 'delete';
        if(confirm("Are you sure you want to delete this data?")){
            $.ajax({
            url: 'crud.php',
            method: 'POST',
            data:{flag: flag,
                schoolid: idstudent}, 
            success: function(data){
            
                if(data == "Yes"){
                    alert("Data Deleted Successfully!");
                     localStorage.setItem("showRegTable", "true");
                     location.reload();
                  }  
                  
                else{
                    alert(data);
                }
            }
          
            });
    }

    });
    });

    //for edit
     $("#btneditsave").click(function(){
        lastname = $('#lastnameedit').val();
        firstname = $('#firstnameedit').val(); // muni na variable ang gina tukoy ko sa note 1.1
        course = $('#courseedit').val();
        yearlevel = $('#yearleveledit').val();
        email = $('#emailedit').val();
        flag = 'edit';

         $.ajax({
        url: 'crud.php',
        method: 'POST',
        data:{flag: flag,
            schoolid: id,
            lastname: lastname,     //first nga lastname is iya sang sa crud.php ang next is ang id declared diri na file
            firstname: firstname,  //Note 1.1: var_declared_crud: var_declared_here
            course: course,
            yearlevel: yearlevel, 
            email: email    
        }, 
        success: function(data){
           
            if(data == "Yes"){
                if (confirm("Data Updated Successfully!")) {
                        document.getElementById('mymodal').style.display = 'none';
                        localStorage.setItem("showRegTable", "true");
                        location.reload();
                    }
            }
            else{
                alert(data);
            }
        }

    });
    });

//for displaying the table registered students
document.getElementById("transac_list").addEventListener("click", function() {
    document.querySelector(".tabledisp_transaction").style.display = "block";
});

//for displaying the table registered students
document.getElementById("regstud").addEventListener("click", function() {
    document.querySelector(".tabledisp_regstud").style.display = "block";
});

//for displaying table items
document.getElementById("itemlist").addEventListener("click", function() {
    document.querySelector(".tabledisp_item").style.display = "block";
});
//for displaying table items
document.getElementById("borrower_list").addEventListener("click", function() {
    document.querySelector(".tabledisp_borrower").style.display = "block";
});
// Hide all tables first function
function hideAllTables() {
    $(".tabledisp_item, .tabledisp_regstud, .tabledisp_borrower, .tabledisp_transaction").hide();
}

// Registered Students button
$("#regstud").click(function () {
    hideAllTables();
    $(".tabledisp_regstud").show();
});

// Items button
$("#itemlist").click(function () {
    hideAllTables();
    $(".tabledisp_item").show();
});

// Borrowers List button
$("#borrower_list").click(function () {
    hideAllTables();
    $(".tabledisp_borrower").show();
});

// Transaction button
$("#transac_list").click(function () {
    hideAllTables();
    $(".tabledisp_transaction").show();
});

// // Close Table Buttons
$(".tabledisp_item, .tabledisp_regstud, .tabledisp_borrower, .tabledisp_transaction").hide();
// for date borrow and return date
   $('#scannerModal').on('shown.bs.modal', function () {
    let now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('dateborrow').value = now.toISOString().slice(0, 16);
});

// for auto return date fill up based on current time and date
   $('#returnModal').on('shown.bs.modal', function () {
    let now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('datereturned').value = now.toISOString().slice(0, 16);
});
//to let the table remain showing even after the deletion where location is reload
if(localStorage.getItem("showRegTable") === "true") {
    document.querySelector(".tabledisp_regstud").style.display = "block";
    localStorage.removeItem("showRegTable"); // Remove so it doesn’t always show
}
if(localStorage.getItem("showItemTable") === "true") {
    document.querySelector(".tabledisp_item").style.display = "block";
    localStorage.removeItem("showItemTable"); // Remove so it doesn’t always show
}


 </script>

</body>
</html>