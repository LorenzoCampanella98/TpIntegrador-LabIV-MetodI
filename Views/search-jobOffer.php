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
        <h2>Search JobOffer</h2>
        <form action="<?php echo FRONT_ROOT?> JobOffer/FilterByCareer" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
        <table> 
            <thead>
              <tr>
                <th>Career</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
              <td >  <select name="text">  
                <?php 
              foreach($careerList as $value)
              {
                
                ?>
                  <option 
                    value="<?php echo $value["description"];?>"><?php echo $value["description"];?>
                  </option>
                <?php   
              }
            ?> 
                </td></select> 
                <td>
                
                    <input type="submit" class="btn" value="Search" style="background-color:#DC8E47;color:white;"/>
                  
                </td>     
              </tr>
            </tbody>
          </table>
        </form>
        <form action="<?php echo FRONT_ROOT?> JobOffer/FilterByJobPosition" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
        <table> 
            <thead>
              <tr>
                <th>JobPosition</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
              <td >  <select name="text">  
                <?php 
              foreach($jobPositionList as $value)
              {
                
                ?>
                  <option 
                    value="<?php echo $value["description"];?>"><?php echo $value["description"];?>
                  </option>
                <?php   
              }
            ?> 
                </td></select> 
                <td>
                
                    <input type="submit" class="btn" value="Search" style="background-color:#DC8E47;color:white;"/>
                  
                </td>     
              </tr>
            </tbody>
          </table>
        </form>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
      <div class="content"> 
        <div class="scrollable">
          <form action="<?php echo FRONT_ROOT?>Application/Add" method="">
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
                    <?php if ( $_SESSION["loggedUser"]->getName()!="admin" && $_SESSION["loggedUser"]->getPostulated()==0 && $jobPosition != null) { //solo si el user no es admin se puede aplicar?>
                      
                      <td>
                        <button type="submit" name="id" class="btn" value="<?php echo $jobOffer->getJobOfferId() ?>"> Apply </button>
                      </td>
                    
              <tr style="max-width: 120px;">
                <th>Description</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                <input type="text" name="description" size="22" min="0" required>
                </td>      
              </tr>
              <input type="text" name="studentId" size="22" min="0" value="<?php echo $_SESSION["loggedUser"]->getStudentId() ?>"  style="visibility:hidden">
                    <?php }?>
              </tr>
            </tbody>
          </table>
          </form>
          <form action="<?php echo FRONT_ROOT?>JobOffer/Search" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 40%;">Description</th>
              <th style="width: 20%;">Skills</th>
              <th style="width: 20%;">Tasks</th>
              <th style="width: 40%;">Expiration Date</th>
            </tr>
          </thead>
          <tbody>
          <?php
              foreach($jobOfferList as $value)
              {
                  if($value->getActive()==1)
                  {

                 
                ?>
                  <tr>
                    <td><?php echo $value->getDescription() ?></td>
                    <td><?php echo $value->getSkills() ?></td>
                    <td><?php echo $value->getTasks() ?></td>
                    <td><?php echo $value->getExpiryDate() ?></td>
                    <td>
                      <button type="submit" name="id" class="btn" value="<?php echo $value->getJobOfferId() ?>"> Select </button> <!-- USO LA BUSQUEDA POR NAME PERO DE LA SELECCIONADA-->
                    </td>
                  </tr>
                <?php }
              }
            ?> 
          </tbody>
        </table>
      </form> 
        </div>
      </div>
    </div>
  </main>
</div>





<?php 
    include_once('footer.php');
?>