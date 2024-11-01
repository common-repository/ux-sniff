<?php 
if( !defined( 'ABSPATH' ) ) exit;

$footer_script=uxsniff_get_option_footer_script();

$rage = isset($_GET['rage'])?1:0;
$os = $_GET['os'];
$size = isset($_GET['w'])?$_GET['w']:'1900x860';
$screenWidth = explode("x",$size)[0];
$screenHeight = explode("x",$size)[1];
$url = urldecode($_GET['url']);
$cid = $_GET['cid'];
$country = $_GET['country'];
$date = $_GET['date'];
$device = isset($_GET['device'])? $_GET['device']:'desktop';
$nick = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST']; 

wp_enqueue_style( 'uxsniff-heatmaps-css', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/css/fsrenderer.css");

    wp_register_script( 'uxsniff_heatmaps_plugin_script', plugins_url() . '/'.  basename(dirname(__FILE__)) . '/assets/js/heatmaps.js', array('jquery'));
		wp_enqueue_script( 'uxsniff_heatmaps_plugin_script' );
?>



<?php if ($footer_script=='') { ?>


<div class="uxsniff_header">
	<div class="logo"></div>
	<h2>Heatmaps</h2>
</div>


<div class="ucsniff_clear" style="border-bottom: 3px solid #e5e7ea;margin:10px 15px 25px 0"></div>

	<p>Please setup your tracking code in the <a href="admin.php?page=uxsniff-info">Settings</a>.
<?php } else {  ?>


<style>
a:focus{outline:none;text-decoration: none}
#renderer html{overflow:hidden}
.scaled{
  width:800px;
  height:600px;
  -ms-transform-origin: top left;
  -webkit-transform-origin: top left;
  transform-origin: top left;
  -webkit-transition: all 500ms ease-in-out !important;
  transition: all 500ms ease-in-out !important;
  position: absolute;
    
}
.align-center {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}
.bar-items{
    float:left;height:70px;
}
.click-items{
    float:none !important;height: 40px;cursor:pointer;width:100%;padding:5px;
}
.click-items:hover{
    background:#fff;
}
.click-items.selected { 
   background:#ffd54d;
}
#loading {
display: none;
/*background: url('/images/loading_orange.gif') no-repeat center center;*/
height: 110px;
width: 110px;
border-radius:60px;
position: fixed;
left: 50%;
top: 50%;
margin: -55px 0 0 -55px;
z-index: 999;
background:#fff;
opacity: 0.8;
}
/* Loading animation */

 
 
 

.loader {
    position: relative;
    margin: 5px auto;
    width: 100px;
}
.loader:before {
    content: '';
    display: block;
    padding-top: 100%;
}

.showbox {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 5%;
}

.circular {
  -webkit-animation: rotate 2s linear infinite;
          animation: rotate 2s linear infinite;
  height: 100%;
  -webkit-transform-origin: center center;
      -ms-transform-origin: center center;
          transform-origin: center center;
  width: 100%;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}

.path {
  stroke-dasharray: 1,200;
  stroke-dashoffset: 0;
  -webkit-animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
          animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
  stroke-linecap: round;
}

@-webkit-keyframes rotate {
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}

@keyframes rotate {
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}
@-webkit-keyframes dash {
  0% {
    stroke-dasharray: 1,200;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 89,200;
    stroke-dashoffset: -35;
  }
  100% {
    stroke-dasharray: 89,200;
    stroke-dashoffset: -124;
  }
}
@keyframes dash {
  0% {
    stroke-dasharray: 1,200;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 89,200;
    stroke-dashoffset: -35;
  }
  100% {
    stroke-dasharray: 89,200;
    stroke-dashoffset: -124;
  }
}
@-webkit-keyframes color {
   100%, 0%, 40%{
    stroke: #f48120;
  }
  50%, 90%{
    stroke: #005a98;
  }
}
@keyframes color {
   100%, 0%, 40%{
    stroke: #f48120;
  }
  50%, 90%{
    stroke: #005a98;
  }
}
.deviceType {
    display: inline-block;
    background: url(<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/icons-devices.svg";?>) -27px 0 no-repeat;
    background-size: 27px 108px;
    margin: 9px 0;
    height: 18px;
    width: 27px;
    position: relative;
    opacity:0.2;
}
.deviceType.active{opacity:1}
.deviceType.Mobile {
    background-position: 0 0;
}
.deviceType.Desktop {
    background-position: 0 -36px;
}
.dropdown {
    position: relative;
    display: inline-block;
}
.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 100%;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}
.dropdown:hover .dropdown-content {
  display: block;
}
</style>

<div class="front-wrapper">
	<div class="wrapper" id="account-wrapper">
		<div class="no-padding">
		
				


<!-- top bar -->
<div class="row col-sm-12 ml-0 mr-0" style="text-align:left;width:100%; height:70px; background:#21313a; color:#ccc;">


<div class="row col-sm-6">
<div class="uxsniff_header" style="margin-top:8px">
	<div class="logo"></div>
	<h2 style="color:#fff">Heatmap</h2>
</div>
</div>

<div class="row col-sm-3">
    
    <div class="col-sm-8" style="float:left;padding:15px 0;">
<a style="text-decoration:none;display:inline-block" href="admin.php?page=uxsniff-heatmap&url=<?=urlencode($url)?>&w=1900x860&cls=<?=$raw?>&device=desktop">
        <div class="barItem deviceType Desktop <?php echo (explode("x",$size)[0] > 450?'active':'')?>" title="Desktop"></div>
</a>
<a style="text-decoration:none;display:inline-block" href="admin.php?page=uxsniff-heatmap&url=<?=urlencode($url)?>&w=410x720&cls=<?=$raw?>&device=mobile">
        <div class="barItem deviceType Mobile <?php echo (explode("x",$size)[0] > 450?'':'active')?>" title="Mobile"></div>
</a>

    </div>    
    <div class="col-sm-3 text-center" style="float:left;padding:0px 10px;height:70px;">
     <div class="align-center"> 
    </div>
         </div>    
</div>
    
<div class="row col-sm-3">  
    <div class="col-sm-11" style="float:left;height:70px;">
<div class="align-center" id="url">           
            <?php echo $nick.$url; ?>
 </div>
</div>
    
</div>
            
</div>   
<!-- end top -->





<div id="account-section2" data-account-section="my-account" style="width:100%;" > 
   

<div class="AppView" style="height:100%">
<div class="appContainer loadedOnce">
<div class="SessionPlaybackView">
<div class="sessionContentWrapper">
    <div class="pageContainer">

<div class="PagePlayback" style="height:100%; opacity: 1;">
    <iframe sandbox="allow-scripts allow-same-origin" class="WebPagePlayback" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/fsheatmap.php";?>?w=<?php echo $screenWidth;?>&h=<?php echo $screenHeight;?>&surl=<?=urlencode($url)?>&url=<?=$nick?><?=urlencode($url)?>&device=<?=$device?>&days=7" style="visibility: visible;width:100%;height:100%;min-height:100vh"></iframe>



</div>
</div>
</div>
</div>
</div>
</div>
</div>




<!-- Page script -->
<script>   
 

var first = '';
var isloaded = 0;
var frameloaded = 0;
var heatmaploaded = 1;
var curURL = '';
var points = [];
var Countdown;
var max = 0;
var heatmapInstance = [];
var message = [];

function eleMap(e){
if(e=='A') return 'Link';
else if(e=='P') return 'Paragraph';
else if(e=='IMG') return 'Image';
else if(e=='B') return 'Bold Text';
else if(e=='I') return 'Italic Text';
else if(e=='U') return 'Underline Text';
else return e;
}

function getGetOrdinal(n) {
   var s=["th","st","nd","rd"],
       v=n%100;
   return n+(s[(v-20)%10]||s[v]||s[0]);
}



function reloadFrame2(raw, url){
var found = false;
var maxX = 0;
var minX = 0;
var maxY = 0;
var minY = 0;
var cx = 0;
var cy = 0;

jQuery.each(message, function(index, data){ 

//console.log(data.raw+'='+raw);
	if(data.raw == raw)  {
		console.log("found xy:"+data.heatmap);
		var heat = data.heatmap;
		if(found){
			var newCx = parseFloat(heat.split('x')[0]);
			var newCy = parseFloat(heat.split('x')[1]);

			cx = (parseFloat(cx) + newCx) / 2;
			cy = (parseFloat(cy) + newCy) / 2
		} 
		else {
		cx = parseFloat(heat.split('x')[0]);
		cy = parseFloat(heat.split('x')[1]);

		if(maxX < cx) maxX = cx;
		if(maxY < cy) maxY = cy;
		if(minX == 0 || minX > cx) minX = cx;
		if(minY == 0 || minY > cy) minY = cy;
		found = true;
		}

	}
});

if(!found) { reloadFrame(url, cx, cy); }
else {
	reloadFrame(url, cx, cy);
}
}

function reloadFrame(url, cx, cy){


if(url =='') url = first;
 
 var newurl = url.split("#")[0];
 
if(isloaded){
    
     jQuery('.WebPagePlayback').contents().find('.frame').attr('src',url+'&cx='+cx+'&cy='+cy);
     //jQuery('#loading').show();
     //if(newurl!=jQuery('#url').text()) jQuery('.WebPagePlayback').contents().find('#loading').show();
     jQuery('.WebPagePlayback').contents().find('.frame').load(function(){
             //jQuery('#loading').hide();
             jQuery('.WebPagePlayback').contents().find('#loading').hide();
		frameloaded = 1;
     });
     if(typeof url != 'undefined' && typeof url.split("#") =='object'){
    
     jQuery('#url').text(newurl);
     }
 
} else {
    setTimeout(function(){reloadFrame(url, cx, cy)},1000);
}
    

}



function reloadFrame3(url, days, dateFrom, dateTo){


var curl = "admin.php?page=uxsniff-fsheatmap&w=<?php echo $screenWidth;?>&h=<?php echo $screenHeight;?>&surl=<?=urlencode($url)?>&url=<?=$nick?><?=urlencode($url)?>&device=<?=$device?>";

if(url =='') url = first; 
if(isloaded){
    console.log(curl+'&days='+days+'&dateFrom='+dateFrom+'&dateTo='+dateTo);
     jQuery('.WebPagePlayback').attr('src',curl+'&days='+days+'&dateFrom='+dateFrom+'&dateTo='+dateTo);
     jQuery('.WebPagePlayback').contents().find('.frame').load(function(){
             jQuery('.WebPagePlayback').contents().find('#loading').hide();
                frameloaded = 1;
     });
 
} else {
    setTimeout(function(){reloadFrame(url, days, dateFrom, dateTo)},1000);
}
    

}



function loadHeatMap(url){

//if(url =='') url = first;
url = url + '&hm=1';

 var newurl = url.split("#")[0];

if(curURL=='') curURL =  newurl;
else {
  if(curURL != newurl) return;
}

//console.log('hm:'+url);

//if(heatmaploaded){
heatmaploaded = 0;

   jQuery('.WebPagePlayback').contents().find('IFRAME').attr('src',url);
  

}

function reloadHeatMap(urls, single=0){

if(!single) {

if(frameloaded) {

//jQuery('.WebPagePlayback').contents().find('#loading').show();
var idx = 0;
	
    jQuery.each(urls, function(index, url){ 
    idx = index;


	});



} else { console.log('retry reloadHeatMap'); setTimeout(function(){reloadHeatMap(urls, 0)},1000);  }

} else  {
  setTimeout(function(){loadHeatMap(urls, 1)}, 1000);

}

}

jQuery(window).on("message", function(e) {
    message = JSON.parse(e.originalEvent.data);
    //console.log(message);
});
jQuery(document).ready(function() {
    


jQuery('.WebPagePlayback').load(function(){
     isloaded = 1;
    console.log("FRAME 1 loaded!");

});

jQuery('body').on('click', '.click-items', function(){
jQuery('.click-items').removeClass('selected');
jQuery(this).addClass('selected');
});


var urls = [];


});




</script>











</div></div></div></div></div>








		
<?php } ?>	

