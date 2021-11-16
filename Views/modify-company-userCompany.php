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
        <form action="<?php echo FRONT_ROOT?> Company/ModifyUserCompany" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Link</th>
                <th>About</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="text" name="company_link" size="22" min="0" maxlength="29" >
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="aboutUs" size="22" min="0" maxlength="29" >
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="description" size="22" min="0" maxlength="29" >
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
              <th style="width: 15%;">Name</th>
              <th style="width: 30%;">Link</th>
              <th style="width: 15%;">About</th>
              <th style="width: 15%;">Description</th>
              <th style="width: 15%;">active</th>
            </tr>
          </thead>
          <tbody>
         <?php $company = $_SESSION["companyUser"]?>
                  <tr>
                    <td><?php echo $company->getCompanyId() ?></td>
                    <td><?php echo $company->getName() ?></td>
                    <td><?php echo $company->getCompanyLink() ?></td>
                    <td><?php echo $company->getAboutUs() ?></td>
                    <td><?php echo $company->getDescription() ?></td>
                    <td><?php echo $company->getActive() ?></td>
                  </tr>

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