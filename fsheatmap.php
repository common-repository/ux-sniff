<?php
$screenWidth = isset($_GET['w'])?$_GET['w']:1200;
$screenHeight = isset($_GET['h'])?$_GET['h']:768;
$url = isset($_GET['url'])?$_GET['url']:'';
$surl = isset($_GET['surl'])?$_GET['surl']:'';
$device = isset($_GET['device'])?$_GET['device']:'desktop';
$days = isset($_GET['days'])?$_GET['days']:7;
$dateFrom = isset($_GET['dateFrom'])?$_GET['dateFrom']:'';
$dateTo = isset($_GET['dateTo'])?$_GET['dateTo']:'';
$content = '';

//wp_enqueue_style( 'uxsniff-heatmaps-css', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/css/fsrenderer.css");

//wp_register_script( 'uxsniff_heatmaps_plugin_script', plugins_url() . '/'.  basename(dirname(__FILE__)) . '/assets/js/heatmaps.js', array('jquery'));
//wp_enqueue_script( 'uxsniff_heatmaps_plugin_script' );

$nick = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST']; 


?>

<link rel="stylesheet" href="./assets/css/fsrenderer.css">
<script src="./assets/js/jquery.js"></script>
  <script src="./assets/js/heatmaps.js"></script>

  <script>


var scale=1;
var urls = [];
var points = [];
var Countdown;
var max = 0;
var heatmapInstance = [];
var framelaoded = 0;
var heatmaploaded = 0;
var docHeight;




jQuery(window).on("message", function(e) {
    var data = JSON.parse(e.originalEvent.data);

if(typeof data != 'undefined'){

if(typeof data.docHeight != 'undefined'){
    console.log(data.docHeight);
    docHeight = data.docHeight;
    jQuery('.overlay, .frame').height(data.docHeight);
    //jQuery('.overlay').height(data.docHeight);

heatmapInstance = h337.create({
        container: jQuery('.overlay')[0]
     });
var nuConfig = {
  maxOpacity: .5,
  minOpacity: 0,
  blur: .75,
  backgroundColor: 'rgba(0,0,0,.55)'
};
heatmapInstance.configure(nuConfig);
//console.log(heatmapInstance);
heatmaploaded = 1;




}
}

if(typeof data.scrollHeight != 'undefined'){
	var scroll = parseFloat(data.scrollHeight);
	var thisHeight = parseFloat(jQuery('.overlays').height()) / 2;
	//scroll = scroll - thisHeight;
	//jQuery('.overlays').scrollTop(scroll);
}


});


jQuery(document).ready(function($){



jQuery('.overlays').on('scroll', function () {
    jQuery('.vp').scrollTop(jQuery(this).scrollTop());
});


 

jQuery('.frame').load(function(){
 frameloaded = 1;	
});
    
  
 nsZoomZoom(); 
  
 jQuery( window ).resize(function() { 
   nsZoomZoom();
 });
  


function setHeatmap(data) {
if(heatmaploaded && docHeight > 0) {
heatmapInstance.setData(data);
jQuery('#loading').hide();
} else { setTimeout(function(){setHeatmap(data)},1000); }
}


function processData(data) {
if(heatmaploaded && docHeight > 0) {



 jQuery.each(data.data, function(track, element) {
                
            var url = '/';
            var click = element.totalClicks;
            var raw = '';
            var coordinates = element.heatmap;
            var cx = coordinates.split('x')[0];
            var cy = coordinates.split('x')[1];
            
                var body = document.body;
                var html = document.documentElement;

// var screenX  = Math.max(body.scrollWidth, body.offsetWidth, html.clientWidth, html.scrollWidth, html.offsetWidth);
var screenX = <?=$screenWidth?>;
//var screenY = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
var screenY = docHeight;

//console.log(screenX+'xx'+screenY);

// check cx is relativeX or pixel
if(cx <= 1 && docHeight > 0){
        cx = parseFloat(cx) * screenX;
        cy = parseFloat(cy) * screenY;
}

var point = {
    x: parseFloat(cx).toFixed(0),
    y: parseFloat(cy).toFixed(0),
    value: parseInt(click)
};

if(max < parseInt(click)) max = parseInt(click);


var point = {
    x: parseFloat(cx).toFixed(0),
    y: parseFloat(cy).toFixed(0),
    value: parseInt(click)
};

if(max < parseInt(click)) max = parseInt(click);

points.push(point);
var data = {
  max: max,
  min: 0,
  data: points
};



clearTimeout(Countdown);
//console.log(data);

Countdown = setTimeout(function(){
   setHeatmap(data);
   // console.log(heatmapInstance.getData());
}, 500);


});




} else { setTimeout(function(){processData(data)},1000); }
}


  
 function nsZoomZoom() {
     
    
    //htmlHeight = jQuery('body').innerHeight();
    htmlHeight = window.innerHeight;
    bodyHeight = jQuery('.scaled').innerHeight();
    //htmlWidth = jQuery('body').innerWidth();  
    htmlWidth = window.innerWidth;
    bodyWidth = jQuery('.scaled').innerWidth();
    
    htmlRatio = htmlWidth/htmlHeight;
    bodyRatio = bodyWidth/bodyHeight;
    
   
//console.log(htmlRatio);
//console.log(bodyRatio);

    if (bodyHeight < htmlHeight)
       scale = 1; 
    else {
       scale = htmlHeight / bodyHeight; 
    }
    
    if(scale > 1) scale=1;
 
    
    
    
  
    
    if (htmlWidth  < bodyWidth ) {
       left = (htmlWidth - (bodyWidth*scale)) / 2;
       if(bodyRatio > htmlRatio) scale =   htmlWidth / bodyWidth; 
    }
    else {
       left = (htmlWidth - (bodyWidth*scale)) / 2;
       if(bodyRatio > htmlRatio) scale = htmlWidth / bodyWidth; 
    }
    
    if(left < 0) left = 0;


//console.log(scale);    

    jQuery(".scaled").css('left', left+'px');
        // Req for IE9
    jQuery(".scaled").css('-ms-transform', 'scale(' + scale + ')');
    jQuery(".scaled").css('transform', 'scale(' + scale + ')');
    
    
 }












jQuery.ajax({ 
    type: 'GET', 
    url: 'https://api.uxsniff.com/json/wp_raw-heatmap.php?url=<?=urlencode($surl)?>&device=<?=$device?>&days=<?=$days?>&dateFrom=<?=$dateFrom?>&dateTo=<?=$dateTo?>',
    success: function (data) { 
    console.log('success');
    parent.postMessage( JSON.stringify(data.data), '*');
    var cur_url = '';
    var i=0;

    if(data.data.length ==0) {
	jQuery('#loading').hide();
    } else {
      processData(data);
	}



}
});




});



</script>



</head><body>
    
<style>
.hm_tooltip { position:absolute; left:0; top:0; background:#00a2f2; font-family: arial;color:white; font-size:18px; font-weight:bold; padding:10px; line-height:18px; display:none;z-index:999999; border-radius:4px;}
.large{
z-index:999999;
display:none;
width: 275px;
    height: 275px;
    position: absolute;
    border-radius: 100%;
    pointer-events: none;
    box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85), 0 0 7px 7px rgba(0, 0, 0, 0.25), inset 0 0 40px 2px rgba(0, 0, 0, 0.25);
}


#renderer html{overflow:hidden}
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

</style>
<div id="loading" style="display: block;">
  <div class="loader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
  </div>
</div>

    
    <div class="Renderer is-map-mode pageInsights map-insights" style="display: block;">
    <div class="checkerboard"></div>
   
    <div class="fade"></div>
    <div class="scaled" style="left: 365.078px; top: 0px; width: <?php echo $screenWidth;?>px; height: <?php echo $screenHeight;?>px;  transform: scale(0.169272, 0.169272) translate(51.3968px, 93.0158px);">
        <div class="viewport" style="transform: scale(1, 1) translate(0px, 0px);">
<div class="overlays" style="height:100%;overflow:scroll">
<div class="hm_tooltip">999</div>
                        <div class="overlay" style="width:100%">
				<div class="large"></div>
			</div>
          </div>

            <div class="vp" style="height:100%;overflow:scroll;z-index:999">

		<!-- sandbox="allow-same-origin allow-scripts"  -->

<iframe id="renderer"  sandbox="allow-same-origin allow-scripts allow-top-navigation" src="<?php echo rawurldecode($url);?>" class="frame" width="<?php echo $screenWidth;?>" height="<?php echo $screenHeight?>" style="position:relative"></iframe>


            </div>
        </div>
    </div>
</div>


