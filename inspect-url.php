<?php 
if( !defined( 'ABSPATH' ) ) exit;

$footer_script=uxsniff_get_option_footer_script();

?>


<div class="uxsniff_header">
	<div class="logo"></div>
	<h2>Inspect URL (Last 7 days)</h2>
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

$class_ele = explode(" ", $class);
$class = '';
foreach($class_ele as $obj){
 if(ctype_upper($obj) == false) $class .= $obj;
}

    
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

                    
                  </div>


</div>
</div>
</div>


<div class="uxsniff_clear"></div>
<div id="inspect-url_table"></div>




<!-- Page script -->
<script>   

jQuery(document).ready(function() {


jQuery('#search').keyup(function(){
      datatable.search(jQuery(this).val()).draw() ;
});  
	
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
    url: 'https://api.uxsniff.com/json/wp_raw-url.php', 
    success: function (data) { 
  
        
        var table =  "<table id='reports-list' class='reports-list' cellspacing='0' width='100%' style='display:table'>";
        var current_sid = '';
        var stamp = 0;
        var seconds = 0;
        var duration = 0;
        var topClick = {};
        var topClickText = {};

        table += '<thead><tr><th>Element</th><th>Class</th><th>Contain Text</th><th>Unique Clicks</th><th>Total Clicks</th><th>Action</th></tr></thead><tbody>';

        var chartDate = {};
        var chartClick = {};
        var chartCT = {};
        var v = [];
        var c = [];
        var ct = [];
        var total_view = 0;
        var total_click = 0;

        jQuery.each(data.data, function(id, element) {
            
     
        var date = moment(id).format('MMM D Y h:m:ss a');
        var date2 = moment(id).format('MMM D');
        var date3 = moment(id).format('h:m a');
        seconds = 0;
        var current = '';
        var classname = 'report-item';


       if (topClickText[id] == 'undefined') topClickText[id] = {};
           var aa = {}
           aa['label'] = element.label
           aa['ele'] = element.element;
           topClickText[id] = aa;
	  
           //topClickText[id]['ele'] = element.element; 
           //console.log(topClickText);

       table += '<tr class="'+classname+'"><td>'+element.element+'</td><td>'+element.class+'</td><td>'+element.label+'</td><td>'+element.uniqueClicks+'</td><td>'+element.totalClicks+'</td><td>';
       table += '<a href="admin.php?page=uxsniff-inspect&url=<?php echo urlencode($url);?>&raw='+encodeURIComponent(id)+'&label='+encodeURIComponent(element.label)+'" target="_blank">';
       table += '<img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect element" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/search.svg";?>" style="width:32px" ></a>';

       table += '<a href="https://uxsniff.com/elementmap?url=<?php echo urlencode($url);?>&w=1900x860&cls='+encodeURIComponent(id)+'&label='+encodeURIComponent(element.label)+'&c='+element.totalClicks+'" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="View element" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/eye.svg";?>" style="width:32px;"></a></td></tr>';

       (typeof topClick[id] == 'undefined')? topClick[id] = parseInt(element.totalClicks): topClick[id] += parseInt(element.totalClicks);
       var date4 = moment(id).format('MMM D');

       

        });

    
        // cahrt Data


        var sdata = [];
        var ssdata = [];
        var used = []
        
         jQuery.each(topClick, function(index, data) {
            var b = {};
            var found = false;
            b['value'] = parseInt(data);
            b['name'] = topClickText[index]['label'];
            jQuery.each(sdata, function(index, data){
                if(data['name'] == b['name']){
                    found = true;
                    data['value'] += parseInt(b['value']);
                }
            });
            if(b['value']>0 && b['name']!='undefined' && !found) sdata.push(b);
        });

        
        console.log(sdata);
        
        // multisort data
        sdata.sort(function(a, b) {
            return a["value"] - b["value"];
        });
        sdata.reverse();
        gdata = sdata.slice(0, 10);
        
        // console.log(sdata);
        // console.log(gdata);
        drawChart(sdata,gdata);
        
        
        
        table +='</tbody></table>';
        
        
        if(typeof datatable =='object' || jQuery.fn.dataTable.isDataTable( '#inspect-url_table')){
           datatable.destroy();
           jQuery('#inspect-url_table, #pagi').empty();
           
        }
        
        
        jQuery('#inspect-url_table').append(table);
            
           //"order": [[ 0, "desc" ],[ 1, "desc" ]],
           var groupColumn = 0;
          datatable = jQuery('#reports-list').DataTable( {
		    	responsive: true,
		    	searching: true,
		    	bLengthChange: false,
		    	"order": [[ 4, "desc" ]],
          "columns": [
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'' }
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
    url: 'https://api.uxsniff.com/json/wp_raw-url.php', 
    success: function (data) { 
      var rows = [];
      jQuery.each(data.data, function(id, element) {
        
        var date = moment(element.timestamp).format('MMM D Y h:m:ss a');
        var date2 = moment(element.timestamp).format('MMM D');
        var date3 = moment(element.timestamp).format('h:m a');
        seconds = 0;
        rows.push([element.element, element.class, element.label,  element.uniqueClicks ,element.totalClicks,'<a href="inspadmin.php?page=uxsniff-inspect&url=<?php echo urlencode($url);?>&raw='+encodeURIComponent(id)+'&label='+encodeURIComponent(element.label)+'" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect element" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/search.svg";?>" style="width:32px" ></a>']);

      });
      console.log(rows);
        datatable.rows.add(rows).draw();
    }
});
}

function drawChart(sdata, gdata){
	var myChart2 = echarts.init(document.getElementById('chartdiv2'));
	option = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                type: 'scroll',
                orient: 'vertical',
                x: 'left',
                data: sdata,
                selected: gdata
            },
            series : [
                {
                    name: 'Top Clicked Elements',
                    type: 'pie',
                    radius : '70%',   
                    center: ['82%', '50%'],                 
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
                        
                    }
                    
                }
            ],
            
            
           
        };
	
	myChart2.setOption(option);    
}



</script>











</div></div></div></div></div>








		
<?php } ?>	

