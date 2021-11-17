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
        <h2>Add ADMIN</h2>
        <form action="<?php echo FRONT_ROOT?> User/AddAdmin" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Name</th>
                <th>File Number</th>
                <th>Surname</th>
                <th>Password</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="text" name="name" size="22" min="0" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="fileNumber" size="22" min="0" maxlength="29" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="surname" size="22" min="0" maxlength="29" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="password" size="22" min="0" maxlength="29" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="email" name="email" size="22" min="0" maxlength="29" required>
                </td>           
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