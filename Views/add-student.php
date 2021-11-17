
<nav id="mainav" class="fl_right">
      <ul class="clear">
        <!--SOLO HOME-->
      <li><a href="<?php echo  FRONT_ROOT."Home/Index "?>">HOME</a></li>
      </ul>
    </nav>
<div class="wrapper row4">
<main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
        <div class="wrapper row3 img-login">
        <div class="div-login"><br>
          <h1 class="text-login">REGISTRO</h1>
        </div>
      <div class="div-login">  
        <form action="<?php echo FRONT_ROOT."User/Register" ?>" method="post">
          <input class="input-login" type="text" name="email" placeholder="email" maxlength="29" required>
          <input class="input-login" type="text" name="pass" placeholder="pass" maxlength="29" required>
          <button class="btn-login btn" type="submit" name="btnLogin">REGISTRARSE</button>
        </form>
      </div>
      </div> 
    
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>


