<?php 
if( !defined( 'ABSPATH' ) ) exit;

$footer_script=uxsniff_get_option_footer_script();

?>


<div class="uxsniff_header">
	<div class="logo"></div>
	<h2>Element Inspector (Last 7 days)</h2>
</div>


<div class="ucsniff_clear" style="border-bottom: 3px solid #e5e7ea;margin:10px 15px 25px 0"></div>

<?php if ($footer_script=='') { ?>
	<p>Please setup your tracking code in the <a href="admin.php?page=uxsniff-info">Settings</a>.
<?php } else {  ?>


<style>
#reports-list_filter{display:none}
</style>

<div class="front-wrapper">
	<div class="wrapper" id="account-wrapper">
		<div class="no-padding">
			<div class="row">
				<div class="col-md-12" id="account-content">



 
  <form class="form row" >

  <div class="form-group row col-sm-6">
       <label class="control-label col-sm-2 align-left text-left" for="category">Search</label>
    <div class="col-sm-8">
       <input type="text" class="form-control form-control-sm" id="search">
    </div>
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

<div id="inspector_table"></div>




<!-- Page script -->
<script>   
 
jQuery(document).ready(function() {
	
getData(7,'','');
   
   jQuery('#search').keyup(function(){
      datatable.search(jQuery(this).val()).draw() ;
    });
    // Event listener to the two range filtering inputs to redraw on input
    jQuery('#label').keyup( function() {
        datatable.draw();
    } );

    jQuery('#entries').change( function() {
        datatable.page.len(jQuery(this).val()).draw();
    } ); 
    
    
    
} );









function getData(days, dateFrom, dateTo){

var dd = [];
if(days > 0){
  var fr = moment().subtract(7,'d').format('YYYY-MM-DD');
  var to = moment().format('YYYY-MM-DD');
}else{
  var fr = moment(dateFrom).format('YYYY-MM-DD');
  var to = moment(dateTo).format('YYYY-MM-DD');
}
var i =0;


if(days=='') days = moment(to).diff(fr, 'days');


if(days > 0) {
  while(days > 0){
    if(i==0){
      if(dateTo==''){
        fr = moment().subtract((days>=14?14:days),'d').format('YYYY-MM-DD');
        to = moment().format('YYYY-MM-DD');        
      } else {
        to = moment(dateTo).format('YYYY-MM-DD');
        fr = moment(dateTo).subtract(14,'d').format('YYYY-MM-DD');
      }
      dd.push({days: 0, dateFrom: fr, dateTo: to});
      console.log('pushed'+dd);
      console.log({days: '', dateFrom: fr, dateTo: to});
      days = days - (days>=14?14:days);
    } else if(days >= 14 ){
        to = moment(fr).subtract(1,'d').format('YYYY-MM-DD');
        fr = moment(fr).subtract(14,'d').format('YYYY-MM-DD');
        
        dd.push({days: '', dateFrom: fr, dateTo: to});
        days = days - 14;
    } else if(days > 0) {
        to = moment(fr).subtract(1,'d').format('YYYY-MM-DD');
        fr = moment(fr).subtract(days,'d').format('YYYY-MM-DD');
        
        dd.push({days: '', dateFrom: fr, dateTo: to});
        days = days - days;
    } 
    i++;
  }
} 


var first = dd.shift();
jQuery.ajax({ 
    type: 'GET', 
    data: first,
    url: 'https://api.uxsniff.com/json/wp_raw.php', 
    success: function (data) { 
  
        
        var table =  "<table id='reports-list' class='reports-list' cellspacing='0' width='100%' style='display:table'>";
        var current_sid = '';
        var stamp = 0;
        var seconds = 0;
        var duration = 0;

        table += '<thead><tr><th>Date</th><th>Date</th><th>Name</th><th>URL</th><th>Element</th><th>Contains Text</th><th>Unique Clicks</th><th>Total Clicks</th><th>Action</th></tr></thead><tbody>';

        jQuery.each(data.data, function(id, element) {
        
        var date = moment(element.date).format('MMM D Y h:m:ss a');
        var date2 = moment(element.date).format('MMM D');
        var date3 = moment(element.date).format('h:m a');
        seconds = 0;
        var current = '';
        var classname = 'report-item';
         
       table += '<tr class="'+classname+'"><td>'+element.date+'</td><td>'+date2+'</td><td>'+element.text+'</td><td>'+element.url+'</td><td>'+element.ele+'</td><td>'+element.label+'</td><td>'+element.uniqueClicks+'</td><td>'+element.totalClicks+'</td><td><a href="admin.php?page=uxsniff-inspect&url='+encodeURIComponent(element.url)+'&raw='+element.raw+'&label='+encodeURIComponent(element.label)+'" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect element" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/search.svg";?>" style="width:32px" ></a><a href="admin.php?page=uxsniff-inspect-url&url='+encodeURIComponent(element.url)+'" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect URL" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/link.svg";?>" style="width:32px" ></a></td></tr>';
           
           
        });
        
        
        
        table +='</tbody></table>';
        
        
        if(typeof datatable =='object' || jQuery.fn.dataTable.isDataTable( '#chartdiv')){
           datatable.destroy();
           jQuery('#inspector_table, #pagi').empty();
           jQuery('#customdate').hide();
        }
        
        
        jQuery('#inspector_table').append(table);
            
           //"order": [[ 0, "desc" ],[ 1, "desc" ]],
           var groupColumn = 0;
          datatable = jQuery('#reports-list').DataTable( {
		    	responsive: true,
		    	searching: true,
		    	bLengthChange: false,
		    	"order": [[ 0, "desc" ]],
          "columns": [
                  { className:'sortable', "visible": false },
		  { className:'sortable' },
                  { className:'sortable' },
                  { className:'break sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'sortable' },
                  { className:'' }],
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
jQuery.ajax({ 
    type: 'GET', 
    data: data,
    url: 'https://api.uxsniff.com/json/wp_raw.php', 
    success: function (data) { 
      var rows = [];
      jQuery.each(data.data, function(id, element) {
        
        var date = moment(element.date).format('MMM D Y h:m:ss a');
        var date2 = moment(element.date).format('MMM D');
        var date3 = moment(element.date).format('h:m a');
        seconds = 0;
        rows.push([date, date2, element.text, element.url, element.ele, element.label, element.uniqueClicks, element.totalClicks,'<a href="admin.php?page=uxsniff-inspect&url='+encodeURIComponent(element.url)+'&raw='+element.raw+'&label='+encodeURIComponent(element.label)+'" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect element" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/search.svg";?>" style="width:32px" ></a><a href="inspect-url?url='+encodeURIComponent(element.url)+'" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect URL" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/link.svg";?>" style="width:32px" ></a>']);
      });
      //console.log(rows);
        datatable.rows.add(rows).draw();
    }
});
}  
</script>











</div></div></div></div></div>








		
<?php } ?>	

