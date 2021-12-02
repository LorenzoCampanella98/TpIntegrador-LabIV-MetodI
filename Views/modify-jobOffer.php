<?php 

    include('header.php');
    include('nav-bar.php');
    require_once('validate-session.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row3" >
  <main class="container" style="width: 95%;"> 
    <!-- main body -->
    <div class="content" > 
      <div id="comments" style="align-items:center;">
        <h2>Modify JobOffer</h2>
        <form action="<?php echo FRONT_ROOT?> JobOffer/Modify" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Id</th>
                <th>Description</th>
                <th>Skills</th>
                <th>Tasks</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="number" name="id" size="22" min="0" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="description" size="22" min="0"  maxlength="29" >
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="skills" size="22" min="0"  maxlength="29" >
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="tasks" size="22" min="0" maxlength="29" >
                </td>
                <td>
                  <input type="radio" id="active" name="active" value=1 required> <!--active envio 1-->
                  <label for="contactChoice1">Activate</label>
                  <input type="radio" id="active" name="active" value=0 required> <!--desactived envio 0-->
                  <label for="contactChoice2">Deactivate</label>
                </td>         
              </tr>
            </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Modify" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
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
          <?php
              foreach($jobOfferList as $jobOffer)
              {
                ?>
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
                    <td><?php echo $jobOffer->getCompany()->getName() ?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getCareer()->getDescription() ?></td>
                    <td><?php echo $jobOffer->getActive() ?></td>
                  </tr>
                <?php
              }
            ?> 
          </tbody>
        </table>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>


<?php 
    include_once('footer.php');
?>