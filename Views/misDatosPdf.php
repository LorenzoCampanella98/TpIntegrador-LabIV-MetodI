<html>


<body>
<table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Student Id</th>
              <th style="width: 30%;">file Number</th>
              <th style="width: 30%;">Name</th>
              <th style="width: 15%;">Surname</th>
              <th style="width: 15%;">Email</th>
              <th style="width: 10%;">postulated</th>
            </tr>
          </thead>
          <tbody>
            <?php
                foreach($userList as $user)
                {
                  if($user->getTypeUserId() == 1)
                  {
                  ?>
                    <tr>
                      <td><?php echo $user->getUserId() ?></td>
                      <td><?php echo $user->getFileNumber() ?></td>
                      <td><?php echo $user->getName() ?></td>
                      <td><?php echo $user->getSurname() ?></td>
                      <td><?php echo $user->getEmail() ?></td>
                      <td><?php echo $user->getPostulated() ?></td>   
                      <td>
                      <button type="submit" name="id" class="btn" value="<?php echo $user->getUserId() ?>"> Remove </button>
                      </td>
            
                    </tr> 
                
                  <?php
                  }
                }
              ?> 
          </tbody>
        </table>
</body>
</html>