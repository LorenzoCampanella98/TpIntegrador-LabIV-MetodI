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
                <th>Address</th>
                <th>Name</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="number" name="cuit" size="22" min="0" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="Address" name="address" size="22" min="0" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="Name" name="name" size="22" min="0" required>
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