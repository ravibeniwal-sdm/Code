<?php
//echo "<pre>"; print_r($output); echo "</pre>";
//exit;

?>

<tr>
        
        <input type="hidden" name="property[iprs][]" value='<?=json_encode($output)?>' />
        <td><?php echo $output->id; ?></td>
        <td>
        <?php
                echo $output->results['0']->grade;                                   
            ?>
        </td>
        <td>
            <?php
                echo $output->results['0']->score;
            ?>
        </td>
        <td><?php if(!empty($output->property->price)) echo 'AUD $'.$output->property->price; ?></td>
        <td><?php if(!empty($output->property->weeklyRent)) echo 'AUD $'.$output->property->weeklyRent; ?></td>
        <td>
        <?php
            if(!empty($output->publishedAt)) 
            {
                $tmp_datetime = explode('T', $output->publishedAt);
                
                $tmp_date = explode('-',$tmp_datetime['0']);
                $day = $tmp_date['2'];
                $month = $tmp_date['1'];
                $year = $tmp_date['0'];
                
                $tmp_time = explode(':',$tmp_datetime['1']);
                $hours = $tmp_time['0'];
                $min = $tmp_time['1'];
                $sec = '0';
             
            
                echo date('d M Y',mktime($hours, $min, $sec ,$month, $day,$year));
            }             
        ?>
        </td>
        
        <td>
        <?php
            if(!empty($output->publishedAt))
            {
                $today_date = date('Y/m/d h:m');

                $tmp_datetime = explode('T', $output->publishedAt);
            
                $tmp_date = explode('-',$tmp_datetime['0']);
                
                $published_date = $tmp_date['0'].'/'.$tmp_date['1'].'/'.$tmp_date['2'].' '.$tmp_datetime['1'];

                $startTimeStamp = strtotime($today_date);
                $endTimeStamp = strtotime($published_date);
                
                $timeDiff = abs($endTimeStamp - $startTimeStamp);
                
                $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                
                // and you might want to convert to integer
                $numberDays = intval($numberDays); 
                
                echo $numberDays; 
            }                 
        ?>
        </td>
        
        <td><?php if(!empty($output->property->beds)) echo $output->property->beds; ?></td>
        <td><?php if(!empty($output->property->baths)) echo $output->property->baths; ?></td>
        <td><?php if(!empty($output->property->cars)) echo $output->property->cars; ?></td>
        <td style="text-align: center;">
        <a href="javascript:void(0);" style="color: red;font-weight: bolder;" onclick="removeIpr(this);">X</a>
        
        </td>
    </tr>