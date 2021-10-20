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
        <h2>Search Company</h2>
        <form action="<?php echo FRONT_ROOT?> Company/Search" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Name</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="text" name="name" size="22" min="0" required>
                </td>      
              </tr>
            </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Search" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
      <div class="content"> 
        <div class="scrollable">
          <table style="text-align:center;">
            <thead>
              <tr>
                <th style="width: 15%;">Company Id</th>
                <th style="width: 30%;">Cuit</th>
                <th style="width: 30%;">Address</th>
                <th style="width: 15%;">name</th>
                <th style="width: 15%;">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                  <td><?php echo $company->getCompanyId()?></td>
                  <td><?php echo $company->getCuit() ?></td>
                  <td><?php echo $company->getAddress()?></td>
                  <td><?php echo $company->getName()?></td>
                  <td><?php echo $company->getActive()?></td>
                  <td><?php  ?></td>
              </tr>
            </tbody>
          </table>
          <form action="<?php echo FRONT_ROOT?>Company/Search" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 40%;">Company Id</th>
              <th style="width: 40%;">name</th>
              <th style="width: 20%;">Select</th>
            </tr>
          </thead>
          <tbody>
          <?php
              foreach($companyList as $company)
              {
                ?>
                  <tr>
                    <td><?php echo $company->getCompanyId() ?></td>
                    <td><?php echo $company->getName() ?></td>
                    <td>
                      <button type="submit" name="id" class="btn" value="<?php echo $company->getName() ?>"> Select </button> <!-- USO LA BUSQUEDA POR NAME PERO DE LA SELECCIONADA-->
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
    </div>
  </main>
</div>





<?php 
    include_once('footer.php');
?>