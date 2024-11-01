<?php 
if( !defined( 'ABSPATH' ) ) exit;

$footer_script=uxsniff_get_option_footer_script();
$footer_domain = uxsniff_get_option_footer_domain();
?>


<div class="uxsniff_header">
    <div class="logo"></div>
    <h2>Rage Alerts (Last 7 days)</h2>
</div>

<div class="ucsniff_clear" style="border-bottom: 3px solid #e5e7ea;margin:10px 15px 25px 0"></div>


<?php if ($footer_script=='') { ?>
    <p>Please setup your tracking code in the <a href="admin.php?page=uxsniff-info">Settings</a>.
<?php } else {  ?>






 <style>

 .leftbox{width:50%;display:inline-block;float:left;position:relative;border-bottom:#e5e7ea 3px dashed;padding:30px 80px;font-size:20px;text-align:right}
 .rightbox{width:50%;display:inline-block;float:left;position:relative;border-bottom:#e5e7ea 3px dashed;padding:30px 80px;font-size:20px}
 .boxbullet{border:#e5e7ea 3px dashed; width:20px;height:20px;border-radius:100%;position:absolute;right:-12px;bottom:-10px;background:#f6f7f9;z-index:99;}
 .bullettext{text-align:center;width:100px;position:absolute;left:50%;bottom:-10px;margin-left: -50px;z-index:999;bottom:20px;background:#f4f6f7;}
 .bullettext2{text-align:center;width:100px;position:absolute;left:50%;margin-left: -50px;z-index:999;background:#fff;border: #e5e7ea 3px dashed;}
 .leftboxdot{width:50%;display:inline-block;float:left;position:relative;border-bottom:#e5e7ea 3px dashed;padding:50px 80px;font-size:20px;text-align:right}
 .rightboxdot{width:50%;display:inline-block;float:left;position:relative;border-bottom:#e5e7ea 3px dashed;padding:50px 80px;font-size:20px}

 #customdate{text-align: center;margin: 20px;border: 0;background: #fcfcfc;display:none;}
 
 .orange {color:#f7981d;}
 .green{color:#6aa84f}
 .blue{color:#4d90ff;}
 .dark{color:#333;}
 .grey{color:#4a6775;}
 .big{font-size:40px;}
 .medium{font-size:16px;}
 .leftboxtext{font-size:40px;padding:10px;position:absolute;bottom:-30px;right:80px;background:#f1f1f1;width:100%;font-family: 'Roboto Slab', serif;font-weight:700;}
 .rightboxtext{font-size:40px;padding:10px;position:absolute;bottom:-30px;left:80px;background:#f1f1f1;width:100%;font-family: 'Roboto Slab', serif;font-weight:700;text-align:left;}
 </style>



<div class="front-wrapper">
    <div class="wrapper" id="account-wrapper">
        <div class="no-padding">
            <div class="row">
                <div class="col-md-12" id="account-content">





<div id="account-section" data-account-section="my-account">
         




<div class="leftbox" style="width:100%; padding:0;position:relative">
    <div class="leftboxtext" style="right:0;/*bottom:-3px;*/position:relative;text-align:center">
                <span class="dark"><span id="total" class="orange"></span> Total Visitors</span>

</div></div>



 
 
   <div style="clear:both;height:30px;"></div>
   
<div style="width:100%;position:relative;display:block;text-align:center">
    <div id="chartdiv"></div>

  <div style="width:100%;display:inline-block;position:relative;float:left">
    <div class="leftboxdot">
        <div class="leftboxtext"><span class="dark" style="font-size:16px"> (<span id="totalEventPct">0.0</span>%)</span> <span class="orange" id="totalEvent">0</span>  <img  src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/smile.svg";?>" style="width:38px;margin-bottom: -4px;"></div>
        
        <div class="bullettext2" style="width: 240px;font-size: 14px;top: 135px;padding: 10px;">Users that interacted with at least one element on the page </div>
        <div class="boxbullet"></div>
    </div>
    
    <div class="rightboxdot">
         <div class="rightboxtext "><img  src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/frown.svg";?>" style="width:38px;margin-bottom: -4px;margin-right:10px"><span class="orange" id="totalIdle">0</span> <span class="dark" style="font-size:16px">(<span id="totalIdlePct">0.0</span>)% </span></div> 
         
          <div class="bullettext2" style="width: 240px;font-size: 14px;top: 135px;left:150px;padding: 10px;">Users that didn’t interact with any element on the page </div>
    </div>
    </div>  

<div style="width:100%;display:inline-block;position:relative;float:left;height:250px;">
      
     <div class="bullettext" style="width:260px;padding:0"><div class="leftboxtext"><img  src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/tired.svg";?>" style="width:38px;"><br><span class="dark"><span id="totalRage">0</span></span><br><span class="dark" style="font-size:16px;display:block">(<span id="totalRagePct">0.0</span>%) </span> </div> </div> 
     
    <div class="leftboxdot" style="height:200px;padding:0">
        <div class="leftboxtext">&nbsp;</div>
        <div class="boxbullet"></div>
    </div>
    
    <div class="rightboxdot" style="height:200px;padding:0">
         <div class="rightboxtext">&nbsp;</div>
         
         <div class="bullettext2" style="width: 160px;font-size: 14px;top: 270px;left: -34px;padding: 10px;">Users with abnormal activities</div>
         
    </div>
    
</div>  

    <div style="clear:both;height:77px;"></div>







<div style="width:100%;display:inline-block;position:relative;float:left;height:150px;">
      
     <div class="bullettext" style="width:260px;padding:0"><div class="leftboxtext" style="bottom:-10px"><span class="dark">Rage Alerts</span> </div> </div> 
     
    <div class="leftboxdot" style="height:100px;padding:0">
        <div class="leftboxtext">&nbsp;</div>
        <div class="boxbullet"></div>
    </div>
    
    <div class="rightboxdot" style="height:100px;padding:0">
         <div class="rightboxtext">&nbsp;</div>
    </div>
    
</div>



<!-- Rage -->


<div id="rageuser1" style="width:100%;display:inline-block;position:relative;float:left">
    <div class="leftboxdot">
        <div class="leftboxtext"><span class="orange" id="user1">0</span>  <img  src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/tired.svg";?>" style="width:38px; margin-bottom:-4px"></div>
        <div class="boxbullet"></div>
    </div>
    <div class="rightboxdot">
         <div class="rightboxtext "><img  src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/hand-pointer.svg";?>" style="width:38px; margin-bottom: -4px">  <span class="orange" id="click1">0</span> <span class="dark" style="font-size:16px"> </span></div> 
    </div>
</div>  

<div style="width:100%;display:inline-block;position:relative;float:left">
       <div class="bullettext2" id="text1" style="display:none;border:#e5e7ea 3px dashed;padding:10px;width:500px;margin-left:-250px;top:30px;background:#fff"></div>

<div id="rageuser2" style="display:none">       
    <div class="leftboxdot" style="height:200px;">
        <div class="leftboxtext"><span class="orange" id="user2">0</span> <img  src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/tired.svg";?>" style="width:38px;margin-bottom: -4px">  </div>
        <div class="boxbullet"></div>
    </div>
    
    <div class="rightboxdot" style="height:200px;">
         <div class="rightboxtext "><img  src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/hand-pointer.svg";?>" style="width:38px; margin-bottom: -4px">   <span class="orange" id="click2">0</span> <span class="dark" style="font-size:16px"> </span></div> 
    </div>
</div>

</div>  
    
    
    
    
    <div style="width:100%;display:inline-block;position:relative;float:left"  >
    
       <div class="bullettext2" id="text2" style="display:none;border:#e5e7ea 3px dashed;padding:10px;width:500px;margin-left:-250px;top:30px;background:#fff"></div>

<div id="rageuser3" style="display:none">     
    <div class="leftboxdot" style="height:200px;">
        <div class="leftboxtext"><span class="orange" id="user3">0</span> <img  src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/tired.svg";?>" style="width:38px; margin-bottom: -4px"> </div>
        
        <div class="boxbullet"></div>
    </div>
    
    <div class="rightboxdot" style="height:200px;">
         <div class="rightboxtext "><img  src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/hand-pointer.svg";?>" style="width:38px; margin-bottom: -4px">  <span class="orange" id="click3">0</span> <span class="dark" style="font-size:16px"> </span> </div> 
    </div>
</div>    
</div>  


    <div style="width:100%;display:inline-block;position:relative;float:left"  >
    
       <div class="bullettext2" id="text3" style="display:none;border:#e5e7ea 3px dashed;padding:10px;width:500px;margin-left:-250px;top:30px;background:#fff"></div>
    
    <div class="leftboxdot" style="height:200px;">
        <div class="leftboxtext">&nbsp;</div>
    </div>
    
    <div class="rightboxdot" style="height:200px;">
         <div class="rightboxtext ">&nbsp;</div>
    </div>
    
    
     <div style="clear:both;"></div>
     <div class="account-detail-item" style="text-align:center;margin:28px 0">





</div>
    </div>
</div></div>



</div></div></div></div></div>








<script>
var datatable = '';

function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}


function getDataChart(days, dateFrom, dateTo){
 
jQuery.ajax({ 
    type: 'GET', 
    data: {days: days, dateFrom: dateFrom, dateTo: dateTo},
    url: 'https://api.uxsniff.com/json/wp_chart_user', 
    success: function (data) { 
        var chartDate = {};
        var chartClick = {};
        var v = [];
        var c = [];
        jQuery.each(data.data, function(index, element) {
            var date = moment(element.date).format('MMM D');
            
        // Chart Data
        if(typeof chartDate[date] == 'number') chartDate[date2] = parseInt(chartDate[date]) + parseInt(element.users);
        else chartDate[date] = parseInt(element.users); 
        
        if(typeof chartClick[date] == 'number') chartClick[date2] = parseInt(chartClick[date]) + parseInt(element.totalClicks);
        else chartClick[date] = parseInt(element.totalClicks); 
        
        });
        
        // cahrt Data
        jQuery.each(chartDate, function(key, value) {
            var a = [];
            a.push(key)
            a.push(value);
            v.push(a);
            
        });
        jQuery.each(chartClick, function(key, value) {
            var a = [];
            a.push(key);
            a.push(value);
            c.push(a);
 
        });
        
        //console.log(c);
        drawChart(v,c);
    }
});
}


var tagsToReplace = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;'
};

function replaceTag(tag) {
    return tagsToReplace[tag] || tag;
}

function safe_tags_replace(str) {
    return str.replace(/[&<>]/g, replaceTag);
}

function getData(days, dateFrom, dateTo){

//getDataChart(days, dateFrom, dateTo);    
var total = 0;
var totalEvent = 0;
var totalRage = 0;
var totalIdle = 0;
var gdata = [];

if(dateFrom=='') jQuery('#selectedDate').val(days + ' days ago');
else jQuery('#selectedDate').val(dateFrom + ' to ' +dateTo);

jQuery.ajax({ 
    type: 'GET', 
    url: 'https://api.uxsniff.com/json/wp_sessions.php?domain=<?php echo esc_html($footer_domain);?>',  
    data: {days: days, dateFrom: dateFrom, dateTo: dateTo},
    success: function (data) { 
        
        
         //jQuery.each(data.data.main, function(index, element) {
             
                var element = data.data.main;
                if(typeof element.sessions == 'undefined') return;
           
                total = parseInt(element.sessions);
                totalRage = parseInt(element.rage);
                totalEvent = (parseInt(element.sessionsEvent)-totalRage);
                //console.log(totalEvent);
            
                totalIdle = total - totalEvent - totalRage;
                 
                totalEventPct =  ((totalEvent/total)*100).toFixed(1);
                totalIdlePct =  ((totalIdle/total)*100).toFixed(1);
                totalRagePct =  ((totalRage/total)*100).toFixed(1); 
                
                 jQuery('#total').animateNumbers(total,true,2000);
                 jQuery('#totalEvent').animateNumbers(totalEvent,true,2000);
                 jQuery('#totalRage').animateNumbers(totalRage,true,2000);
                 jQuery('#totalEventPct').animateNumbers(totalEventPct,true,2000);
                 jQuery('#totalIdle').animateNumbers(totalIdle,true,2000);
                 jQuery('#totalIdlePct').animateNumbers(totalIdlePct,true,2000);
                 jQuery('#totalRagePct').animateNumbers(totalRagePct,true,2000);
                 
                 //gdata = [{"value":totalEvent,"name":'User with Action'},{"value":totalRage,"name":'Rage User'},{"value":totalIdle,"name":'Idle User'}];
                 gdata = [{"value":totalIdle,"name":'Idle User'},{"value":totalRage,"name":'Rage User'},{"value":totalEvent,"name":'Active User'}];
     
         //});   
         
         
         // RAGEEEEE 
         var rage = [];
         jQuery.each(data.data.rage, function(index, element) {
             
            var pagePath = element.url;
            var click = element.totalClicks;
            var track = element.track;
            // store rage click
            if(click>10){
                rage.push({'url' : pagePath, 'click':click, 'label':track});
            }
                
           
             
         });
         
         var rageClick = [];
         jQuery(rage).each(function(i,data){
             var rg = [];
             var user = 1;
             var pagePath = data.url;
             var label = data.label;
             var click = parseInt(data.click);
             var found = false;
             
             jQuery(rageClick).each(function(j,ele){
                
                 if(ele.url==pagePath && ele.label==label){
                     found = true;
                     rageClick[j]['users'] = (parseInt(rageClick[j]['users'])+1);
                     rageClick[j]['click'] = (parseInt(rageClick[j]['click'])+ click);
                 }
             });
             
             if(found==false) { 
                rageClick.push({'url' : pagePath, 'click':click, 'label':label, 'users':user});
             }
             
         });
         rageClick.sort((a, b) => (a.users < b.users) ? 1 : (a.users === b.users) ? ((a.click < b.click) ? 1: -1) : -1);
         
         
        var table =  "<table id='reports-list' class='reports-list' cellspacing='0' width='100%' style='display:table'>";
        table += '<thead><tr><th class="col-sm-4">URL</th><th class="col-sm-4">Element</th><th class="col-sm-2">Users</th><th class="col-sm-2">Total Clicks</th><th>Action</th></tr></thead><tbody>';
         
         jQuery(rageClick).each(function(j,element){
         j++;
         if(j <= 3){
             jQuery('#rageuser'+j).show();
             jQuery('#text'+j).show();
             jQuery('#user'+j).text(element.users);
             jQuery('#click'+j).text(element.click);
             jQuery('#text'+j).html('<a target="_blank" href="https://app.uxsniff.com/login?next=report-rage"><b>'+element.users+' users clicked '+element.click+' times on element <span class="orange">"'+element.label+'"</span> on <span class="orange">'+element.url+'</soan></b></a>');
         //999 users clicked 9,999 times on element "signup" at /homepage      
         //rtable += '<tr class="report-item"><td>'+element.url+'</td><td>'+element.users+'</td><td>'+element.click+'</td><td class="break">'+element.label+'</td></tr>';
         } else {
            table += '<tr><td>'+element.url+'</td><td>'+safe_tags_replace(element.label)+'</td><td>'+element.users+'</td><td>'+element.click+'</td><td><a target="_blank" href="/rage?ele='+encodeURIComponent(element.label)+'&url='+encodeURIComponent(element.url)+'"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect element" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/search.svg";?></a></td></tr>';  
         }
         });


          table +='</tbody></table>';

         //////////////////////////////////////

         option2 = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
           
            series : [
                {
                    name: 'User Behaviour',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '50%'],
                    data: gdata,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
            
        };
        var myChart = echarts.init(document.getElementById('chartdiv'));
        myChart.setOption(option2);
         
    }
});
}

function drawChart(v,c){
    var myChart2 = echarts.init(document.getElementById('chartdiv2'));
    option = {
            xAxis: [{
                name: 'date',
                type: 'category',
                boundaryGap: true,
                inverse: true,
                splitLine: {
                    show: false
                },
                axisTick: {
                    show: false
                },
                nameLocation: 'middle',
                nameGap: 25
            }],
            yAxis: {
                type: 'value',
                splitLine: {
                    show: true,
                    lineStyle: {
                        color: ['#eaeaea']
                    }
                },
                axisLine:{
                    lineStyle: {
                        opacity:0
                    }
                },
                axisTick: {
                    show: false
                }
                
            },
            legend: {
                left: 'left',
                data: ['sessions', 'clicks']
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'none'
                },
                
            },
            grid: {
              left: '80px',
              top: '50px',
              right: '10px',
              bottom: '50px'
            },
            series: [{
                name: 'clicks',
                data: c,
                type: 'bar',
                symbolSize: 10,
                symbol: 'circle',
                areaStyle: {
                     opacity: '0.1'
                },
                lineStyle: {
                    width: 3
                },
                itemStyle: {
                    color: '#f7981d'
                   
                }
            },{
                name: 'sessions',
                data: v,
                type: 'line',
                symbolSize: 6,
                symbol: 'circle',
                areaStyle: {
                     opacity: '0.1'
                },
                lineStyle: {
                    width: 2
                },
                itemStyle: {
                    color: '#058dc7'
                }
            }]
        };
    
    myChart2.setOption(option);    
}



jQuery(function() {
 getData(7,'','');
});

</script>


        
<?php } ?>  

