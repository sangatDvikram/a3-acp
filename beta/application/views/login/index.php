<div class="section" id="wrapper">
<div class="valign-wrapper">
<div class="container valign center">
<h3>Login </h3> 
<div class="divider"></div>	

<div class="row ">

<div class="col offset-l3 l6 center  s12 white z-depth-1 white">

<div class="row">
  <div class="col s12">
  <?php

  //Errors Will go Here
echo validation_errors();

if(isset($session)){echo "$session";}

  ?>
  </div>
</div> 


<div class="row">
  <form class="col s12" action="<?=current_url()?>" method="post">
    <div class="row">
      <div class="input-field col s12">
        <input id="username" type="text" class="validate" name="username">
        <label for="username">Username</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="password" type="password" class="validate" name="password">
        <label for="password">Password</label>
      </div>
    </div>
    
    <div class="row">
      <div class="input-field col s12">
        <button class="btn waves-effect waves-light" type="submit" name="action">Login
    <i class="mdi-action-lock-open left"></i>
  </button>
  </div>
  <div class="row">
  <div class=" col offset-s1 center s10 ">
	  <span class="left">
	  <input type="checkbox" id="test5" name='remember' />
	    <label for="test5">Remember Me</label>
		</span>
		<span class='right'><a href="#"> Forgot Password?</a></span>
      </div>
    </div>
    </div>
  </form>
</div>

</div>
	
 
</div>
<a href="#"> Create New Account</a>
</div>
</div>
</div>
