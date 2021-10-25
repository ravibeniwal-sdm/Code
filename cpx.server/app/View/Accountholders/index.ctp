
<style>
.action-btn > a {
    margin-bottom: 1px;
    
}

.non-selected-btn {
    background-color: lightgrey;
    border-color: lightgrey;
    color: black;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 5px 10px;
}

#sparks li h5
{
    text-transform: none !important;
}
</style>
<style>
.ui-dialog .ui-dialog-title 
{
    color: red;
    font-weight: bold;
    font-size: 16px;
}

.btn-purge {
    background-color: #db0435; 
    border-color: #db0435;
    color:white;
}

.btn-purge:hover, .btn-purge:focus
{
    color:white !important;
}

@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

    .submitbtn{
        margin-right: 0px !important;
    }
    
}

</style>
<script language="javascript">

function reset_search()
{
    $('#search').val('');
    
    $('#welcome_reminder').attr('checked', false);
     
    $('#search_accountholders_form').submit();
}

function export_data()
{
    window.location.href='<?=ADMIN_PATH?>accountholders/<?=$searchQueryStr?>export=1';
}

</script>

<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment"> 
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
				<i class="fa fa-refresh"></i>
			</span> 
		</span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>Home</li><li>Account holders</li>
		</ol>
		<!-- end breadcrumb -->

		

	</div>
	<!-- END RIBBON -->

    <!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Settings <span>&gt; Account holders</span></h1>
			</div>
			
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8 smart-form" >
            <section class="col col-12" style="float: right;" >
                
                
                    
                    <section class="col col-2">  
                        <ul id="sparks" class="">                  
        					<li class="sparks-info counter_link">
        						<h5> <a href="<?=ADMIN_PATH?>accountholders?filtertxt=verified">Verified<span style="text-align: center;"><?php echo $total_verified_users; ?></span></a></h5>
        					</li>
                        </ul>
    				</section>
                   
                    <section class="col col-2">       
                        <ul id="sparks" class="">                
        					<li class="sparks-info counter_link">
        						<h5> <a href="<?=ADMIN_PATH?>accountholders?filtertxt=unverified">Unverified<span style="text-align: center;"><?php echo $total_unverified_users ?></span></a></h5>
        					</li>
                        </ul>
    				</section>
                    
                    <section class="col col-2">    
                        <ul id="sparks" class="">                
        					<li class="sparks-info counter_link">
        						<h5> <a href="<?=ADMIN_PATH?>accountholders?filtertxt=cpx_form">CPx form<span style="text-align: center;"><?php echo $total_cpx_form_users ?></span></a></h5>
        					</li>
                        </ul>
    				</section>
                 
                    <section class="col col-2">   
                        <ul id="sparks" class="">                
        					<li class="sparks-info counter_link">
        						<h5> <a href="<?=ADMIN_PATH?>accountholders?filtertxt=social_media">Social media<span style="text-align: center;"><?php echo $total_social_media_users ?></span></a></h5>
        					</li>
                        </ul>
    				</section>
                    
                    <section class="col col-2">  
                        <ul id="sparks" class="">                
        					<li class="sparks-info counter_link">
        						<h5> <a href="<?=ADMIN_PATH?>accountholders?filtertxt=via_feeds">Via feeds<span style="text-align: center;"><?php echo $total_via_feeds_users ?></span></a></h5>
        					</li>
                        </ul>
    				</section>
                   
                    <section class="col col-2">   
                        <ul id="sparks" class="">                         
        					<li class="sparks-info counter_link">
        						<h5> <a href="<?=ADMIN_PATH?>accountholders?filtertxt=total_account_holders">Total account holders <span style="text-align: center;"><?php echo $total_account_holders;?></span></a></h5>
        					</li>
        				</ul>
                    </section>
                 
                 
               
               
                
                </section>
			</div>
		</div>
        
        
                                
		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- new widget -->
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false" >
					
						<header>
							
							

						</header>

						<!-- widget div-->
						<div>

							<!-- widget content -->
                            
							<div class="widget-body">
								
                                <div class="table-responsive">
                                
                                <form class="smart-form" id="search_accountholders_form" method="post" action="<?=ADMIN_PATH?>accountholders/">
                                
                                        <fieldset>
                                        	<div class="row">
                                                <section class="col col-12">
                                                
                                                <section class="col col-3">
                                                    <section class="col col-12 ">
    													<label class="input"  >
                                                            <strong>Account holder email </strong>
    													</label>
    												</section>
                                                </section>
                                                
                                                <section class="col col-9">
                                                    
                                                    <section class="col col-5">
    													<label class="input">
    														<input  type="text" id="search" name="search"  value="<?php echo !empty($searchtxt) ? $searchtxt : '' ?>" onfocus="$('#welcome_reminder').attr('checked', false);"/> 
    													</label>
    												</section>
                                                    <section class="col col-4">
                                                    <?php
                                                        $selected_str = ''; 
                                                        if(isset($welcome_reminder) && !empty($welcome_reminder))
                                                            $selected_str = 'CHECKED="CHECKED"';  
                                                    ?>
    													<input type="checkbox" id="welcome_reminder" name="welcome_reminder"  <?php echo $selected_str; ?> onchange="$('#search').val('');"/>  Welcome reminder pending
    												</section>
                                                   </section> 
                                                   
                                                   </section> 
                                               </div>
                                                
                                            </fieldset>
                                            
                                            <footer>
                                            
												<button type="submit" name="search_done" value="1" class="btn btn-primary  submitbtn" >
													Search
												</button>
												<button type="button" class="btn btn-default " onclick="reset_search();">
													Reset
												</button>
                                                
                                                <button type="button" class="btn btn-primary  submitbtn" onclick="export_data();">
													Export
												</button>    
									   </footer>
									
                                </form> 
                                
								</div>
                                
                                
                                
								<div class="custom-scroll table-responsive">
								
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Account holders</th>
                                                <th>Live properties</th>
                                                <th>Total properties</th>
                                                <th>Action</th>
											</tr>
										</thead>
										<tbody>
                                            <?php 
//echo "<pre>";
//print_r($accountholdersList);
//echo "</pre>";die;
                                            
                                            if(!empty($accountholdersList))
                                            {
                                            foreach($accountholdersList as $accountholders)
                                            {
                                            
                                            ?>
                                            
											<tr>
												<td>
                                                <div style="margin-top: 10px;">
                                                <?php echo $accountholders['username'];?>
                                                
                                                
                                                </div>
                                                </td>
											    
                                                <td>
                                                <div style="margin-top: 10px;" class="counter_link">
                                                <?php 
                                                if($accountholders['live_properties'] > 0)
                                                    echo '<a  href="'.WEB_PATH.'#!/'.$accountholders['username'].'" target="_blank">'.$accountholders['live_properties'].'</a>';
                                                else
                                                    echo $accountholders['live_properties'];
                                                ?>
                                                
                                                
                                                </div>
                                                </td>   
                                                 
                                                <td>
                                                <div style="margin-top: 10px;">
                                                <?php echo $accountholders['total_properties'];?>
                                                
                                                
                                                </div>
                                                </td>                                                  
                                                
                                                <td style="width: 100px; " >
                                                    <div class="action-btn smart-form" style="padding-right: 15px;margin-top: 10px;" >    
                                                    <?php
                                                    $no_of_invitation_sent = 0;
                                                    if(isset($accountholders['no_of_invitation_sent']))
                                                        $no_of_invitation_sent = $accountholders['no_of_invitation_sent'];
                                                    
                                                    if(isset($accountholders['system_generated_user']) && ($accountholders['system_generated_user']) && $accountholders['live_properties'] && ($accountholders['status'] == 'inactive'))
                                                    {
                                                        if($no_of_invitation_sent == 0)
                                                        {
                                                    ?>
                                                    <a id="welcome_user_btn" href="<?=ADMIN_PATH?>auth/welcome_user/welcome/<?=$accountholders['id']?>" class="btn btn-primary container-full">Welcome to CPx </a><br /><br />
                                                    <?php
                                                        }
                                                        elseif($no_of_invitation_sent == 1)
                                                        {
                                                    ?>
                                                    <a href="<?=ADMIN_PATH?>auth/welcome_user/welcome/<?=$accountholders['id']?>" class="btn btn-purge container-full">Welcome Reminder </a><br /><br />
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                   <?php 
                                                   if(isset($accountholders['registration_timestamp']))
                                                   {
                                                    $registration_timestamp = $accountholders['registration_timestamp'];
            
                                                    $cDate = strtotime(date('Y-m-d H:i:s'));
                                                    
                                                    // Getting the value of old date + 24 hours
                                                    $registrationDateAfterOneDay = $registration_timestamp + 86400; // 86400 seconds in 24 hrs
                                                    
                                                   
                                                    if(($accountholders['status'] == 'inactive') && ($registrationDateAfterOneDay < $cDate) && (!isset($accountholders['system_generated_user']))) 
                                                    {
                                                    ?>
                                                    
                                                      <a href="<?=ADMIN_PATH?>auth/welcome_user/resend/<?=$accountholders['id']?>" class="btn btn-primary container-full">Resend Verification </a><br />                                                                                                 
                                                      <?php
                                                      }
                                                      }
                                                      ?>     
                                                    
                                                    </div> 
                                               
                                                </td>
											</tr>
                                            <?php
                                            }
                                            }
                                            else
                                            {
                                                
                                                ?>
                                                <tr>
                                                    <td colspan="4" style="text-align: center;"><strong>No account holders were found</strong>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
										</tbody>
									</table>
                                    <div class="text-right">
                                    
    								<?php
                                    $startPage = 1;
                                    $disPages = 10;
                                    if($currentPage>10)
                                    {
                                        $startPage = ((floor($currentPage/10))*10)+1;
                                        $disPages = ($startPage + 10)-1;
                                        
                                    }
                                    
                                    if($currentPage == ($startPage-1))
                                    {
                                        $startPage = $startPage - 10;
                                        $disPages = $disPages - 10;
                                    }                                        
                                    
                                    if($disPages > $noOFPages)
                                    {
                                        if($noOFPages>10)
                                        {
                                            $startPage = $disPages - 9;
                                            $disPages = $noOFPages;
                                        }
                                        else
                                        {
                                            $startPage = 1;
                                            $disPages = $noOFPages;
                                        }     
                                    }
                                    ?>
                                    <ul class="pagination pagination-sm">
    								<?php
                                    if(($currentPage-1)>0)
                                    {
                                    ?>
                                    <li>
    									<a href="<?=ADMIN_PATH?>accountholders/index/<?=($currentPage-1).$searchQueryStr;?>"><i class="fa fa-angle-left"></i></a>
    								</li>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    for($i=$startPage;$i<=$disPages;$i++)
                                    {
                                    ?>
                                    
                                    <li class="<?=(($i==$currentPage)?"active":"")?>">
    									<a  href="<?=ADMIN_PATH?>accountholders/index/<?=($i).$searchQueryStr;?>"><?=$i?></a>
    								</li>
    								<?php
                                    }
                                    ?>
                                    <?php
                                    if(($currentPage+1)<=$noOFPages)
                                    {
                                    ?>
                                    
    								<li>
    									<a href="<?=ADMIN_PATH?>accountholders/index/<?=($currentPage+1).$searchQueryStr;?>"><i class="fa fa-angle-right"></i></a>
    								</li>
                                    <?php
                                    }
                                    ?>
    							</ul>
									</div>
								</div>
                               
                                
							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
			</div>
			<!-- end row -->

		</section>
		<!-- end widget grid -->
	</div>
	<!-- END MAIN CONTENT -->
</div>