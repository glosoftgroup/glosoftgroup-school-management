<div class="col-md-12">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
  <div class="panel-heading">
    <h4 class="panel-title">Meetings Calender</h4>
    <div class="heading-elements">
      <?php if (!$this->ion_auth->is_in_group($this->user->id, 3)){ ?>        
             <?php echo anchor( 'admin/meetings/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => ' New Event')), 'class="btn btn-primary"');?>
       <?php } ?>
        <?php echo anchor( 'admin/meetings/calendar' , '<i class="glyphicon glyphicon-calendar"></i> Calendar View', 'class="btn btn-primary"');?> 
                <?php echo anchor( 'admin/meetings/' , '<i class="glyphicon glyphicon-list">
                </i> List View', 'class="btn btn-primary"');?>
    </div>
  </div>
  
  <div class="panel-body">
                    
                            <div id="calendar"></div>
                        </div> 
  </div>
          
<!--- Full skul Calendar---->
		<?php
$event_data = array();

foreach ($events as $event)
{

    $user = $this->ion_auth->get_user($event->created_by);
    
	$start_date = $event->start_date;
    $end_date = $event->end_date;
    $current = date('Y-m-d', time());
  
     if($end_date<time()){
        $event_data[] = array(
            'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
            'start' => date('d M Y H:i', $event->start_date),
            'end' => date('d M Y H:i', $event->end_date),
            'venue' => $event->venue,
            'event_title' => $event->title,
            'cache' => true,
            'backgroundColor' => 'black',
            'description' => strip_tags($event->description),
            'user' => $user->first_name . ' ' . $user->last_name,
        );
	}
  else{
        $event_data[] = array(
            'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
            'start' => date('d M Y H:i', $event->start_date),
            'end' => date('d M Y H:i', $event->end_date),
            'venue' => $event->venue,
            'event_title' => $event->title,
            'cache' => true,
            'backgroundColor' => '#54A1E6',
            'description' => strip_tags($event->description),
            'user' => $user->first_name . ' ' . $user->last_name,
        );
	}
  
}
?>




<script>

   var cld;

cld = (function($) {
  "use strict";
  var handleNewEventsForm, init, initCalendar, initExternalEvents;
  init = function() {
  
    initCalendar();
    handleNewEventsForm();
  };
  /* initialize the external events*/

 
  /* initialize the calendar*/

  initCalendar = function() {
    var d, date, m, y;
    date = new Date();
    d = date.getDate();
    m = date.getMonth();
    y = date.getFullYear();
    $("#calendar").fullCalendar({
      header: {
        left: "prev,next today",
        center: "title",
        right: "month,agendaWeek,agendaDay"
      },
      events: <?php echo json_encode($event_data); ?>,
      
      
    });
  };
  /* Add a new elements to the "Draggable Events" list */

 
  return {
    init: init
  };
})(jQuery);

          cld.init();
      
</script>	

		   
		   
		   