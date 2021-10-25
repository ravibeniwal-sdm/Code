<?php 
echo $this->fetch('content');
if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();
?><?php //echo $this->element('sql_dump'); ?>