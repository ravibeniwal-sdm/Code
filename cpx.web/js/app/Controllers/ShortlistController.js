app.controller('ShortlistCtrl', ['$scope','$rootScope', 'QueryService','ShortlistService','CommonShareService','$window','$modal','$log','getRateInfo','numberFilter','$q','$timeout','ShareStatusShortlistService','shareIdArrayService', function ($scope,$rootScope, QueryService, ShortlistService,CommonShareService,$window,$modal, $log,getRateInfo,numberFilter,$q,$timeout,ShareStatusShortlistService, shareIdArrayService) {
	
	$rootScope.title = "Central Property Exchange | Real Estate| Shortlist";
	$rootScope.metakeywords = "property,shortlist,graded,standard,view,reserve,grade,cart,bucket,favourite";
	
	$scope.properties = ShortlistService.getProducts();
	
	//console.log($scope.properties);
	
	 $scope.shorlistedPropIds = [];
	    angular.forEach($scope.properties, function(property, index) {
	          $scope.shorlistedPropIds.push(property.id);
	        });
	    console.log($scope.shorlistedPropIds);
	
    
    $scope.baseWebUrl = baseWebUrl;
    $scope.baseAmazonUrl = baseAmazonUrl;
	$scope.defaultPI_LOANTERM = 30;
	$scope.defaultIO_LOANTERM = 5;
	$scope.defaultPI_RATE = 4.29;
	$scope.defaultIO_RATE = 4.29;
	$scope.default_costvalue = 5;
	
    $scope.short_currlabel = undefined;
	$scope.short_convcpx = undefined;
    $scope.short_convlisted = undefined;
    $scope.short_convsaving = undefined;
    
	$scope.caseflag = 'one';
//	$scope.short = ShortlistService.getProducts();
	
//	console.log("hello"+$scope.short);
	
//	localStorage.setItem("token", token);
	
//	$rootScope.shownothing = true;
	
    var shortlistcriteria = '';
    shortlistcriteria = angular.fromJson(sessionStorage.shortlistcriteriaVal);


    
    
    



    
	$scope.viewValue = 'standard';
	$scope.shortlist = {selectedView:'standard', individualView:[]};
	$scope.gradevalues = [1,2,3,4,5];
	$scope.isViewSelected = function(selView, propertyId){
		if($scope.shortlist.individualView.indexOf(selView+propertyId)!=-1){
			return true;
		}
		if(selView==$scope.shortlist.selectedView  && isIndividualViewSelected(selView, propertyId)==-1){
			return true;
		}
		
		return false;
	};
	
	 $scope.setsShortlistStatus = function(status){
		 ShareStatusShortlistService.setStatusShortlist(status);
	    }
	
	$scope.selectView = function(selView, propertyId){
		var idx = isIndividualViewSelected(selView, propertyId);
		if(idx>-1){
			$scope.shortlist.individualView.splice(idx,1);
		}
		/*no need to put in individaul array if the default view is selected */
		if(selView!=$scope.shortlist.selectedView ){
			$scope.shortlist.individualView.push(selView+propertyId);
		}
		
		if($scope.shortlist.individualView.length>0){
			$scope.viewValue = 'none';
		}else{
			$scope.viewValue = selView;
		}
	};
	$scope.onGlobalViewChange = function(){
		if($scope.viewValue!='none'){
			$scope.shortlist.selectedView = $scope.viewValue;
		}
		$scope.shortlist.individualView=[];
	};
	var isIndividualViewSelected = function(selView, propertyId){
		var idx = $scope.shortlist.individualView.indexOf('standard'+propertyId);
		if(idx>-1){
			return idx;
		}
		var idx = $scope.shortlist.individualView.indexOf('loan'+propertyId);
		if(idx>-1){
			return idx;
		}
		var idx = $scope.shortlist.individualView.indexOf('investment'+propertyId);
		if(idx>-1){
			return idx;
		}
		return -1;
		
	};
	
	// remove function
	$scope.removeItem = function (index) {
		$scope.properties = ShortlistService.removeProduct(index);
		$scope.shortlistcount = $scope.properties.length;
	};	  
	
	//clear shortlist function
	
	 $scope.clearlist = function () {
		$scope.properties = ShortlistService.clearshortlist();
	 
		$scope.shortlistcount = $scope.properties.length;
	 };	  
	
	 //count

	 $scope.shortlistcount = ShortlistService.getcount();
		 
	// console.log($scope.shortlistcount);
	 
    //share via mail
 
	 /////AREA UNITS START///////////
	 angular.forEach($scope.properties , function(property, index) {
	 if(property.areaunit == 'squareMeter'){
			property.areaunit = 'm2';
		}
		else if(property.areaunit == 'acre'){
			property.areaunit = 'acre';
		}
		else if(property.areaunit == 'Hectare'){
			property.areaunit = 'ha';
		}
		else if(property.areaunit == 'squareFeet'){
			property.areaunit = 'Sq Ft';
		}
	 
	 });
	 /////AREA UNITS START///////////
	 
     angular.forEach($scope.properties , function(property, index) {
            
            property.gradevalues = [1,2,3,4,5];
            property.grade_table_status=[{id:0,isopen:true}];	
            property.ipr_history = [];
            
            if(property.gradestatus > 0)
            {
                angular.forEach(property.iprs, function(iprs_arr, i) {
            
                    property.score = 0;
                    
                    property.grade_table_arr = [];
                                                    
                	angular.forEach(iprs_arr.currentResult.items, function(grade, j) {

                             
                        if(grade.name != "Parking" && grade.name != "Outdoor Space")
                        {
                            if(grade.score >= 0 && grade.score <= 10 )
                                attr_val = 1;
                            else if(grade.score >= 10 && grade.score <= 20 )
                                attr_val = 2;        
                            else if(grade.score >= 20 && grade.score <= 30 )
                                attr_val = 3;
                            else if(grade.score >= 30 && grade.score <= 40 )
                                attr_val = 4;
                            else if(grade.score >= 40  )
                                attr_val = 5;                                                                                                               }
                        else
                        {
                            if(grade.score >= 0 && grade.score <= 5 )
                                attr_val = 1;
                            else if(grade.score >= 5 && grade.score <= 10 )
                                attr_val = 2;        
                            else if(grade.score >= 10 && grade.score <= 15 )
                                attr_val = 3;
                            else if(grade.score >= 15 && grade.score <= 20 )
                                attr_val = 4;
                            else if(grade.score >= 20  )
                                attr_val = 5;                         
                        }                                                                                            
                                                                            
                        property.grade_table_arr.push({ attr_name: grade.name, attr_score: grade.score, attr_val: attr_val});
                                                                                             
                    });
                    
                    property.score = iprs_arr.results['0'].score;
            
                    property.grade = iprs_arr.results['0'].grade;
                                            
                    property.price_assessed = 'AUD $ '+iprs_arr.property.price;
                    
                    property.weekly_rent  = 'AUD $ '+iprs_arr.property.weeklyRent;
                    
                    property.publish_date = moment(iprs_arr.publishedAt,'YYYY-MM-DDThh:mm').format('DD MMM YYYY');
                    
                    property.days_old = iprs_arr.numberof_days_old;
                
                    property.bed = iprs_arr.property.beds;
                    property.bath = iprs_arr.property.baths;
                    property.cars = iprs_arr.property.cars;                
                    
                    property.document_url = iprs_arr.downloadUri;

                    if(i>0)
                        property.grade_table_status.push({id:i,isopen:false});
                    
                    property.ipr_history.push({id:i, grade: property.grade, score: property.score, price_assessed: property.price_assessed, weekly_rent: property.weekly_rent, publish_date : property.publish_date, days_old : property.days_old, bed:property.bed, bath:property.bath, cars:property.cars, document_url:property.document_url,grade_table_arr:property.grade_table_arr});
                });
            
                console.log("ipr history");
                console.log( property.ipr_history);
                console.log("gradetablestatus");
                console.log( property.grade_table_status);
            }
            
    	 });
        
        $scope.show_grade_table = function(id,property_id){
            angular.forEach($scope.properties , function(property, index) {
                
                    if(property.id == property_id)
                    {
                        angular.forEach(property.grade_table_status, function(grade_table_status, i) {
                            
                            if(i != id)
                            {
                                property.grade_table_status[i].isopen = false;
                            }
                            else
                            {
                                property.grade_table_status[i].isopen = true;
                            }                           
                        });    
                    }
                    
                    console.log("gradetablestatus");
                    console.log( property.grade_table_status);
                });   
            }     
	 
 $scope.open2 = function (item) {

	    var modalInstance = $modal.open({
	      templateUrl: 'mymailcontent.html',
	      controller: 'ModalmailCtrl',
	      size: '',
	      resolve: {
	        items: function () {
	          return item;
	        }
	      }
	    });

	    modalInstance.result.then(function (selectedItem) {
		      $scope.selected = selectedItem;
		    }, function () {
		      $log.info('Modal dismissed at: ' + new Date());
		    });
		  };
	
		////function to show interest rate's sponser pop-up
		  $scope.openpopup = function (size) {

			    var modalInstance = $modal.open({
			      templateUrl: 'mypopupmsg.html',
			      controller: 'ModalInstanceCtrl',
			      windowClass: 'app-modal-window',
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
		  
		  
		  
		  
		  
		  
		  
		  $scope.toggle_enquire_servicerequest = function (val) {
							
					
			  sessionStorage.toggle_val = angular.toJson(val); 	   
		  };
		  
	//print link	  
		  
		  $scope.passid = function (printid) {
						
		//	  console.log(printid);
			  CommonShareService.passid(printid);
		  };
		  
	//pass enquiry 	  
		  
		  $scope.passenquiry = function (printid) {
				
			$rootScope.shownothing = false;
			//  console.log(printid);
			  CommonShareService.passenquireid(printid);
		  };
		  
	// pass all enquiries	  
		  
		  $scope.passall = function () {
			  
			  $rootScope.shownothing = false; 
			//  console.log("all");
			  CommonShareService.passallid();
		  };
		  $scope.passbuythis = function (printid) {
							
						$rootScope.shownothing = false;
						// console.log(printid);
						  CommonShareService.passbuythisid(printid);
					  };
		// go url function
		  $scope.go = function (url) {
			//  alert(url); 
			   $window.open(url);
		   };
		  
		   
		//show hide flags
		   $scope.flagsvisible = true;
		   $scope.showhidetext = "Hide";
		   $scope.hideshowflags = function () {
			   
			   $scope.flagsvisible = !($scope.flagsvisible);   
				
			   if($scope.flagsvisible == false){
				   $scope.showhidetext = "Show";
			   }else
			   {$scope.showhidetext = "Hide";}   
			   
			   };
			   
			   
			   ////////////////currency filters shortlist
			   
			   
			   $scope.countryflag = 'au';
			   $scope.countrylabel = 'AUD';
			    
			   $scope.dollarflag = true;
	     	      function getRate(currency) {
	     	        return currency && currency.rate;
	     	      }

	     	      // Grab the promises from the two calls  
	     	      var namesPromise = getRateInfo();
	     	     // var ratesPromise = getRateInfo('latest');

	     	      $scope.to = {};
	     	 //     $scope.currency2 = {};
	     	      $scope.from = {};

	     	      // Use the $q.all method to run code only when both promises have been resolved
	     	      $q.all([namesPromise]).then(function(responses) {

	     	  //      var currencyNames = responses[0];
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
	     	            label : code +" "+ name + " (" + numberFilter(rate*multiplier , 3) + " / AUD)",
	     	            rate: rate*multiplier
	     	          });	     	          
	     	        });
	     	        
	     	     
	     	        
	     	        // set AUD as default currency
	     	        $scope.from.currency = $scope.currencies[7];
	     	        $scope.to.currency = $scope.currencies[7];
                    
                    if(shortlistcriteria.to.currency != '')
                    {
                        $scope.from = shortlistcriteria.from ;                        
                        $scope.to = shortlistcriteria.to ;
                        
                        $scope.currencyObj = shortlistcriteria.to.currency;
                        var currentCurrencyIndex = _.findIndex($scope.currencies, {code: $scope.currencyObj.code})
                        
                        $scope.to.currency = $scope.currencies[currentCurrencyIndex];
                        
                        $scope.countryflag = shortlistcriteria.to.currency.code.toLowerCase().substr(0, 2);
                        $scope.countrylabel = shortlistcriteria.to.currency.code;

                        
                        $scope.updateValueAll($scope.from, $scope.to, $scope.properties, false);
                       
                    }
	     	      });


                  
	     	      $scope.updateValueAll = function(from, to, items, isTopconvertor) {
	     	    	 $scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);
	 		    	 $scope.countrylabel = to.currency.code;
	     	    	
	 		    	angular.forEach(items, function(item, key) {
	 		    		
			    		item.short_currlabel = to.currency.code;

			    		if(to.currency.code == "AUD"){item.short_currlabel = undefined;}  
	 		    		
			    		item.short_convcpx = item.cpxprice / getRate(from.currency) * getRate(to.currency);
                        item.short_convlisted = item.listedprice / getRate(from.currency) * getRate(to.currency);
                        
                        item.short_convsaving = item.saving / getRate(from.currency) * getRate(to.currency);
			    		
			    		item.series = [];
			    		item.data = [];
			    		
			    		///for all scenarios
			    		angular.forEach(item.scenarios, function(scenaitem, key) {


			    			scenaitem.conv_costprice = scenaitem.costprice / getRate(from.currency) * getRate(to.currency);

		    				scenaitem.conv_estimate = scenaitem.estimate / getRate(from.currency) * getRate(to.currency);

		    				scenaitem.conv_loanamt = scenaitem.loanamt / getRate(from.currency) * getRate(to.currency);

		    				
		    				scenaitem.conv_cashamount = scenaitem.cashamount / getRate(from.currency) * getRate(to.currency);
			    			//repayments calculations based on interest type// cal graph data
			    			if(scenaitem.loantype == 'PI'){

			    				if(scenaitem.intrate == undefined || scenaitem.intrate == ""){

			    					scenaitem.intrate = 0; 
			    				} 

			    				scenaitem.conv_repayments = $scope.calrepayPI(scenaitem.loanterm,scenaitem.intrate,scenaitem.conv_loanamt);

			    				scenaitem.graphdata = $scope.calgraphdata(scenaitem.loanterm,scenaitem.intrate,scenaitem.conv_loanamt,scenaitem.conv_repayments);
			    			}else{
			    				scenaitem.conv_repayments = $scope.calrepayIO(scenaitem.intrate,scenaitem.conv_loanamt);
                                
                                if(scenaitem.loanterm=='' || scenaitem.loanterm == 0)
                                {
                                    scenaitem.loanterm = $scope.defaultIO_LOANTERM;
                                }
                                
			    				scenaitem.graphdata = $scope.calgraphdata(scenaitem.loanterm,scenaitem.intrate,scenaitem.conv_loanamt,scenaitem.conv_repayments);
			    			}


			    			item.data.push(scenaitem.graphdata[0].data);
			    			item.series.push(scenaitem.name);


			    			
			    			if(scenaitem.graphdata[0].label.length>item.labels.length){			    				
			    				item.labels = scenaitem.graphdata[0].label;
			    			}
			    			



			    			
			    		});
			    		
			    		
		    			
			    		 var max = 0;
	     	 	    	  for(i=0;i<item.scenarios.length;i++){

	     	 	    		  if(item.scenarios[i].graphdata[0].label.length > max){

	     	 	    			  max = item.scenarios[i].graphdata[0].label.length;
	     	 	    			  var newindex = i;
	     	 	    		  }
	     	 	    	  }

	     	 	    	  if(item.scenarios.length>0){
	     	 	    	  item.labels = item.scenarios[newindex].graphdata[0].label;  
	     	 	    	  }
			    		
			    		
 	
			    	});
	     	      
	     	      };   
			   
	     	      
	     	      	     	      
	     	      
	     	      
	     	//////loan view table data
	     	      

	     	      $scope.isCollapsedflag = false;   

	     	      $scope.setiscreate = function(prop){

	     	    	  $scope.iscreate= true;
	     	    	 $scope.editflag=null;
	     	    	$scope.editingname=null;
                    
                    prop.scena.loanterm = 5;
	     	      }

	     	      $scope.typeselected = 'IO'; 

	     	      $scope.isIOselected = function(value,prop){

	     	    	  $scope.typeselected = value;
                      
                        if(value == 'IO')
                        {
                            prop.scena.loanterm = 5;
                        }
                        else if(value == 'PI')
                        {
                            prop.scena.loanterm = 30;
                        }                   

	     	      };   
	     	    
	     	    
	     	     //repayments for PI shortlist page
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


	     	   //repayments for IO shortlist page
	     	      $scope.calrepayIO = function(rate,loanamount){

	     	    	  var pay = (rate*loanamount)/(100*12); 
	     	    	  return pay;
	     	      };    
	     	   
	     	   //graph data calculations
	     	      $scope.calgraphdata = function(term,rate,loanamount,repay){

	     	    	  var label=[0];
	     	    	  var data = [loanamount.toFixed(2)];
	     	    	  var n = term * 12;
	     	    	  var c = rate /(100 * 12);

	     	    	  for(i=1;i<=n;i++){

	     	    		  if(i%12 == 0){  
	     	    			  label.push(i/12);
	     	    			  
	     	    			 
	     	    			  data.push(loanamount.toFixed(2));
	     	    		  }


	     	    		  var mon_int = loanamount*c;
	     	    		  var mon_princi = repay - mon_int;
	     	    		  
	     	    		  
	     	    		  loanamount = loanamount - mon_princi;

	     	    	  }

	     	    	  var graph=[{data:'',label:''}];   
	     	    	  graph[0].data = data;
	     	    	  graph[0].label = label;


	     	    	  return graph;
	     	      };      
	     	   
	     	    
	   	    	//setting base scenario for all properties 
	     	      
	     	     $scope.setbasescenario = function(properties){
	     	      
	     	      angular.forEach(properties, function(prop, code){
	     	    	  
	     	    	 prop.short_currlabel = undefined;
		     	    	prop.short_convcpx = undefined; 

	     	    	  prop.scena = {name:'',
	     	    			  lvr:'',
	     	    			  cashamount:'',
	     	    			  loantype:'',
	     	    			  interestrate:'',
	     	    			  loanterm:'',
	     	    			  costper:''
	     	    	  }; 



	     	    	  prop.scenarios =[];
	     	    	  
	     	    	  //base IO
	     	    	  var Base = {}; 
	     	    	  
                      if(prop.sponsors.IO !=undefined)
                    { 
                       
                       Base.name = 'Base IO';

	     	    	  Base.loantype = 'IO';

	     	    	  Base.intrate = prop.sponsors.IO.intrest_rate;
    	    	      Base.loanterm = prop.sponsors.IO.term;
	     	    	  Base.caseflag = 'one';
	     	    	  Base.cost = $scope.default_costvalue;
	     	    	  $scope.defaultcostpercent = Base.cost*1/100;

	     	    	  Base.costprice = prop.cpxprice * $scope.defaultcostpercent;
	     	    	  Base.estimate = prop.cpxprice*1 + Base.costprice;
	     	    	  Base.cashamount = 0;
	     	    	  Base.cashpercent = 0;
	     	    	  Base.loanamt = Base.estimate - Base.cashamount;
	     	    	  var lvr = Base.loanamt / prop.cpxprice;
	     	    	  Base.lvr = lvr* 100;


	     	    	  Base.repayments = $scope.calrepayIO(Base.intrate,Base.loanamt);
	     	    	  //	Base.repayments = $scope.calrepayPI(Base.loanterm,Base.intrate,prop.loanamt);		
	     	    	  Base.graphdata = $scope.calgraphdata(Base.loanterm,Base.intrate,Base.loanamt,Base.repayments);


	     	    	  $scope.scenariotowatch = Base;	     	    	  
	     	    	  prop.scenarios.push(Base);

	     	    	  prop.labels = Base.graphdata[0].label;
	     	    	  prop.series = [Base.name];
	     	    	  prop.data = [Base.graphdata[0].data];

	     	    	 }
	     	    	 ////base for PI
	     	    	if(prop.sponsors.PI !=undefined)
                    {  
	     	    	  var Base_PI = {}; 
	     	    	  Base_PI.name = 'Base PI';

	     	    	  Base_PI.loantype = 'PI';

	     	    	  Base_PI.intrate = prop.sponsors.PI.intrest_rate;
    	              Base_PI.loanterm = prop.sponsors.PI.term;
	     	    	  Base_PI.caseflag = 'one';
	     	    	  Base_PI.cost = $scope.default_costvalue;
	     	    	  $scope.defaultcostpercent = Base_PI.cost*1/100;

	     	    	  Base_PI.costprice = prop.cpxprice * $scope.defaultcostpercent;
	     	    	  Base_PI.estimate = prop.cpxprice*1 + Base_PI.costprice;
	     	    	  Base_PI.cashamount = 0;
	     	    	  Base_PI.cashpercent = 0;
	     	    	  Base_PI.loanamt = Base_PI.estimate - Base_PI.cashamount;
	     	    	  var lvr = Base_PI.loanamt / prop.cpxprice;
	     	    	  Base_PI.lvr = lvr* 100;


	     	    	  //Base_PI.repayments = $scope.calrepayIO(Base_PI.intrate,Base_PI.loanamt);
	     	    	  Base_PI.repayments = $scope.calrepayPI(Base_PI.loanterm,Base_PI.intrate,Base_PI.loanamt);		
	     	    	  Base_PI.graphdata = $scope.calgraphdata(Base_PI.loanterm,Base_PI.intrate,Base_PI.loanamt,Base_PI.repayments);
  	    	  
	     	    	  prop.scenarios.push(Base_PI);
	     	    	  
	     	    	
	     	    	 prop.labels = Base_PI.graphdata[0].label;
 	    			 prop.data.push(Base_PI.graphdata[0].data);
 	    			 prop.series.push(Base_PI.name);
	     	    	}   
	     	    	  
	     	    	  

	     	      });		 
	     	     
	     	    
	     	     }
	     	      
	     	     ///////////function for setting default to AUD
	     	    	 
	     	     //call to set base scenario
	     	    $scope.setbasescenario($scope.properties);
	     	     
	     	   
	     	     
	     	      //////add new scenario

	     	      $scope.submitscenario = function(property,scena){

                    //console.log(property);

	     	    	  //setting alerts status
	     	    	  if(scena.name){
	     	    		  $scope.status = 'OK';	

	     	    		  if($scope.editingname !=null){
	     	    			  $scope.status = 'editOK';
	     	    			  $scope.editingname=null;}

	     	    		  angular.forEach(property.scenarios, function(object, code) {

	     	    			  if(object.name.toLowerCase() == scena.name.toLowerCase()){

	     	    				  $scope.status = 'notOK';
	     	    			  }
	     	    		  });

	     	    		  if($scope.editflag != null){
	     	    			  if(property.scenarios[$scope.editflag].name.toLowerCase() == scena.name.toLowerCase()){
	     	    				  $scope.status = 'editOK';
	     	    			  }}

	     	    	  }else{$scope.status = 'notOK';}
                      
                     // console.log("time :1")
                     // console.log(scena);  

                    
	     	    	 // console.log($scope.status);

	     	    	  /////allow if status is OK or editOK
	     	    	  if($scope.status != 'notOK'){
	     	    		  $scope.scenatowatch = scena; 


	     	    		  var scenario ={name: scena.name,
	     	    				  lvr:scena.lvr,
	     	    				  cashamount:scena.cashamount,
	     	    				  cashpercent:null,
	     	    				  loantype:scena.loantype,
	     	    				  intrate:scena.interestrate,
	     	    				  loanterm:scena.loanterm,
	     	    				  repayments:null,
	     	    				  cost:scena.costper,
	     	    				  estimate:null,
	     	    				  loanamt:null};  


                     // console.log("time :2")
                     // console.log(scenario); 
                     // console.log(scena); 
	     	    		  
	     	    		  $scope.defaultcostpercent = scenario.cost*1/100;

	     	    		  if(scenario.cost == undefined || scenario.cost == ""){
	     	    			  scenario.cost = 5;
	     	    			  $scope.defaultcostpercent = 0.05;
	     	    		  } 


	     	    		  //case 1
	     	    		  if((scena.lvr == undefined || scena.lvr == '') && (scena.cashamount == undefined || scena.cashamount == '')){

	     	    			 scenario.caseflag = 'one';
	     	    			 // console.log('inside1');
	     	    			  scenario.costprice = property.cpxprice * $scope.defaultcostpercent;

	     	    			  scenario.estimate = property.cpxprice*1 + scenario.costprice;

	     	    			  scenario.cashamount = 0;

	     	    			  scenario.cashpercent = 0;

	     	    			  scenario.loanamt = scenario.estimate - scenario.cashamount;
	     	    			  	     	    			
	     	    			  var lvr = scenario.loanamt / property.cpxprice;

	     	    			  scenario.lvr = lvr* 100;
	     	    			  
	     	    			  
	     	    			  
	     	    			 

	     	    		  }


	     	    		  //case 2
	     	    		  else if((scena.lvr && scena.lvr !='') && (scena.cashamount == undefined || scena.cashamount == '')){

	     	    			 scenario.caseflag = 'two';
	     	    			  scenario.costprice = property.cpxprice * $scope.defaultcostpercent;

	     	    			// console.log('inside2');

	     	    			  var lvr = scena.lvr / 100;

	     	    			  scenario.estimate = property.cpxprice*1 + scenario.costprice;

	     	    			  scenario.cashamount = scenario.estimate - (lvr * property.cpxprice);

	     	    			  scenario.cashpercent = (100 + 100*$scope.defaultcostpercent) - scena.lvr;

	     	    			  scenario.loanamt = scenario.estimate - scenario.cashamount;

	     	    		  }

	     	    		  //case 3
	     	    		  else if(((scena.cashamount && scena.cashamount !='') && (scena.lvr == undefined || scena.lvr == '')) || ((scena.cashamount && scena.cashamount !='') && (scena.lvr && scena.lvr !=''))){

	     	    			  //console.log('inside3');

	     	    			 scenario.caseflag = 'three';
	     	    			  scenario.costprice = property.cpxprice * $scope.defaultcostpercent;

	     	    			  scenario.estimate = property.cpxprice*1 + scenario.costprice;



	     	    			  if(property.short_currlabel){


	     	    				  if(scena.cashtype == '%'){

	     	    					  var x = (property.short_convcpx*scena.cashamount)/100;

	     	    				  }
	     	    				  else
	     	    				  {var x = scena.cashamount;}


	     	    				  scenario.conv_costprice = scenario.costprice / getRate($scope.from.currency) * getRate($scope.to.currency);
	     	    				  scenario.conv_estimate = scenario.estimate / getRate($scope.from.currency) * getRate($scope.to.currency);


	     	    				  var lvr = (scenario.conv_estimate - x) / property.short_convcpx;

	     	    				  scenario.lvr = lvr * 100;
	     	    				 
	     	    				  scenario.conv_cashamount = x;	
	     	    				 
	     	    				  scenario.cashamount = x / getRate($scope.to.currency) * getRate($scope.from.currency);;

	     	    				  scenario.cashpercent = (100 + 100*$scope.defaultcostpercent) - scenario.lvr*1;

	     	    				  scenario.conv_loanamt = scenario.conv_estimate - scenario.conv_cashamount;

	     	    				  scenario.loanamt = scenario.estimate - scenario.cashamount;

	     	    			  }

	     	    			  else{
	     	    				  if(scena.cashtype == '%'){

	     	    					  var x = (property.cpxprice*scena.cashamount)/100;

	     	    				  }else{var x = scena.cashamount;}

	     	    				  var lvr = (scenario.estimate - x) / property.cpxprice;

	     	    				  scenario.lvr = lvr * 100;

	     	    				  scenario.cashamount = x;

	     	    				  scenario.cashpercent = (100 + 100*$scope.defaultcostpercent) - scenario.lvr*1;

	     	    				  scenario.loanamt = scenario.estimate - scenario.cashamount;
	     	    			  }
	     	    		  }

	     	    		  //repayments calculations based on interest type// cal graph data
	     	    		  if(scenario.loantype == 'PI'){
	     	    			  
	     	    			 if(scenario.intrate == undefined || scenario.intrate == ""){
	     	    				 
	     	    				scenario.intrate = 0; 
	     	    				} 
	     	    			
	     	    			  scenario.repayments = $scope.calrepayPI(scenario.loanterm,scenario.intrate,scenario.loanamt);
	     	    			 
	     	    			  scenario.graphdata = $scope.calgraphdata(scenario.loanterm,scenario.intrate,scenario.loanamt,scenario.repayments);
	     	    			// console.log(scenario.graphdata);
	     	    		  }else{
	     	    			 //scenario.loanterm = $scope.defaultIO_LOANTERM;
                             if(scenario.loanterm=='' || scenario.loanterm == 0)
                             {
                                scenario.loanterm = $scope.defaultIO_LOANTERM;
                             }
	     	    			  scenario.repayments = $scope.calrepayIO(scenario.intrate,scenario.loanamt);
	     	    			 scenario.graphdata = $scope.calgraphdata(scenario.loanterm,scenario.intrate,scenario.loanamt,scenario.repayments);
	     	    		  }

	     	    		  
	     	    		  



	     	    		  //check edit
	     	    		  if($scope.editflag != null){
	     	    			  
	     	    			     	    			  
	     	    			  property.scenarios[$scope.editflag] = scenario;
	     	    			 
		     	    			property.data.splice($scope.editflag, 0, scenario.graphdata[0].data);
		     	    			property.series.splice($scope.editflag, 0, scenario.name);
		     	    		    $scope.clearscenario(property,scena);	
		     	    			
	     	    		  } 
	     	    		  else{
	     	    			  property.scenarios.push(scenario);
	     	    			  property.data.push(scenario.graphdata[0].data);
	     	    			  property.series.push(scenario.name);
                            
                              $scope.clearscenario(property,scena);

	     	    		  }


	     	    		  //update with selected currency
	     	    		 if(property.short_currlabel){
	     	    			 // console.log(property.short_currlabel);
	     	    			 $scope.updateValueAll($scope.from, $scope.to, [property], false);
	     	    			 }
	     	    		 
	     	    		 else{

//	     	    			console.log(scenario.graphdata[0].label.length,property.labels.length);
//	     	    			if(scenario.graphdata[0].label.length>property.labels.length){
//		     	    			 property.labels = scenario.graphdata[0].label;
//		     	    		
//	     	    			}
//	     	    			else{
//	     	    				if($scope.editflag != null){
//	     	    				property.labels.push(property.labels.length);
//	     	    			}}
	     	    		
	     	    			
	     	    			
	     	    			
	     	    			 var max = 0;
	     	 	    	  for(i=0;i<property.scenarios.length;i++){

	     	 	    		  if(property.scenarios[i].graphdata[0].label.length > max){

	     	 	    			  max = property.scenarios[i].graphdata[0].label.length;
	     	 	    			  var newindex = i;
	     	 	    		  }
	     	 	    	  }

	     	 	    	  if(property.scenarios.length>0){
	     	 	    	  property.labels = property.scenarios[newindex].graphdata[0].label;  
	     	 	    	  }
	     	    			
	     	    		    	
 	     	    		 }
	     	    		 
	     	    		 $scope.editflag = null;
	     	    		//console.log(property.labels);
	     	    		//console.log($scope.editflag);
	     	    		
	     	    		  $scope.scenariotowatch2 = scenario;


	     	    		
	     	    		  
	     	    		  //functions to show yello td when property is edited
	     	    		  if($scope.scenariotowatch2.name != $scope.scenariotowatch.name){
	     	    			  scenario.namechanged = true;
	     	    		  }else{scenario.namechanged = false;}

	     	    		  if($scope.scenariotowatch2.lvr != $scope.scenariotowatch.lvr){
	     	    			  scenario.lvrchanged = true;
	     	    		  }else{scenario.lvrchanged = false;}

	     	    		  if($scope.scenariotowatch2.cashamount != $scope.scenariotowatch.cashamount){
	     	    			  scenario.cashamountchanged = true;
	     	    		  }else{scenario.cashamountchanged = false;}

	     	    		  if($scope.scenariotowatch2.loantype != $scope.scenariotowatch.loantype){
	     	    			  scenario.loantypechanged = true;
	     	    		  }else{scenario.loantypechanged = false;}

	     	    		  if($scope.scenariotowatch2.intrate != $scope.scenariotowatch.intrate){
	     	    			  scenario.intratechanged = true;
	     	    		  }else{scenario.intratechanged = false;}

	     	    		  if($scope.scenariotowatch2.loanterm != $scope.scenariotowatch.loanterm){
	     	    			  scenario.loantermchanged = true;
	     	    		  }else{scenario.loantermchanged = false;}

	     	    		  if($scope.scenariotowatch2.repayments != $scope.scenariotowatch.repayments){
	     	    			  scenario.repaymentschanged = true;
	     	    		  }else{scenario.repaymentschanged = false;}

	     	    		  if($scope.scenariotowatch2.cost != $scope.scenariotowatch.cost){
	     	    			  scenario.costchanged = true;
	     	    		  }else{scenario.costchanged = false;}

	     	    		  if($scope.scenariotowatch2.estimate != $scope.scenariotowatch.estimate){
	     	    			  scenario.estimatechanged = true;
	     	    		  }else{scenario.estimatechanged = false;}

	     	    		  if($scope.scenariotowatch2.loanamt != $scope.scenariotowatch.loanamt){
	     	    			  scenario.loanamtchanged = true;
	     	    		  }else{scenario.loanamtchanged = false;}

	     	    		  //clear when done
	     	    		  
	     	    		  
	     	    		  
	     	    		 // 

	     	    	  }


	     	    	  //////////alerts


	     	    	  if($scope.status=='OK'){
	     	    		  $scope.alerts = [{ type: 'success', msg: 'Scenario added successfully' }];
	     	    	  }

	     	    	  else if($scope.status=='editOK'){
	     	    		  $scope.alerts = [{ type: 'success', msg: 'Scenario edited successfully' }];
	     	    	  }

	     	    	  else{
	     	    		  $scope.alerts = [{ type: 'danger', msg: 'Oops! please provide an unique and non-empty scenario name' }];
	     	    	  }


	     	    	  $timeout(function () {
	     	    		  $scope.alerts.splice(0, 1);
	     	    	  }, 3000);




	     	      }	
	      
	      
  
	      
	      
	      
	    //function for clear scenario  
	      $scope.clearscenario = function(property,scena,editflag){
	    	 
	    	 scena.name = undefined;
	 		 scena.lvr = undefined;
             scena.cashtype = '$';
	 		 scena.cashamount = undefined;
	 		 scena.loantype = 'IO';
	 		 scena.interestrate = undefined;
	 		 scena.loanterm = undefined;
		 		
		 	 scena.costper = undefined;
		 	 $scope.typeselected = 'IO';
		 	 
		 	 if(editflag != null){
		 		 
		 		 	property.data.splice(editflag, 0, $scope.cached_indexdata);
	    			property.series.splice(editflag, 0, $scope.cached_indexseries);
	    			
	    			$scope.cached_indexdata = null;
	    			$scope.cached_indexseries = null;
		 	 }
		 	 
		 	 
		 	 
	 	}
	      
	      //delete
	      $scope.deletescenario = function(prop,index){

	    	  if(index != 0 && index != 1){	
	    	  prop.data.splice(index, 1);
	    	  prop.series.splice(index, 1);
	    	  prop.scenarios.splice(index, 1); 


	    	  var max = 0;
	    	  for(i=0;i<prop.scenarios.length;i++){

	    		  if(prop.scenarios[i].graphdata[0].label.length > max){

	    			  max = prop.scenarios[i].graphdata[0].label.length;
	    			  var newindex = i;
	    		  }
	    	  }

	    	  if(prop.scenarios.length>0){
	    	  prop.labels = prop.scenarios[newindex].graphdata[0].label;  
	    	  }
	    	  }}
	      
	      
	      //edit
	      $scope.editflag= null;
	      $scope.editingname = null;
	      $scope.editscenario = function(scenario,prop,index){
	    	  
	    	  
	    	  $scope.editflag = index;
	    	  $scope.iscreate= false; 
	    	  $scope.isCollapsedflag = false;
	    	  $scope.editingname = scenario.name;
	    	  
	    	  
	    	//  console.log(scenario);
	    	     prop.scena.name = scenario.name;
		 		
		 		 
	    	     if(scenario.caseflag == 'three'){
	    	    	 prop.scena.cashamount = scenario.cashamount;
	    	    	 prop.scena.lvr = undefined;
	    	     }
	    	     else if(scenario.caseflag == 'two'){
	    	    	 prop.scena.cashamount = undefined;
	    	    	 prop.scena.lvr = scenario.lvr; 
	    	     }
	    	     else{
	    	    	 prop.scena.cashamount = undefined;
	    	    	 prop.scena.lvr = undefined; 

	    	     }
		 		 prop.scena.loantype = scenario.loantype;
		 		 prop.scena.interestrate = scenario.intrate;
		 		 prop.scena.loanterm = scenario.loanterm;
			 	

			 	 prop.scena.costper = scenario.cost;
			 	 $scope.typeselected = scenario.loantype;
			 	
			 	 $scope.cached_indexdata = prop.data[index];
			 	 $scope.cached_indexseries = prop.series[index];
			 	
			 	 prop.data.splice(index, 1);
		    	  prop.series.splice(index, 1);
	      } 
	      
	      //toggle form
	      $scope.toggle = function(){
	    	  
	    	  $scope.isCollapsedflag = !$scope.isCollapsedflag; 
	    	  
	      } 
	      
		  
}]);