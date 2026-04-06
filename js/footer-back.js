
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-40196231-1']);
  _gaq.push(['_setDomainName', 'a3ultimate.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();



  


function clearcooki()
{
var dataString = 'id=1' ;
$.ajax({
type: "POST",
url: "/cookie.php",
data: dataString,
cache: false,
success: function(html){
alert('Cookies Has Been Successfully Deleted !!');
window.location ="/Home";
}
});
return false;


};
 // var images = new Array();
 var images = new Array('/images/castle.jpg','/images/back-top.jpg', '/images/new.jpg','/images/back-top-hk1.jpg','/images/back-top-war.JPG','/images/arch.jpg','/images/mag.jpg','/images/back-top-ru.jpg','/images/bg.jpg','/images/bg1.jpg');
  var l = images.length;
  var random_no = Math.floor(l*Math.random());
 // document.getElementById("banner").src = images[random_no];
  $('#banner').attr('src', images[random_no]).load(function() {
            $('#banner').fadeIn("slow");
        });
