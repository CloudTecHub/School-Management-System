<?php 
include('include/sidebar.php');
?>
   <form action="../session/admin.php" method="post">
     <div class="studentcontainer">
       <h1 class="main-title">ADD ADMINISTRATOR</h1>
       <div>
       <label for="Class Name">Admin ID</label>
       <input class="add-class-input" type="text" name="administrator_id">

       <label for="Class Name">Admin Full Name</label>
       <input class="add-class-input" type="text" name="name">

       <label for="Class Teacher">Role</label>
       <select class="add-class-input" name="role">
        <option name="role">Select Role</option>
        <option name="role">administrator</option>
       </select>

         <label for="Class Name">Username</label>
         <input class="add-class-input" type="text" name="username">

         <label for="Class Teacher">Password</label>
         <input class="add-class-input" type="password" name="password">

         <label for="Class Teacher">Confirm Password</label>
         <input class="add-class-input" type="password" name="conpassword">

       </div>
       <div>
         <input class="savebtn" type="submit" value="Save">
       </div>
     </div>
   </form>
   <?php include('include/head.php'); ?>