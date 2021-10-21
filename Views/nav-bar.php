<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
      <h1>TP FINAL</h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <!--SOLO HOME-->
      <li><a href="<?php echo  FRONT_ROOT."Home/Index "?>">HOME</a></li>
      </ul>
    </nav>
    <?php if($_SESSION["loggedUser"]->getFirstName()=="admin"){ // MENU FILTRADO SOLO PARA ADMINS?> 
    <nav id="mainav" class="fl_right">
      <ul class="clear">
          <li class="active"><a class="drop" href="#">Student</a>
            <ul>
              <!-- PARA STUDENT-->
             <!-- <li><a href="<?php echo  FRONT_ROOT."Student/ShowAddView "?>">ADD</a></li> DESACTIVADA LA CREACION DE ALUMNOS -->
              <li><a href="<?php echo  FRONT_ROOT."Student/ShowListView "?>">LIST</a></li>
            </ul>
          </li>
      </ul>
    </nav>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
          <li class="active"><a class="drop" href="#">Career</a>
            <ul>
              <!-- PARA Careers-->
             <!-- <li><a href="<?php echo  FRONT_ROOT."Student/ShowAddView "?>">ADD</a></li> DESACTIVADA LA CREACION DE ALUMNOS -->
              <li><a href="<?php echo  FRONT_ROOT."Career/ShowListView "?>">LIST</a></li>
            </ul>
          </li>
      </ul>
    </nav>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
          <li class="active"><a class="drop" href="#">JobPosition</a>
            <ul>
              <!-- PARA JobPosition-->
  
              <li><a href="<?php echo  FRONT_ROOT."JobPosition/ShowListView "?>">LIST</a></li>
            </ul>
          </li>
      </ul>
    </nav>
    <?php } ?>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
          <li class="active"><a class="drop" href="#">Company</a>
            <ul>
              <!--PARA COMPANY-->
              <?php if($_SESSION["loggedUser"]->getFirstName()=="admin"){ // PRUEBA DE FUNCIONES SOLO PARA ADMIN EN EL NAVBAR?>
                <li><a href="<?php echo  FRONT_ROOT."Company/ShowAddView "?>">ADD</a></li>
                <li><a href="<?php echo  FRONT_ROOT."Company/ShowModifyView "?>">MODIFY</a></li>
                <li><a href="<?php echo  FRONT_ROOT."Company/ShowListView "?>">LIST / status</a></li>
              <?php } ?>
              <li><a href="<?php echo  FRONT_ROOT."Company/ShowSearchView "?>">SEARCH</a></li>
              
              
            </ul>
          </li>
      </ul>
    </nav>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
          <li class="active"><a class="drop" href="#">Others</a>
            <ul>
              <!-- PARA OTROS-->
              <li><a href="<?php echo  FRONT_ROOT."Home/Logout "?>">LOGOUT</a></li>
            </ul>
          </li>
      </ul>
    </nav>
  </header>
</div>