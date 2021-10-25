<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <ul class="list-inline">
        <li>
            <a href="javascript:void(0);" onclick="call_preview();" title="Preview Changes" class="editbtnall previewupdates">Preview Changes</a>
        </li>
    </ul>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom:20px;">
        
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >
        
        <div>Completeness Status</div>
     
        
        <div class="widget-toolbar" style="float: left;border: 0px;padding-left: 0px;"> 
		 <div class="progress progress-xs" data-progressbar-value="<?php echo $completeness_status;?>">
                <div class="progress-bar"></div>
            </div>
	      </div>
          
          
    </div>
    
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        
        <div>Status: <?php echo $status_str;?></div>
            
    </div>

</div>