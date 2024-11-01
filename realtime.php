<?php 
if( !defined( 'ABSPATH' ) ) exit;

$footer_script=uxsniff_get_option_footer_script();

?>


<div class="uxsniff_header">
    <div class="logo"></div>
    <h2>Real-time 30 minutes</h2>
</div>

<div class="ucsniff_clear" style="border-bottom: 3px solid #e5e7ea;margin:10px 15px 25px 0"></div>


<?php if ($footer_script=='') { ?>
    <p>Please setup your tracking code in the <a href="admin.php?page=uxsniff-info">Settings</a>.
<?php } else {  ?>

<div class="front-wrapper">
    <div class="wrapper" id="account-wrapper">
        <div class="no-padding">
            <div class="row">
                <div class="col-md-12" id="account-content">

<div style="width:100%;display:inline-block;float:left">

    <div class="leftbox">
       <div class="leftboxtext"><span class="orange" id="totalViews">0</span> <span class="dark" >Active Views</span> </div>
       <div class="boxbullet"></div>
    </div>


    <div class="rightbox">
        <div class="rightboxtext orange"><span class="orange" id="totalClicks">0</span> <span class="dark">Clicks</span> </div> 
    </div>

</div>


<div style="width:100%;display:inline-block;position:relative;float:left">

    <div class="leftboxdot" style="padding-top:0;padding-bottom:0">
    <div class="boxdot_wrapper">
       <div id="chartView" style="width:100%;height:250px;"></div>
        </div>
        <div class="boxbullet"></div>
    </div>

    <div class="rightboxdot" style="padding-top:0;padding-bottom:0">
    <div class="boxdot_wrapper">
          <div id="chartClick" style="width:100%;height:250px;"></div>
        </div>

    </div>

</div>



<div style="width:100%;display:inline-block;position:relative;float:left">
           
    <div class="leftboxdot" style="border:0">

        <div class="boxdot_wrapper">

        <span style="font-size:30px">Top Clicked Elements</span> 
        <div id="chartdiv" class="chartdiv" ></div>

            </div>
    </div>

    <div class="rightboxdot" style="border-bottom:0">

        <div class="boxdot_wrapper">

            <span style="font-size:30px">Top Viewed Pages</span>
            <div id="chartdiv2" style="width:100%;height:250px;"></div>
            <div id="topViews"></div>

        </div>

    </div>

</div>

<div class="uxsniff_clear"></div>

<div class="leftbox" style="width:100%; padding:0;position:relative">
    <div class="leftboxtext" style="right:0;/*bottom:-3px;*/position:relative;text-align:center">
        User Activities
    </div>
</div>

<div class="uxsniff_clear" style="height:30px"></div>

<div id="realtime"></div>




</div></div></div></div></div>








<script>

function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}
function ordinal(i) {
    var j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + "st";
    }
    if (j == 2 && k != 12) {
        return i + "nd";
    }
    if (j == 3 && k != 13) {
        return i + "rd";
    }
    return i + "th";
}


jQuery(function() {

var myChart = echarts.init(document.getElementById('chartdiv'));
var myChart2 = echarts.init(document.getElementById('chartdiv2'));
var chartView = echarts.init(document.getElementById('chartView'));
var chartClick = echarts.init(document.getElementById('chartClick'));


var dataChartClick = '';

interval = setInterval(getData, 12000);

function getData() {

var newData = [];
    jQuery.ajax({ 
    type: 'GET', 
    url: 'https://api.uxsniff.com/json/wp_realtimeclick.php', 
    success: function (data) { 
        jQuery("#totalViews").animateNumbers(data.data.totalResults,true,2000);
        jQuery("#totalClicks").animateNumbers(data.data.totalEvents,true,2000);
        var v = [], c =[], vc =[];
        
        jQuery.each(data.data.rows, function(index, element) {
        var mins = parseInt(element[5]);
        (typeof v[mins] == 'undefined')? v[mins]=1 : v[mins] += 1;
        (typeof c[mins] == 'undefined')? c[mins]=1 : c[mins] += parseInt(element[7]);
        (typeof vc[mins] == 'undefined')? vc[mins]=1 : vc[mins] = (vc[mins] + (c[mins]/v[mins]))/2;
            
        for(var i=0; i<=30; i++) {
        if(typeof v[i] == 'undefined') v[i] = 0;
        if(typeof c[i] == 'undefined') c[i] = 0;
        } 
 
        
        });
        
        
        newData = [c[30],c[29],c[28],c[27],c[26],c[25],c[24],c[23],c[22],c[21],c[20],c[19],c[18],c[17],c[16],c[15],c[14],c[13],c[12],c[11],c[10],c[9],c[8],c[7],c[6],c[5],c[4],c[3],c[2],c[1],c[0]];
        
        newVData = [v[30],v[29],v[28],v[27],v[26],v[25],v[24],v[23],v[22],v[21],v[20],v[19],v[18],v[17],v[16],v[15],v[14],v[13],v[12],v[11],v[10],v[9],v[8],v[7],v[6],v[5],v[4],v[3],v[2],v[1],v[0]];
        
        var optionChartClick = {
            series: [{
                data: newData,
                type: 'bar',
                animation: false,
                itemStyle: {
                    color: '#058dc7',
                    opacity: '0.6'
                },
            }]
        };
        var optionChartView = {
            series: [{
                data: newVData,
                type: 'line',
                animation: false,
                itemStyle: {
                    color: '#058dc7',
                    opacity: '0.6'
                },
            }]
        };
        
        chartClick.setOption(optionChartClick);   
        chartView.setOption(optionChartView);
        
    }
    });
    
}


jQuery.ajax({ 
    type: 'GET',
    url: 'https://api.uxsniff.com/json/wp_realtimeclick.php', 
    success: function (data) { 
  
        jQuery("#totalViews").animateNumbers(data.data.totalResults,true,2000);
        jQuery("#totalClicks").animateNumbers(data.data.totalEvents,true,2000);
        
        var v = [], c =[], vc =[];
        
        var table =  "<table id='reports-list' class='reports-list' cellspacing='0' width='100%' style='display:table'>";
        
        var topTable =  "<table id='top-list' class='reports-list' cellspacing='0' width='100%' style='display:table'>";
        
        var current_sid = '';
        var stamp = 0;
        var seconds = 0;
        var duration = 0;
        var topView = [];
        var topClick = {}
        var topClickText = {};
        var topUrl = {};
        
        table += '<thead><tr><th>URL</th><th>Country</th><th>Minutes Ago</th><th>Clicks</th><th>Elements</th><th>Action</th></tr></thead><tbody>';
        topTable += '<thead><tr><th>URL</th><th>Views</th></tr></thead><tbody>';

        jQuery.each(data.data.rows, function(index, element) {
            
            
            var string = element[0].split(' - ');
            
            
            if(typeof string[1] != 'undefined'){
            var raw = string[1];  
        if(raw.indexOf('#') !== -1) {
         var ele = raw.split('#')[0];
         var classstring = string[1].split('#')[1];
        }
        else {
         var ele = raw.split('.')[0];
        var classstring = string[1].split('.')[1];
        }   
            var cls = classstring.split(':')[0];
            var eq = parseInt(classstring.split(':')[1]);
            var ele_string =  'The '+ordinal((eq+1))+' '+ele+' having class name of '+cls+'';
            } else {
                var raw = '(not set)';
                ele_string = 'not set';
            }  
            var eleText = element[6];
            if(eleText == '') eleText = 'not set'
            
            var url = element[1];

            url = url.replace('/<?php echo (!empty($_SERVER['HTTPS'])?'https://':'http://').$_SERVER['HTTP_HOST'];?>','');
            
            
            if(typeof(topUrl[url]) != 'undefined') topUrl[url] += 1;
            else topUrl[url] = 1;
            
           
            
            // bar chart info //////////////////////
            var mins = parseInt(element[5]);
            (typeof v[mins] == 'undefined')? v[mins]=1 : v[mins] += 1;
            (typeof c[mins] == 'undefined')? c[mins]=1 : c[mins] += parseInt(element[7]);
            (typeof vc[mins] == 'undefined')? vc[mins]=1 : vc[mins] = (vc[mins] + (c[mins]/v[mins]))/2;
            
            
            
            (typeof topView[element[1]] == 'undefined')? topView[element[1]] = 1: topView[element[1]] += 1;
            (typeof topClick[ele] == 'undefined')? topClick[ele] = 1: topClick[ele] += 1;
            
            (typeof topClickText[ele] == 'undefined')?  topClickText[ele] = {}:
            (typeof topClickText[ele][eleText] == 'undefined')? topClickText[ele][eleText] = 1: topClickText[ele][eleText] += 1;
            
          
     
           table += '<tr class="report-item"><td class="col-sm-4 break">'+url+'</td><td class="col-sm-1">'+element[2]+'</td><td class="col-sm-1">'+element[5]+'</td><td class="col-sm-1">'+element[7]+'</td><td class="col-sm-5 break2">'+ element[6] +'<img data-toggle="tooltip" title="" class="question-tooltip-icon bottom" data-original-title="'+ele_string+'" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/info-circle.svg";?>"  style="width:24px;padding: 0 5px;margin-bottom: -1px"></td><td><a href="admin.php?page=uxsniff-inspect&url='+encodeURIComponent(url)+'&raw='+encodeURIComponent(raw)+'&label='+encodeURIComponent(element[6])+'" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect element" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/search.svg";?>" style="width:32px" ></a><a href="admin.php?page=uxsniff-inspect-url&url='+encodeURIComponent(url)+'" target="_blank"><img class="report-action view-report" aria-hidden="true" data-toggle="tooltip" data-original-title="Inspect URL" style="width:32px" data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect element" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/link.svg";?>"></a></td></tr>';


           
           //(element.city=='(not set)'?'':element.city)
           
        });
      
        var topUrls = [];
        
        jQuery.each(topUrl, function(key, value) {
            var a = {};
            a['url'] = key;
            a['count'] = value;
            topUrls.push(a);
            
        });
        // multisort data
        topUrls.sort(function(a, b) {
            return b['count'] - a['count'];
        });
        
        var i = 0;
        jQuery.each(topUrls, function(key, value) {
        if(i < 10) topTable += '<tr class="report-item"><td class="break">'+value.url+'</td><td>'+value.count+'</td></tr>';
        i++;
        });
        topTable +='</tbody></table>';
        jQuery('#topViews').append(topTable);
        
        
        
        
        for(var i=0; i<=30; i++) {
        if(typeof v[i] == 'undefined') v[i] = 0;
        if(typeof c[i] == 'undefined') c[i] = 0;
        } 
        
       
        
        
        
        optionChartView = {
            xAxis: {
                name: 'Mins',
                nameLocation: 'middle',
                boundaryGap: false,
                show: false,
                type: 'category',
                data: [30,29,28,27,26,25,24,23,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1],
                boundaryGap: false,
                inverse: false,
                splitLine: {
                    show: false
                },
                axisLine: {
                    show: false
                },
                axisTick: {
                    show: false
                },
                nameLocation: 'middle',
                nameGap: 25
            },
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
            tooltip: {
                trigger: 'axis',
                formatter: "{b} minutes ago <br> {c} views"
            },
            series: [{
                data: [v[30],v[29],v[28],v[27],v[26],v[25],v[24],v[23],v[22],v[21],v[20],v[19],v[18],v[17],v[16],v[15],c[14],v[13],v[12],v[11],v[10],v[9],v[8],v[7],v[6],v[5],v[4],v[3],v[2],v[1],v[0]],
                type: 'line',
                itemStyle: {
                    color: '#058dc7',
                    opacity: '0.6'
                },
            }]
        };
        
        dataChartClick = [c[30],c[29],c[28],c[27],c[26],c[25],c[24],c[23],c[22],c[21],c[20],c[19],c[18],c[17],c[16],c[15],c[14],c[13],c[12],c[11],c[10],c[9],c[8],c[7],c[6],c[5],c[4],c[3],c[2],c[1],c[0]] ;
         
        optionChartClick = {
                xAxis: {
                name: 'Mins',
                nameLocation: 'middle',
                boundaryGap: false,
                show: false,
                type: 'category',
                data: [30,29,28,27,26,25,24,23,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1],
                boundaryGap: false,
                inverse: false,
                splitLine: {
                    show: false
                },
                axisLine: {
                    show: false
                },
                axisTick: {
                    show: false
                },
                nameLocation: 'middle',
                nameGap: 25
            },
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
            tooltip: {
                trigger: 'axis',
                formatter: "{b} minutes ago <br> {c} clicks"
            },
            /*toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },*/
            series: [{
                data: dataChartClick,
                type: 'bar',
                itemStyle: {
                    color: '#058dc7',
                    opacity: '0.6'
                },
            }]
        };
        
        
        
        option = {
            xAxis: [{
                name: 'minutes',
                type: 'value',
                boundaryGap: false,
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
                data: ['views', 'clicks']
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'none'
                },
                
            },
            series: [{
                name: 'clicks',
                data: [[30,c[30]],[29,c[29]],[28,c[28]],[27,c[27]],[26,c[26]],[25,c[25]],[24,c[24]],[23,c[23]],[22,c[22]],[21,c[21]],[20,c[20]],[19,c[19]],[18,c[18]],[17,c[17]],[16,c[16]],[15,c[15]],[14,c[14]],[13,c[13]],[12,c[12]],[11,c[11]],[10,c[10]],[9,c[9]],[8,c[8]],[7,c[7]],[6,c[6]],[5,c[5]],[4,c[4]],[3,c[3]],[2,c[2]],[1,c[1]],[0,c[0]]],
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
                name: 'views',
                data: [[30,v[30]],[29,v[29]],[28,v[28]],[27,v[27]],[26,v[26]],[25,v[25]],[24,v[24]],[23,v[23]],[22,v[22]],[21,v[21]],[20,v[20]],[19,v[19]],[18,v[18]],[17,v[17]],[16,v[16]],[15,v[15]],[14,v[14]],[13,v[13]],[12,v[12]],[11,v[11]],[10,v[10]],[9,v[9]],[8,v[8]],[7,v[7]],[6,v[6]],[5,v[5]],[4,v[4]],[3,v[3]],[2,v[2]],[1,v[1]],[0,v[0]]],
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
        
        
        
        
        var legend = [];
        var sdata = [];
        var ssdata = [];
        
     
        
        jQuery.each(topClick, function(key, value) {
           
            legend.push("'"+key+"'");
        });
        
         jQuery.each(topClickText, function(index, data) {
            var b = {};
            b['value'] = 0;
            b['name'] = index;
            
             jQuery.each(data, function(key, value) {
                var a = {};
                a['value'] = value;
                a['name'] = key;
                b['value'] += value;
                ssdata.push(a);
             });
             
             if(b['value']>0 && b['name']!='undefined') sdata.push(b);
        });
        
        
                data = "["+sdata.join(",")+"]";
        data2 = "["+ssdata.join(",")+"]";
        legend = "["+legend.join(",")+"]";
        
        
        // multisort data
        sdata.sort(function(a, b) {
            return a["value"] - b["value"];
        });
        sdata.reverse();
        gdata = sdata.slice(0, 10);
        
        option2 = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                type: 'scroll',
                orient: 'vertical',
                right: 10,
                top: 20,
                bottom: 20,
                data: sdata,
                selected: gdata
            },
            series : [
                {
                    name: 'Top Clicked Elements',
                    type: 'pie',
                    radius : '55%',
                    center: ['32%', '44%'],  
                    data: gdata,
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        
                    },
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





         myChart.setOption(option2);
         myChart2.setOption(option);
         chartView.setOption(optionChartView);
         chartClick.setOption(optionChartClick);    

         
         
        
        table +='</tbody></table>';
        
        jQuery('#realtime').append(table);
            
          
           var groupColumn = 0;
           
           var toptable = jQuery('#top-list').DataTable( {
                responsive: true,
                paging:   false,
                info: false,
                searching: false,
                "pageLength": 25,
                "order": [[ 1, "desc" ]],
                /* Disable initial sort */
                "ordering": false,
                "aaSorting": [],
                bLengthChange: false
           });
           var datatable = jQuery('#reports-list').DataTable( {
                responsive: true,
                searching: false,
                "pageLength": 25,
                "order": [[ 2, "asc" ]],
                /* Disable initial sort */
                "aaSorting": [],
                bLengthChange: false,
                "columns": [
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                   { className:'sortable' },
                   { className:'sortable' }

                ],
                "columnDefs": [
                    { "visible": true, "targets": 0},
                    { "visible": true, "targets": 1 },
                    { "visible": true, "targets": 2 },
                    { "visible": true, "targets": 3 },
                    { "visible": true, "targets": 4 },
                    { "visible": true, "targets": 5 }
                ],
                
                drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;
            var groupingCounts = [];
            var counter = 1;
            var current = 0;
            var totalClicks = 0;
            var totalDuration = 0;
            var totalURL = 0;
            var ccid = 0;
            var cur_url = '';
            var url = '';

            
            
             api.column(groupColumn, { page: 'current' }).data().each(function (group, i) {
                groupname = group.split("-")[1];
                
 
                if(cur_url == api.rows({ page: 'current' }).data()[i][1]) {
                    totalURL++;
                } else {
                    cur_url = api.rows({ page: 'current' }).data()[i][1];
                    totalURL = 0;
                }
               
                country = api.rows({ page: 'current' }).data()[i][1];
                totalClicks = api.rows({ page: 'current' }).data()[i][3];
                url = group;    
                    
                if (last !== group) {
                    
                    if (last !== undefined) {
                         groupingCounts[last] = counter;
                    }
                    
                    current = i;
                    last = group;
                    
                    if(typeof api.rows({ page: 'current' }).data()[i+1] == 'undefined' || group != api.rows({ page: 'current' }).data()[i+1][0] ){
                    
                     totalURL = 0;
                    
                    }

 
                    
                } else {
                    
                    counter++;
                    ccid = group;
                //// Print Group Label    
                if(typeof api.rows({ page: 'current' }).data()[i+1] == 'undefined' || cur_url != api.rows({ page: 'current' }).data()[i+1][0] ){
                     counter = 1;
                     totalURL = 0;
                    
                    
              } else {
                   
                    
                
              }
              ////////// End print Group Label
              

                    
                    
                
                    
                
              

                }
                

                
                             

                    
                
            });



            
        },
        
        
        

        
        // loop all columns

        
    // end loop all columns
            
            } );
        
    },
     error: function(jqxhr, status, exception) {
             console.log('Exception:', exception);
         }
    
    
});
   









});


</script>


        
<?php } ?>  

