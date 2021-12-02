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
      <form action="<?php echo FRONT_ROOT?>JobOffer/GenerarPdf" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">JobOffer Id</th>
              <th style="width: 15%;">Publication DATE</th>
              <th style="width: 30%;">Expiration DATE</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 15%;">Skills</th>
              <th style="width: 15%;">Tasks</th>
              <th style="width: 15%;">JobPosition</th>
              <th style="width: 15%;">Company</th>
              <th style="width: 15%;">Career</th> 
              <th style="width: 15%;">Active</th>
            </tr>
          </thead>
          <tbody>
          <?php
              foreach($jobOfferList as $jobOffer)
              {
                ?>
                  <tr>
                    <td><?php echo $jobOffer->getJobOfferId() ?></td>
                    <td><?php echo $jobOffer->getPublicationDate() ?></td>
                    <td><?php echo $jobOffer->getExpiryDate() ?></td>
                    <td><?php echo $jobOffer->getDescription() ?></td>
                    <td><?php echo $jobOffer->getSkills() ?></td>
                    <td><?php echo $jobOffer->getTasks() ?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getDescription() ?></td>
                    <td><?php echo $jobOffer->getCompany()->getDescription() ?></td>
                    <td><?php /*echo $jobOffer->getJobPosition()->getCareer()->getDescription() */?></td>
                    <td><?php echo $jobOffer->getActive() ?></td>
                    <td>
                      <button type="submit" name="id" class="btn" value="<?php echo $jobOffer->getJobOfferId() ?>"> Generar Pdf </button>
                    </td> 
                  </tr>
                <?php
              }
            ?> 
          </tbody>
        </table></form>
        <?php foreach ($jobOfferList as $jobOffer) {
          $userList = $jobOffer->getApplicants();
          ?>
        <?php if($userList != null) { ?> 
          <div>
            <table>
              <thead>
                <tr>
                  <th>
                    Alumnos postulados a la JobOffer: <?php echo  $jobOffer->getJobOfferId()?>
                    -> company: <?php echo $jobOffer->getCompany()->getDescription() ?>
                    -> JobPosition: <?php echo $jobOffer->getJobPosition()->getDescription() ?>
                </th>
                </tr>
              </thead>
            </table>
            <?php /*<h4>Alumnos postulados a la JobOffer: <?php echo  $jobOffer->getJobOfferId()?></h4>*/ ?>
            <table style="text-align:center;">
          <thead>
            <tr>
             <!-- <th style="width: 15%;">JobOfferId</th> -->
              <th style="width: 15%;">Student Id</th>
              <th style="width: 30%;">File Number</th>
              <th style="width: 30%;">Name</th>
              <th style="width: 15%;">Surname</th>
              <th style="width: 15%;">Email</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach($userList  as $user)
                {
                  ?>
                    <tr>
                     <!-- <td>< //?php echo $jobOffer->getJobOfferId() ?></td> -->
                      <td><?php echo $user->getUserId() ?></td>
                      <td><?php echo $user->getFileNumber() ?></td>
                      <td><?php echo $user->getName() ?></td>
                      <td><?php echo $user->getSurname() ?></td>
                      <td><?php echo $user->getEmail() ?></td>
                    </tr> 
                
                  <?php
                }
              ?> 
          </tbody>
        </table></div>
        <?php }?>
        <?php }?>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>