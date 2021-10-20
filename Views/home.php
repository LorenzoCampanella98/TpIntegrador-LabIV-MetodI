<?php 
  
    include_once('header.php');
    if(isset($_SESSION["loggedUser"]))
    {
      include_once('nav-bar.php');
    }
?>
<?php 
  if(!isset($_SESSION["loggedUser"]))
  { ?>
    <div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
      <div class="overlay">
        <div id="breadcrumb" class="clear"> 
          <ul>
            <li><a href="#">WELLCOME</a></li>
          </ul>
        </div>
      </div>
    </div>
<!-- #######################################################################3 -->
<div class="wrapper row4">
<main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
        <div class="wrapper row3 img-login">
        <div class="div-login"><br>
          <h1 class="text-login">LOGIN</h1>
        </div>
      <div class="div-login">  
        <form action="<?php echo FRONT_ROOT."Home/Login" ?>" method="post">
          <input class="input-login" type="text" name="username" placeholder="Email" required>
          <input class="input-login" type="password" name="password" placeholder="phone number" required >
          <button class="btn-login btn" type="submit" name="btnLogin">Ingresar</button>
        </form>
      </div>
      </div> <?php 
    } else { 
      $student_actual=$_SESSION["loggedUser"]; //Guardo el session en student para mostrarlo?>
      <div class="hoc container clear">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Student Id</th>
              <th style="width: 30%;">Carreer Id</th>
              <th style="width: 30%;">First Name</th>
              <th style="width: 15%;">Last Name</th>
              <th style="width: 10%;">DNI</th>
              <th style="width: 10%;">fileNumber</th>
              <th style="width: 10%;">Gender</th>
              <th style="width: 10%;">birthDate</th>
              <th style="width: 10%;">Email</th>
              <th style="width: 10%;">PhoneNumber</th>
              <th style="width: 10%;">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $student_actual->getStudentId() ?></td>
              <td><?php echo $student_actual->getCareerId() ?></td>
              <td><?php echo $student_actual->getFirstName() ?></td>
              <td><?php echo $student_actual->getLastName() ?></td>
              <td><?php echo $student_actual->getDni() ?></td>
              <td><?php echo $student_actual->getFilenumber() ?></td>
              <td><?php echo $student_actual->getGender() ?></td>
              <td><?php echo $student_actual->getbirthDate() ?></td>
              <td><?php echo $student_actual->getEmail() ?></td>
              <td><?php echo $student_actual->getPhoneNumber() ?></td>
              <td><?php echo $student_actual->getActive() ?></td>
              </tr>
          </tbody>
        </table>
      </div>  
  <?php } ?>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

    

