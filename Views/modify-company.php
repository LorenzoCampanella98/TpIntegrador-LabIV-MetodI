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
        <h2>Modify Company</h2>
        <form action="<?php echo FRONT_ROOT?> Company/Modify" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Id</th>
                <th>Address</th>
                <th>Name</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="number" name="id" size="22" min="0" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="address" size="22" min="0" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="name" size="22" min="0" required>
                </td>
                <td>
                  <input type="radio" id="active" name="active" value=1> <!--active envio 1-->
                  <label for="contactChoice1">Activate</label>
                  <input type="radio" id="active" name="active" value=0> <!--desactived envio 0-->
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
              <th style="width: 15%;">Company Id</th>
              <th style="width: 30%;">Cuit</th>
              <th style="width: 30%;">Address</th>
              <th style="width: 15%;">name</th>
              <th style="width: 15%;">Status</th>
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