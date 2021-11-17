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
        <h2>Add Company</h2>
        <form action="<?php echo FRONT_ROOT?> Company/Add" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Cuit</th>
                <th>Name</th>
                <th>Link</th>
                <th>About Us</th>
                <th>description</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="number" name="cuit" size="22" min="0" required>
                </td>
                <?php if($_SESSION["loggedUser"]->getTypeUserId()==3) { ?>
                <td style="max-width: 120px;">    
                  <input type="text" name="name" value="<?php echo $_SESSION["loggedUser"]->getName();?>" placeholder="<?php echo $_SESSION["loggedUser"]->getName();?>" size="22" min="0" maxlength="29" disabled>
                  <input type="text" name="name" value="<?php echo $_SESSION["loggedUser"]->getName();?>" size="22" min="0" maxlength="29" style="visibility:hidden">
                </td>
                <?php } else { ?>
                  <td>
                    <input type="text" name="name" size="22" min="0" maxlength="29" required>
                  </td>
                <?php } ?>
                <td style="max-width: 120px;">    
                  <input type="text" name="company_link" size="22" min="0" maxlength="29" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="aboutUs" size="22" min="0" maxlength="29" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="description" size="22" min="0" maxlength="29" required>
                </td>           
              </tr>
              <tr>
                <?php if($message !=null) {?>
                  <input type="submit" class="btn" value="<?php echo $message ?>" style="background-color:#DC8E47;color:red;" disabled/>
                  <?php } ?>
              </tr>
            </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Agregar" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
<?php 
    include_once('footer.php');
?>