<?php 

    include('header.php');
    include('nav-bar.php');
    require_once('validate-session.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
      <form action="<?php echo FRONT_ROOT?>JobOffer/ListStudentsByJobOffer" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">JobOffer Id</th>
              <th style="width: 15%;">Publication DATE</th>
              <th style="width: 30%;">Expiration DATE</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 15%;">Skills</th>
              <th style="width: 15%;">Tasks</th>
              <th style="width: 15%;">Flyer</th>
              <th style="width: 15%;">JobPosition</th>
              <th style="width: 15%;">Company</th>
              <th style="width: 15%;">Career</th> 
              <th style="width: 15%;">Active</th>
            </tr>
          </thead>
          <tbody>
          <?php $jobOffer=$_SESSION["jobOfferUser"] ?>
                  <tr>
                  <?php $rute='../Uploads/'.$jobOffer->getFlyer();//ruta para mostrar el flyer?>
                    <td><?php echo $jobOffer->getJobOfferId() ?></td>
                    <td><?php echo $jobOffer->getPublicationDate() ?></td>
                    <td><?php echo $jobOffer->getExpiryDate() ?></td>
                    <td><?php echo $jobOffer->getDescription() ?></td>
                    <td><?php echo $jobOffer->getSkills() ?></td>
                    <td><?php echo $jobOffer->getTasks() ?></td>
                    <td><?php echo "<img src='$rute'"?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getDescription() ?></td>
                    <td><?php echo $jobOffer->getCompany()->getDescription() ?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getCareer()->getDescription() ?></td>
                    <td><?php echo $jobOffer->getActive() ?></td>
                  </tr>
        
          </tbody>
        </table></form>
        <?php if($userList != null) { ?> 
            <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">User Id</th>
              <th style="width: 30%;">File Number</th>
              <th style="width: 30%;">Name</th>
              <th style="width: 15%;">Surname</th>
              <th style="width: 15%;">Email</th>
              <th style="width: 10%;">Postulacion activa</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach($userList as $user)
                {
                  ?>
                    <tr>
                      <td><?php echo $user->getUserId() ?></td>
                      <td><?php echo $user->getFileNumber() ?></td>
                      <td><?php echo $user->getName() ?></td>
                      <td><?php echo $user->getSurname() ?></td>
                      <td><?php echo $user->getEmail() ?></td>
                      <td><?php if($user->getPostulated()==1){
                        echo "SI";
                      } else {
                        echo "NO";
                      } ?></td>
                    </tr> 
                
                  <?php
                }
              ?> 
          </tbody>
        </table>
        <?php }?>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>