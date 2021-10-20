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
      <form action="<?php echo FRONT_ROOT?>Company/ChangeStatus" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Company Id</th>
              <th style="width: 30%;">Cuit</th>
              <th style="width: 30%;">Address</th>
              <th style="width: 15%;">name</th>
              <th style="width: 15%;">Status</th>
              <th style="width: 15%;">Cambiar estado</th>
            </tr>
          </thead>
          <tbody>
          <?php
              foreach($companyList as $company)
              {
                ?>
                  <tr>
                    <td><?php echo $company->getCompanyId() ?></td>
                    <td><?php echo $company->getCuit() ?></td>
                    <td><?php echo $company->getAddress() ?></td>
                    <td><?php echo $company->getName() ?></td>
                    <td><?php echo $company->getActive() ?></td>
                    <td>
                      <button type="submit" name="id" class="btn" value="<?php echo $company->getCompanyId() ?>"> Cambiar </button>
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