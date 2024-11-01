<?php 
if( !defined( 'ABSPATH' ) ) exit;

$footer_script=uxsniff_get_option_footer_script();
$footer_domain = uxsniff_get_option_footer_domain();
$parse_url = parse_url($footer_domain);
$domain = $parse_url['host'];

$svg_desktop = '<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="tv-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="lighticon desktop"><path fill="currentColor" d="M536 480H104a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h432a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zM608 0H32A32 32 0 0 0 0 32v352a32 32 0 0 0 32 32h576a32 32 0 0 0 32-32V32a32 32 0 0 0-32-32zm0 384H32V32h576z" class=""></path></svg>';
$svg_mobile = '<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="mobile" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="lighticon mobile"><path fill="currentColor" d="M192 416c0 17.7-14.3 32-32 32s-32-14.3-32-32 14.3-32 32-32 32 14.3 32 32zM320 48v416c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V48C0 21.5 21.5 0 48 0h224c26.5 0 48 21.5 48 48zm-32 0c0-8.8-7.2-16-16-16H48c-8.8 0-16 7.2-16 16v416c0 8.8 7.2 16 16 16h224c8.8 0 16-7.2 16-16V48z" class=""></path></svg>';

?>


<div class="uxsniff_header">
    <div class="logo"></div>
    <h2>Recordings (Last 7 days)</h2>
</div>


<div class="uxsniff_clear" style="border-bottom: 3px solid #e5e7ea;margin:10px 15px 25px 0"></div>

<?php if ($footer_script=='') { ?>
    <p>Please setup your tracking code in the <a href="admin.php?page=uxsniff-info">Settings</a>.
<?php } else {  ?>


<style>
td.subrow table {  width: 100%;}
#reports-list_filter{display:none}
#reports-list tr { cursor: pointer; }
a.play-recording .fas, a.play-recording .far{ color: #1384d7; }
a.play-recording:visited .fas, a.play-recording:visited .far{ color: rgba(74,74,74,.89); }

a.play-recording { color: #1384d7; }
a.play-recording:visited { color: rgba(74,74,74,.89); }

.report-action { font-size: 16px; }
.small-text {font-size:12px;font-weight:500}

.reports-list td a.action { display: flex !important; }
.action_icon { width: 15px; height: 15px; }
a.action {
  color: rgb(94, 94, 94);
  background: none;
  border-radius: 50%;
  font-size: 16px !important;
  height: 40px;
  width: 40px;
  vertical-align: middle;
  display: flex;
  align-items: center;
  justify-items: center;
  justify-content: center;
}
a.action:hover {
  text-decoration: none;
  background: #e5e7ea;
  color: #313131;
}
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

<div id="chartdiv"></div>




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



var json = '';
var datatable = '';

Array.prototype.unique = function() {
  return this.filter(function (value, index, self) { 
    return self.indexOf(value) === index;
  });
}
function secondsToHms(d) {
    d = Number(d);
    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    var hDisplay = h > 0 ? h + (h == 1 ? " hr, " : " hrs, ") : "";
    var mDisplay = m > 0 ? m + (m == 1 ? " min, " : " mins, ") : "";
    var sDisplay = s > 0 ? s + (s == 1 ? " sec" : " secs") : "";
    return hDisplay + mDisplay + sDisplay; 
}


function format(cid) { 
 var childTable = '';
   jQuery.each(json[cid], function(sid, element) {


            var browserSize = element['browserSize'];
            var totalDuration = (element['duration']>0?'':'-') +secondsToHms(element['duration']);
            var totalPages = element['totalUrl'];
            var date = moment.utc(element.timestamp).local().format('MMM D Y h:mm:ss a');
            var osbrowser = element['browser']+' '+element['os'];
            var url = element['url'];
            var country = element['countryName'];
            var link = 'https://app.uxsniff.com/recording?cid='+cid+'&sid='+sid+'&domain=<?php echo $domain;?>&subdomain=<?php echo $domain;?>&landing='+encodeURIComponent(url)+'&os='+element.os+' - '+element.browser+'&country='+element.country+'&date='+date;


     childTable += '<table class="subreports-list" id="recording-'+sid.replace('.','-')+'"><tbody><tr>' +
            '<td class="col-sm-1"></td><td class="col-sm-3"><div class="col-sm-12 text-left"><i class="fa fa-calendar-alt question-tooltip-icon "></i><a class="play-recording" style="font-size:14px;" href="'+ link +'" target="_blank">'+date+'</a> </div></td>' +
            '<td class="col-sm-1" style="padding:0"><div class="col-sm-12" style="text-align:left; padding: 0; display:flex;"><a class="play-recording action" data-url-id="'+sid+'" href="'+link+'"  data-toggle="tooltip" data-original-title="Play recording" target="_blank"><img src="<?php echo plugin_dir_url( __FILE__ );?>assets/img/play-solid.svg" class="action_icon"></a></div></td>' +
            '<td class="col-sm-7 text-left">';



childTable +=  '<b>Landing page</b>: '+url+'<br>';
childTable +=  '<b>Duration</b>: '+totalDuration+'<br>';
childTable +=  '<b>Device</b>: '+osbrowser+'<br>';
childTable +=  '<b>Clicks</b>: '+element['clicks']+'<br>';
childTable +=  '<b>Referrer</b>: '+element['referrer']+'<br>';


      childTable +=  '</td></tr></tbody></table>';
      });
          
    return childTable;
  }



jQuery.ajax({ 
    type: 'GET', 
    data: first,
    url: 'https://api.uxsniff.com/json/wp_recordlist.php?domain=<?php echo esc_html($footer_domain);?>', 
    success: function (data) { 
  
        json = data.data;
        
        var table =  "<table id='reports-list' class='reports-list' cellspacing='0' width='100%' style='display:table'>";
        var current_sid = '';
        var stamp = 0;
        var seconds = 0;
        var duration = 0;
        
       
        table += '<thead><tr><th>Date</th><th>Users</th><th>Users</th><th>Sessions</th><th>Pages</th><th>Landing page</th><th>Duration</th><th>Country</th><th>Device</th><th></th><th></th><th>Clicks</th><th>Double clicks</th><th>Browser</th><th>OS</th><th>Device type</th><th>Campaign</th><th>Source</th><th>Medium</th><th>Referrer</th></tr></thead><tbody>';



        jQuery.each(data.data, function(cid, client) {
            
            if(isNaN(cid.split('.')[0])) return true;

            var sessions =  Object.keys(client);
            var totalSessions = sessions.length;
            var totalDuration = 0;
            var totalPages = 0;
            var totalClicks = 0;
            var totalDclicks = 0;
            var date = ''; var date2 = '';
            var timestamp = '';
            var device = '';
            var browser = '';
            var os = '';
            var osbrowser = '';
            var campaign = '';
            var source = '';
            var medium = '';
            var referrer = '';
            var url = '';
            var urls_search = new Array();
            var countryName = client[sessions[0]].countryName;
            if(client[sessions[0]].country.toLowerCase()=='zz' || client[sessions[0]].country=='') var country = '<img src="<?php echo plugin_dir_url( __FILE__ );?>assets/img/flat-zz-24.png" width="22" height="22" title="Unknown country">';
            else var country = '<img src="<?php echo plugin_dir_url( __FILE__ );?>assets/img/flags/64/'+client[sessions[0]].country.toLowerCase()+'.png" width="22" height="22" title="'+countryName+'">';

            

            jQuery.each(json[cid], function(sid, element) {
              jQuery.each(json[cid][sid]['journey'], function(index, element) {
                urls_search.push(element['url']);
              });
           }); 

            // get total sessions
             jQuery.each(client, function(sid, element) {
              totalDuration+= element.duration;
              totalPages+= element.totalUrl;
              totalClicks += element.clicks;
              totalDclicks += element.dclicks;
              url = element.url;
              if(date=='') date = moment.utc(element.timestamp).local().format('MMM D');
              if(date2=='') date2 = moment.utc(element.timestamp).local().format('MMM D Y h:m:ss a');
              if(timestamp == '') timestamp = moment.utc(element.timestamp).unix();
              osbrowser = element.browser+' '+element.os;
              browser = element.browser;
              os = element.os;
              mobile = element.os;
              device = element.device;
              campaign = element.campaign;
              source = element.source;
              medium = element.medium;
              referrer = element.referrer;
              referrer_short = referrer.split('?')[0];
              referrer_short = referrer_short.replace('https://','');
              referrer_short = referrer_short.replace('http://','');
              if(referrer){
                referrer = referrer.replace("http://","");
                referrer = referrer.replace("https://","");
              }
             });

             //onclick="showHide(\''+cid+'\');"
                  table += '<tr data-cid="'+cid+'" class="details">'
                        + '<td data-sort="'+timestamp+'">'+date+'</td><td>' + (cid.split('.')[0])  +  '</td>'
                        + '<td><div class="col-sm-12" style="display: flex; align-items: center;">' +country+' &nbsp;&nbsp;' + (cid.split('.')[0])  +  ' </div></td>'
                        + '<td><div class="col-sm-12"><i class="fa fa-calendar-alt question-tooltip-icon "></i> <span class="totalSessions">'+totalSessions+'</span></div></td>'
                        + '<td><div class="col-sm-12"><i class="fas fa-link question-tooltip-icon"></i> '+totalPages+'</div></td>' 
                        + '<td class="text-left">'+url+'</td>'
                        + '<td data-sort="'+totalDuration+'">'+ (totalDuration>0?'':'-') +secondsToHms(totalDuration)+'</td><td><span style="display:none">'+countryName+'</span>'+country+'</td><td>'+osbrowser+'</td><td>'+urls_search.unique().join('|')+'</td>'
                        + '<td>'+totalDuration+'</td>'
                        + '<td>'+totalClicks+'</td>'
                        + '<td>'+totalDclicks+'</td>'
                        + '<td>'+browser+'</td>'
                        + '<td>'+os+'</td>'
                        + '<td>'+device+'</td>'
                        + '<td>'+campaign+'</td>'
                        + '<td>'+source+'</td>'
                        + '<td>'+medium+'</td>'
                        + '<td>'+referrer_short+'</td>'
                        + '</tr>';


        jQuery.each(client, function(sid, element) {

        
            
        var date = moment.utc(element.timestamp).local().format('MMM D Y h:m:ss a');
        var date2 = moment.utc(element.timestamp).local().format('MMM D');
        var date3 = moment.utc(element.timestamp).local().format('h:m a');
        seconds = 0;
        var current = '';
        var classname = 'report-item';
        
        
        
        
        if(current_sid==sid) {
            
            var start = moment(stamp);
            var end = moment(element.timestamp);
            
            seconds = start.diff(end, 'seconds');
            stamp = element.timestamp ;
            classname = 'noreport-item';
        }
        else {
            current_sid = sid;
            stamp = element.timestamp;
            seconds = 0;
            classname = 'report-item';
        }
        
        duration = (parseInt(element.duration)>0?parseInt(element.duration):seconds);
        
          //console.log(element);


     
      
           
           //(element.city=='(not set)'?'':element.city)
           
        });});
        
        
        
        table +='</tbody></table>';
        
        
        if(typeof datatable =='object' || jQuery.fn.dataTable.isDataTable( '#chartdiv')){
           datatable.destroy();
           jQuery('#chartdiv, #pagi').empty();
           
        }
        
        //$.fn.dataTable.numString(/^\d+ Clicks?$/);
        jQuery('#chartdiv').append(table);
           //"order": [[ 0, "desc" ],[ 1, "desc" ]],
           var groupColumn = 0;
           datatable = jQuery('#reports-list').DataTable( {
          responsive: true,
          searching: true,
          "pageLength": 10,
          "order": [[ 0, "desc" ]],
          /* Disable initial sort */
          "aaSorting": [],
          /*aaSorting: [[2, 'desc']],*/
          bLengthChange: false,
          mRender: function (data, type, full) {
            if(type == 'sort') return data.Sort;
            return data.Display
          },
          'columns': [
            null,
            null, 
            null, 
            null, 
            null,
            null,
            null,
            null,
            null,
            null,
            null,null,null,null,null,
            null,null,null,null,null,
          ],
          'columnDefs': [
          { 'targets': [0], "visible": true, 'className' : 'group sortable col-sm-1',},
          { 'targets': [1], "visible": false},
          { 'targets': [2],'className' : 'group sortable text-left col-sm-3 ',},
          { 'targets': [3],'className' : 'group sortable text-left col-sm-1',},
          { 'targets': [4], "visible": false},
          { 'targets': [5],'className' : 'group sortable col-sm-3', "orderable": false},
          { 'targets': [6],'className' : 'group sortable col-sm-1',},
          { 'targets': [7], "visible": false, 'className' : 'group sortable col-sm-2', "orderable": false}, // country
          { 'targets': [8],  'className' : 'group sortable col-sm-2', "orderable": false},
          { 'targets': [9], "visible": false}, 
          { 'targets': [10], 'className' : 'group sortable', "visible": false}, // duration
          { 'targets': [11], 'className' : 'group sortable', "visible": true}, // clicks
          { 'targets': [12], 'className' : 'group sortable', "visible": false}, // dclicks
          { 'targets': [13], 'className' : 'group sortable', "visible": false}, // browser
          { 'targets': [14], 'className' : 'group sortable', "visible": false}, // os
          { 'targets': [15], 'className' : 'group sortable', "visible": false}, // device
          { 'targets': [16], 'className' : 'group sortable', "visible": false}, // campaign
          { 'targets': [17], 'className' : 'group sortable', "visible": false}, // source
          { 'targets': [18], 'className' : 'group sortable', "visible": false}, // medium
          { 'targets': [19], 'className' : 'group sortable', "visible": true}, // referral
          ],
          initComplete: (settings, json)=>{
              jQuery('#reports-list_paginate').appendTo('#pagi');
          }
          });




// Add event listener for opening and closing details
  jQuery('#reports-list tbody').on('click', 'tr.details', function () {
    var tr = jQuery(this).closest('tr');
    var row = datatable.row(tr);
    var cid = jQuery(this).data('cid');

    if (row.child.isShown()) {
      // This row is already open - close it
      row.child.hide();
      tr.removeClass('shown');
    }
      else
    {
      // Open this row
      row.child(format(cid), 'subrow').show();
      tr.addClass('shown');

    }
  });


  // numstring plugin
  jQuery.fn.dataTable.numString = function(format) {
    //This is the type detection plug in
    jQuery.fn.dataTable.ext.type.detect.unshift(function(data) {
      if (typeof data !== "string") {
        return null;
      }
   
      if (data.match(format)) {
        return "numString-" + format.source;
      }
   
      return null;
    });
     
    //This is the ordering plug in
    jQuery.fn.dataTable.ext.type.order[
      "numString-" + format.source + "-pre"
    ] = function(data) {
      var num = data.replace(/\D/g, "");
   
      return num * 1;
    };
    // end plug-in
  };


        
    // redraw tabke
    //datatable.fnDraw();

    },
     error: function(jqxhr, status, exception) {
             console.log('Exception:', exception);
         }
    
    
});
}


</script>











</div></div></div></div></div>








        
<?php } ?>  

