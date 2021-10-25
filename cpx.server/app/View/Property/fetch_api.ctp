<?php
$result['message'] = $result['output'] =  '';

$result['status'] =  1;

if(empty($output))
{
    $result['message'] =  'Access denied';
    $result['status'] =  0;
}
else if(isset($output->errorMessage) && !empty($output->errorMessage))
{
    $result['message'] =  'Invalid review id';
    $result['status'] =  0;
} 
else if(isset($output->message) && !empty($output->message))
{
    $result['message'] =  $output->message;
    $result['status'] =  0;
}   
else
{
    $result['output'] = $this->element("/admin/iprDetail",array('output'=>$output));
}

echo json_encode($result);
?>