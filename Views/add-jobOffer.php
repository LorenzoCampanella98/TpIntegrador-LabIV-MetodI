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
        <h2>Add JobOffer</h2>
        <form action="<?php echo FRONT_ROOT?> JobOffer/subirFlyer" method="post" enctype="multipart/form-data" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Flyer</th>
                <th>Description</th>
                <th>Skills</th>
                <th>Tasks</th>
                <th>JobPosition Us</th>
                <th>Company</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td><input type="file" name="file" id="file" class="form-control-file" required></td>
                <td style="max-width: 120px;">    
                  <input type="text" name="description" size="22" min="0"  maxlength="29" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="skills" size="22" min="0" maxlength="29" required>
                </td>
                <td style="max-width: 120px;">    
                  <input type="text" name="tasks" size="22" min="0" maxlength="29" required>
                </td>
                <td >  <select name="jobPositionId">  
                <?php 
              foreach($jobPositionList as $value)
              {
                
                ?>
                  <option 
                    value="<?php echo $value["jobPositionId"];?>"><?php echo $value["description"];?>
                  </option>
                <?php   
              }
            ?> 
                </td></select>
                <?php if ($_SESSION["loggedUser"]->getTypeUserId()==3) { ?> 
                  <td>
                  <input type="text" name="" value="<?php echo $_SESSION["companyUser"]->getName();?>" size="22" min="0" maxlength="29" disabled>
                  <input type="text" name="companyId" value="<?php echo $_SESSION["companyUser"]->getCompanyId();?>" size="22" min="0"  style="visibility:hidden">
                  </td>
                <?php } else { ?>
                          <td><select name="companyId">
                          <?php 
                        foreach($companyList as $company)
                        {
                          if($company->getActive()==1){
                            ?>
                              <option value="<?php echo $company->getCompanyId(); ?>"><?php echo $company->getName();?></option>
                            
                    <?php   }   
                      }
                    ?> 
                        </td>    </select> 
                <?php }  ?>           
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