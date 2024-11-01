<?php 
if( !defined( 'ABSPATH' ) ) exit;

$footer_script=uxsniff_get_option_footer_script();

?>


<div class="uxsniff_header">
	<div class="logo"></div>
	<h2>Inspect Element (Last 7 days)</h2>
</div>


<div class="ucsniff_clear" style="border-bottom: 3px solid #e5e7ea;margin:10px 15px 25px 0"></div>

<?php if ($footer_script=='') { ?>
	<p>Please setup your tracking code in the <a href="admin.php?page=uxsniff-info">Settings</a>.
<?php } else {  
    

$url = $_GET['url'];
$ele = $_GET['raw'];
$label = $_GET['label'];

$string = $ele;
$element = explode(".",$string)[0];
$classstring = explode(".",$string)[1];
$class = explode(":",$classstring)[0];
$child = explode(":",$classstring)[1];

    
?>


<style>
table.dataTable td.break {
  max-width:150px;    
  word-break: break-word;
}      

.dataTable td, .dataTable th {
    /* don't shorten cell contents */
    white-space: normal !important;
}
.dataTables_filter{display:none;}
 .overview-detail b{ width:120px;display:inline-block;float:left;clear:both;margin:5px 0}
 .overview-detail span{ width:250px; display:inline-block; float:left;margin:5px 0}
</style>

<div class="front-wrapper">
	<div class="wrapper" id="account-wrapper">
		<div class="no-padding">
			<div class="row">
				<div class="col-md-12" id="account-content">



 
  <form class="form row" >

  <div class="form-group row col-sm-6">
      
  </div>

  <div class="form-group row col-sm-3">
  </div>

  <div class="form-group row col-sm-3  ml-5">
       <label class="control-label col-sm-4 text-right" for="category">Show</label>
    <div class="col-sm-8">
       <select class="form-control form-control-sm" id="entries">
            <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
      </select>
    </div>
  </div>
    
    
  </form>


<div class="uxsniff_clear"></div>


<div class="row">

<div class="col-sm-8 no-padding">
<div class="white-container overview" style="margin:20px 20px 15px 0;width:100%">
  <div id="chartdiv2" style="width:100%;height:300px;"></div>
</div>
</div>

<div class="col-sm-4 no-padding">
<div class="overview white-container text-left" style="width:100%;min-height:330px;margin:20px 0px 15px 0;">
                <div class="overview-detail">
                    <div class="overview-detail"><b>URL</b><span id="url"></span></div>
                      <div class="overview-detail"><b>Element</b><span><?php echo 'The <u>'.uxsniff_ordinal(($child+1)).'</u> <i>'.htmlentities($element).'.'.$class.'</i> <br>';
 ?></span></div>
                     <div class="overview-detail"><b>Contain Text</b><span id="contain"></span></div>
                     <div class="overview-detail"><b>Sessions</b><span id="tsessions"></span></div>
                     <div class="overview-detail"><b>Total Clicks</b><span id="tclicks"></span></div>
                     <div class="overview-detail"><b>Average CTR</b><span id="ctr"></span></div>

<div style="clear:both;width:100%;height:20px"></div>
<div class="account-detail-item" style="text-align:center">

     <!-- <a class="blue" href="/">Inspect Element in All URL</a>-->

<a class="blue" href="https://uxsniff.com/elementmap?url=<?php echo urlencode($url);?>&w=1900x860&cls=<?php echo rawurlencode($ele);?>&label=&c=1" target="_blank">View Element</a>

</div>
                    
                  </div>


</div>
</div>
</div>


<div class="uxsniff_clear"></div>
<div id="inspect_table"></div>




<!-- Page script -->
<script>   
 jQuery('.report-action#delete-report').on('click', function() {
    console.log('del');    
      var parent = jQuery(this).parents('.report-item');
      self.lastReportAction = parent.data('report-id');
      jQuery('.modal#modal-delete-report').modal({keyboard: true, backdrop: true}); // confirm via modal prompt
    });

    // confirm delete
    jQuery("#confirm-delete-report").on('click', function() {
      self.delete(self.lastReportAction); // delete from db
      jQuery(".report-item[data-report-id='" + self.lastReportAction + "']").remove(); // delete from DOM
      self.lastReportAction = null;
    });

    // rename report
    jQuery('.report-action#rename-report').on('click', function() {
      var parent = jQuery(this).parents('.report-item');
      var currentTitle = parent.find(".report-title a").text();
      self.lastReportAction = parent.data('report-id');
      jQuery("#new-report-title").val(currentTitle);
      jQuery('.modal#modal-rename-report').modal({keyboard: true, backdrop: true}); // confirm via modal prompt
    });
    jQuery("#new-report-title").on('keypress', function(e) {
      if(e.which == 13) jQuery('#confirm-rename-report').click();
    });
    jQuery('.modal#modal-rename-report').on('shown.bs.modal', function () {
      jQuery("#new-report-title").select().focus();
    });
    jQuery("#confirm-rename-report").on('click', function() {
      var newTitle = jQuery("#new-report-title").val();
      newTitle = newTitle.trim().length > 0 ? newTitle : newTitle.trim();
      if(newTitle.length > 200) {
        alert('Please limit your title to 200 characters (your title is ' + newTitle.length + ' characters)');
        return;
      }
      self.rename(self.lastReportAction, newTitle);
      jQuery(".report-item[data-report-id='" + self.lastReportAction + "']").find('.report-title a').text(newTitle.length ? newTitle : 'untitled'); // update DOM
      self.lastReportAction = null;
    });
    
jQuery(document).ready(function() {
	
getData(7,'','','<?php echo $url;?>','<?php echo $ele;?>','<?php echo $label;?>');
 
    jQuery('#entries').change( function() {
        datatable.page.len(jQuery(this).val()).draw();
    } ); 
    
    
    
} );




function getData(days, dateFrom, dateTo, url, ele, label){


         jQuery('#url').text(url);
         jQuery('#element').html(ele);
         jQuery('#contain').text(label);


var dd = [];
if(days > 0){
  var fr = moment().subtract(7,'d').format('YYYY-MM-DD');
  var to = moment().format('YYYY-MM-DD');
}else{
  var fr = moment(dateFrom).format('YYYY-MM-DD');
  var to = moment(dateTo).format('YYYY-MM-DD');
}
var i =0;

console.log(fr+'-'+to)
if(days=='') days = moment(to).diff(fr, 'days')
console.log(days);

/*
if(days > 0) {
  while(days > 0){
    if(i==0){
      if(dateTo==''){
        fr = moment().subtract((days>=30?30:days),'d').format('YYYY-MM-DD');
        to = moment().format('YYYY-MM-DD');        
      } else {
        to = moment(dateTo).format('YYYY-MM-DD');
        fr = moment(dateTo).subtract(30,'d').format('YYYY-MM-DD');
      }
      dd.push({days: 0, dateFrom: fr, dateTo: to, url: url, ele:ele, label:label});
      console.log('pushed'+dd);
      console.log({days: '', dateFrom: fr, dateTo: to});
      days = days - (days>=30?30:days);
    } else if(days >= 30 ){
        to = moment(fr).subtract(1,'d').format('YYYY-MM-DD');
        fr = moment(fr).subtract(30,'d').format('YYYY-MM-DD');
        
        dd.push({days: '', dateFrom: fr, dateTo: to, url: url, ele:ele, label:label});
        days = days - 30;
    } else if(days > 0) {
        to = moment(fr).subtract(1,'d').format('YYYY-MM-DD');
        fr = moment(fr).subtract(days,'d').format('YYYY-MM-DD');
        
        dd.push({days: '', dateFrom: fr, dateTo: to, url: url, ele:ele, label:label});
        days = days - days;
    } 
    i++;
  }
} 
*/

// disable ajax pagination
dd.push({days: days, dateFrom: dateFrom, dateTo: dateTo, url: url, ele:ele, label:label});

console.log('final'+dd);
console.log(dd);
var first = dd.shift();
console.log('get first'+first);
console.log(first);
jQuery.ajax({ 
    type: 'GET', 
    data: first,
    url: 'https://api.uxsniff.com/json/wp_journey.php', 
    success: function (data) { 
  
        
        var table =  "<table id='reports-list' class='reports-list' cellspacing='0' width='100%' style='display:table'>";
        var current_sid = '';
        var stamp = 0;
        var seconds = 0;
        var duration = 0;

        table += '<thead><tr><th>Date</th><th>Date</th><th>URL</th><th>Element</th><th>Contain Text</th><th>Unique Clicks</th><th>Total Clicks</th><th>Sessions</th><th>CTR%</th></tr></thead><tbody>';

        var chartDate = {};
        var chartClick = {};
        var chartCT = {};
        var v = [];
        var c = [];
        var ct = [];
        var total_view = 0;
        var total_click = 0;

        jQuery.each(data.pageview, function(id, element) {
        
        var date = moment(id).format('MMM D Y h:m:ss a');
        var date2 = moment(id).format('MMM D');
        var date3 = moment(id).format('h:m a');
        seconds = 0;
        var current = '';
        var classname = 'report-item';

        if(typeof data.data[id] != 'undefined') total_click += parseInt(data.data[id].totalClicks);
        total_view += parseInt(element);

//console.log('data'+data.data[id].totalClicks+' id:'+id);
       if(typeof data.data[id] != 'undefined') table += '<tr class="'+classname+'"><td>'+id+'</td><td>'+date2+'</td><td><?php echo $url?></td><td><?php echo 'The <u>'.uxsniff_ordinal(($child+1)).'</u> '.htmlentities(uxsniff_matchElement($element)).' having class name of <i>'.$class.'</i>. <br>';?></td><td><?php echo $label?></td><td>'+data.data[id].uniqueClicks+'</td><td>'+data.data[id].totalClicks+'</td><td>'+element+'</td><td>'+eval(parseInt(data.data[id].totalClicks)/parseInt(element)*100).toFixed(2)+'%</td></tr>';
        else 
       table += '<tr class="'+classname+'"><td>'+id+'</td><td>'+date2+'</td><td><?php echo $url?></td><td><?php echo 'The <u>'.uxsniff_ordinal(($child+1)).'</u> '.htmlentities(uxsniff_matchElement($element)).' having class name of <i>'.$class.'</i>. <br>';?></td><td><?php echo $label?></td><td>0</td><td>0</td><td>'+element+'</td><td>0%</td></tr>';


       var date4 = moment(id).format('MMM D');
            
        // Chart Data
        if(typeof chartDate[date4] == 'number') chartDate[date4] = parseInt(chartDate[date4]) + parseInt(element);
        else chartDate[date4] = parseInt(element); 
        
        if(typeof chartClick[date4] == 'number') chartClick[date4] = parseInt(chartClick[date4]) + (typeof data.data[id] != 'undefined')?parseInt(data.data[id].totalClicks):0;
        else chartClick[date4] = (typeof data.data[id] != 'undefined')?parseInt(data.data[id].totalClicks):0; 

        if(typeof chartCT[date4] == 'float') chartCT[date4] = parseFloat(chartCT[date4]) + (typeof data.data[id] != 'undefined')?eval(parseInt(data.data[id].totalClicks)/parseInt(element)*100).toFixed(2)/2:0;
        else chartCT[date4] = (typeof data.data[id] != 'undefined')?eval(parseInt(data.data[id].totalClicks)/parseInt(element)*100).toFixed(2):0;     
           

        });

        //console.log(total_click + '/' + total_view)
        jQuery('#ctr').text(eval(total_click/total_view * 100).toFixed(2)+'%');
        jQuery('#tsessions').text(total_view);
        jQuery('#tclicks').text(total_click);
    
    //console.log(chartDate);
        // cahrt Data
        jQuery.each(chartDate, function(key, value) {
            var a = [];
            a.push(key)
            a.push(value);
            v.push(a);
            
        });
        v.reverse();
        jQuery.each(chartClick, function(key, value) {
            var a = [];
            a.push(key);
            a.push(value);
            c.push(a);
            
        });
        c.reverse();
        jQuery.each(chartCT, function(key, value) {
            var a = [];
            a.push(key);
            a.push(value);
            ct.push(a);
            
        });
        ct.reverse();
        //console.log(c);
        drawChart(v,c, ct);
        
        
        
        table +='</tbody></table>';
        
        
        if(typeof datatable =='object' || jQuery.fn.dataTable.isDataTable( '#inspect_table')){
           datatable.destroy();
           jQuery('#inspect_table, #pagi').empty();
           jQuery('#customdate').hide();
        }
        
        
        jQuery('#inspect_table').append(table);
            
           //"order": [[ 0, "desc" ],[ 1, "desc" ]],
           var groupColumn = 0;
          datatable = jQuery('#reports-list').DataTable( {
		    	responsive: true,
		    	searching: true,
		    	bLengthChange: false,
		    	"order": [[ 0, "desc" ]],
          "columns": [
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'' }],
          "columnDefs": [
                    { "visible": false,  "targets": 0},
                    { "visible": false,  "targets": 2},
                    { "visible": false,  "targets": 3},
                    { "visible": false,  "targets": 4}
                ],        
          initComplete: (settings, json)=>{
              jQuery('#reports-list_paginate').appendTo('#pagi');
          },
        
        
        

        
        // loop all columns

        
    // end loop all columns
		    
            } );
            

    jQuery('#entries').change( function() {
        datatable.page.len(jQuery(this).val()).draw();
    } );
        
    jQuery.each(dd,function(i,o){
      getTheData(o);
    });
        
    },
     error: function(jqxhr, status, exception) {
             console.log('Exception:', exception);
         }
    
    
});
}

function getTheData(data){
  console.log('get:'+data);
jQuery.ajax({ 
    type: 'GET', 
    data: data,
    url: 'https://api.uxsniff.com/json/wp_journey.php', 
    success: function (data) { 
      var rows = [];
      jQuery.each(data.data, function(id, element) {
        
        var date = moment(element.timestamp).format('MMM D Y h:m:ss a');
        var date2 = moment(element.timestamp).format('MMM D');
        var date3 = moment(element.timestamp).format('h:m a');
        seconds = 0;
        rows.push([id, date2, element.uniqueClicks, '<?php echo $url;?>','','<?php echo $label;?>',element.totalClicks, data.pageview[element.date], eval(parseInt(element.totalClicks)/parseInt(data.pageview[element.date])*100).toFixed(2)]);
         
      });
      console.log(rows);
        datatable.rows.add(rows).draw();
    }
});
}

function drawChart(v,c, ct){
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
                data: ['sessions', 'clicks', 'CTR(%)']
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
                type: 'line',
                symbolSize: 8,
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
                symbolSize: 8,
                symbol: 'circle',
                areaStyle: {
                     opacity: '0.1'
                },
                lineStyle: {
                    width: 3
                },
                itemStyle: {
                    color: '#058dc7'
                }
            },{
                name: 'CTR(%)',
                data: ct,
                type: 'line',
                symbolSize: 8,
                symbol: 'circle',
                areaStyle: {
                     opacity: '0.1'
                },
                lineStyle: {
                    width: 3
                },
                itemStyle: {
                    color: '#5bdb00'
                }
            }]
        };
	
	myChart2.setOption(option);    
}




</script>











</div></div></div></div></div>








		
<?php } ?>	

