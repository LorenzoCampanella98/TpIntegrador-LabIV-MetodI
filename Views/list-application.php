<?php

use Models\Application;

include('header.php');
    include('nav-bar.php');
    require_once('validate-session.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
    <div class="content"> 
      <div class="scrollable">
      <?php if($applicationList!=null) { ?>
      <form action="<?php echo FRONT_ROOT?> Application/BajaAplication" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Application Id</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="number" name="id" size="22" min="0" maxlength="29" required>
                </td>      
              </tr>
            </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Dar de Baja" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
      <form action="<?php echo FRONT_ROOT?>JobOffer/SearchForApplications" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Application ID</th>
              <th style="width: 15%;">Date</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 30%;">JobOffer Description</th>
              <th style="width: 15%;">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach($applicationList as $application)
                {
                  ?>
                    <tr>
                      <td><?php echo $application->getApplicationId() ?></td>
                      <td><?php echo $application->getApplicationDate() ?></td>
                      <td><?php echo $application->getDescription() ?></td>
                      <td><?php echo $application->getJobOffer()->getDescription() ?></td>
                      <td><?php echo $application->getActive() ?></td>
                      <td>
                      <button type="submit" name="id" class="btn" value="<?php echo $application->getjobOffer()->getJobOfferId() ?>"> VER </button> <!-- USO LA BUSQUEDA POR NAME PERO DE LA SELECCIONADA-->
                      </td>
                    </tr>
                  <?php
                }
              ?> 
          </tbody>
        </table>
      </form>
      <?php } else { ?>
        <div>
          <tr>
          <th style="width: 75%;"><?php echo "AUN NO HAS APLICADO A NINGUNA JOB OFFER"  ?></th>
          </tr>
        </div>
      <?php } ?>
      </div>
      <?php if ($jobOffer!=null) { ?>
        
      <table style="text-align:center;">
          <thead>
          <tr>
              <th style="width: 20%;">JobOffer Id</th>
              <th style="width: 20%;">Publication DATE</th>
              <th style="width: 30%;">Expiration DATE</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 25%;">Skills</th>
              <th style="width: 25%;">Tasks</th>
              <th style="width: 25%;">Job Position</th>
              <th style="width: 25%;">Company</th>
              <th style="width: 25%;">Career</th> 
              <th style="width: 25%;">Active</th>
              </tr>
          </thead>
          <tbody>
            <tr>
                    <td><?php echo $jobOffer->getJobOfferId() ?></td>
                    <td><?php echo $jobOffer->getPublicationDate() ?></td>
                    <td><?php echo $jobOffer->getExpiryDate() ?></td>
                    <td><?php echo $jobOffer->getDescription() ?></td>
                    <td><?php echo $jobOffer->getSkills() ?></td>
                    <td><?php echo $jobOffer->getTasks() ?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getDescription() ?></td>
                    <td><?php echo $jobOffer->getCompany()->getName() ?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getCareer()->getDescription() ?></td>
                    <td><?php echo $jobOffer->getActive() ?></td>
            </tr>
          </tbody>
        </table>
        <?php } ?>
        <?php if(isset($message)) {?>
          <table>
            <tr>
              <th>
              <th style="width: 100%;"><?php echo $message  ?></th>
              </th>
            </tr>
          </table>
        <?php  }?>
    </div>
  </main>
</div>
<?php 
    include_once('footer.php');
?>