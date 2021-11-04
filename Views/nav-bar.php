<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
      <h1>TP FINAL</h1>
    </div>
    
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <!--SOLO LogOut-->
        <li><a href="<?php echo  FRONT_ROOT."Home/Logout "?>">LOGOUT</a></li>
      </ul>
    </nav>
    
    <?php if($_SESSION["loggedUser"]->getName()=="admin"){ // MENU FILTRADO SOLO PARA ADMINS?> 
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
    <?php } ?>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
          <li class="active"><a class="drop" href="#">Company</a>
            <ul>
              <!--PARA COMPANY-->
              <?php if($_SESSION["loggedUser"]->getName()=="admin"){ // PRUEBA DE FUNCIONES SOLO PARA ADMIN EN EL NAVBAR?>
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
          <li class="active"><a class="drop" href="#">JobOffer</a>
            <ul>
              <!--PARA JobOffer-->
              <?php if($_SESSION["loggedUser"]->getName()=="admin"){ // PRUEBA DE FUNCIONES SOLO PARA ADMIN EN EL NAVBAR?>
                <li><a href="<?php echo  FRONT_ROOT."JobOffer/ShowAddView "?>">ADD</a></li>
                <li><a href="<?php echo  FRONT_ROOT."JobOffer/ShowListView "?>">LIST / status</a></li>
                <li><a href="<?php echo  FRONT_ROOT."JobOffer/ShowModifyView "?>">MODIFY</a></li>
              <?php } ?>
              <li><a href="<?php echo  FRONT_ROOT."JobOffer/ShowSearchView "?>">SEARCH</a></li>
            </ul>
          </li>
      </ul>
    </nav>
    <?php if($_SESSION["loggedUser"]->getName()!="admin") { ?>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <!--SOLO APPLICATIONS   -->
      <li><a href="<?php echo  FRONT_ROOT."Application/ShowListView"?>">MyApplications</a></li>
      </ul>
    </nav>
    <?php } ?>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <!--SOLO HOME-->
      <li><a href="<?php echo  FRONT_ROOT."Home/Index "?>">HOME</a></li>
      </ul>
    </nav>
    
  </header>
</div>