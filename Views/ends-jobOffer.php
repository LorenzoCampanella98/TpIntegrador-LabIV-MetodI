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
      <?php if($jobOffersFinalizadas!=null) { ?>  
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
              <th style="width: 15%;">JobPositio Desc</th>
              <th style="width: 15%;">Company</th>
              <th style="width: 15%;">Career Desc</th> 
            </tr>
          </thead>
          <tbody>
          <?php
              foreach($jobOffersFinalizadas as $jobOffer)
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
                    <td><?php echo $jobOffer->getCompany()->getName() ?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getCareer()->getDescription() ?></td>
                  </tr>
                <?php
              }
            ?> 
          </tbody>
        </table></form>
        <?php } else { ?>
            <table>
                <tr>
                    <th style="width: 25%;"><?php echo "No hay nuevas Job Offers Finalizadas"  ?></th>
                </tr>
            </table>
        <?php } ?> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>