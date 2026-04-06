 function check_r_stats(){
    var rema = document.getElementById('rema');
    var mana = document.getElementById('mana');
    var tota = document.getElementById('total');

      var total = tota.value;
      var y = rema.value;
     var y5 = mana.value;


      if(y === null || y === " " || y.lenght == 0) {
      y=0;                                      }
      if(y5 === null || y5 === " " || y5.length == 0){
      y5=0;                                     }


      var tall = parseInt(total);

  	  var z = parseInt(y5);
	  var r = parseInt(tall) - parseInt(z);
 	 //check if entered more that remianing stats
 	 if(r >= 0)
  {
  var check_s = parseInt(z) + parseInt(r);
  if(tall.value === check_s.value)
  {
    var nr = parseInt(tall) - parseInt(z);

     document.cstats.rema.value=nr;
  }

   }
   else
  {
  alert("You have insufficient remaning points!");
  }
}