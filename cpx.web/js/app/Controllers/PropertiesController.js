app.controller('PropertiesCtrl', ['$scope','$rootScope','$filter','$timeout','$location','$window','QueryService','ShortlistService','CommonShareService','$modal', '$log','$routeParams','uiGmapGoogleMapApi','uiGmapIsReady','getRateInfo','numberFilter','$q','$http','$translate','myService','shareIdArrayService','isFeaturedService','ShareStatusShortlistService', function ($scope,$rootScope,$filter,$timeout,$location, $window,QueryService,  ShortlistService,CommonShareService, $modal, $log,$routeParams,uiGmapGoogleMapApi,uiGmapIsReady,getRateInfo,numberFilter,$q,$http,$translate,myService,shareIdArrayService,isFeaturedService,ShareStatusShortlistService) {
	
//console.log($scope.repay);
	
	if($location.absUrl().indexOf("view-graded-properties") >= 0){
		
	$scope.isviewgradedpage = true;	
	$rootScope.metakeywords = "property,properties,price,cpx,beds,type,ipr,smsf,deposit,sold,domacom,grade,grid,map,all,graded";
	
	$rootScope.title= "Real Estate | Properties | Homes For Sale | Apartments For Sale | Old Homes | New Developments | Graded Properties | Independent Properties | Independently Reviewed | No Selling Fees  | CPx";
	
	$rootScope.description="A FRESH APPROACH TO BUYING PROPERTY, Get free, instant access to independently reviewed and graded properties";
	}
	else
	{}
	
    switch($routeParams.type)
    {
        case "graded" : 
            $scope.groups=[{id:0,isopen:true},{id:1,isopen:false},{id:2,isopen:false}];
            $scope.selectedmenu=[{id:0,selected:true},{id:1,selected:false},{id:2,selected:false},{id:3,selected:false},{id:4,selected:false},{id:5,selected:false}];
            break;
        case "affordable" : 
            $scope.groups=[{id:0,isopen:false},{id:1,isopen:true},{id:2,isopen:false}];
            $scope.selectedmenu=[{id:0,selected:false},{id:1,selected:true},{id:2,selected:false},{id:3,selected:false},{id:4,selected:false},{id:5,selected:false}];
            break;
        case "investment" : 
            $scope.groups=[{id:0,isopen:false},{id:1,isopen:false},{id:2,isopen:true}];
            $scope.selectedmenu=[{id:0,selected:true},{id:1,selected:false},{id:2,selected:false},{id:3,selected:false},{id:4,selected:false},{id:5,selected:false}];
            break;
        default:
            $scope.groups=[{id:0,isopen:false},{id:1,isopen:false},{id:2,isopen:false}];
            $scope.selectedmenu=[{id:0,selected:false},{id:1,selected:false},{id:2,selected:false},{id:3,selected:false},{id:4,selected:false},{id:5,selected:false}];
    }
    
    
	
	$scope.gridTooltip = "Grid view";
	$scope.mapTooltip = "Map view";
	
    $scope.baseWebUrl = baseWebUrl;
    $scope.baseAmazonUrl = baseAmazonUrl;
	$scope.searchcriteria=[];
	$scope.loancriteria=[];
	$scope.savedsearchcriteria=[];
	$scope.selectedmenu = [];
    
    $scope.sortOptionVal='';
	//$scope.allproperties = PropertyService.properties;
	
	$scope.allproperties = [];
	
    $rootScope.shownothing = true;
		
	$scope.isStandardOpen=true;
	$scope.isLoanOpen=false;
	$scope.isInvestmentOpen=false;
	
	$scope.defaultLOANTERM = 30;
	$scope.defaultPI_RATE = 4.29;
	$scope.defaultIO_RATE = 4.29;
	$scope.default_costvalue = 5;
	$scope.pageSize = 18;
	
	$scope.itemsPerPage = 18;
	$scope.maxSize = 7;
	
	$scope.animatebtn = false;
	
	$scope.viewid = 'grid';
    
     //var ratesPromise = getRateInfo('latest');

    $scope.to = {};
    //     $scope.currency2 = {};
    $scope.from = {};

    $scope.showloading = false;
 
       
    $scope.toggle_enquire_servicerequest = function (val) {
						
    	  sessionStorage.toggle_val = angular.toJson(val); 	   
      };
    $scope.clearPropertyID = function () {
            //console.log("function  clicked ssss");
            CommonShareService.passenquireid(null);
    };
	
    Object.size = function(obj) {
		    var size = 0, key;
		    for (key in obj) {
		        if (obj.hasOwnProperty(key)) size++;
		    }
		    return size;
		};
    
        
	//PropertyService.success(function(data) { 
	  
	
	
	 
	
	
	
	 
	 /* $scope.pageChanged = function() {
		  
		  $scope.paginationInfo ={};
		  $scope.paginationInfo.currentPage = $scope.currentPage ;
		  
			 QueryService.create($scope.paginationInfo).$promise.then(function(data) {
					
					$scope.properties= data.properties;
					 console.log($scope.properties);
			  
			    
			 
			  });
		 
		  };*/
		
	
	   

	  $scope.setPage = function (pageNo) {
		 // $scope.pageChanged(1);
		  //console.log("djh");
		  $scope.currPage = pageNo;
	  };
	  
	 $scope.passrequestfreeipr = function (printid) {
							
		  CommonShareService.passid(printid);
	  };
	  
	$scope.propertyview = function (value) {
	   
	    if(value=="map")
        {
                $scope.markers = $scope.properties;
                $scope.mapDisplayPropID = null;
                     
                if($scope.totalItems>0) 
                    {
                    $scope.changeproperty(0);
                    }
        		
        			///////////////
        			 $scope.MapOptions = {
        				        minZoom: 7,
        				        zoomControl: false,
        				        draggable: true,
        				        navigationControl: false,
        				        mapTypeControl: false,
        				        scaleControl: true,
        				        streetViewControl: false,
        				        disableDoubleClickZoom: false,
        				        keyboardShortcuts: true,
        				        markers: {
        				            selected: {}
        				        },
        				        styles: [{
        				            featureType: "poi",
        				            elementType: "labels",
        				            stylers: [{
        				                visibility: "off"
        				            }]
        				        }, {
        				            featureType: "transit",
        				            elementType: "all",
        				            stylers: [{
        				                visibility: "off"
        				            }]
        				        }],
        				    };
        			        
                            //parvez
                            
        			 		//////////////////window options
        			 		$scope.windowOptions = {
        				        show: false,
        				        templateUrl: "templates/mapwindow.html",
        				        templateParameter:  ''
        				        	};
        			
        			 		////////////////
        			 		
        			 		 uiGmapGoogleMapApi.then(function (maps) {
        					        $scope.googlemap = {};
        					        $scope.map = {
        					            center: {
        					                latitude: -26.78,
        					                longitude: 140.41
        					            },
        					            zoom: 4,
        					            pan: 1,
        					            options: $scope.mapOptions,
        					            control: {},
        					            events: {
        					                tilesloaded: function (maps, eventName, args) {},
        					                dragend: function (maps, eventName, args) {},
        					                zoom_changed: function (maps, eventName, args) {}
        					            }
        					        };
        					    });
        			
        			 		 ///////////////
        			 		 
        			 		 uiGmapIsReady.promise() // if no value is put in promise() it defaults to promise(1)
        					    .then(function (instances) {
        					      //  console.log(instances[0].map); // get the current map
        					    })
        					        .then(function () {
        					        	
        					        $scope.addMarkerClickFunction($scope.markers);
        					    });
            
        }else
        {
            $scope.markers = [];
        }
        
		$scope.viewid = value;
	};
	
	$scope.paginationdata = { currPage: 1};
	
	
	
	$scope.pageChanged = function(currentPage) {
	
		/*if($scope.doms){
			
			
			$scope.currPage = 1 
			
			console.log("DOMs" + $scope.doms);
			 console.log('Page changed to: ' + $scope.currPage);
		}*/
		
		//else{
			 $scope.paginationdata.currPage = currentPage ;
			 //console.log('Page changed to: ' + $scope.paginationdata.currPage);
		//}
	
		
	   
	  };
		  	

	//console.log(currentPage);
	  
	$scope.changeproperty = function(index){
	   
       //$scope.mapDisplayPropID=$scope.properties[index].id;
       $scope.onClick($scope.properties[index]);
	};
	  
	  
	$scope.updateCriteria = function (proids) {
	   
       console.log("saved information");
       console.log(proids);
       
	 	shareIdArrayService.setIdArray(proids);
	};  
	  
	$scope.showupdate = false;  
    $scope.showreset = false;  
    
    $scope.savedsearchcriteria.minprice = "";
	$scope.savedsearchcriteria.maxprice = "";
    $scope.savedsearchcriteria.minbeds = "Any";
	$scope.savedsearchcriteria.maxbeds = "Any";
	$scope.savedsearchcriteria.searchid = "";
	$scope.savedsearchcriteria.repay = "";
	$scope.savedsearchcriteria.searchtext = "";	
    $scope.savedsearchcriteria.publisher = "";		
    
    
     $scope.loancriteria.type = "$";
     
     
    $scope.checkforReset = function ()
    {
        
      searchFieldArray = ["domacom","established","grade","homeland","left","maxbeds","minbeds","maxprice","minprice","newprop","repay","saving","searchid","searchtext","publisher","sold","type","underoffer","vendorfinance","loanTermslvr","loanTermsloancash","loanTermsinputcost"];
      searchToggleArray = new Array();
      searchToggleArray['domacom']=true;
      searchToggleArray['established']=true;
      searchToggleArray['grade']=true;
      searchToggleArray['homeland']=true;
      searchToggleArray['left']=true;
      searchToggleArray['newprop']=true;
      searchToggleArray['saving']=true;
      searchToggleArray['sold']=true;
      searchToggleArray['underoffer']=true;
      searchToggleArray['vendorfinance']=true;
      
    //  searchloadnArray = new Array();
    //  searchloadnArray['loanTermslvr']=true;
    //  searchloadnArray['loanTermstype']=true;
    //  searchloadnArray['loanTermsloancash']=true;
    //  searchloadnArray['loanTermsinputcost']=true;
      
      
      
      
      for (var i in searchFieldArray)
        {
            
           key = searchFieldArray[i];
           
           console.log(searchToggleArray[key]);
           
           if(searchToggleArray[key])
              {
                
                
                if( ($scope.savedsearchcriteria[key])==true)
                      {
                         console.log("for "+key+"---->"+$scope.savedsearchcriteria[key])
                       
                        $scope.showreset = true;
                        break;
                      }  
              }else
              {
                checkforvalue = $scope.savedsearchcriteria[key];
                if(checkforvalue=="Any")
                    checkforvalue = "";
                if(checkforvalue)
                  {
                     console.log("for "+key+"---->"+checkforvalue);
                    
                    $scope.showreset = true;
                    break;
                  }
              }
           
           
           
          $scope.showreset = false;   
           
        }  
        
        
    }   
    
    
	$scope.checkforupdate= function (propobject,field_change) {
	   
      // alert("in");
       console.log($scope.savedsearchcriteria[field_change]+"in"+propobject[field_change]);
      
      if($scope.savedsearchcriteria[field_change] != propobject[field_change])
                  {        
                   
                    return true;   
                  }else
                  {
                    return false;
                  }
                  
      
              
      
       
    };   
    
    $scope.updateloanInfo = function (propobject,isPaginationBtn,sortOptionVal,value,defaultflag) {
        	   $scope.showloading = true;
               $scope.searchcriteria.loanTermslvr = $scope.loancriteria.lvr;
 			   $scope.searchcriteria.loanTermstype = $scope.loancriteria.type;
    		   $scope.searchcriteria.loanTermsloancash = $scope.loancriteria.loancash;
    		   $scope.searchcriteria.loanTermsinputcost = $scope.loancriteria.inputcost;
	           $scope.searchcriteria.tocurrency = $scope.to.currency;
    		   $scope.searchcriteria.currencyObject = $scope.currencies;
			 //$scope.updatepropertyIds($scope.propIds);
			   $scope.updateCriteria($scope.searchcriteria);
               
               //$scope.savedsearchcriteria = propobject;
               $scope.savedsearchcriteria.loanTermslvr = $scope.loancriteria.lvr;
 			   $scope.savedsearchcriteria.loanTermstype = $scope.loancriteria.type;
    		   $scope.savedsearchcriteria.loanTermsloancash = $scope.loancriteria.loancash;
    		   $scope.savedsearchcriteria.loanTermsinputcost = $scope.loancriteria.inputcost;
               
               
               
               $scope.loanupdate(value,defaultflag);
               $scope.checkforReset();
               
               
             	$scope.showloading = false;   
    }    
    
    
    	
		 
	
	//update function
	$scope.update = function (propobject,isPaginationBtn,sortOptionVal,value,defaultflag) {
		
		//console.log($scope.searchcriteria);
		$scope.showloading = true;
        
        $scope.convertedcpx =  $scope.getcpxprice($scope.searchcriteria.repay);
		
        $scope.markers = [];
       	        
        $scope.mapDisplayPropID=0;
    	$scope.animatebtn = false;
		
		if($scope.searchcriteria.gradefilter == 'Filter: show all'){
			$scope.searchcriteria.gradefilter = null;
		}
		
        $scope.searchcriteria={};
		//$scope.sortcriteria.option = $scope.searchcriteria.option;
		$scope.searchcriteria.sortOptionVal = sortOptionVal;
		
		$scope.searchcriteria.minprice = propobject.minprice;
		$scope.searchcriteria.maxprice = propobject.maxprice;
		
		$scope.searchcriteria.type = propobject.type ;
		$scope.searchcriteria.searchid = propobject.searchid;
        $scope.searchcriteria.publisher = propobject.publisher;
		$scope.searchcriteria.minbeds = propobject.minbeds;
		$scope.searchcriteria.maxbeds = propobject.maxbeds;
		$scope.searchcriteria.left = propobject.left;
        $scope.searchcriteria.saving = propobject.saving;
        $scope.searchcriteria.vendorfinance = propobject.vendorfinance;
		$scope.searchcriteria.domacom = propobject.domacom;
		$scope.searchcriteria.searchtext = propobject.searchtext;
		$scope.searchcriteria.grade = propobject.grade;
		$scope.searchcriteria.underoffer = propobject.underoffer;
		$scope.searchcriteria.sold = propobject.sold;
		$scope.searchcriteria.repay = propobject.repay;
		$scope.searchcriteria.repaypricerange = $scope.convertedcpx;
		
        $scope.searchcriteria.established = propobject.established;
        $scope.searchcriteria.newprop = propobject.newprop;
        $scope.searchcriteria.homeland = propobject.homeland;
        
        /* new code */ 
        $scope.savedsearchcriteria = propobject;
	/*	$scope.savedsearchcriteria = [];
		$scope.savedsearchcriteria.minprice = propobject.minprice;
		$scope.savedsearchcriteria.maxprice = propobject.maxprice;
        $scope.savedsearchcriteria.minbeds = propobject.minbeds;
		$scope.savedsearchcriteria.maxbeds = propobject.maxbeds;
		$scope.savedsearchcriteria.searchid = propobject.searchid;
		$scope.savedsearchcriteria.searchtext = propobject.searchtext;
		$scope.savedsearchcriteria.repay = propobject.repay;
	*/			
        
        
        /* new code end */
        
        
        
		
		if(!isPaginationBtn){
			$scope.paginationdata.currPage = 1;
		}
		
		$scope.searchcriteria.currentPage = $scope.paginationdata.currPage;
			
 		// console.log($scope.searchcriteria);
		 $scope.showhidenetabs(false);
		 QueryService.create($scope.searchcriteria).$promise.then(function(data) {
			
             $scope.setDefaultValues(data);
             
             $scope.checkforReset();
                    
             $scope.currencyObj = $scope.to.currency;
			 var currentCurrencyIndex = _.findIndex($scope.currencies, {code: $scope.currencyObj.code})
			 $scope.to.currency = $scope.currencies[currentCurrencyIndex];
            
            
             $scope.properties= data.properties;
			 
			 
			 //console.log(data.count);
			 $scope.totalItems = data.count;
			 
            /* if($scope.searchcriteria.grade)
                $scope.totalItems=0;
              */  
            /* if($scope.searchcriteria.grade && !$scope.totalItems)
             {
                $scope.propertyview('nograde');
             }
             else
              {
                 $scope.propertyview($scope.viewid);
              } 
			 */
			 
			 
			 var current_items = data.properties;
			 
			 /*data.properties = current_items;*/
			  
			  $scope.markers = $scope.properties;
			 
			  
			  uiGmapIsReady.promise() // if no value is put in promise() it defaults to promise(1)
			    .then(function (instances) {
			      //  console.log(instances[0].map); // get the current map
			    })
			        .then(function () {
			        	
			        $scope.addMarkerClickFunction($scope.markers);
			    });
			     
			  if($scope.totalItems>0)
                    $scope.changeproperty(0);
              
			 
              // console.log("in update");
              // console.log($scope.loancriteria); 
              // console.log(value); 
             
			  
  			   $scope.searchcriteria.loanTermslvr = $scope.loancriteria.lvr;
 			   $scope.searchcriteria.loanTermstype = $scope.loancriteria.type;
    		   $scope.searchcriteria.loanTermsloancash = $scope.loancriteria.loancash;
    		   $scope.searchcriteria.loanTermsinputcost = $scope.loancriteria.inputcost;
	           $scope.searchcriteria.tocurrency = $scope.to.currency;
    		   $scope.searchcriteria.currencyObject = $scope.currencies;
			 //$scope.updatepropertyIds($scope.propIds);
			   $scope.updateCriteria($scope.searchcriteria);
			  
               /*$scope.teria =  shareIdArrayService.getIdArray();
			   if(!isPaginationBtn){
						$scope.paginationdata.currPage = 1;
					}
			     $scope.searchcriteria.currentPage = $scope.paginationdata.currPage;*/
			 
			   $scope.pageSize = 18;
			   $scope.wholePages = Math.ceil( $scope.totalItems /  $scope.pageSize );
			  
			
			  if($scope.totalItems % 2 ==0){
				
				  $scope.propertiesThisPage = 2; 
			  }
			  else{
				  
				  if($scope.wholePages >$scope.paginationdata.currPage ){
					  $scope.propertiesThisPage = 2;
				  }
				  
				  else{
					  $scope.propertiesThisPage = 1;
				  }
				 
			  }
			
    			////////////////////////////////////////////////
    
    		    	$scope.loanupdate(value,defaultflag);
    		    
    			//////////////////////////////////////////////// 
			 
			 $scope.showloading = false;
		     });
			 
	};
    
    
    


    //reset function
    $scope.reset = function (propobject,sortobject,loanobject) {
		$scope.showloading = true;
        $scope.markers = [];
       	
        $scope.mapDisplayPropID=0;
        $scope.clearcriteria = function (proids) {
        	   
        	shareIdArrayService.clearIdArray(proids);
        };
        
        $scope.clearcriteria($scope.searchcriteria);
        
        var  searchAffordablevalues = [];
        sessionStorage.searchAffordableVal = angular.toJson(searchAffordablevalues); 
        
        var  shortlistvalues = [];
        sessionStorage.shortlistcriteriaVal = angular.toJson(shortlistvalues); 
        
		$scope.animatebtn = false;
		propobject.minprice = undefined;
		propobject.maxprice = undefined;
		propobject.minbeds = 'Any';
		propobject.maxbeds = 'Any';
		propobject.type = 'Any';
		sortobject.option = '1';
		propobject.left = undefined;
        propobject.saving = undefined;
        propobject.vendorfinance = undefined;
		propobject.domacom = undefined;
		propobject.latest = undefined;
		propobject.sold = undefined;
        propobject.established = undefined;
        propobject.newprop = undefined;
        propobject.homeland = undefined;
		propobject.underoffer = undefined;
		propobject.gradelabel = 'Filter: Show all';
		propobject.grade = '';
		propobject.searchtext =undefined;
		propobject.searchid =undefined;
        propobject.publisher =undefined;
		propobject.conv_minprice=undefined;
		propobject.conv_maxprice=undefined;
		propobject.repay=undefined;
		
		loanobject.type = '$';
		loanobject.lvr = undefined;
		loanobject.loancash = undefined;
		loanobject.inputcost = undefined;
		
		$scope.countryflag = 'au';
	    $scope.countrylabel = 'AUD';
		$scope.to.currency = $scope.currencies[7];
        
		$scope.loanupdate(loanobject,'reset');
		
		$scope.paginationdata.currPage = 1;
		
        //$scope.savedsearchcriteria = propobject;
        $scope.savedsearchcriteria = [];
        $scope.savedsearchcriteria.minprice = "";
    	$scope.savedsearchcriteria.maxprice = "";
        $scope.savedsearchcriteria.minbeds = "Any";
    	$scope.savedsearchcriteria.maxbeds = "Any";
    	$scope.savedsearchcriteria.searchid = "";
        $scope.savedsearchcriteria.publisher = "";
    	$scope.savedsearchcriteria.repay = "";
    	$scope.savedsearchcriteria.searchtext = "";
        
        
        //console.log($scope.savedsearchcriteria);
        
		QueryService.success(function(data) {
		    
            $scope.checkforReset();
              
			$scope.totalItems  = data.count;
            $scope.properties= data.properties;
            
            if($scope.viewid=="map")
            {                                    
                $scope.markers = $scope.properties;

            		uiGmapIsReady.promise() // if no value is put in promise() it defaults to promise(1)
            	    .then(function (instances) {
            	      //  console.log(instances[0].map); // get the current map
            	    })
            	        .then(function () {
            	        	
            	        $scope.addMarkerClickFunction($scope.markers);
            	    });
            		
                    for(i=0;i<$scope.markers.length;i++){
    				
    				  $scope.markers[i].icon = ""
    				  		  
  				      } 
                 if($scope.totalItems > 0)
                 {
                 $scope.changeproperty(0);   
                 }
                      
            }
            else
            {
                $scope.markers = [];
            }            
            
            
            
            var dummyobject = {grade: "", type: "Any", minbeds: "Any", maxbeds: "Any"};
		    $scope.loanupdate(dummyobject,'reset');    
            
            $scope.showloading = false;                    
		});
		
	/*	if(!$scope.IsVisibleSold)
            $scope.IsVisibleSold = true;

        if(!$scope.IsVisibleUnderoffer)            
            $scope.IsVisibleUnderoffer = true;
        
        if(!$scope.IsVisiblenew)            
            $scope.IsVisiblenew = true;
            
        if(!$scope.IsVisiblehomeland)            
            $scope.IsVisiblehomeland = true;
            
        if(!$scope.IsVisibleestablished)            
            $scope.IsVisibleestablished = true;
            
      */
      $scope.showhidenetabs(true);      
            
	};	
	
	
	
    	//grades filter
		//animate
		
		$scope.animate = function (value,field) {
		    
		
			if($scope.checkforupdate($scope.searchcriteria,field))
                $scope.update($scope.searchcriteria,false,$scope.sortcriteria.option,$scope.loancriteria,'converter');
            if(value == 'on'){
				$scope.animatebtn = true;
				
			}
			
		};
		
		
	// go function for downloading pdf	
	
	$scope.go = function (url) {
	      $window.open(url);
	};
	
	$scope.open = function (size) {

	    var modalInstance = $modal.open({
	      templateUrl: 'myModalContent.html',
	      controller: 'ModalInstanceCtrl',
	      size: size,
	      resolve: {
	        items: function () {
	          return $scope.items;
	        }
	      }
	    });

	    modalInstance.result.then(function (selectedItem) {
		      $scope.selected = selectedItem;
		    }, function () {
		      $log.info('Modal dismissed at: ' + new Date());
		    });
		  };
		  
		  $scope.items = ['item1', 'item2', 'item3'];
		  
		  
		    ////function to show interest rate's sponser pop-up
		    // map view
		              
            $scope.onClick = function (data) {
               
                $scope.mapDisplayPropID = data.id;
                $scope.changeMarker();
                               
		    };
            
            $scope.changeMarker = function(){
                console.log($scope.mapDisplayPropID);
                 
                 // Update the map marker icons
                  angular.forEach($scope.markers, function (mkr) {
                   // console.log("new marker id=>"+mkr.id);
                      if (mkr.id == $scope.mapDisplayPropID) {
                          mkr.icon = "./images/CPX-pins_darkgreen_2x.png";
                      } else {
                          mkr.icon = '';
                      }
                  });
                  
                  console.log($scope.markers);
                
            };
            
            
		    $scope.closeClick = function () {
		        $scope.windowOptions.show = false;
		    };

		  //  $scope.title = "Window Title!";

		   
          $scope.changeSearch= function (groupID) {
               
               if(groupID==2)
               {
                return false;
               }
                
                if($scope.groups[groupID].isopen == true)
                {
                    $scope.groups[groupID].isopen = false;
                    changeFlag = false;
                    angular.forEach($scope.groups, function (group) {
                         if (group.id !=2 && group.isopen == true) {
                            changeFlag = true;  
                          } 
                    });
                    
                    if(!changeFlag)
                    {
                        
                        
                        $scope.showallsearches_Text = 'Show all searches';

                        $scope.showallsearches_toggle = true;
                    }
                    
                    
                    //$scope.groups=[{id:0,isopen:false},{id:1,isopen:false},{id:2,isopen:false}];
                }
                else
                {
                    $scope.groups=[{id:0,isopen:false},{id:1,isopen:false},{id:2,isopen:false}];
                    $scope.groups[groupID].isopen = true;    
                }
		    };
            
            
            
            $scope.showallsearches_toggle = true;
            $scope.showallsearches_Text = 'Show all searches';
    
            $scope.showhideallsearches = function(){
                
                $scope.groups=[{id:0,isopen:$scope.showallsearches_toggle},{id:1,isopen:$scope.showallsearches_toggle},{id:2,isopen:false}];
                
                
                $scope.showallsearches_Text = $scope.showallsearches_toggle ? 'Hide all searches' : 'Show all searches';

                $scope.showallsearches_toggle = $scope.showallsearches_toggle ? false : true;
            };
            		    
		    /*angular.forEach($scope.allproperties, function(item, key) { 
		    var df = 'MM/DD/YYYY'
			    var d1 = moment($scope.item.auction_date, moment.ISO_8601);
		    	console.log(d1);
			    var d2 =  moment();
			  
			    var days1 = Math.ceil(moment.duration(d1.diff(d2)).asDays());
			  
			    $scope.days = days1;
		    })
		             */         
		                       
		   	
		   
	//	    $scope.markers = $scope.properties;
		   
		    
		    $scope.addMarkerClickFunction = function (markersArray) {
		    	
		    	
		        angular.forEach(markersArray, function (value, key) {
		            value.onClick = function () {
		            	
                        //console.log("here");
                        //console.log(value);
		                $scope.onClick(value);
		                $scope.MapOptions.markers.selected = value;
		              //  $scope.propitem = value;
		               
		            };
		        });
		    };

		    //alerts
		    
		    $scope.alerts = [];

		    $scope.addAlert = function(id) {
		    	
		    	$scope.alertid = id;
		      $scope.alerts.push({msg: 'Property shortlisted successfully!'});
		      $scope.autoHide();
		    };
		    $scope.autoHide =function(){
		                    $timeout(function() {
		                          $scope.alerts.splice(0, 1);
		                    }, 2000);
		    }

		    $scope.closeAlert = function(index) {
		      $scope.alerts.splice(index, 1);
		    };
		        
		    
		    
		    ////////////////currency filters view graded property page
		    
		    

		   
		    function getRate(currency) {
		    	return currency && currency.rate;
		    }

		    // Grab the promises from the two calls  
		    var namesPromise = getRateInfo();
		   
		    // Use the $q.all method to run code only when both promises have been resolved
		    $q.all([namesPromise]).then(function(responses) {

		    	//var currencyNames = responses[0];
		    	var currencyRates = responses[0].quotes;

		    	// Generate the currencies array
		    	$scope.currencies = [];

		    	var currencyNames = CommonShareService.getcurrencyNames();
		    	
		    	var USDrate=currencyRates['USDUSD'];
     	        var AUDrate=currencyRates['USDAUD'];
     	        var multiplier=USDrate/AUDrate;
		    	
        		   angular.forEach(currencyNames, function(name, code) {
        			   		
        			   var rate = currencyRates['USD'+code];
        		    		$scope.currencies.push({
        		    			code: code,
        		    			label : code +" "+ name + " (" + numberFilter(rate*multiplier, 3) + " / AUD)",
        		    			rate: rate*multiplier
        		    		});
        
        
        		    	});
		    	
		    	// set default currency as AUD
		    	$scope.from.currency = $scope.currencies[7];
		    	
                if($scope.to.currency==undefined)
                    $scope.to.currency = $scope.currencies[7];
                                
		    });

            
            $scope.shortlist ={};
            $scope.affordable ={};
              
            $scope.storeSessionVal = function () {
                $scope.storeShortlistCriteria = function (vals) {
    			   	   sessionStorage.shortlistcriteriaVal = angular.toJson(vals); 	   
            	   };  
     
                    $scope.shortlist.to = $scope.to;
                    $scope.shortlist.from = $scope.from;
                   
            	   $scope.storeShortlistCriteria($scope.shortlist); 
    
                   
                    $scope.storeAffordableCriteria = function (vals) {
                	   sessionStorage.searchAffordableVal = angular.toJson(vals);
                        	   
            	   };
            	   
                   $scope.affordable.to = $scope.to;
                   $scope.affordable.from = $scope.from;
                                  
                   if(($scope.searchcriteria != undefined) && ($scope.searchcriteria.repay != undefined))
                        $scope.affordable.repay = $scope.searchcriteria.repay;
                   
            	   $scope.storeAffordableCriteria($scope.affordable);
            }
            
            //add to shortlist functions
		  $rootScope.count = ShortlistService.getcount();
		  $scope.shortlistcount = $rootScope.count;
          
          
          
		  $scope.addtoshortlist = function (prop) {
		      
              $scope.storeSessionVal();
              
			  console.log(prop);
			  $rootScope.count = ShortlistService.addProduct(prop);
              $scope.shortlistcount = $rootScope.count;
   		       console.log($rootScope.count);
		};
        	  
        
		    //function for all properties
		    $scope.countryflag = 'au';
		    $scope.countrylabel = 'AUD';
		    $scope.updateValueAll = function(from, to, items) {

		    	$scope.storeSessionVal();

		    	$scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);

		    	$scope.countrylabel = to.currency.code;
                
                                                                                                
		    	angular.forEach(items, function(item, key) {


		    		item.currencylabel = to.currency.code;
		    		//	console.log(item.currencylabel);

		    		if(to.currency.code == "AUD"){item.currencylabel = undefined;}  
		    		from.value = item.cpxprice;

		    		item.convertedcpx = item.cpxprice / getRate(from.currency) * getRate(to.currency);
		    		
		    		item.convertedlistedprice = item.listedprice / getRate(from.currency) * getRate(to.currency);
                    
                    item.convertedsavingprice = item.saving / getRate(from.currency) * getRate(to.currency);

		    		item.conv_costprice = item.costprice / getRate(from.currency) * getRate(to.currency);

		    		item.conv_estimatedtotal = item.estimatedtotal / getRate(from.currency) * getRate(to.currency);
		    		
		    		//console.log(item.conv_estimatedtotal);
                //code change by parvez for sponsors change 
		    	//	console.log("item");  
                //    console.log(item.sponsors);
                PIloanterm = $scope.defaultLOANTERM;
                PIrate_int = $scope.defaultPI_RATE;
                IOrate_int = $scope.defaultIO_RATE;
                if(item.sponsors.IO !=undefined)
                 {
                    IOrate_int = item.sponsors.IO.intrest_rate;
                 }   
                if(item.sponsors.PI !=undefined)
                 {
                    PIrate_int = item.sponsors.PI.intrest_rate;
    	    	    PIloanterm = item.sponsors.PI.term;
                 }   
                
                

		    		if($scope.case3flag){

		    			if($scope.percentflag){ 
		    				item.conv_cashamt = (item.convertedcpx*$scope.cashentered)/100;
		    			}else{
		    				item.conv_cashamt = $scope.cashentered;
		    			}
		    			item.conv_loanamt = item.conv_estimatedtotal - item.conv_cashamt;
		    			
		    			//console.log(item.conv_loanamt);
		    			
                        
		    			item.conv_PIrepayments = $scope.calrepayPI(PIloanterm,PIrate_int,item.conv_loanamt);
	   	    			 
		    			item.conv_IOrepayments = $scope.calrepayIO(IOrate_int,item.conv_loanamt);

		    		}else{

		    			item.conv_loanamt = item.loanamt / getRate(from.currency) * getRate(to.currency);

		    			item.conv_cashamt = item.cashamt / getRate(from.currency) * getRate(to.currency); 
		    			
		    			//item.conv_IOrepayments = item.IOrepayments / getRate(from.currency) * getRate(to.currency);

			    		//item.conv_PIrepayments = item.PIrepayments / getRate(from.currency) * getRate(to.currency);
			    		
		    			item.conv_PIrepayments = $scope.calrepayPI(PIloanterm,PIrate_int,item.conv_loanamt);
	   	    			 
		    			item.conv_IOrepayments = $scope.calrepayIO(IOrate_int,item.conv_loanamt);
			    		
		    			//console.log(item.conv_IOrepayments);
		    		}
		    	});
		    };


		    //function for individual property
		    $scope.dollarflag = false; 
		    $scope.updateValue = function(from, to, item) {
                
                $scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);
                $scope.countrylabel = to.currency.code;
                
		    	item.currencylabel = to.currency.code;
		    	if(to.currency.code == "AUD"){item.currencylabel = undefined;}  
		    	//from.value = item.cpxprice;
		    	item.convertedcpx = item.cpxprice / getRate(from.currency) * getRate(to.currency);
		    	item.convertedlistedprice = item.listedprice / getRate(from.currency) * getRate(to.currency);
                item.convertedsavingprice = item.savingprice / getRate(from.currency) * getRate(to.currency);
		    	
		    	
		    };


		    ////////loan view functions
		    
		    
		    /////////costs toggle 

//		    $scope.costselector = function (value) {
//
//		    	$scope.showcosts = !$scope.showcosts;
//
//		    };

		    
		  //repayments for PI
   	      $scope.calrepayPI = function(term,rate,loanamount){
   	    	  
   	    	  if(rate == 0){
   	    		
   	    		  var pay = loanamount/(term*12);
   	    		  
   	    	  }else{
   	    	  var n = term * 12;
   	    	  var c = rate /(100 * 12);

   	    	  var number1 = c * Math.pow(1+c, n);
   	    	  var number2 = Math.pow(1+c, n) - 1;

   	    	  var pay = loanamount *(number1/number2);
   	    	  
   	    	  }
   	    	 
   	    	  return pay;
   	      };   


   	   //repayments for IO
   	      $scope.calrepayIO = function(rate,loanamount){

   	    	  var pay = (rate*loanamount)/(100*12); 
   	    	  return pay;
   	      };    
		    
   	      
   	      $scope.converttoaud = function(to,price){
   	    	  
   	    	
	    	$scope.curr =getRate(to.currency);
	    	
	    	//console.log('curreny rate: '+$scope.curr);
	    	
	    	$scope.convertedcpx =[];
			angular.forEach(price, function(cpxprice, index) {
	    	
	    	$scope.convertedcpx.push(Math.round(cpxprice / $scope.curr));
	    	
			});
			
	    	return  $scope.convertedcpx;
	    	
   	      }
   	      
   	      
   	      
		    $scope.getcpxprice = function(getpay){
		    	
              //  $scope.defaultLOANTERM = 30;
        	  //  $scope.defaultPI_RATE = 4.29;
     		  //  $scope.defaultIO_RATE = 4.29;
        	 //	$scope.default_costvalue = 5;
                
		    	//console.log(getpay);
		    	$scope.getpay = Math.ceil(getpay  , 106800);
		    	//$scope.getpay = Math.ceil($scope.searchcriteria.repay  , 106800);
		    	
		    	$scope.pay = [];
		    	
		    	//$scope.pay.push($scope.getpay);
		    	
		    	$scope.pay.push($scope.getpay * 1.2);
		    	
		    	$scope.pay.push($scope.getpay * 0.8);
		    	
		    	/*angular.forEach($scope.properties, function(prop, code) {
		    		
		    	}*/
		    	
                
                
		    	//$scope.dk = $scope.pay * 2;
		    	//console.log($scope.loancriteria.inputcost);
		    	if($scope.loancriteria.inputcost == undefined || $scope.loancriteria.inputcost == '' || $scope.loancriteria.inputcost == null || isNaN($scope.loancriteria.inputcost) === true){

		    		$scope.defaultcostpercent = $scope.default_costvalue / 100;
		    		$scope.defaultIOpercent = $scope.defaultIO_RATE;
		    		//console.log("rate de :" + $scope.defaultcostpercent);
		    	}else{
		    		
		    		$scope.defaultcostpercent = $scope.loancriteria.inputcost / 100;
		    		$scope.defaultIOpercent = $scope.loancriteria.inputcost;
		    		//console.log("rate new :" + $scope.defaultcostpercent);
		    	}
		    	
		    	//case 1
	    		if(($scope.loancriteria.lvr == undefined || $scope.loancriteria.lvr == '') && ($scope.loancriteria.loancash == undefined || $scope.loancriteria.loancash == '')){
	    			$scope.cpxprice =[];
	    			angular.forEach($scope.pay, function(pay, index) {
	    				$scope.loanamount = (pay*12*100)/$scope.defaultIO_RATE;
	    		    	$scope.cashamount = 0;
	    		    	$scope.estimatedTotal = $scope.loanamount + $scope.cashamount ;
	    		    	//console.log($scope.estimatedTotal);
	    		    	$scope.cpxprice.push( Math.ceil (($scope.estimatedTotal)/(1 + ($scope.defaultcostpercent))));
	    		    	
	    		    	//****************PI Cal********************//
	    		    	
	    		    	$scope.constant1 = $scope.defaultPI_RATE / (12*100) ; 
	    		    	
	    		    	//console.log($scope.constant1);
	    		    	
	    		    	$scope.constant2 = $scope.defaultLOANTERM *12 ; 
	    		    	
	    		    	$scope.number1 = $scope.constant1 * Math.pow(1+$scope.constant1, $scope.constant2);
	    		    	//console.log($scope.number1);
	    		    	$scope.number2 = Math.pow(1+$scope.constant1, $scope.constant2) - 1;//console.log($scope.number2);
	    		    	$scope.number3 = pay/(1 + $scope.defaultcostpercent); //console.log(pay);
	    		    	//console.log($scope.loancriteria.lvrpercent);
	    		    	 	
	    		    	$scope.PIprice = $scope.number3 *($scope.number2/$scope.number1);
	    		    	
	    		    	//console.log($scope.PIprice);
	    		    	$scope.cpxprice.push( Math.ceil($scope.PIprice));
	    		    	
			    	});
		    	
		    	
		    	//console.log($scope.cpxprice);
		    
	    		}
	    		
	    		//case 2
	    		else if(($scope.loancriteria.lvr && $scope.loancriteria.lvr !='') && ($scope.loancriteria.loancash == undefined || $scope.loancriteria.loancash == '')){
	    			
	    			$scope.cpxprice =[];
	    			angular.forEach($scope.pay, function(pay, index) {
	    			
	    			$scope.loancriteria.lvrpercent = $scope.loancriteria.lvr/100;
	    			//$scope.cpxprice = Math.ceil(($scope.pay *12*100)/($scope.loancriteria.lvrpersent * $scope.defaultcostpercent));
	    			$scope.cal1 = Math.ceil(pay *12*100);
	    			//console.log($scope.cal1);
	    			$scope.cal2 = $scope.loancriteria.lvrpercent * $scope.defaultIO_RATE;
	    			//console.log($scope.loancriteria.lvrpercent);
	    			//console.log($scope.defaultcostpercent);
	    			$scope.cpxprice.push(Math.ceil($scope.cal1/$scope.cal2));
	    			
	    			
	    			$scope.constant1 = $scope.defaultPI_RATE / (12*100) ; 
    		    	
    		    	//console.log($scope.constant1);
    		    	
    		    	$scope.constant2 = $scope.defaultLOANTERM *12 ; 
    		    	
    		    	$scope.number1 = $scope.constant1 * Math.pow(1+$scope.constant1, $scope.constant2);
    		    	//console.log($scope.number1);
    		    	$scope.number2 = Math.pow(1+$scope.constant1, $scope.constant2) - 1;//console.log($scope.number2);
    		    	$scope.number3 = pay/$scope.loancriteria.lvrpercent; //console.log(pay);
    		    	//console.log($scope.loancriteria.lvrpercent);
    		    	 	
    		    	$scope.PIprice = $scope.number3 *($scope.number2/$scope.number1);
    		    	
    		    	//console.log($scope.PIprice);
    		    	$scope.cpxprice.push(Math.ceil($scope.PIprice));
	    			});
	    			//console.log($scope.cpxprice);
	    		}	
	    		
	    		
	    		//case 3
	    		
	    		else if(($scope.loancriteria.loancash && $scope.loancriteria.loancash !='') && ($scope.loancriteria.lvr == undefined || $scope.loancriteria.lvr == '')){
	    			
	    			if($scope.loancriteria.type == '%'){
	    				
	    				$scope.cpxprice =[];
		    			angular.forEach($scope.pay, function(pay, index) {
	    				
	    				$scope.defaultcostpercentplusone = 1 + $scope.defaultcostpercent;
	    				
	    				$scope.cal1 =12*100*pay /($scope.defaultIO_RATE * $scope.defaultcostpercentplusone);
	    				//console.log($scope.cal1);
	    				$scope.cal2 = Math.ceil($scope.defaultcostpercentplusone * 100) / Math.ceil(($scope.defaultcostpercentplusone * 100)- $scope.loancriteria.loancash);
	    				//console.log($scope.cal2);
	    				$scope.cpxprice.push(Math.ceil($scope.cal1*$scope.cal2));
	    				
	    				
	    				//*************PI Cal*************//
	    				$scope.constant1 = $scope.defaultPI_RATE / (12*100) ; 
	    		    	
	    		    	//console.log($scope.constant1);
	    		    	
	    		    	$scope.constant2 = $scope.defaultLOANTERM *12 ; 
	    		    	
	    		    	$scope.number1 = $scope.constant1 * Math.pow(1+$scope.constant1, $scope.constant2);
	    		    	//console.log($scope.number1);
	    		    	$scope.number2 = Math.pow(1+$scope.constant1, $scope.constant2) - 1;//console.log($scope.number2);
	    		    	$scope.number3 = pay/($scope.defaultcostpercentplusone - $scope.loancriteria.loancash/100); //console.log(pay);
	    		    	//console.log($scope.number3);
	    		    	 	
	    		    	$scope.PIprice = $scope.number3 *($scope.number2/$scope.number1) ;
	    		    	
	    		    	//$scope.PIprice =$scope.number4 + ; 
	    		    	//console.log($scope.PIprice);
	    		    	$scope.cpxprice.push(Math.ceil($scope.PIprice));
	    				
	    				
	    				
						
		    			});
		    			//console.log($scope.cpxprice);
	    			}
	    			
	    			else{
	    				
	    				$scope.cpxprice =[];
		    			angular.forEach($scope.pay, function(pay, index) {
	    				
		    				$scope.defaultcostpercentplusone = 1 + $scope.defaultcostpercent;
		    				
		    				$scope.cal1 = 12*100*pay /($scope.defaultIO_RATE * $scope.defaultcostpercentplusone);
		    				
		    				$scope.cal2 = $scope.loancriteria.loancash / $scope.defaultcostpercentplusone;
		    				
		    				$scope.cpxprice.push(Math.ceil($scope.cal1+$scope.cal2));
						
		    		    
		    				//*************PI Cal*************//
		    				$scope.constant1 = $scope.defaultPI_RATE / (12*100) ; 
		    		    	
		    		    	//console.log($scope.constant1);
		    		    	
		    		    	$scope.constant2 = $scope.defaultLOANTERM *12 ; 
		    		    	
		    		    	$scope.number1 = $scope.constant1 * Math.pow(1+$scope.constant1, $scope.constant2);
		    		    	console.log($scope.number1);
		    		    	$scope.number2 = Math.pow(1+$scope.constant1, $scope.constant2) - 1;console.log($scope.number2);
		    		    	$scope.number3 = pay/$scope.defaultcostpercentplusone; //console.log(pay);
		    		    	console.log($scope.number3);
		    		    	 	
		    		    	$scope.number4 = $scope.number3 *($scope.number2/$scope.number1) ;
		    		    	
		    		    	$scope.PIprice =$scope.number4 + $scope.cal2 ; 
		    		    	//console.log($scope.PIprice);
		    		    	$scope.cpxprice.push(Math.ceil($scope.PIprice));
		    				
		    				
		    			});
		    			
		    			//console.log($scope.cpxprice);
	    			}
	    			
	    		}
	    		
	    		console.log("checking cpxprice in get price range");
	    		console.log($scope.cpxprice);
	    		console.log($scope.to);
	    		$scope.convertedcpx = $scope.converttoaud($scope.to,$scope.cpxprice);
	    		
	    		//console.log("converted Price JJJ:" + $scope.convertedcpx);
	    		
	    		
	    		return $scope.convertedcpx;
	    		
		    }

		    
			
		    $scope.loanupdate = function (value,defaultflag) {



		    	if(value.inputcost == undefined || value.inputcost == '' || value.inputcost == null || isNaN(value.inputcost) === true){

		    		$scope.defaultcostpercent = $scope.default_costvalue / 100;
		    	}else{
		    		
		    		$scope.defaultcostpercent = value.inputcost / 100;
		    	}
		    	
		    	//console.log($scope.properties);
		    	
		    	angular.forEach($scope.properties, function(prop, code) {

		    		
		    		//case 1
		    		if((value.lvr == undefined || value.lvr == '') && (value.loancash == undefined || value.loancash == '')){


		    			$scope.case3flag = false;
		    			prop.costprice = prop.cpxprice * $scope.defaultcostpercent;

		    			prop.estimatedtotal = prop.cpxprice*1 + prop.costprice;

		    			prop.cashamt = 0;

		    			prop.cashpercent = 0;

		    			prop.loanamt = prop.estimatedtotal - prop.cashamt;

		    			prop.lvr = prop.loanamt / prop.cpxprice;

		    			prop.lvrdisplay = prop.lvr* 100;
		    			
		    			
		    			if(defaultflag == 'converter'){

		    				$scope.updateValueAll($scope.from,$scope.to,[prop]);
		    			}

		    			if(defaultflag == 'reset'){
		    				prop.conv_cashamt = undefined;
		    				prop.conv_costprice = undefined;
		    				prop.conv_estimatedtotal = undefined;
		    				prop.conv_loanamt = undefined;
		    				prop.convertedcpx = undefined;
		    				prop.currencylabel = undefined;
		    			}

		    			
		    		}

		    		//case 2
		    		else if((value.lvr && value.lvr !='') && (value.loancash == undefined || value.loancash == '')){



		    			$scope.case3flag = false;
		    			prop.costprice = prop.cpxprice * $scope.defaultcostpercent;

		    			prop.lvrdisplay = value.lvr;

		    			prop.lvr = prop.lvrdisplay / 100;

		    			prop.estimatedtotal = prop.cpxprice*1 + prop.costprice;

		    			prop.cashamt = prop.estimatedtotal - (prop.lvr * prop.cpxprice);

		    			prop.cashpercent = (100 + 100*$scope.defaultcostpercent) - prop.lvrdisplay*1;

		    			prop.loanamt = prop.estimatedtotal - prop.cashamt;
		    			
		    			

		    			if(defaultflag == 'converter'){
		    				$scope.updateValueAll($scope.from,$scope.to,[prop]);
		    			}

		    		}

		    		//case 3
		    		else if((value.loancash && value.loancash !='') && (value.lvr == undefined || value.lvr == '')){

		    			
		    			$scope.case3flag = true;

		    			prop.costprice = prop.cpxprice * $scope.defaultcostpercent;

		    			prop.estimatedtotal = prop.cpxprice*1 + prop.costprice;


		    			if(defaultflag == 'converter'){
		    				
		    				$scope.updateValueAll($scope.from,$scope.to,[prop]);
		    				if(value.type == '%'){
		    					$scope.percentflag = true;
		    					var x = (prop.convertedcpx*value.loancash)/100;
		    					$scope.cashentered = value.loancash;
		    				}
		    				else
		    				{
    				            var x = value.loancash;
                                $scope.percentflag = false;
                                $scope.cashentered = value.loancash;
                            }




		    				prop.lvr = (prop.conv_estimatedtotal - x) / prop.convertedcpx;

		    				prop.lvrdisplay = prop.lvr * 100;



		    				prop.conv_cashamt =x;

		    				prop.cashamt =x;

		    				prop.cashpercent = (100 + 100*$scope.defaultcostpercent) - prop.lvrdisplay*1;

		    				prop.conv_loanamt = prop.conv_estimatedtotal - prop.conv_cashamt;

		    				prop.loanamt = prop.conv_loanamt;
		    				
		    				PIloanterm = $scope.defaultLOANTERM;
                            PIrate_int = $scope.defaultPI_RATE;
                            IOrate_int = $scope.defaultIO_RATE;
                            if(prop.sponsors.IO !=undefined)
                             {
                                IOrate_int = prop.sponsors.IO.intrest_rate;
                             }   
                            if(prop.sponsors.PI !=undefined)
                             {
                                PIrate_int = prop.sponsors.PI.intrest_rate;
                	    	    PIloanterm = prop.sponsors.PI.term;
                             }   
                            
                            
		    				
		    				
		    				prop.conv_PIrepayments = $scope.calrepayPI(PIloanterm,PIrate_int,prop.conv_loanamt);
		   	    			 
			    			prop.conv_IOrepayments = $scope.calrepayIO(IOrate_int,prop.conv_loanamt);




		    			}else{

		    				if(value.type == '%'){

		    					var x = (prop.cpxprice*value.loancash)/100;

		    				}else{var x = value.loancash;}

		    				prop.lvr = (prop.estimatedtotal - x) / prop.cpxprice;

		    				prop.lvrdisplay = prop.lvr * 100;

		    				prop.cashamt = x;

		    				prop.cashpercent = (100 + 100*$scope.defaultcostpercent) - prop.lvrdisplay*1;

		    				prop.loanamt = prop.estimatedtotal - prop.cashamt;
		    				
		    				
		    			}

		    		}

		    	    PIloanterm = $scope.defaultLOANTERM;
                    PIrate_int = $scope.defaultPI_RATE;
                    IOrate_int = $scope.defaultIO_RATE;
                    if(prop.sponsors.IO !=undefined)
                     {
                        IOrate_int = prop.sponsors.IO.intrest_rate;
                     }   
                    if(prop.sponsors.PI !=undefined)
                     {
                        PIrate_int = prop.sponsors.PI.intrest_rate;
        	    	    PIloanterm = prop.sponsors.PI.term;
                     }    
		    		
		    		//repayments calculations based on interest type// cal graph data		
   	    			
		    		prop.PIrepayments = $scope.calrepayPI(PIloanterm,PIrate_int,prop.loanamt);
  	    			 
   	    			prop.IOrepayments = $scope.calrepayIO(IOrate_int,prop.loanamt);

   	    			   	    			
			    	});
		    };
	
				/////////gotoloan-tab
			
			 $scope.gotoloantab = function () {
				 $rootScope.scrolltoloan = true;
			 }; 
			
					   
				  $scope.vm = {
		                    // countries: Lookup.countries,
		                    languages: [
		                    {"value": "en", "name": "English"},
		                    {"value": "de", "name": "German"},
		                    ]
		                }
		                $scope.logSelected = function() {
		                  $translate.use($scope.vm.language.selected);
		                  console.log('SELECTED LANGUAGE IS :', $scope.vm.language.selected);
		                }
				  /////////////////////////////////////////////////////////////////
				  
				  
				  $scope.showDropdown = function (element) {
					    var event;
					    event = document.createEvent('MouseEvents');
					    event.initMouseEvent('mousedown', true, true, window);
					    element.dispatchEvent(event);
					};

					
					window.runThis = function () { 
					    var dropdown = document.getElementById('Select1');
					    $scope.showDropdown(dropdown);
					};
	  
				 
				//Added By Irshad
         $scope.passenquiry = function (printid) {
				
			// $rootScope.shownothing = false;
			//  console.log(printid);
			  CommonShareService.passenquireid(printid);
		  };	
					
					
					/*QueryService.create($scope.query).$promise.then(function(msg) {
					        $scope.msg = msg.toJSON();
					 });*/
    $scope.IsVisibleSold = true;
            						
	$scope.showhidesold = function () {
               
        if($scope.searchcriteria.underoffer)
        {
            $scope.IsVisibleSold = false;
            $scope.searchcriteria.sold = false;
        }    
        else
            $scope.IsVisibleSold = true;
    }
    
    $scope.IsVisibleUnderoffer = true;
            						
	$scope.showhideunderoffer = function () {
	   if($scope.searchcriteria.sold)
       {
            $scope.IsVisibleUnderoffer = false;
            $scope.searchcriteria.underoffer = false;
       }     
        else
            $scope.IsVisibleUnderoffer = true;
    }	
    
    
    $scope.IsVisiblenew = true;
    $scope.IsVisiblehomeland = true;
    
   	$scope.showhidenetabs = function ($all) {
   	    
        
        
        if($scope.searchcriteria.newprop || $all)
                $scope.showhideestablished();
        
        if($scope.searchcriteria.established || $all)
                $scope.showhidenewhomeland();
        if($scope.searchcriteria.homeland || $all)
                $scope.showhideestablishednew();
        
        if($scope.searchcriteria.sold || $all)
                $scope.showhideunderoffer();
        if($scope.searchcriteria.underoffer || $all)
                $scope.showhidesold();
    }    
    
            						
	$scope.showhidenewhomeland = function () {
	   
       //alert($scope.searchcriteria.established);
	   if($scope.searchcriteria.established)
       {
            $scope.IsVisiblenew = false;
            $scope.searchcriteria.newprop = false;
            $scope.IsVisiblehomeland = false;
            $scope.searchcriteria.homeland = false;
       }else
       {
            $scope.IsVisiblenew = true;
            $scope.IsVisiblehomeland = true;  
            
            
        
       }
             
                      
    }				
    
    $scope.IsVisibleestablished = true;
            						
	$scope.showhideestablished = function () {
	   if($scope.searchcriteria.newprop)
       {
            
            $scope.IsVisibleestablished = false;
            $scope.searchcriteria.established = false;
       }else
       {
            $scope.IsVisibleestablished = true;
       }
       console.log($scope.IsVisibleestablished+" --- " +$scope.searchcriteria.established);
            
    }
    
            						
	$scope.showhideestablishednew = function () {
	   
       if($scope.searchcriteria.homeland)
       {
            $scope.IsVisibleestablished = false;
            $scope.searchcriteria.established = false;
            $scope.IsVisiblenew = false;
            $scope.searchcriteria.newprop = false;
       }else
       {
            
            
            
            $scope.IsVisiblenew = true; 
            $scope.IsVisibleestablished = true;
        
       }
      
                        
    }

    $('.gridmapdiv ul li span').click(function (e) {
        e.preventDefault();
        $('.gridmapdiv ul li span').removeClass('selectedlist');
        $(this).addClass('selected');
    });	
	
    $scope.propertiesSuggestionBoxIsVisible = true;
    $scope.ShowHidePropertiesSuggestionBox = function () {
        //If DIV is visible it will be hidden and vice versa.
        $scope.propertiesSuggestionBoxIsVisible = !$scope.propertiesSuggestionBoxIsVisible;
    }
    
    
    //Function added from the productile controller by Parvez 12-07-2016
    
    
		$scope.getPropertyDetails = function(id) {
	    	
	    	//console.log("Function Called");
			$scope.propertyDetailed={};
			
			$scope.propertyDetailed.id = id;
			
		//	console.log($scope.propertyDetailed.id);
			
			QueryService.create($scope.propertyDetailed).$promise.then(function(data) {
				
				
				 $scope.properties= data.properties;
				 console.log( $scope.properties);
				 myService.setMyData($scope.properties);
			});
			
		}
	    
		
	    /////////////////////////////////////////////////
		
		$scope.checkIfFeatured = function(property){
			$scope.getonlyfeatured = {};
			
			if(property.featured == true){
				$scope.getonlyfeatured.from = "home";
				$scope.getonlyfeatured.val = true ;
				//console.log($scope.featured);
			
			}
			else{
				
				$scope.getonlyfeatured.from = "home";
				$scope.getonlyfeatured.val = false ;
			}
			
			console.log($scope.getonlyfeatured);
			isFeaturedService.setAsFeatured($scope.getonlyfeatured);
		}
		
		$scope.checkIfFeaturedViewAll = function(property){
			$scope.getonlyfeatured = {};
			$scope.getonlyfeatured.from = "listing";
				$scope.getonlyfeatured.val = false ;
				
				console.log($scope.getonlyfeatured);
			isFeaturedService.setAsFeatured($scope.getonlyfeatured);
		}
		
		//console.log($scope.getonlyfeatured);
		
		
		 $scope.setsShortlistStatus = function(status){
			 ShareStatusShortlistService.setStatusShortlist(status);
		    }
		
	
	//function getAuctionCount(auctionDate) {
	 $scope.getAuctionCount = function (auctionDate) {	
		 var df = 'MM/DD/YYYY'
			    var d1 = moment(auctionDate, "YYYY-MM-DD-hh:mm:ss");

			    var d2 =  moment();
			  
			    var days1 = Math.round(moment.duration(d1.diff(d2)).asDays());
			  
			    $scope.days = days1;
			   // console.log(days);
			    
			    if($scope.days > 0){
			    	$scope.auctionstatus = 'yes';
			    }
			    else if($scope.days < 0){
			    	$scope.auctionstatus = 'no';
			    }
			    else if($scope.days == 0){
			    	$scope.auctionstatus = 'today';
			    }
			    
			    return $scope.days;
		}
    
    
    
    //sorting
	 $scope.sortlist = function (option) {
		 
		 
		 if(option == '1'){
			 $scope.properties = $filter('orderBy')($scope.properties, "rel" ,true);
		 }

		 if(option == '2'){
			 $scope.properties = $filter('orderBy')($scope.properties, "beds" ,true);
		 }

		 if(option == '3'){
			 $scope.properties = $filter('orderBy')($scope.properties, "beds" ,false);
		 }

		 if(option == '4'){
			 $scope.properties = $filter('orderBy')($scope.properties, "cpxprice" ,true);
		 }

		 if(option == '5'){
			 $scope.properties = $filter('orderBy')($scope.properties, "cpxprice" ,false);
		 }

		 if(option == '6'){
			 $scope.properties = $filter('orderBy')($scope.properties, "score" ,true);
		 }

		 if(option == '7'){
			 $scope.properties = $filter('orderBy')($scope.properties, "score" ,false);
		 } 

		 if(option == '8'){
			 $scope.properties = $filter('orderBy')($scope.properties, "PIrepayments" ,true);
		 }

		 if(option == '9'){
			 $scope.properties = $filter('orderBy')($scope.properties, "PIrepayments" ,false);
		 } 
		
		// console.log($scope.properties);
		if($scope.viewid=="map")
            $scope.markers = $scope.properties;
        else
            $scope.markers = [];            
		  
	 };	
	
    var idArray = shareIdArrayService.getIdArray();
	var searchaffordable = '';
    //searchaffordable = angular.fromJson(sessionStorage.searchAffordableVal);
   // console.log("freezing checking");
   // console.log(idArray);
    //console.log(searchaffordable);
    
    var size = Object.size(idArray);
    if ((size != 0) || ($routeParams.searchid != '' && $routeParams.searchid != undefined) || (searchaffordable != '' ))        {
    	//console.log("in if condition");
        
                    if((searchaffordable != '' && searchaffordable != undefined))
                    {
                        $scope.searchcriteria = searchaffordable;
                    }
                    
                    if((size != 0 && size != undefined))
                    {
                        $scope.searchcriteria = shareIdArrayService.getIdArray();	
                    }	
                
                    if($routeParams.searchid != '' && $routeParams.searchid != undefined)
                    {
                        $scope.searchcriteria.searchid = $routeParams.searchid;
                    }
                    if(($scope.searchcriteria != undefined) && ($scope.searchcriteria.loanTermslvr != undefined)){
					   $scope.loancriteria.lvr = $scope.searchcriteria.loanTermslvr ;
                    }
					
					if(($scope.searchcriteria != undefined) && ($scope.searchcriteria.loanTermstype == undefined)){
						$scope.searchcriteria.loanTermstype = "$";
					}
                    
                    if(($scope.searchcriteria != undefined) && ($scope.searchcriteria.loanTermstype != undefined)){
					                         
                       $scope.loancriteria.type = $scope.searchcriteria.loanTermstype ;
                    }
					
                    if(($scope.searchcriteria != undefined) && ($scope.searchcriteria.loanTermsloancash != undefined )){
					 $scope.loancriteria.loancash = $scope.searchcriteria.loanTermsloancash;
					
                    }
                    if(($scope.searchcriteria != undefined) && ($scope.searchcriteria.loanTermsinputcost != undefined)){
					
					 $scope.loancriteria.inputcost = $scope.searchcriteria.loanTermsinputcost ;
                    }
                    
                    
					$scope.to = {};
                    $scope.to.currency = $scope.searchcriteria.tocurrency;
					//console.log($scope.currencyObj.code);
					 if(($scope.searchcriteria != undefined) && ($scope.searchcriteria.tocurrency)){
						// $scope.currencyObj = $scope.searchcriteria.tocurrency;
						// var currentCurrencyIndex = _.findIndex($scope.currencies, {code: $scope.currencyObj.code})
						// $scope.to.currency = $scope.currencies[currentCurrencyIndex];
					 }
					 //console.log(index);
					 //$scope.countrylabel = $scope.searchcriteria.tocurrency.coe;
					  
                      //console.log($scope.loancriteria);
					
                    //Added By Irshad
                    /*code for view selected properties start here*/        
                    
                    if(($scope.searchcriteria != undefined) && ($scope.searchcriteria.to))
                    {
                        
                       // $scope.to = $scope.searchcriteria.to;

                        
                    }
                    
                    if(($scope.searchcriteria != undefined))
                    {
                      //  $scope.from = $scope.searchcriteria.from;
                    }
                    
                   
					
		}
    //console.log("to currency");
      //console.log("freezing checking");
   // console.log(idArray);   
   // console.log("before print");
   // console.log($scope.searchcriteria);
   // console.log("after print");
    //console.log("parvez testing");
    //console.log($scope.searchcriteria);
//function getAuctionCount(auctionDate) {
	 $scope.setDefaultValues = function (data) {
	                      //console.log("default sponsors"); 
	                      //console.log(data.default_sponsors);
                          
                            if(data.default_sponsors.PI != undefined ) 
                            {   
		                    $scope.defaultLOANTERM = data.default_sponsors.PI.term;
                            $scope.defaultPI_RATE = data.default_sponsors.PI.intrest_rate;
                            }
                            if(data.default_sponsors.IO != undefined ) 
                            {
                            $scope.defaultIO_RATE = data.default_sponsors.IO.intrest_rate;
                            }
                            
		}
    
    
    
    
    
    if ((size != 0) || ($routeParams.searchid != '' && $routeParams.searchid != undefined) || (searchaffordable != '' ))        { 
            var dummyobject = {grade: "", type: "Any", minbeds: "Any", maxbeds: "Any"};
            $scope.loanupdate(dummyobject,'reset');
          // console.log("before search loan criteria");
          // console.log($scope.loancriteria);
           
            $scope.update($scope.searchcriteria,true,$scope.searchcriteria.sortOptionVal,$scope.loancriteria,'converter');
            
           /* if(size != 0)
                    {
    					$scope.searchcriteria.currentPage = idArray.currentPage;
    					$scope.pageChanged(idArray.currentPage);
                        $scope.sortcriteria.option = $scope.searchcriteria.sortOptionVal; 
                    }
            */
       }else
       {
        
       
       
	       QueryService.create($scope.searchcriteria).$promise.then(function(data) {
				
				$scope.setDefaultValues(data);
                $scope.allproperties = data.properties;
        	       	
        	    $scope.properties = [];
        	    angular.copy($scope.allproperties, $scope.properties);
                
                			
                /*code for view selected properties ends here*/  
                   // if(($scope.searchcriteria != undefined) && ($scope.searchcriteria.from))
                   // {
                        
                        //$scope.currencyObj = $scope.searchcriteria.to.currency;

                        //var currentCurrencyIndex = _.findIndex($scope.currencies, {code: $scope.currencyObj.code})
                        
                        //$scope.to.currency = $scope.currencies[currentCurrencyIndex];
                        
                        //$scope.countrylabel = $scope.to.currency.code;
                        
                        //$scope.countryflag = $scope.to.currency.code.toLowerCase().substr(0, 2);
                        //  console.log("freezing checking");
                        //  console.log($scope.searchcriteria);
                                      
                       //  $scope.update($scope.searchcriteria,true,$scope.searchcriteria.sortOptionVal,$scope.loancriteria,'converter');
                   // }
                    
                    
                	/*    
            	    $scope.gradelabels = [];
            	    angular.forEach(data.properties, function(property, index) {
            	          $scope.gradelabels.push({label : property.gradelabel , value : property.grade});
            	        });
            	   
                	 $scope.uniqueNames = [];
                	 $scope.uniarr = [];
                	   for(i = 0; i< $scope.gradelabels.length; i++){    
                	       if( $scope.uniqueNames.indexOf($scope.gradelabels[i].label) === -1){
                	    	   $scope.uniqueNames.push($scope.gradelabels[i].label);        
                	    	   
                	       } 
                	       
                	   }
	   
        	   for(i = 0; i< $scope.uniqueNames.length; i++){    
        	   
        		   if($scope.uniqueNames[i] == ""){
        	    	   $scope.uniarr.push({label : 'Filter by grade: Any'  ,value : 'Any' }); 
        	       }
        	       
        	       if($scope.uniqueNames[i] == "Filter by grade: AA - a score equal or above 275"){
        	    	   $scope.uniarr.push({label : $scope.uniqueNames[i]  ,value : 'AA' }); 
        	       }
        	       
        	       if($scope.uniqueNames[i] == "Filter by grade: A - a score equal or above 215"){
        	    	   $scope.uniarr.push({label : $scope.uniqueNames[i]  ,value : 'A' }); 
        	       }
        	       
        	       if($scope.uniqueNames[i] == "Filter by grade: B - a score equal or above 155"){
        	    	   $scope.uniarr.push({label : $scope.uniqueNames[i]  ,value : 'B' }); 
        	       }
        	       
        	       if($scope.uniqueNames[i] == "Filter by grade: C - a score equal or above 95"){
        	    	   $scope.uniarr.push({label : $scope.uniqueNames[i]  ,value : 'C' }); 
        	       }
        	       
        	       if($scope.uniqueNames[i] == "Filter by grade: D - a score equal or above 95"){
        	    	   $scope.uniarr.push({label : $scope.uniqueNames[i]  ,value : 'D' }); 
        	       }
        	       
        	      
        	   }
	   
        	   $scope.propType = [];
        	   angular.forEach(data.categories, function(category, index) {
        		   if(category != ""){
        	          $scope.propType.push({label : category});
        		   } 
        		   });
	   
	               */
	   
		            $scope.totalItems = data.count;
                    $scope.wholePages = Math.ceil( $scope.totalItems /  $scope.pageSize );
                    
                    
                    if($scope.totalItems % 2 ==0){
                    
                      $scope.propertiesThisPage = 2; 
                    }
                    else{
                      
                      if($scope.wholePages >$scope.paginationdata.currPage ){
                    	  $scope.propertiesThisPage = 2;
                      }
                      
                      else{
                    	  $scope.propertiesThisPage = 1;
                      }
                     
                    }
                   
                      
        
                    var dummyobject = {grade: "", type: "Any", minbeds: "Any", maxbeds: "Any"};
            		$scope.loanupdate(dummyobject,'reset');
		
			 		
       
       
					  
					  
	});
	
	}
   
    
    
    
    			  
}]);