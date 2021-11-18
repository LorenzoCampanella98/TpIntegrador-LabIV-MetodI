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
        <?php if(isset($message)) {?>
          <table>
              <thead>
                <tr><th><?php echo $message?></th></tr>
                <tr><th><?php echo $message1?></th></tr>
                <tr><th><?php echo $message2?></th></tr>
              </thead>
            </table>
        <?php } else { ?>
        <?php if ($applicationList!=null) {?>
      <form action="<?php echo FRONT_ROOT?>Application/Declinar" method="">
        <table style="text-align:center;">
          <thead>
          <tr>
              <th style="width: 15%;">Application ID</th>
              <th style="width: 15%;">Student</th>
              <th style="width: 15%;">Date</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 30%;">JobOffer Description</th>
              <th style="width: 30%;">CV</th>
              <th style="width: 15%;">Status</th>
            </tr>
          </thead>
          <tbody>
          <?php
              foreach($applicationList as $company)
              {
                ?>
                  <tr>
                      <td><?php echo $application->getApplicationId() ?></td>
                      <td><?php echo $application->getUser()->getName() ?></td>
                      <td><?php echo $application->getApplicationDate() ?></td>
                      <td><?php echo $application->getDescription() ?></td>
                      <td><?php echo $application->getJobOffer()->getDescription() ?></td>
                      <td><?php echo $application->getCv() ?></td>
                      <td><?php echo $application->getActive() ?></td>
                      <input type="text" name="id" value="<?php echo $application->getApplicationId(); ?>" style="visibility:hidden">
                      <input type="text" name="userId" value="<?php echo $application->getUser()->getUserId(); ?>" style="visibility:hidden">
                    <td>
                      <button type="submit"  class="btn"> Declinar </button>
                    </td>
                  </tr>
                <?php
              }
            ?> 
          </tbody>
        </table></form> 
        <?php } else { ?>
        <table>
         <tr>
              <th style="width: 25%;"><?php echo "No existen Applicaciones activas"  ?></th>
         </tr>
      </table>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>