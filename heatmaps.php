<?php 
if( !defined( 'ABSPATH' ) ) exit;

$footer_script=uxsniff_get_option_footer_script();
$footer_domain = uxsniff_get_option_footer_domain();
?>


<div class="uxsniff_header">
    <div class="logo"></div>
    <h2>Heatmaps (Last 7 days)</h2>
</div>


<div class="uxsniff_clear" style="border-bottom: 3px solid #e5e7ea;margin:10px 15px 25px 0"></div>

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

<div id="heatmap_table"></div>




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


// disable ajax pagination
dd.push({days: days, dateFrom: dateFrom, dateTo: dateTo});


var first = dd.shift();

jQuery.ajax({ 
    type: 'GET', 
    data: first,
    url: 'https://api.uxsniff.com/json/wp_heatmap.php?domain=<?php echo esc_html($footer_domain);?>', 
    success: function (data) { 
  
        
        var table =  "<table id='reports-list' class='reports-list' cellspacing='0' width='100%' style='display:table'>";
        var current_sid = '';
        var stamp = 0;
        var seconds = 0;
        var duration = 0;

        table += '<thead><tr><th>URL</th><th>Pageviews</th><th>Action</th></tr></thead><tbody>';

        jQuery.each(data.data, function(id, element) {
        
        var current = '';
        var classname = 'report-item';
        
        //console.log(element);
         
         https://uxsniff.com/#view=206549372&view_path=%2F&view_domain=https://uxsniff.com&uxs_heatmap_inline=1&days=7&from=&to=&device=desktop

       table += '<tr class="'+classname+'"><td>'+element.url+'</td><td>'+element.users+'</td><td><a href="'+element.url+'#uxs_heatmap_inline=1&device=desktop" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="View heatmap" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/fire.svg";?>" style="width:30px" ></a><a href="'+element.url+'#uxs_clickmap_inline=1&device=desktop" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="View Clickmap" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/mouse.svg";?>" style="width:28px" ></a></td></tr>';
           
           
        });
        
        
        
        table +='</tbody></table>';
        
        
        if(typeof datatable =='object' || jQuery.fn.dataTable.isDataTable( '#heatmap_table')){
           datatable.destroy();
           jQuery('#heatmap_table, #pagi').empty();
           jQuery('#customdate').hide();
        }
        
        
        jQuery('#heatmap_table').append(table);
            
           //"order": [[ 0, "desc" ],[ 1, "desc" ]],
           var groupColumn = 0;
          datatable = jQuery('#reports-list').DataTable( {
                responsive: true,
                searching: true,
                bLengthChange: false,
                "order": [[ 1, "desc" ]],
          "columns": [
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
  console.log('get:'+data);
jQuery.ajax({ 
    type: 'GET', 
    data: data,
    url: 'https://api.uxsniff.com/json/wp_heatmap.php?domain=<?php echo $footer_domain;?>', 
    success: function (data) { 
      var rows = [];
      jQuery.each(data.data, function(id, element) {
        
        var date = moment(element.date).format('MMM D Y h:m:ss a');
        var date2 = moment(element.date).format('MMM D');
        var date3 = moment(element.date).format('h:m a');
        seconds = 0;
        rows.push([element.url, element.users,'<a href="admin.php?page=uxsniff-heatmap&url='+encodeURIComponent(element.url)+'" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="View heatmap" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/fire.svg";?>" style="width:30px" ></a><a href="admin.php?page=uxsniff-inspect-url&url='+encodeURIComponent(element.url)+'" target="_blank"><img data-toggle="tooltip" title="" class="report-action view-report" aria-hidden="true" data-original-title="Inspect URL" src="<?php echo plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/img/link.svg";?>" style="width:32px" ></a>']);


      });
      //console.log(rows);
        datatable.rows.add(rows).draw();
    }
});
}  
</script>











</div></div></div></div></div>








        
<?php } ?>  

