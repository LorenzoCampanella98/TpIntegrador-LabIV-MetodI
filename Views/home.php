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
          <input class="input-login" type="text" name="email" placeholder="Email"  required>
          <input class="input-login" type="password" name="password" placeholder="Pass" maxlength="29" required >
          <button class="btn-login btn" type="submit" name="btnLogin">Ingresar</button>
        </form>
      </div>
      <div class="div-login"> <!-- para el registro -->  
      <a class="btn-login btn" href="<?php echo  FRONT_ROOT."Student/ShowAddView "?>">REGISTRARSE-User</a>
      <a class="btn-login btn" href="<?php echo  FRONT_ROOT."Student/ShowAddViewUserCompany "?>">REGISTRARSE-Company</a>
      <?php if(isset($message)) {?>
      <table>
         <tr>
              <th style="width: 25%;"><?php echo "SYSTEM: "  ?></th>
              <th style="width: 75%;"><?php echo $message  ?></th>
              
          </tr>
      </table>
        <?php } ?>
      </div>
      </div>
      
      
      <?php 
    } else { 
      $student_actual=$_SESSION["loggedUser"]; //Guardo el session en student para mostrarlo?>
      <div class="hoc container clear">
      <h2>Me</h2>
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Student Id</th>
              <th style="width: 30%;">file Number</th>
              <th style="width: 30%;">Name</th>
              <th style="width: 15%;">Surname</th>
              <th style="width: 15%;">Email</th>
              <th style="width: 15%;">Password</th>
              <th style="width: 10%;">postulated</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $student_actual->getStudentId() ?></td>
              <td><?php echo $student_actual->getFileNumber() ?></td>
              <td><?php echo $student_actual->getName() ?></td>
              <td><?php echo $student_actual->getSurname() ?></td>
              <td><?php echo $student_actual->getEmail() ?></td>
              <td><?php echo $student_actual->getPassword() ?></td>
              <td><?php echo $student_actual->getPostulated() ?></td>
              </tr>
          </tbody>
        </table>
      </div>
      <?php if(isset($_SESSION["companyUser"])) { 
        $company = $_SESSION["companyUser"];?>
        <div class="hoc container clear">
      <h2>My Company</h2>
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Name</th>
              <th style="width: 30%;">Cuit</th>
              <th style="width: 30%;">Link</th>
              <th style="width: 15%;">About</th>
              <th style="width: 15%;">Description</th>
              <th style="width: 15%;">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
                    <td><?php echo $company->getName() ?></td>
                    <td><?php echo $company->getCuit() ?></td>
                    <td><?php echo $company->getCompanyLink() ?></td>
                    <td><?php echo $company->getAboutUs() ?></td>
                    <td><?php echo $company->getDescription() ?></td>
                    <td><?php echo $company->getActive() ?></td>
              </tr>
          </tbody>
        </table>
      </div>
      <?php }?>
      <?php if(isset($_SESSION["jobOfferUser"])) {?>
       <?php $jobOffer = $_SESSION["jobOfferUser"];?>
            <div class="hoc container clear">
            <h2>My JobOffer</h2>
              <table style="text-align:center;">
                <thead>
                  <tr>
                    <th style="width: 15%;">Publication DATE</th>
                    <th style="width: 30%;">Expiration DATE</th>
                    <th style="width: 30%;">Description</th>
                    <th style="width: 15%;">Skills</th>
                    <th style="width: 15%;">Tasks</th>
                    <th style="width: 15%;">JobPositio Desc</th>
                    <th style="width: 15%;">Company</th>
                    <th style="width: 15%;">Career Desc</th> 
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $jobOffer->getPublicationDate() ?></td>
                    <td><?php echo $jobOffer->getExpiryDate() ?></td>
                    <td><?php echo $jobOffer->getDescription() ?></td>
                    <td><?php echo $jobOffer->getSkills() ?></td>
                    <td><?php echo $jobOffer->getTasks() ?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getDescription() ?></td>
                    <td><?php echo $jobOffer->getCompany()->getName() ?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getCareer()->getDescription() ?></td>
                    </tr>
                </tbody>
              </table>
            </div>
      <?php }?>
      
  <?php } ?>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

    

