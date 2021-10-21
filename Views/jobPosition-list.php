<?php

use Models\JobPosition;

include('header.php');
    include('nav-bar.php');
    require_once('validate-session.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
    <div class="content"> 
      <div class="scrollable">
      <form action="<?php echo FRONT_ROOT?>JobPosition/ReloadJson" method="">
        
            
        <button type="submit" name="id" class="btn" value=""> RECARGAR Json </button> 
                 
      </form>
      <form action="<?php echo FRONT_ROOT?>" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">JobPositionId</th>
              <th style="width: 30%;">Carreer Id</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 30%;">Action - no activada - </th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach($jobPositionList as $value){
                  ?>
                    <tr>
                      <td><?php echo $value->getJobPositionId() ?></td>
                      <td><?php echo $value->getCareerId() ?></td>
                      <td><?php echo $value->getDescription() ?></td>
                      <td>
                        <!-- <button type="submit" name="id" class="btn" value="<?php echo $value->getJobPositionId() ?>"> Remove </button>-->
                      </td>
                      
                    </tr>
                    
                <?php }
              ?> 
          </tbody>
        </table>
      </form> 
      </div>
    </div>
  </main>
</div>
<?php 
    include_once('footer.php');
?>