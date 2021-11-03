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
      <form action="<?php echo FRONT_ROOT?>JobOffer/SearchForApplications" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Date</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 30%;">JobOfferId</th>
              <th style="width: 15%;">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach($applicationList as $application)
                {
                  ?>
                    <tr>
                      <td><?php echo $application->getApplicationDate() ?></td>
                      <td><?php echo $application->getDescription() ?></td>
                      <td><?php echo $application->getJobOfferId() ?></td>
                      <td><?php echo $application->getActive() ?></td>
                      <td>
                      <button type="submit" name="id" class="btn" value="<?php echo $application->getJobOfferId() ?>"> Select </button> <!-- USO LA BUSQUEDA POR NAME PERO DE LA SELECCIONADA-->
                    </td>
                    </tr>
                  <?php
                }
              ?> 
          </tbody>
        </table>
      </form>
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
                    <td><?php echo $jobPosition["description"] ?></td>
                    <td><?php echo $company->getName() ?></td>
                    <td><?php echo $career["description"] ?></td>
                    <td><?php echo $jobOffer->getActive() ?></td>
            </tr>
          </tbody>
        </table>
        <?php } ?>
    </div>
  </main>
</div>
<?php 
    include_once('footer.php');
?>