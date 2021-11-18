<?php

use Models\JobOffer;

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
        <form action="<?php echo FRONT_ROOT?> JobOffer/FilterByCareer" method="post" enctype="multipart/form-data" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Career</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="text" name="text" size="22" min="0" maxlength="29" required>
                </td>      
              </tr>
            </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Search" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
        <form action="<?php echo FRONT_ROOT?> JobOffer/FilterByJobPosition" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Job Position</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="text" name="text" size="22" min="0" maxlength="29" required>
                </td>      
              </tr>
            </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Search" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>

    </div>
    <!-- / main body -->
    
    <div class="clear"></div>
      <div class="content"> 
        <div class="scrollable">
         <?php /* <form action="<?php echo FRONT_ROOT?>Application/" method="POST" enctype="multipart/form-data"> */?>
          <?php if($jobOffer->getJobOfferId()!=null) {?>
            <table style="text-align:center;">
            <thead>
              <tr>
              <th style="width: 20%;">JobOffer Id</th>
              <th style="width: 20%;">Publication DATE</th>
              <th style="width: 30%;">Expiration DATE</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 25%;">Skills</th>
              <th style="width: 25%;">Tasks</th>
              <th style="width: 25%;">Job Position Desc</th>
              <th style="width: 25%;">Company</th>
              <th style="width: 25%;">Career Desc</th> 
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
                    <td><?php echo $jobOffer->getJobPosition()->getDescription()?></td>
                    <td><?php echo $jobOffer->getCompany()->getName()?></td>
                    <td><?php echo $jobOffer->getJobPosition()->getCareer()->getDescription()?></td>
                    <td><?php echo $jobOffer->getActive() ?></td>
              </tr>
            </tbody>
            </table>
                    <?php /* if ( $_SESSION["loggedUser"]->getTypeUserId()==1 && $_SESSION["loggedUser"]->getPostulated()==0) { //solo si el user no es admin se puede aplicar?>
              </tr>
            </tbody>
            </table>
            <?php 
            <table>
              <tr>
               <th>Description</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 500px;">    
                  <input type="text" name="description" size="22" maxlength="29" min="0" required>
                </td>
                <td>
                  <input type="file" name="file" id="file" class="form-control-file" required>
                </td>
               
                   <input type="number" name="userId" size="22" min="0" value="<?php echo $_SESSION["loggedUser"]->getUserId() ?>"  style="visibility:hidden">
                   <input type="number" name="jobOfferId" size="22" min="0" value="<?php  echo $jobOffer->getJobOfferId() ?>"  style="visibility:hidden">
               
                <td>
                  <button type="submit" name="id" class="btn"> Apply </button>
                </td>
             
                    <?php }?>
              
            </tbody>
            </table>
          </table>*/ ?>
          <?php } ?>
          <?php if ($jobOffer->getJobOfferId()!=null && $_SESSION["loggedUser"]->getTypeUserId()==1 && $_SESSION["loggedUser"]->getPostulated()==0) {?>
         <?php // </form> ?>
                     <form action="<?php echo FRONT_ROOT ?>Application/SubirCv" method="POST" enctype="multipart/form-data">
                        <table style="text-align:center;">
                          <?php /* <tr>
                            <th colspan="2"><center><h4>Subir Cv</h4></center></th>
                          </tr> */?>
                          <thead> 
                              <tr>  
                                <th style="width: 50%;">Carga de Cv</th>
                                <th style="width: 50%;">Descripcion</th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><input type="file" name="file" id="file" class="form-control-file" required></td>
                              <td><input type="text" name="description" size="22" maxlength="29" min="0" required></td>
                              <input type="number" name="userId" size="22" min="0" value="<?php echo $_SESSION["loggedUser"]->getUserId() ?>"  style="visibility:hidden">
                              <input type="number" name="jobOfferId" size="22" min="0" value="<?php  echo $jobOffer->getJobOfferId() ?>"  style="visibility:hidden">
                              <td ><center><button type="submit" class="btn btn-success">Aplicar</button><center></td>
                            </tr>
                         </tbody>
                        </table>
                      </form>
          
          <?php // </form> ?>
          <?php } ?>
          <form action="<?php echo FRONT_ROOT?>JobOffer/Search" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 40%;">Job Offer</th>
              <th style="width: 20%;">JobPosition</th>
              <th style="width: 20%;">Company</th>
              <th style="width: 40%;">Career</th>
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
                    <td><?php echo $value->getJobPosition()->getDescription() ?></td>
                    <td><?php echo $value->getCompany()->getName() ?></td>
                    <td><?php echo $value->getJobPosition()->getCareer()->getDescription() ?></td>
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