<?php
    include('header.php');
    include('nav-bar.php');
    require_once('validate-session.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
    <div class="content"> 
      <div class="scrollable">
      <form action="<?php echo FRONT_ROOT?>Student/ReloadJson" method="">
        
            
        <button type="submit" name="id" class="btn" value=""> RECARGAR Json </button> 
                 
      </form>
      <form action="<?php echo FRONT_ROOT?>Student/Remove" method="">
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
            <?php
                foreach($studentList as $student)
                {
                  ?>
                    <tr>
                      <td><?php echo $student->getStudentId() ?></td>
                      <td><?php echo $student->getCareerId() ?></td>
                      <td><?php echo $student->getFirstName() ?></td>
                      <td><?php echo $student->getLastName() ?></td>
                      <td><?php echo $student->getDni() ?></td>
                      <td><?php echo $student->getFilenumber() ?></td>
                      <td><?php echo $student->getGender() ?></td>
                      <td><?php echo $student->getbirthDate() ?></td>
                      <td><?php echo $student->getEmail() ?></td>
                      <td><?php echo $student->getPhoneNumber() ?></td>
                      <td><?php echo $student->getActive() ?></td>
                      <td>
                    <!--   <button type="submit" name="id" class="btn" value="<?php echo $student->getStudentId() ?>"> Remove </button> NO SE PUEDEN MODIFICAR LOS STATUS PORQUE VIENE DE LA API -->
                      </td>
                    </tr>
                  <?php
                }
              ?> 
          </tbody>
        </table>
      </form> 
      </div>
    </div>
  </main>
</div>
<?php 
    include_once('footer.php');
?>