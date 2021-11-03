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
      <form action="<?php echo FRONT_ROOT?>JobOffer/Remove" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">JobOffer Id</th>
              <th style="width: 15%;">Publication DATE</th>
              <th style="width: 30%;">Expiration DATE</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 15%;">Skills</th>
              <th style="width: 15%;">Tasks</th>
              <th style="width: 15%;">JobPositionId</th>
              <th style="width: 15%;">CompanyId</th>
              <th style="width: 15%;">Career id</th> 
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
                    <td><?php echo $jobOffer->getJobPositionId() ?></td>
                    <td><?php echo $jobOffer->getCompanyId() ?></td>
                    <td><?php echo $jobOffer->getCareerId() ?></td>
                    <td><?php echo $jobOffer->getActive() ?></td>
                    <td>
                      <button type="submit" name="id" class="btn" value="<?php echo $jobOffer->getJobOfferId() ?>"> Remove </button>
                    </td>
                  </tr>
                <?php
              }
            ?> 
          </tbody>
        </table></form> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>