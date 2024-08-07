<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php

function getGraph_data($graph_name=null,$data_room=null,$start=null,$end=null){
    
    $availability	= $data_room->availability; 
    $summary		= $data_room->summary; 
    $start_date 	= new DateTime($start);
    $end_date 		= new DateTime($end ); 
    $interval		= $start_date->diff($end_date);
    $days 			= $interval->days;

    $data 			= new \stdClass();
    
    if (!empty($graph_name)) 
    {
        if ($graph_name == "room_available_by_date") 
        {
            $tmp 					= new \stdClass();
            $tmp->frequency_list 	= new \stdClass();
            $tmp->label_list 		= new \stdClass();
            $tmp->key				=[];
            $tmp->id				= "room_available_by_date";
            $tmp->chart_type 		= "bar";
            $tmp->stack 			= false;
            $tmp->display_horizontal= false;
            $tmp->data_name			="Room Available by Date";
            $tmp->max_height		=0;
            $tmp->exceed_max_room	= new \stdClass();
            
            if (!empty($days)) {
                for ($a = 0; $a < count($availability); $a++) {
                    $label_name = "label_" . $a;
                    $tmp->label_list->$label_name = [$availability[$a]->name];
                    
                    $frequency_name = "frequency_" . $a;
                    $tmp->frequency_list->$frequency_name = [];

                    for ($b = 0; $b < $days; $b++) {
                        $today = date("Y-m-d", (strtotime($start) + ($b * 86400)));
                        $avail = $availability[$a]->availability->{$today}->available ?? '0';

                        $tmp->frequency_list->$frequency_name[] = $avail;						
                        $tmp->max_height = max($tmp->max_height, $avail);
                        
                        if ($avail<0) 
                        {
                            $room_name = $availability[$a]->name;
                            if (!isset($tmp->exceed_max_room->$room_name)) {
                                $tmp->exceed_max_room->$room_name[$today] = [];
                            }
                            $tmp->exceed_max_room->$room_name[$today] = $avail;
                        }

                        if (!in_array($today, $tmp->key)) {
                            $tmp->key[] = $today;
                        }
                    }
                }
            }
                
            if ($tmp->max_height > 0) {$tmp->max_height++;}
            $data	= $tmp;
        }
        else if ($graph_name == "room_taken_by_date") 
        {	
            $tmp 					= new \stdClass();
            $tmp->frequency_list 	= new \stdClass();
            $tmp->label_list 		= new \stdClass();
            $tmp->key				=[];
            $tmp->id				= "room_taken_by_date";
            $tmp->chart_type 		= "bar";
            $tmp->stack 			= false;
            $tmp->display_horizontal= false;
            $tmp->data_name			="Room Taken by Date";
            $tmp->max_height		=0;
            $tmp->exceed_max_room	= new \stdClass();
            
            if (!empty($days)) {
                for ($a = 0; $a < count($availability); $a++) {
                    $label_name = "label_" . $a;
                    $tmp->label_list->$label_name = [$availability[$a]->name];
                    
                    $frequency_name = "frequency_" . $a;
                    $tmp->frequency_list->$frequency_name = [];

                    for ($b = 0; $b < $days; $b++) {
                        $today = date("Y-m-d", (strtotime($start) + ($b * 86400)));
                        $avail = $availability[$a]->availability->{$today}->available ?? '0';
                        $taken = $availability[$a]->total_rooms - $avail;
                        
                        $tmp->frequency_list->$frequency_name[] = $taken;
                        $tmp->max_height = max($tmp->max_height, $taken);
                        
                        if ($taken>$availability[$a]->total_rooms) 
                        {
                            $room_name = $availability[$a]->name;
                            if (!isset($tmp->exceed_max_room->$room_name)) {
                                $tmp->exceed_max_room->$room_name[$today] = [];
                            }
                            $tmp->exceed_max_room->$room_name[$today] = $taken;
                        }
                        
                        if (!in_array($today, $tmp->key)) {
                            $tmp->key[] = $today;
                        }
                    }
                }
            }
                
            if (!empty($tmp->max_height)) {$tmp->max_height++;}
            $data	= $tmp;
        }
    }
    return $data;
}

function generateGraph2($data_name = null,$id = null,$stack = null,$label_list = null,$frequency_list = null,$key = null,$chart_type = null,$display_horizontal = null,$max_height = null,$exceed_max_room = null) {
    
    $color 			= array(
    '#ed5c63', '#fc7f5f', '#f2a145', '#e7c001', '#29bd4f', '#01c3a1', '#00c2d6', '#00aaef',
    '#3d5ab6', '#7b4ab3', '#af6dd7', '#978986', '#8a978d', '#828c96'
    );

    if (!empty($data_name)&&!empty($id)&&!empty($stack)&&!empty($label_list)&&!empty($frequency_list)&&!empty($key)&&!empty($chart_type)&&!empty($display_horizontal)&&!empty($max_height)) {
        echo '<div class="card shadow-sm my-2 p-2">';
        echo '
                <div class="card-header">
                    <h4 class="text-center">'.$data_name.'</h4>
                </div>
                <div class="card-body text-end">
                    <canvas id="' . $id . '" class="kt-dynamic-chart" style="height: 100% !important;"
                            data-stack="' . htmlspecialchars(json_encode($stack)) . '" 
                            data-target="" 
                            data-csv-target="" 
                            data-name="' . htmlspecialchars(json_encode($data_name)) . '" 
                            data-label_list="' . htmlspecialchars(json_encode($label_list)) . '" 
                            data-frequency_list="' . htmlspecialchars(json_encode($frequency_list)) . '" 
                            data-labels="' . htmlspecialchars(json_encode($key)) . '" 
                            data-chart-type="' . htmlspecialchars($chart_type) . '" 
                            data-display-horizontal="' . htmlspecialchars(json_encode($display_horizontal)) . '" 
                            data-color="' . htmlspecialchars(json_encode($color)) . '" 
                            data-max-height="' . htmlspecialchars(json_encode($max_height)) . '">
                    </canvas>
                </div>';
            
        if (!empty($exceed_max_room) && json_encode($exceed_max_room) != '{}') {
            echo "<h3 class='mt-4 text-danger'>Exceed Maximum Room</h3>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'><tr><th>Room Type</th><th>Date</th><th>Value</th></tr></thead>";
            echo "<tbody>";

            foreach ($exceed_max_room as $roomType => $dates) {
                foreach ($dates as $date => $value) {
                    echo "<tr>";
                    echo "<td class='bg-dark text-white'>{$roomType}</td>";
                    echo "<td class='bg-danger text-white'>{$date}</td>";
                    echo "<td class='bg-danger text-white'>{$value}</td>";
                    echo "</tr>";
                }
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
        echo "</div>";
    }
}

function generateGraph($graph_data = null) {
    
    $color 			= array(
    '#ed5c63', '#fc7f5f', '#f2a145', '#e7c001', '#29bd4f', '#01c3a1', '#00c2d6', '#00aaef',
    '#3d5ab6', '#7b4ab3', '#af6dd7', '#978986', '#8a978d', '#828c96'
    );

    if (!empty($graph_data)) {
        echo '<div class="card shadow-sm my-2 p-2">';
        echo '
                <div class="card-header">
                    <h4 class="text-center">'.$graph_data->data_name.'</h4>
                </div>
                <div class="card-body text-end">
                    <canvas id="' . $graph_data->id . '" class="kt-dynamic-chart" style="height: 100% !important;"
                            data-stack="' . htmlspecialchars(json_encode($graph_data->stack)) . '" 
                            data-target="" 
                            data-csv-target="" 
                            data-name="' . htmlspecialchars(json_encode($graph_data->data_name)) . '" 
                            data-label_list="' . htmlspecialchars(json_encode($graph_data->label_list)) . '" 
                            data-frequency_list="' . htmlspecialchars(json_encode($graph_data->frequency_list)) . '" 
                            data-labels="' . htmlspecialchars(json_encode($graph_data->key)) . '" 
                            data-chart-type="' . htmlspecialchars($graph_data->chart_type) . '" 
                            data-display-horizontal="' . htmlspecialchars(json_encode($graph_data->display_horizontal)) . '" 
                            data-color="' . htmlspecialchars(json_encode($color)) . '" 
                            data-max-height="' . htmlspecialchars(json_encode($graph_data->max_height)) . '">
                    </canvas>
                </div>';
            
        if (!empty($graph_data->exceed_max_room) && json_encode($graph_data->exceed_max_room) != '{}') {
            echo "<h3 class='mt-4 text-danger'>Exceed Maximum Room</h3>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'><tr><th>Room Type</th><th>Date</th><th>Value</th></tr></thead>";
            echo "<tbody>";

            foreach ($graph_data->exceed_max_room as $roomType => $dates) {
                foreach ($dates as $date => $value) {
                    echo "<tr>";
                    echo "<td class='bg-dark text-white'>{$roomType}</td>";
                    echo "<td class='bg-danger text-white'>{$date}</td>";
                    echo "<td class='bg-danger text-white'>{$value}</td>";
                    echo "</tr>";
                }
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
        echo "</div>";
    }
}

?>