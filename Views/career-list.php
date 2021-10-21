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
      <form action="<?php echo FRONT_ROOT?>Career/LoadBd" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">CAREER</th>
              
            </tr>
          </thead>
          <tbody> 
              <button type="submit" name="id" class="btn" value=""> Recargar Json </button> 
          </tbody>
        </table>
      </form>
      <form action="<?php echo FRONT_ROOT?> " method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Career ID</th>
              <th style="width: 30%;">Description</th>
              <th style="width: 30%;">Status</th>
              <th style="width: 30%;">action - desactivado</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach($careerList as $value)
                {
                  ?>
                    <tr>
                      <td><?php echo $value->getCareerId() ?></td>
                      <td><?php echo $value->getDescription() ?></td>
                      <td><?php echo $value->getActive() ?></td>
                      <td>
                    <!--   <button type="submit" name="id" class="btn" value="<?php echo $value->getCareerId()  ?>"> Remove </button> NO SE PUEDEN MODIFICAR LOS STATUS PORQUE VIENE DE LA API -->
                      </td>
                    </tr>
                  <?php
                }
              ?> 
          </tbody>
        </table>
      </form>  
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>