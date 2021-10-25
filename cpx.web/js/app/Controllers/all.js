

app.controller('DetailsCtrl', ['$scope','$routeParams','$location','$rootScope','$window','$filter','PropertyService','ShortlistService','CommonShareService','$modal', '$log','$timeout','getRateInfo','numberFilter','$q','$anchorScroll',function ($scope, $routeParams, $location, $rootScope, $window, $filter, PropertyService, ShortlistService,CommonShareService,$modal, $log, $timeout,getRateInfo,numberFilter,$q,$anchorScroll ) {
	
	
	$rootScope.metakeywords = "graded,propell,details,observation,grade,beds,bath,car,size,rent,lease,cpx price,ipr,rental,review,free,estimate,report,contract,summary,independent,valuation,Depreciation,Population,capital,growth";
	
	//$scope.properties = PropertyService;
	$scope.id = $routeParams.id;
	
	PropertyService.success(function(data) { 
		
		$scope.properties = data.properties;	
		
	
	
	
	
	
	$scope.navigationState = 'tab-review';
	$rootScope.count = ShortlistService.getcount();
//	$scope.preid = 0;
	$scope.propertieslength = $scope.properties.length;
	var current_index = $filter('get-property-filter')($scope.properties, $scope.id);
	 	
	$scope.absurl = $location.absUrl();
	$scope.currentproperty = $scope.properties[current_index];
	$scope.countryflag = 'au';
    $scope.countrylabel = 'AUD';
   
    $scope.defaultPI_LOANTERM = 30;
	$scope.defaultIO_LOANTERM = 5;
	$scope.defaultPI_RATE = 4.29;
	$scope.defaultIO_RATE = 4.29;
	$scope.default_costvalue = 5;
	
	$scope.currentproperty.short_currlabel = undefined;
	$scope.currentproperty.short_convcpx = undefined;
	
	$scope.caseflag = 'one';
	
	//title tag for html 
	
	$scope.flagset="|";
	if($scope.currentproperty.smsf == true){
		
		$scope.flagset=$scope.flagset+" SMSF |";
	}
   if($scope.currentproperty.domacom == true){
		
		$scope.flagset=$scope.flagset+" DomaCom |";
	}
	
	$rootScope.title= $scope.currentproperty.name+" | "+$scope.currentproperty.beds+" Beds | "+$scope.currentproperty.category+" | "+$scope.currentproperty.address[0].street+" | "+$scope.currentproperty.address[0].suburb+" | "+$scope.currentproperty.address[0].state+" | "+$scope.currentproperty.address[0].postcode+" | Australia "+$scope.flagset+" CPx";
	
	
	
	
	
	
	
	//nextid
	
	if(current_index < $scope.propertieslength-1)
		{
	$scope.nextindex = current_index + 1;
		}
	else {
		$scope.nextindex = 0;
	}
	$scope.nextid = $scope.properties[$scope.nextindex].id; 
	
	//previous id
	
	if(current_index == 0 )
	{
   $scope.preindex = $scope.propertieslength -1;
	}
  else {
	$scope.preindex = current_index - 1;
     }
   $scope.preid = $scope.properties[$scope.preindex].id; 

	
   
 //default tab on details page
   
   if(!($scope.currentproperty.ipr && $scope.currentproperty.ipr.length>0)){
	   $scope.navigationState = 'tab-map';
	   $scope.refreshmap();
   }
   
   
   if($rootScope.scrolltoloan){
	   $scope.navigationState = 'tab-loan-cal';
	   $location.hash('loan-details');

		 $timeout(function() {
      	 $anchorScroll();     
     }, 2000);
   }
   
   /////////map
   
   
   $scope.currentimages = $scope.currentproperty.images;
   $scope.refreshslider();
   
	$scope.gradevalues = [1,2,3,4,5];
//	$rootScope.counts = [0,2,4,6,8,10,12,14,16,18,20];
	$scope.grades = ['AA','A','B','C','D'];
	$scope.map = { center: { latitude: $scope.currentproperty.coords.latitude, longitude: $scope.currentproperty.coords.longitude}, zoom: 16,
		    markersr: [
		               {
		                   id: 101,
		                   latitude:  $scope.currentproperty.coords.latitude,
		                   longitude: $scope.currentproperty.coords.longitude
		               }]
		               
		              
		     };
		  $scope.icon = "./images/CPX-pins_darkgreen.png" ;
	
   
		  
		// Create new array for type
			if($scope.currentproperty.support_info && $scope.currentproperty.support_info.length>0){
				$scope.linkuri = $scope.currentproperty.support_info;
				$scope.newtype=[];
				for(i=0;i<$scope.linkuri.length;i++){
					if($scope.linkuri[i].Uri.indexOf('pdf')>0){
						$scope.newtype[i] = 'pdf';
					}else if($scope.linkuri[i].Uri.indexOf('image')>0){
						$scope.newtype[i] = 'image';
					}
					else{
						$scope.newtype[i] = 'link';
					}
				}
			}
		  
		  
			//call to set base scenario
    	    $scope.setbasescenario($scope.currentproperty);   
		  
		  
		  
		  
		  
   
	});
   
   
   
 //map refresh
	  
	 $scope.refreshmap = function () { 
	  $scope.showMap = false;
    $timeout(function () {
      $scope.showMap = true;
    });
	 };
   
 //refresh slider  
   
	 $scope.refreshslider = function () { 
		  $scope.showslider = false;
	    $timeout(function () {
	      $scope.showslider = true;
	    });
		 };
   
   
   
   
   //function go(url)	 
	
   $scope.go = function (url) {
//	   alert(url); 
	   $window.open(url);
   };
	 
	 
	
	
		  
		  
		  
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
		  
		  $scope.items = [];
//		  $scope.items.push($scope.currentproperty);
//		  console.log($scope.items);
		  
		  $scope.open2 = function (size) {

			    var modalInstance = $modal.open({
			      templateUrl: 'mymailcontent.html',
			      controller: 'ModalmailCtrl',
			      size: size,
			      resolve: {
			        items: function () {
			          return $scope.currentproperty;
			        }
			      }
			    });

			    modalInstance.result.then(function (selectedItem) {
				      $scope.selected = selectedItem;
				    }, function () {
				      $log.info('Modal dismissed at: ' + new Date());
				    });
				  };
				  
//print link
				  $scope.passid = function (printid) {
					   
					  CommonShareService.passid(printid);
				   };
				  
//add to shortlist
				   
				    
				   
				   
				   
				   $scope.addtoshortlist = function (prop) {
					   
					   $scope.defaultcostpercent = 0.05;
					   
					    prop.costprice = prop.cpxprice * $scope.defaultcostpercent;

		    			prop.estimatedtotal = prop.cpxprice*1 + prop.costprice;

		    			prop.cashamt = 0;

		    			prop.cashpercent = 0;

		    			prop.loanamt = prop.estimatedtotal - prop.cashamt;
		    			
		    			prop.lvr = prop.loanamt / prop.cpxprice;

		    			prop.lvrdisplay = prop.lvr* 100;
					   
						 
						  $rootScope.count = ShortlistService.addProduct(prop);
					   	
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
				                    }, 3000);
				    }

				    $scope.closeAlert = function(index) {
				      $scope.alerts.splice(index, 1);
				    };
				    

				  //pass enquiry 	  
					  
					  $scope.passenquiry = function (printid) {
							
						$rootScope.shownothing = false;
						//  console.log(printid);
						  CommonShareService.passenquireid(printid);
					  };
					  
					  // Hide iframe
					  $scope.iframevisible = false;
					   $scope.hideiframe = function () {
						   $scope.iframevisible = true;   
						   };
					// show contract iframe
					   $scope.iframecontract = false;
					   $scope.showcontractiframe = function () {
						   $scope.iframecontract = true;   
						   };	
							
						   // show history iframe
						   $scope.iframehistory = false;
						   $scope.showhistoryiframe = function () {
							   $scope.iframehistory = true;   
							   };	
															
						   
						   
							
							$scope.activechange = function(openimg){
								$scope.iframevisible = false;
								$scope.imageSupport = openimg;
			
							}
							
					// function to change button color		
							$scope.checkclicked = function(title){
								
								$scope.currentclicked = title;
							}
							
							
	
							
			
			
			
			
			
	////////////
   	      $scope.maptype = "roadmap"; 
   	      $scope.setmap = function(type){
   	    	  
   	    	  $scope.maptype = type;
   	      }
				
   	     $scope.streetviewclosed = function(){
  	    	  
  	    	  $scope.maptype = "roadmap";
  	      }
		    
		    ////////////////currency filters
		  

			 $scope.countryflag = 'au';
			   $scope.countrylabel = 'AUD';
			    
			   $scope.dollarflag = true;
	     	      function getRate(currency) {
	     	        return currency && currency.rate;
	     	      }

	     	      // Grab the promises from the two calls  
	     	      var namesPromise = getRateInfo();
	     	      //var ratesPromise = getRateInfo('latest');

	     	      $scope.to = {};
	     	 //     $scope.currency2 = {};
	     	      $scope.from = {};
	     	      

	     	      // Use the $q.all method to run code only when both promises have been resolved
	     	      $q.all([namesPromise]).then(function(responses) {
	     	    	  
     	    	 
	     	    	  //      var currencyNames = responses[0];
	     	    	        var currencyRates = responses[0].quotes;
	     	    	        
	     	    	       // console.log(responses[0]);
	     	    	       

	     	    	        // Generate the currencies array
	     	    	        $scope.currencies = [];
	     	    	        
	     	    	       var currencyNames = CommonShareService.getcurrencyNames();
	     	    	        
	     	    	        var USDrate=currencyRates['USDUSD'];
	     	    	       var AUDrate=currencyRates['USDAUD'];
	     	    	       var multiplier=USDrate/AUDrate;
	     	    	     
	     	    	       
	     	    	       //console.log(USDrate,AUDrate,multiplier);	
	     	    	        angular.forEach(currencyNames, function(name, code) {
	     	    	         
	     	    	        	
	     	    	        	  	
	     	    	        	
	     	    	        var rate = currencyRates['USD'+code];
	     	    	          $scope.currencies.push({
	     	    	            code: code,
	     	    	            label : code +" "+ name + " (" + numberFilter(rate*multiplier, 3) + " / AUD)",
	     	    	            rate: rate*multiplier
	     	    	          });	    
	     	    	          
	     	    	          //console.log(rate*multiplier);
	     	    	        });
	     	    	        
	     	    	        
	     	    	         // set default currency as AUD
	     	    	        $scope.from.currency = $scope.currencies[7];
	     	    	        $scope.to.currency = $scope.currencies[7];
	     	     	
                      
	     	        
	     	        
	     	      });

	     	      
	     	      
	     	      $scope.updateValueAll = function(from, to, item, isTopconvertor) {
	     	    	  
	     	    	 //console.log(from, to); 	
	     	    	 $scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);
	 		    	 $scope.countrylabel = to.currency.code;
	     	    	
	 		  
	 		    		
			    		item.short_currlabel = to.currency.code;

			    		if(to.currency.code == "AUD"){item.short_currlabel = undefined;}  
	 		    		
			    		item.short_convcpx = item.cpxprice / getRate(from.currency) * getRate(to.currency);

			    		
			    		item.series = [];
			    		item.data = [];
			    		
			    		///for all scenarios
			    		angular.forEach(item.scenarios, function(scenaitem, key) {


			    			if(!(scenaitem.caseflag == 'three') || isTopconvertor){
			    				
			    				scenaitem.conv_costprice = scenaitem.costprice / getRate(from.currency) * getRate(to.currency);

			    				scenaitem.conv_estimate = scenaitem.estimate / getRate(from.currency) * getRate(to.currency);

			    				scenaitem.conv_loanamt = scenaitem.loanamt / getRate(from.currency) * getRate(to.currency);

			    				
			    				scenaitem.conv_cashamount = scenaitem.cashamount / getRate(from.currency) * getRate(to.currency);

			    			}
			    			//repayments calculations based on interest type// cal graph data
			    			if(scenaitem.loantype == 'PI'){

			    				if(scenaitem.intrate == undefined || scenaitem.intrate == ""){

			    					scenaitem.intrate = 0; 
			    				} 

			    				scenaitem.conv_repayments = $scope.calrepayPI(scenaitem.loanterm,scenaitem.intrate,scenaitem.conv_loanamt);

			    				scenaitem.graphdata = $scope.calgraphdata(scenaitem.loanterm,scenaitem.intrate,scenaitem.conv_loanamt,scenaitem.conv_repayments);
			    			}else{
			    				scenaitem.conv_repayments = $scope.calrepayIO(scenaitem.intrate,scenaitem.conv_loanamt);
			    				scenaitem.graphdata = $scope.calgraphdata($scope.defaultIO_LOANTERM,scenaitem.intrate,scenaitem.conv_loanamt,scenaitem.conv_repayments);
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
			    		
			    		
	
			    
	     	      
	     	      };   

			
			
		////////////loan-view
     	     
     	     
     	     
     	     
 	     	//////loan view table data
    	      

    	      $scope.isCollapsedflag = false;   

    	      $scope.setiscreate = function(){

    	    	  $scope.iscreate= true;
    	    	 $scope.editflag=null;
    	    	$scope.editingname=null;
    	      }

    	      $scope.typeselected = 'IO'; 

    	      $scope.isIOselected = function(value){

    	    	  $scope.typeselected = value;

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
     	     
     	    $scope.toggle = function(){	  
  	    	  $scope.isCollapsedflag = !$scope.isCollapsedflag; 
  	    	  } 
				
     	 //setting base scenario for all properties 
   	      
    	     $scope.setbasescenario = function(prop){
    	      

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
    	    	  Base.name = 'Base IO';

    	    	  Base.loantype = 'IO';

    	    	  Base.intrate = $scope.defaultIO_RATE;
    	    	  Base.loanterm = $scope.defaultIO_LOANTERM;
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

    	    	 
    	    	 ////base for PI
    	    	  
    	    	 var Base_PI = {}; 
    	    	  Base_PI.name = 'Base PI';

    	    	  Base_PI.loantype = 'PI';

    	    	  Base_PI.intrate = $scope.defaultPI_RATE;
    	    	  Base_PI.loanterm = $scope.defaultPI_LOANTERM;
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
    	      
    	     
    	     
			
    	    
    	    
    	    
    	//////add new scenario

   	      $scope.submitscenario = function(property,scena){

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
   	    			scenario.loanterm = $scope.defaultIO_LOANTERM;
   	    			  scenario.repayments = $scope.calrepayIO(scenario.intrate,scenario.loanamt);
   	    			 scenario.graphdata = $scope.calgraphdata($scope.defaultIO_LOANTERM,scenario.intrate,scenario.loanamt,scenario.repayments);
   	    		  }

   	    		  
   	    		  



   	    		  //check edit
   	    		  if($scope.editflag != null){
   	    			  
   	    			     	    			  
   	    			  property.scenarios[$scope.editflag] = scenario;
   	    			 
	     	    			property.data.splice($scope.editflag, 0, scenario.graphdata[0].data);
	     	    			property.series.splice($scope.editflag, 0, scenario.name);
	     	    			
	     	    			
   	    		  } 
   	    		  else{
   	    			  property.scenarios.push(scenario);
   	    			 property.data.push(scenario.graphdata[0].data);
   	    			property.series.push(scenario.name);

   	    		  }


   	    		  //update with selected currency
   	    		 if(property.short_currlabel){
   	    			 // console.log(property.short_currlabel);
   	    			 $scope.updateValueAll($scope.from, $scope.to, property, false);
   	    			 }
   	    		 
   	    		 else{

//   	    			console.log(scenario.graphdata[0].label.length,property.labels.length);
//   	    			if(scenario.graphdata[0].label.length>property.labels.length){
//	     	    			 property.labels = scenario.graphdata[0].label;
//	     	    		
//   	    			}
//   	    			else{
//   	    				if($scope.editflag != null){
//   	    				property.labels.push(property.labels.length);
//   	    			}}
   	    		
   	    			
   	    			
   	    			
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
   	    		  
   	    		  
   	    		  
   	    		  $scope.clearscenario(property,scena);

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
	      }
	      
	      
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
    	    
    	    
    	    
    	    
    	    
    	    
				    

}]);app.controller('HomePageCtrl', ['$scope','$rootScope','$window','PropertyService', function ($scope,$rootScope, $window, PropertyService) {
	
	
	

$scope.isviewgradedpage = false;		
$rootScope.metakeywords = "CPx,Real estate,Buy property,Sell property,Investment property,Property Sydney,No agent,Advertise property,Graded properties,Real estate advertising,Property Melbourne,No agent fees,Real estate sales,Buy real estate,Independently reviewed and graded properties,Independent real estate sales,Central Property Exchange";
$rootScope.title= "Central Property Exchange | Independent Real Estate Sales| Home Page";
$rootScope.description="Central Property Exchange | Independent Real Estate Sales  |  Residential and Investment Properties  | A Fresh Approach to Buying Property";

	

	
	PropertyService.success(function(data) { 
		
		$scope.properties = data.properties;	
	});
	
	
	$scope.go = function (url) {
	      $window.open(url);
	};
	
	
	function checkClickedview() {
		
	     $scope.$emit('viewEvent');
   	
	}
	
	$scope.sortdate = function(itemP) {
	    var date = new Date(itemP.date_created);
	    return date;
	};
	
	 $scope.myInterval = 4000;
	 
	 $scope.slides = [

	                  {
	                	  	text: 'Get free, instant access to independently reviewedand graded properties '
					  },
	                  {
						  	text: 'Know the outcome before you buy'
	                  },
	                  {
	                	  	text: 'Know the outcome before you sell'
	                  },
	                  {
	                	  	text: 'Know the outcome first '
	                  },
	                  {
	                	  	text: 'Know the opportunity before buy or sell'
	                  },
	                  {
		                    text: 'Independently reviewed and graded properties '
		              },
		              {
		                    text: 'Connecting property buyers with sellers  '
		              },
		              {
		                    text: 'Minimising risk for property buyers '
		              },
		              {
		                    text: 'No negotiating necessary '
		              },
		              {
		                    text: 'CPx is the ideal property platform for the financial services industry '
		              },
		              {
		                    text: 'Fee-for-Service '
		              },
		              {
		                    text: 'Buyers and Sellers save money'
		              },
		              {
		                    text: 'A fresh approach to buying property '
		              },
		              {
		                    text: 'CPx is all about independent real estate sales'
		              },
		              {
		                    text: 'CPx is a real estate advertising platform with a difference '
		              },
		              {
		                    text: 'CPx delivers services from the property buyer perspective '
		              },
		              {
		                    text: 'It is an Australian first'
		              },
		              {
		                    text: 'NO listing-agent selling-fees'
		              },
		              {
		                    text: 'Buyers can save $6,000 to $30,000 off the selling price '
		              },
		              
	                ];
	
	
	
}]);
app.controller('PropertiesCtrl', ['$scope','$rootScope','$filter','$timeout','$location','$window','PropertyService','ShortlistService','CommonShareService','$modal', '$log','$routeParams','uiGmapGoogleMapApi','uiGmapIsReady','getRateInfo','numberFilter','$q', function ($scope,$rootScope,$filter,$timeout,$location, $window, PropertyService, ShortlistService,CommonShareService, $modal, $log,$routeParams,uiGmapGoogleMapApi,uiGmapIsReady,getRateInfo,numberFilter,$q) {
	
	
	
	
	if($location.absUrl().indexOf("view-graded-properties") >= 0){
		
	$scope.isviewgradedpage = true;	
	$rootScope.metakeywords = "property,properties,price,cpx,beds,type,ipr,smsf,deposit,sold,domacom,grade,grid,map,all,graded";
	
	$rootScope.title= "Real Estate | Properties | Homes For Sale | Apartments For Sale | Old Homes | New Developments | Graded Properties | Independent Properties | Independently Reviewed | No Selling Fees  | CPx";
	
	$rootScope.description="A FRESH APPROACH TO BUYING PROPERTY, Get free, instant access to independently reviewed and graded properties";
	}
	else
	{}
	
	
	
	$scope.searchcriteria=[];
	$scope.loancriteria=[];
	
	
	//$scope.allproperties = PropertyService.properties;
	
	$scope.allproperties = [];
	PropertyService.success(function(data) { 
		$scope.allproperties = data.properties;
	    
	    
	    $scope.properties = [];
	    angular.copy($scope.allproperties, $scope.properties);
		$rootScope.shownothing = true;
		
		$scope.isStandardOpen=true;
		$scope.isLoanOpen=false;
		$scope.isInvestmentOpen=false;
		
		$scope.defaultLOANTERM = 30;
		$scope.defaultPI_RATE = 4.29;
		$scope.defaultIO_RATE = 4.29;
		$scope.default_costvalue = 5;
		
		
		$scope.groups=[{id:0,isopen:true},{id:1,isopen:false},{id:2,isopen:false}];
		
		
		$scope.animatebtn = false;
		
		$scope.viewid = 'grid';
		
		 $scope.markers = $scope.properties;
		
		//propertyview function
		 
		 var dummyobject = {grade: "", type: "Any", minbeds: "Any", maxbeds: "Any"};
			$scope.update(dummyobject);
			
			$scope.options = [
			                  
			                  { label: 'Filter by grade: Any', value: '' },
			                  { label: 'Filter by grade: AA - a score equal or above 275', value: 'AA' },
			                  { label: 'Filter by grade: A - a score equal or above 215', value: 'A' },
			                  { label: 'Filter by grade: B - a score equal or above 155', value: 'B' },
			                  { label: 'Filter by grade: C - a score equal or above 95', value: 'C' },
			                  { label: 'Filter by grade: D - a score less than 95', value: 'D' }
			                ];
			
			$scope.searchcriteria.grade = $scope.options[0].value;
			///////////////
			 $scope.MapOptions = {
				        minZoom: 3,
				        zoomControl: false,
				        draggable: true,
				        navigationControl: false,
				        mapTypeControl: false,
				        scaleControl: false,
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
			
			
			
			
			 $rootScope.scrolltoloan = false;
			 $scope.loanupdate($scope.loancriteria,'default');
	});
	
	
	
	
	
	$scope.propertyview = function (value) {
	    
		$scope.viewid = value;
	};
	
	
	
	
	//update function
	$scope.update = function (propobject) {
		
		
		 
		$scope.animatebtn = false;
		
      	if(propobject.minprice != undefined && propobject.minprice != "Any"){
      		propobject.conv_minprice = propobject.minprice/$scope.to.currency.rate;
      
      	}
    //  	console.log($scope.to.currency);
      	
      	if(propobject.maxprice != undefined && propobject.maxprice != "Any"){
      		propobject.conv_maxprice = propobject.maxprice/$scope.to.currency.rate;
      	}
      	
		console.log(propobject);
 
      	
     
     
		var current_items = $filter('get-search-filter')($scope.allproperties, propobject);
	
		  
	        
		  $scope.properties = current_items;
		  
		  $scope.markers = $scope.properties;
		  
		  for(i=0;i<$scope.markers.length;i++){
			
			  $scope.markers[i].icon = "./images/CPX-pin_RED.png"
			  if(i<3){
			  $scope.markers[i].icon = "./images/CPX-pins_darkgreen.png"  
			  }
			  if(i>2 && i<13){
				  $scope.markers[i].icon = "./images/CPX-pin_BLUE.png"  
			  }			  
			  }
		  
		  
		  
	};
	
	
	
	
    //reset function
    $scope.reset = function (propobject,sortobject,loanobject) {
		
		$scope.properties = $scope.allproperties;
		$scope.markers = $scope.allproperties;
		
		for(i=0;i<$scope.markers.length;i++){
			
			$scope.markers[i].icon = "./images/CPX-pin_RED.png"
			 
				if(i<3){
			  $scope.markers[i].icon = "./images/CPX-pins_darkgreen.png"  
			  }
			  if(i>2 && i<13){
				  $scope.markers[i].icon = "./images/CPX-pin_BLUE.png"  
			  }
			}
		
		$scope.animatebtn = false;
		propobject.minprice = undefined;
		propobject.maxprice = undefined;
		propobject.minbeds = 'Any';
		propobject.maxbeds = 'Any';
		propobject.type = 'Any';
		sortobject.option = '1';
		propobject.left = undefined;
		propobject.domacom = undefined;
		propobject.latest = undefined;
		propobject.sold = undefined;
		propobject.gradelabel = 'Filter by grade: Any';
		propobject.grade = '';
		propobject.searchtext =undefined;
		propobject.searchid =undefined;
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
		

		
	};	
	
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
		
		 $scope.markers = $scope.properties;
		  
		  for(i=0;i<$scope.markers.length;i++){
			
			  $scope.markers[i].icon = "./images/CPX-pin_RED.png"
			  if(i<3){
			  $scope.markers[i].icon = "./images/CPX-pins_darkgreen.png"  
			  }
			  if(i>2 && i<13){
				  $scope.markers[i].icon = "./images/CPX-pin_BLUE.png"  
			  }			  
			  }
	 
	 };	
	
	
	//grades filter
		
		
		
		
		
		//animate
		
		$scope.animate = function (value) {
		    
		
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
		  
		  
		  
		  
	
		  //add to shortlist functions
		  $rootScope.count = ShortlistService.getcount();
		  
		  $scope.addtoshortlist = function (prop) {
		 
			//  console.log(prop);
			  
			  $rootScope.count = ShortlistService.addProduct(prop);
		   	//	console.log($rootScope.count);
		};	  
		  
		
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
 // map view
		  
		  
		 
		  
		 
		 

		   

		    $scope.onClick = function (data) {
		        $scope.windowOptions.show = !$scope.windowOptions.show;
		   //     console.log('$scope.windowOptions.show: ', $scope.windowOptions.show);
		    //    console.log('This is a ' + data);
		        $scope.windowOptions.templateParameter = data;
		        $scope.temp = 0;
		        //alert('This is a ' + data);
		    };

		    $scope.closeClick = function () {
		        $scope.windowOptions.show = false;
		    };

		  //  $scope.title = "Window Title!";

		   

		                      
		                       
		   	
		   
	//	    $scope.markers = $scope.properties;
		   
		    
		    $scope.addMarkerClickFunction = function (markersArray) {
		    	
		    	
		        angular.forEach(markersArray, function (value, key) {
		            value.onClick = function () {
		            //	console.log(value);
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
		                    }, 3000000);
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
		    //var ratesPromise = getRateInfo('latest');

		    $scope.to = {};
		    //     $scope.currency2 = {};
		    $scope.from = {};

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
		    	$scope.to.currency = $scope.currencies[7];
		    });

		    
		    //function for all properties
		    $scope.countryflag = 'au';
		    $scope.countrylabel = 'AUD';
		    $scope.updateValueAll = function(from, to, items) {


		    	$scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);

		    	$scope.countrylabel = to.currency.code;

		    	angular.forEach(items, function(item, key) {


		    		item.currencylabel = to.currency.code;
		    		//	console.log(item.currencylabel);

		    		if(to.currency.code == "AUD"){item.currencylabel = undefined;}  
		    		from.value = item.cpxprice;

		    		item.convertedcpx = item.cpxprice / getRate(from.currency) * getRate(to.currency);

		    		item.conv_costprice = item.costprice / getRate(from.currency) * getRate(to.currency);

		    		item.conv_estimatedtotal = item.estimatedtotal / getRate(from.currency) * getRate(to.currency);
		    		
		    		

		    		

		    		if($scope.case3flag){

		    			if($scope.percentflag){ 
		    				item.conv_cashamt = (item.convertedcpx*$scope.cashentered)/100;
		    			}else{
		    				item.conv_cashamt = $scope.cashentered;
		    			}
		    			item.conv_loanamt = item.conv_estimatedtotal - item.conv_cashamt;
		    			
		    			//console.log(item.conv_loanamt);
		    			
		    			item.conv_PIrepayments = $scope.calrepayPI($scope.defaultLOANTERM,$scope.defaultPI_RATE,item.conv_loanamt);
	   	    			 
		    			item.conv_IOrepayments = $scope.calrepayIO($scope.defaultIO_RATE,item.conv_loanamt);

		    		}else{

		    			item.conv_loanamt = item.loanamt / getRate(from.currency) * getRate(to.currency);

		    			item.conv_cashamt = item.cashamt / getRate(from.currency) * getRate(to.currency); 
		    			
		    			//item.conv_IOrepayments = item.IOrepayments / getRate(from.currency) * getRate(to.currency);

			    		//item.conv_PIrepayments = item.PIrepayments / getRate(from.currency) * getRate(to.currency);
			    		
		    			item.conv_PIrepayments = $scope.calrepayPI($scope.defaultLOANTERM,$scope.defaultPI_RATE,item.conv_loanamt);
	   	    			 
		    			item.conv_IOrepayments = $scope.calrepayIO($scope.defaultIO_RATE,item.conv_loanamt);
			    		
		    		}
		    	});
		    };


		    //function for individual property
		    $scope.dollarflag = false; 
		    $scope.updateValue = function(from, to, item) {

		    	item.currencylabel = to.currency.code;
		    	if(to.currency.code == "AUD"){item.currencylabel = undefined;}  
		    	//from.value = item.cpxprice;
		    	item.convertedcpx = item.cpxprice / getRate(from.currency) * getRate(to.currency);
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
		    
		    

			
		    $scope.loanupdate = function (value,defaultflag) {

		    	

		    	if(value.inputcost == undefined || value.inputcost == '' || value.inputcost == null || isNaN(value.inputcost) === true){

		    		$scope.defaultcostpercent = $scope.default_costvalue / 100;
		    	}else{
		    		
		    		$scope.defaultcostpercent = value.inputcost / 100;
		    	}
		    	
		    	angular.forEach($scope.allproperties, function(prop, code) {

		    		
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
		    				{var x = value.loancash;
		    				$scope.percentflag = false;
		    				$scope.cashentered = value.loancash;}




		    				prop.lvr = (prop.conv_estimatedtotal - x) / prop.convertedcpx;

		    				prop.lvrdisplay = prop.lvr * 100;



		    				prop.conv_cashamt =x;

		    				prop.cashamt =x;

		    				prop.cashpercent = (100 + 100*$scope.defaultcostpercent) - prop.lvrdisplay*1;

		    				prop.conv_loanamt = prop.conv_estimatedtotal - prop.conv_cashamt;

		    				prop.loanamt = prop.conv_loanamt;
		    				
		    				
		    				
		    				
		    				prop.conv_PIrepayments = $scope.calrepayPI($scope.defaultLOANTERM,$scope.defaultPI_RATE,prop.conv_loanamt);
		   	    			 
			    			prop.conv_IOrepayments = $scope.calrepayIO($scope.defaultIO_RATE,prop.conv_loanamt);




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

		    	
		    		
		    		//repayments calculations based on interest type// cal graph data		
   	    			
		    		prop.PIrepayments = $scope.calrepayPI($scope.defaultLOANTERM,$scope.defaultPI_RATE,prop.loanamt);
  	    			 
   	    			prop.IOrepayments = $scope.calrepayIO($scope.defaultIO_RATE,prop.loanamt);

   	    			
   	    			   	    			
			    	});



		    };

		   
		   
			
			 
			
				/////////gotoloan-tab
			
			 $scope.gotoloantab = function () {

				 
				 $rootScope.scrolltoloan = true;
				  }; 
			
			
		   

}]);app.controller('ModalInstanceCtrl', function ($scope, $modalInstance, items) {

	  $scope.items = items;
//	  console.log($scope.items);
//	  $scope.selected = {
//	    item: $scope.items[0]
//	  };
//
//	  $scope.ok = function () {
//	    $modalInstance.close($scope.selected.item);
//	  };

	  $scope.cancel = function () {
	    $modalInstance.dismiss('cancel');
	  };
	});app.controller('ModalmailCtrl', ['$scope', 'items', '$location', 'ShareMailService', '$rootScope', '$modalInstance', function ($scope, items, $location, ShareMailService, $rootScope, $modalInstance) {
	
//	console.log(items);
	
	 $scope.absurl = "http://centralpropertyexchange.com.au/#!/details/"+items.id;
	  
    var area = items.address[0].StreetNumber+" "+items.address[0].street+", "+items.address[0].suburb+", "+items.address[0].city+" "+items.address[0].state+" "+items.address[0].postcode;
	  
	  $scope.subject = "Sharing property link with you;"+" "+items.name+" "+area;
	  
	  $scope.txtmsg = "Hello,\n"+"I found this property on CPx.\n\nPlease have a look/ review"+" "+items.name+", "+items.type+"\n"+area+"\n"+$scope.absurl+"\n\nRegards";
	  
	  
//	  console.log($scope.txtmsg);
	 
//	  console.log($scope.sharemail);
	
	  $scope.ok = function () {
	        $modalInstance.close();
	      };
	
	
	
	$rootScope.loading=false;
	
	 $scope.sendEmail=function(){
		 $rootScope.loading = true;
		 ShareMailService.create($scope.sharemail).$promise.then(function(msg) {
	        $scope.msg = msg.toJSON();
//	        console.log($scope.msg);
//	        console.log($scope.msg.status);
	        $rootScope.loading = false;
	        if($scope.msg.status=='OK'){
			        $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
	        }else{
	        	$scope.alerts = [
	        	                 { type: 'danger', msg: 'Oops! something went wrong please try again.' },
			   	                ];
	        }
	        $scope.contact = null;
            $scope.closeAlert = function(index) {
              $scope.alerts.splice(index, 1);
            };
	     });
	       
		 $scope.ok();
		 
	    };
	    
	    
	    
	    
	    
	    $scope.cancel = function () {
		    $modalInstance.dismiss('cancel');
		  };
	}]);
app.controller('FaqmailCtrl', ['$scope', 'items', '$location', '$routeParams', 'ShareMailService', '$rootScope', '$modalInstance', function ($scope, items, $location, $routeParams, ShareMailService, $rootScope, $modalInstance) {
	
	//console.log(items);
	
	 $scope.absurl = "http://centralpropertyexchange.com.au/#!/blog/"+items;
	  
     
	  
	  
	  $scope.subject = "BLOG / "+$routeParams.pid.replace("_", " "); 
	  
	  $scope.txtmsg = "Hello,"+"\n\nPlease have a look/ review"+"\n"+$scope.absurl+"\n\nRegards";
	  
	  
//	  console.log($scope.txtmsg);
	 
//	  console.log($scope.sharemail);
	
	  $scope.ok = function () {
	        $modalInstance.close();
	      };
	
	
	
	$rootScope.loading=false;
	
	 $scope.sendEmail=function(){
		 $rootScope.loading = true;
		 ShareMailService.create($scope.sharemail).$promise.then(function(msg) {
	        $scope.msg = msg.toJSON();
//	        console.log($scope.msg);
//	        console.log($scope.msg.status);
	        $rootScope.loading = false;
	        if($scope.msg.status=='OK'){
			        $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
	        }else{
	        	$scope.alerts = [
	        	                 { type: 'danger', msg: 'Oops! something went wrong please try again.' },
			   	                ];
	        }
	        $scope.contact = null;
            $scope.closeAlert = function(index) {
              $scope.alerts.splice(index, 1);
            };
	     });
	       
		 $scope.ok();
		 
	    };
	    
	    
	    
	    
	    
	    $scope.cancel = function () {
		    $modalInstance.dismiss('cancel');
		  };
	}]);app.controller('AboutCtrl', ['$scope','$rootScope','$routeParams','$location', '$anchorScroll','$window','$modal','$log','$timeout','CommonShareService', function ($scope,$rootScope,$routeParams,$location, $anchorScroll,$window,$modal,$log,$timeout,CommonShareService) {
	
	
	$rootScope.shownothing = true;
	$scope.pid = $routeParams.pid;
	$scope.subid = $routeParams.subid;
	
	
	$scope.keywordset = [{pid: 'what-is-cpx', keywords: 'What is CPx,CPx,Real estate,Real estate agents,Real estate sales,Real estate services,Real estate advertising,Cost savings,Property buying,Real estate websites,Purchase a property,Central Property Exchange,Independent representation,Property seller and buyer,No real estate agent selling fees,Independent property review,Listing properties ready for sale,Independent real estate sales,Fair and independent representation',
		description:"Central Property Exchange � Independent Real Estate Advertising  � Cost Savings for Property Sellers and Buyers � New Market for Real Estate Agents, Buyers, Advisors, Property Developers, Builders.",title:"Central Property Exchange | Real Estate Advertising | What is CPx"},

		{pid: 'independent-process', keywords: 'CPx,Real estate,Property seller,Real estate sales,Sellers and buyers,Central Property Exchange,Do it yourself,Industry professional,Real estate agents,Independent process,Alternative process,Independently represented,Properties across Australia,Independent property review,Significant cost savings,Independent real estate sales,The financial services industry,A fresh approach to buying property',
			description:"Central Property Exchange � Independent Process for Real Estate Sales � Buy and Sell Residential and Investment Properties � A Fresh Approach To Buying Property.",title:"Central Property Exchange | Buy & Sell Real Estate| Independent Process"},

			{pid: 'independent-property-review', keywords: 'CPx,IPR,Property review,Australian property,Central Property Exchange,Property specific,IPR report,Listed price,Property attributes,Independent commentary,Real estate properties,Construction completion date,Independent property review,Properties available for sale,Historical property and area data',
				description:"Central Property Exchange � Property Specific Reports - Buy and Sell Residential and Investment Properties � Independent Commentary on Properties Available for Sale.",title:"Central Property Exchange | Real Estate| Independent Property Review"},


				{pid: 'what-is-graded', keywords: 'CPx,Graded,Price risk,Real estate,New concept,National valuers,Save money,Property score,Property grade,Individualised service,Comparing properties,Property demographics,Historical growth rate,Propell National Valuers,The world of real estate,General property search,Property across Australia,Offers buyers several benefits',
					description:"Central Property Exchange � Scored And Graded Individual Property Reports - Buy And Sell Residential And Investment Properties � A Smart New Concept In The World Of Real Estate.",title:"Central Property Exchange | Real Estate Report| What is graded"},	 

					{pid: 'find-industry-professionals', keywords: 'CPx,Sellers,Buyers,Service,Agreements,Recommendations,Benefit,Fixed fee,CPx governance,Customer loyalty,Industry professionals,Central Property Exchange,Indicative service fees,Significant cost savings ,Property seller and buyer,Percentage of the sale price,Independent representation,Finding an industry professional',
						description:'Central Property Exchange � Find Industry Professionals � CPx Allows The Property Seller And Buyer To Appoint Their Personal Industry Professional.',title:'Central Property Exchange | Find Industry Professionals | Appoint your own Professional'},
					{pid: 'view-directory', keywords: 'directory,view,list'},

					{pid: 'press-releases', keywords: 'CPx,Blog,New property,Property price,Buyer�s agent,Press Releases,Villa World,Domacom,No middle man ,Financial services,Property investing,Central property exchange,Buy and sell property,Buy property through CPx,Save thousands of dollars ,List your property with CPx,Fractional property investing,Residential builders and developers,The future of real estate buying and selling',
						description:'Central Property Exchange � Blog � Press Releases � Buy and sell property without a middle-man.',title:'Central Property Exchange | Real Estate| Press Releases'},


						{pid: 'Publications', keywords: 'CPx,Blog,SMSF,Real Estate,Publications,Buy property,Independent Process,Confidis,DomaCom,Villa World,Save thousands,Finance professionals,Advertising properties,Central property exchange,Cut out the middle-man,Self managed super fund,Buy property through CPx,Fractional property investing,List your properties with CPx,Buy and sell property for less,Finance professionals benefit',	                    
							description:"Central Property Exchange � Blog � Publications � Buy and sell property for less with CPx.",title:'Central Property Exchange | Real Estate| Publications'},


							{pid: 'cpx-announcements', keywords: 'CPx,Real Estate,Developers,Announcements,Private Vendors,Save thousands,Property for sale,Mortgage Brokers,Financial Planners,Real estate agents,Graded properties,Central property exchange,Property Developers,New Real Estate service,No real estate agent fees,Deal directly with the vendor,Independent online real estate,Advertise your property for sale',
								description:'Central Property Exchange � Blog � CPx announcements � List your property with CPx and save thousands.',title:'Central Property Exchange | Real Estate| Announcements'},

								{pid: 'blogindex', keywords: 'blog,subscribe,faq,cpx,announcement,press,release,publications',
									description:'Central Property Exchange � Blog � CPx announcements � FAQ - Press Releases - Publications.',title:'Central Property Exchange | Real Estate| Blog'},

								{pid: 'FAQs', keywords: 'CPx,FAQ,Confidis,DomaCom,Real Estate,Commission,Vendor direct,Property seller,Advertise on CPx,Property Developer,Currency conversions,Real estate advertising,Central property exchange,Sell my properties,Questions and Answers,Attract property buyers,Vendor direct advertising,Best price for my property,Major real estate advertising websites,Property is already listed with an agent',
									description:'Central Property Exchange � Blog � FAQ � Questions and answers on common queries when using CPx.',title:'Central Property Exchange | Real Estate| FAQ'},

									{pid: 'working-with-cpx', keywords: 'CPx,Fees,Buyers,Real Estate,Membership,Accountants,Full Disclosure,Free membership,Financial Planners,Mortgage Brokers,Industry Professionals,Central property exchange,No referral fees,Real Estate Agents,No transaction fees,Fixed fee-for-service,Receive free referrals,Property sellers and buyers',
										description:'Central Property Exchange � Industry Professionals � Working With CPx � This Page Is For Industry Professionals Wanting To Know More About Working With CPx.',title:'Central Property Exchange | Industry Professionals | Working with CPx'},


										{pid: 'list-property', keywords: 'CPx,List,Vendors,Advertise,Properties,Developers,Selling fees,Real estate,Selling property,Financial Services,Significant savings,Central property exchange,Real Estate agents,Apples with apples,List your property on CPx,Listing a property for sale,Independent Property Review,Dealing directly with the vendor,No real estate agent selling fees',
											description:'Central Property Exchange � Properties � List Your Property On Cpx � Let�s Start With A Pressing Question.  Why List Or Advertise With CPx?',title:'Central Property Exchange | Properties | List your Property on CPx'}

										];

	
	
	//FAQ's page
	$scope.status =[{url:'how-cpx-traffic-compare',value:false,id:'one',keywords: 'CPx,FAQ,Hits,Buyer,Properties,Advertising,Millions,Page views,Find a buyer,Website Traffic,Advertising fees,Central Property Exchange,Millions of hits,Properties for clients,Major real estate sites,Financial services industry,Real estate website traffic,Independent listing process,Short list suitable properties',
		description:'Central Property Exchange � FAQ � Website Traffic � How Does CPx Website Traffic Compare To Major Sites',title:'Central Property Exchange | FAQ| Website Traffic'},


		{url:'how-cpx-attract-property-buyers',value:false,id:'two',keywords: 'CPx,FAQ,Online,Buyers ,Properties,Marketing,Sales team,Attract buyers,Marketing plan,Business network,Financial services,Central Property Exchange,Significant savings,Marketing to buyers,Industry professionals,Properties ready for sale,Property seller and buyer,Independent property review',
			description:'Central Property Exchange � FAQ � CPx Marketing � How Does CPx Attract Property Buyers',title:'Central Property Exchange | FAQ| CPx Marketing'},


			{url:'advertise-with-cpx',value:false,id:'three',keywords: 'CPx,FAQ,Agency,Property,Advertising,Marketplace,Selling-fee,Open agency,Non-exclusive,Already Listed,Exclusive agency,Central Property Exchange,Procure a buyer,Multiple mediums,Real estate agents,Property is already listed,Project Marketing Company,Exclusive agency agreement',
				description:'Central Property Exchange � FAQ � Already Listed � My Property Is Already Listed With An Agent Or Project Marketing Company',title:'Central Property Exchange | FAQ| Already Listed'},


				{url:'real-estate-licence',value:false,id:'four',keywords: 'CPx,FAQ,Listing,License,Property,Advertise,Real estate,License to list ,Listing process,Governance section,Independent process,Central Property Exchange,Anyone can list,Advertise on CPx,List your property,Real estate license,For more information,Governance listing process',
					description:'Central Property Exchange � FAQ � No License to List � Must I Have A Real Estate License To List Advertise On CPx',title:'Central Property Exchange | FAQ| No License to List'},


					{url:'cpx-vs-direct-vendor',value:false,id:'five',keywords: 'CPx,FAQ,Agent,Vendor,Compare,Advertising,Real estate,Listed price,Vendor agent,Property advertising,Compare CPx,Central Property Exchange,List client properties,Independent process,Propell National Valuers,Real estate agent selling-fee,Independent property review,Vendor direct advertising sites',
						description:'Central Property Exchange � FAQ � Vendor Advertising � How does CPx compare to vendor direct advertising sites',title:'Central Property Exchange | FAQ| Vendor Advertising'},


						{url:'less-properties',value:false,id:'six',keywords: 'CPx,FAQ,Buyer,Listed,Australia,Properties,Secondary keywords,Real estate,New listings,Listed properties,Rental estimates,Properties Australia,Central Property Exchange,Long tail keywords,Real estate sites,Contract-of-sale,Properties for purchase,Propell National Valuers,Properties listed on CPx,Independent property review,No real estate agent selling fee',
							description:'Central Property Exchange � FAQ � Properties Listed � Why Are There Are Small Number Of Properties Listed On CPx?',title:'Central Property Exchange | FAQ| Properties Listed'},


							{url:'property-developer-network',value:false,id:'seven',keywords: 'CPx,Sell,FAQ ,Buyer,Property,Network,Commissions,Advertising,Sell properties,Selling strategy,Network to sell,Property Developer,Central Property Exchange,Listed for sale,Procure a buyer,Value for money,Property sale price,Sell your properties,Savings to the buyer,Network to sell my properties',
								description:'Central Property Exchange � FAQ � Property Network � I Am A Property Developer Who Uses A Network To Sell My Properties.  Will My Network Be Compromised If The Same Property Is Also Listed For Sale On CPx?',title:'Central Property Exchange | FAQ| Property Network'},


								{url:'commission-listing-fees',value:false,id:'eight',keywords: 'CPx,FAQ,Fees,Buyer,Service,Property,Commission,Open house,Admin support,Scope of service,Representing sellers,Industry professionals,Central Property Exchange,Scope of service,CPx Administration,Listing support fees,Indicative service fees,How much commission,Included in the listed price',
									description:'Central Property Exchange � FAQ � Retained Commission � How Much Of The Commission Can Be Retained To Offset CPx Administration/ Listing Support Fees?',title:'Central Property Exchange | FAQ| Retained Commission'},


									{url:'low-grade-advertise',value:false,id:'nine',keywords: 'CPx,FAQ ,Score,Property,Categories,Advertising,Overall score,Property pricing,Graded property,Assist the vendor ,Property categories,Central Property Exchange,Best for a buyer,Advertising on CPx,Low Graded Property,Comparative attributes,The score of a property,CPx recommends buyers',
										description:'Central Property Exchange � FAQ � Low Graded Property � Is A Property With A Low Graded Score Worthwhile Advertising On CPx?',title:'Central Property Exchange | FAQ| Low Graded Property'},


										{url:'best-price-for-property',value:false,id:'ten',keywords: 'CPx,FAQ ,Fees,Profit,Property,Advertising,Low rate,Best price,Sale profit,Property seller,Advertising fees,Central Property Exchange,Best market price,View current rates,Profit in your pocket,Best price for my property,Listing your property with CPx,Not paying agent commissions',
											description:'Central Property Exchange � FAQ � Best Price � I Am A Property Seller And I Want The Best Price For My Property.  Can I Achieve This Using CPx?',title:'Central Property Exchange | FAQ| Best Price'},


											{url:'domacom-fractional-property-investing',value:false,id:'eleven',keywords: 'CPx,FAQ,Share,DomaCom,Properties,Investment,Unit holders,Property rent,Property shares,Safe investment,Property to invest in,Central Property Exchange,Public book build,Manage the properties,Buying investment property,Diversified property portfolio,Managed Investment Scheme,Earn money from my investment,Fractional Property Investing Fund,Sell some or all of my property units,Property ownership and management costs',
												description:'Central Property Exchange � FAQ � DomaCom � DomaCom Fractional Property Investing.',title:'Central Property Exchange | FAQ| DomaCom'},


												{url:'self-managed-super-fund-smsf',value:false,id:'twelve',keywords: 'CPx,FAQ ,SMSF,Super,Trustees,Retirement,Trust fund,Super fund,Buying property,Investment property,Superannuation monies,Central Property Exchange,Trustees of the fund,Self Managed Super Fund,Bought through a managed SMSF,Property purchase through my SMSF,Investing in property through your SMSF,Limited Recourse Borrowing Arrangements,Growing wealth to provide retirement income',
													description:'Central Property Exchange � FAQ � SMSF � Self Managed Super Fund.',title:'Central Property Exchange | FAQ| SMSF'},


													{url:'currency-conversion',value:false,id:'thirteen',keywords: 'CPx,FAQ ,Rates,Currency,Exchange,Conversions,Investment,Breach,User rule,Exchange rates,Trusted sources,Currency Conversions,Central Property Exchange,Third party suppliers,Investment decisions,Open Exchange Rates,Breach of this user rule,Accuracy of information,Making investment decisions',
														description:'Central Property Exchange � FAQ � Currency Conversions � Currency Conversions Is A Guide To Open Exchange Rates.',title:'Central Property Exchange | FAQ| Currency Conversions'},


														{url:'confidis-pty-ltd',value:false,id:'fourteen',keywords: 'CPx,ANZ,AIG,FAQ,Audit,Confidis,Transactions,Underwritten,Security,Trust Fund,Trust Account,Confidis Pty Ltd,Independent trust,Central Property Exchange,Certificate of Funds,Money is held safely,Australia�s leading banks,Trust Account transaction,Underwritten by AIG Australia,Deposits and disbursements of commissions and monies',
															description:'Central Property Exchange � FAQ � Confidis � What does Confidis Pty Ltd do?',title:'Central Property Exchange | FAQ| Confidis Pty Ltd'},
															

															{url:'loan-view',value:false,id:'fifteen',keywords: 'CPx,LVR,Loan,View,Costs,Search,Glossary,Announcements,Loan view,Interest rate,Interest only,Cash amount,Purchase costs,Estimated total,Search property,Add loan scenario,Monthly repayments,Loan to value ratio,Principle & Interest,Financial loan scenario,Find affordable properties,Central property exchange,Loan view glossary of terms,Financial search facility for property buyers,',
																description:'Central Property Exchange � FAQ � Loan View Glossary Of Terms – Loan View Is A Search Facility For Property Buyers.',title:'Central Property Exchange | FAQ | Loan View Glossary of Terms'}
														];

	 
	 // Press Release
	 
	$scope.pressstatus =[{url:'residential-builders-and-developers',value:false,id:'two',keywords: 'CPx,Agent,Profits,Builders,Developers,Press Release,Dealing direct,New way to sell,Negotiate directly,Real estate agency,Independent professionals,Central property exchange,Reap the rewards,Builders and Developers,Vendor can list their property,List your properties with CPx,New property selling process,The future of real estate trading',
		description:'Central Property Exchange � Press Release � Residential Builders and Developers� List Properties with CPx and Reap the Rewards.',title:'Central Property Exchange | Press Release| Builders & Developers'},


		{url:'private-residential-property-sellers',value:false,id:'three',keywords: 'CPx,Sell,Vendor,Real Estate,Press Release,Representative,No set fee,Property expert,Sellers and buyers ,Agent and vendor,Changing properties,Central property exchange,New property website,Sales commission fees,Save thousands of dollars,Eliminates high selling fees,Future of real estate buying and selling,Cut out the middle-man and save thousands',
			description:'Central Property Exchange � Press Release � Private Residential Property Sellers � Cut out the middle-man and save thousands.',title:'Central Property Exchange | Press Release| Private Sellers'},


			{url:'cpx-launch',value:false,id:'four',keywords: 'CPx,Fees,Launch,Real Estate,Negotiated,Commissions,Press Release,Advertising,Referral fees,Property gallery,Service providers,Independent agents,Central property exchange,Real estate website,Buying property online,Cut out the middle man,Real estate industry first,Buy and sell properties for less,Commissions and advertising fees,Listing and selling a property through CPx',
				description:'Central Property Exchange � Press Release � CPx Launch � Buy and sell property through CPx.',title:'Central Property Exchange | Press Release| CPx Launch'},


				{url:'property-buyers',value:false,id:'one',keywords: 'CPx,Purchase,Saving,Sale price,Property price,Press Release,Selling fees,Buy property,Property for sale,Agent commissions,Independent representative,Central property exchange,No set agent fees,Real estate agents,Current market guide,Buy property through CPx,Independently list property,Online property listing website',
					description:'Central Property Exchange � Press Release � Property Buyers � Be In Charge When You Buy Property Through Cpx.',title:'Central Property Exchange | Press Release| Property Buyers'},

					{url:'financial-services',value:false,id:'five',keywords: 'CPx,Finance,Investors,Properties,Real Estate,Press Release,Accountants,Financial Services,Financial Planners,Mortgage Brokers,Independent vendors,Central property exchange,Site feedback,Property grade,New property website,Quality service providers,Saving thousands of dollars,Finance Professionals Benefit with CPx',
						description:'Central Property Exchange � Press Release � Financial Services � Finance Professionals Benefit with Cpx.',title:'Central Property Exchange | Press Release| Financial Services'},

						{url:'buyers-agents',value:false,id:'six',keywords: 'CPx,Agent,Buyer ,Real Estate,Press Release,Representative,Buyers Agent,Buying Property,Negotiate directly,Free membership,Source properties,Central property exchange,Add more value,No fee for referrals,Portfolio of properties,Expand agency business,Negotiate with the vendor,Listed as a service provider',
							description:'Central Property Exchange � Press Release � Buyers Agents � Agents Get To Add More Value With CPx.',title:'Central Property Exchange | Press Release| Buyers Agents'},


							{url:'fractional-property-investing',value:false,id:'seven',keywords: 'CPx,Property,Investing,Fractional,DomaCom,Press Release,Equity release,Property fund,Capital growth,SMSF Trustees,Choose property,Australian properties,Long term investors,Fractional property investing,Property Investment solution,Financial services professionals,Independently listed properties,Buy property without the middleman',
								description:'Central Property Exchange � Press Release � Fractional Property Investing � DomaCom Collaborates With CPx.',title:'Central Property Exchange | Press Release| Fractional Investing'},


								{url:'villa-world',value:false,id:'eight',keywords: 'CPx,Private,Brokers,Investors,Villa World,Press Release,New homes,Property sales,List properties,Negotiated price,Industry professionals,Central Property Exchange,Buyers and sellers,Buy and sell property,Significant cost savings,Saving thousands of dollars,Property development group,Advertise completed new homes',
									description:'Central Property Exchange � Press Release � Villa World � Villa World Lists New Homes With CPx.',title:'Central Property Exchange | Press Release| Villa World'},

								{url:'power-exchange',value:false,id:'nine',keywords: '',
									description:'',title:'Central Property Exchange | Press Release| Power Exchange'}

								];

	 //cpx announcement 	
	 
	$scope.cpxanoustatus =[{url:'new-service-for-private-vendors-and-developers',value:false,id:'one',keywords: 'CPx,Real Estate,Developers,Announcements,Private Vendors,Save thousands,Property for sale,Mortgage Brokers,Financial Planners,Real estate agents,Graded properties,Central property exchange,Property Developers,New Real Estate service,No real estate agent fees,Deal directly with the vendor,Independent online real estate,Advertise your property for sale',
		description:'Central Property Exchange � Blog � CPx announcements � List your property with CPx and save thousands.',title:'Central Property Exchange | Real Estate| Announcements'},
		
		{url:'loan-view',value:false,id:'two',keywords: 'CPx,LVR,Loan,Budget,Deposit, Shortlist,Announcements,Loan view,Search tool,Interest only,Loan amount,Cash amount,Search for property,Borrowing capacity,Monthly repayments,Central property exchange,Loan to value ratio,Principle & Interest,Repayment life cycle,View graded properties,Real estate sales website,Experience the loan view difference,Be the power behind the interest rate,The smart new way to search property,',
			description:'Central Property Exchange � Cpx Announcements � Loan View � The smart new way to search property!',title:'Central Property Exchange | CPx Announcements| Loan View '}
		
	 	                 ];
	 
	 
	$scope.viewgradedstatus =[{value:false},
	                          {value:false}
    ];
	
	
	
	
	
	
	
	if($scope.pid != undefined){
	//console.log($scope.pid);
	
	for(i=0;i<$scope.keywordset.length;i++){
		
		if($scope.keywordset[i].pid == $scope.pid){
		
			$rootScope.metakeywords = $scope.keywordset[i].keywords;
			$rootScope.description = $scope.keywordset[i].description;
			$rootScope.title = $scope.keywordset[i].title;
			
		//	console.log($scope.keywordset[i]);
		}
		
	}
	}
		
	
	if($scope.subid != undefined && $scope.subid != "subid"){
		
		// faq's
		 if($scope.pid == 'FAQs'){
			 
			 for(i=0;i<$scope.status.length;i++){
				 
				 if($routeParams.subid == $scope.status[i].url){
					 
					 $rootScope.metakeywords = $scope.status[i].keywords; 
					 $rootScope.description = $scope.status[i].description; 
					 $rootScope.title = $scope.status[i].title; 
				
					}
				 }}
		
		 
		//for press release
		 else if($scope.pid == 'press-releases'){
		 for(i=0;i<$scope.pressstatus.length;i++){
			 
			 if($routeParams.subid == $scope.pressstatus[i].url){
				 
				 $rootScope.metakeywords = $scope.pressstatus[i].keywords;
				 $rootScope.description = $scope.pressstatus[i].description; 
				 $rootScope.title = $scope.pressstatus[i].title; 
				}
			 }}
		 
		 
		//for cpx announcement
		 else if($scope.pid == 'cpx-announcements'){
		 for(i=0;i<$scope.cpxanoustatus.length;i++){
			 
			 if($routeParams.subid == $scope.cpxanoustatus[i].url){
				
				 $rootScope.metakeywords = $scope.cpxanoustatus[i].keywords; 
				 $rootScope.description = $scope.cpxanoustatus[i].description; 
				 $rootScope.title = $scope.cpxanoustatus[i].title; 
				 
				}
			 }}
		 
		 }
	
	
	
	//console.log($scope.subid);
	 $scope.isCPxCollapsed = true;

	
	 
//	 $scope.aboutmenu = {What_is_CPx:true, Independent_process:false,Independent_property_review:false,What_is_graded:false,find_industry_professionals:false,FAQs:false,list-property:false,advertise-property:false,mnucontactus:false,
//			 working_with_cpx:false,view_directory:false,Sign_up:false,Business_login:false,Contact_us_for_more:false,press_releases:false,Publications:false,cpx_announcements:false,blogindex:false,
//			 view_directory:false,submit-service-request:false};
	 
	 
	 $scope.aboutmenu =[
			 
			 {name:'what-is-cpx',value:true},
			 {name:'independent-process',value:false},
			 {name:'independent-property-review',value:false},
			 {name:'what-is-graded',value:false},
			 
			 {name:'find-industry-professionals',value:false},
			 
			 {name:'FAQs',value:false},
			 {name:'list-property',value:false},
			 
			 {name:'advertise-property',value:false},
			 {name:'mnucontactus',value:false},
			 
			 {name:'working-with-cpx',value:false},
			 {name:'view-directory',value:false},
			 {name:'submit-free-membership-form',value:false},
			 {name:'Business_login',value:false},
			 {name:'Contact_us_for_more',value:false},
			 
			 {name:'press-releases',value:false},
			 {name:'Publications',value:false},
			 {name:'cpx-announcements',value:false},
			 {name:'blogindex',value:false},
			 
			 {name:'submit-service-request',value:false},
			 
			 
		];

	 

	// $scope.isCollapsed = true;
	 $scope.toggleStatus ={first:false,second:false,third:false,fourth:false,fifth:false,sixth:true,seventh:false};
	 
	
	 
	 $scope.selectMenuItem = function (itemkey){
		// alert( itemkey);
		 for (var key in $scope.aboutmenu) {
			
			 if($scope.aboutmenu[key].name==itemkey){
				 $scope.aboutmenu[key].value=true;

			 }else{
				 $scope.aboutmenu[key].value=false;
			 }
		 }
	
	 };
	 $scope.selectMenuItem($scope.pid );
	 
	
	 
//	 $scope.isMenuSelected = function (itemkey){
//		 
//		 var selected=false;
//		 for (var key in $scope.aboutmenu) {
//			 if(key==itemkey.mnu){
//				 selected=true;
//				 break;
//			 }
//		 }
//		 //alert( JSON.stringify($scope.aboutmenu) + ' return ' + selected);
//		 return selected;
//	 };
	 
	 
	 // function for anchor schroll
 
	 
	 $scope.gotoBottom = function() {
	       
		 
	     var flag = CommonShareService.getgotorate();
		 
		 
		 
		 if(flag == true){
			 
			 
			 $scope.viewgradedstatus[1].value = true; 
		//	 console.log($scope.viewgradedstatus[1].value);
			 $location.hash('grade');

			 $timeout(function() {
	        	 $anchorScroll();     
           }, 4000);
			 
			 
			 
		 }
		 
		 
		 
		 
		 //for faq's
		 
		 if($scope.pid == 'FAQs'){
		 for(i=0;i<$scope.status.length;i++){
			 
			 if($routeParams.subid == $scope.status[i].url){
				 
				 
				 
				 $location.hash($scope.status[i].id);
				 $scope.status[i].value = true;   
			        // call $anchorScroll()
			       
			        
			        $timeout(function() {
			        	 $anchorScroll();     
		           }, 4000);
			        
				}
			 }}
		 
		 
		//for press release
		 else if($scope.pid == 'press-releases'){
		 for(i=0;i<$scope.pressstatus.length;i++){
			 
			 if($routeParams.subid == $scope.pressstatus[i].url){
				 $location.hash($scope.pressstatus[i].id);
				 $scope.pressstatus[i].value = true;   
			        // call $anchorScroll()

				 $timeout(function() {
		        	 $anchorScroll();     
	           }, 4000);
				 
				}
			 }}
		 
		 
		//for cpx announcement
		 else if($scope.pid == 'cpx-announcements'){
		 for(i=0;i<$scope.cpxanoustatus.length;i++){
			 
			 if($routeParams.subid == $scope.cpxanoustatus[i].url){
				 $location.hash($scope.cpxanoustatus[i].id);
				 $scope.cpxanoustatus[i].value = true;   
			        // call $anchorScroll()
			       
				 $timeout(function() {
		        	 $anchorScroll();     
	           }, 4000);
				 
				}
			 }}
		 
		
	        
	      };
	      
	      
	    
	      $scope.gotorate = function (){
		    	 
	    	  CommonShareService.passgotorate();
		    }  
	      
	      
	      $scope.gotorate2 = function (){
		    	 
	    	  CommonShareService.passgotorate2();
		    }
	      
	      
	       
	      if($scope.pid == 'FAQs' || $scope.pid == 'press-releases' || $scope.pid == 'cpx-announcements' || $scope.pid == 'what-is-graded'){
	      $scope.gotoBottom();     
	      }	  
	      
	    //share via mail
	      
	      var firstmail = '';
	      $scope.openfaqmail = function (aid) {
	    	  	
	    	//for faq's
	 		 if($scope.pid == 'FAQs'){
	 		 for(i=0;i<$scope.status.length;i++){
	 			 if(aid == $scope.status[i].id){
	 				firstmail = $scope.pid+"/"+$scope.status[i].url;
	 			 	}
	 			 }
	 		 } else if($scope.pid == 'press-releases'){
	 			 for(i=0;i<$scope.pressstatus.length;i++){
		 			 if(aid == $scope.pressstatus[i].id){
		 				firstmail = $scope.pid+"/"+$scope.pressstatus[i].url;
		 			 	}
		 			 }
	 		 } else if($scope.pid == 'cpx-announcements'){
	 			 for(i=0;i<$scope.cpxanoustatus.length;i++){
		 			 if(aid == $scope.cpxanoustatus[i].id){
		 				firstmail = $scope.pid+"/"+$scope.cpxanoustatus[i].url;
		 			 	}
		 			 }
	 		 }
	    	  
	    	  
	    	  
	    	  
	     	    var modalInstance = $modal.open({
	     	      templateUrl: 'mymailcontent.html',
	     	      controller: 'FaqmailCtrl',
	     	      size: '',
	     	      resolve: {
	     	        items: function () {
	     	          return firstmail;
	     	        }
	     	      }
	     	    });

	     	    modalInstance.result.then(function (selectedItem) {
	     		      $scope.selected = selectedItem;
	     		    }, function () {
	     		      $log.info('Modal dismissed at: ' + new Date());
	     		    });
	     		  };

	 //blog print function
	     		 
	     $scope.setprintpage = function (page){
	    	 
	    	 
	    	 CommonShareService.passblogprintid(page);
	    	 
	     }  
	     
	  //subscribe form
	     
	     $scope.registrationForm = {
	    		    'email'     : ''
	    		};
	     
	     $scope.resetform = function (){
	    	 
	    	 alert($scope.registrationForm.email);
	    	 
	    	 $timeout(function() {
	    		 $scope.registrationForm.email = '';      
           }, 3000);
	    
	    	 
	     }  
	     
	
	       		 
	     
}]);app.controller('OrderCtrl', ['$scope','$rootScope', function ($scope,$rootScope) {
	 	
	 $scope.isCPxCollapsed = true;
	 $scope.isCollapsed = true;
	 $scope.toggleStatus ={ipr:false,ire:false,ics:false,deprpt:false,propval:false,popugrowth:false};
}]);
app.controller('ListCtrl', ['$scope','$rootScope','$location','$anchorScroll','$timeout','CommonShareService', function ($scope,$rootScope,$location,$anchorScroll,$timeout,CommonShareService) {
	 
	$rootScope.metakeywords = "";
	
	$scope.listStatus ={rate:false,offer:false};
	 
	 
	 var flag = CommonShareService.getgotorate2();
	 
	 if(flag == true){
		
		 $scope.listStatus.rate = true;
		 $location.hash('rate');
		
		 $timeout(function() {
        	 $anchorScroll();     
       }, 4000);
	 } 
	
}]);
app.controller('ErrorPageCtrl', ['$scope', function ($scope) {
}]);

app.controller('ContactCtrl', ['$scope', 'ContactService','$rootScope','CommonShareService','ShortlistService','vcRecaptchaService','$http','$timeout', function ($scope, ContactService, $rootScope, CommonShareService,ShortlistService,vcRecaptchaService,$http,$timeout) {
	
	$rootScope.metakeywords = "CPx,Email,Contact,Message,Telephone,Management,Questions,Email address,Contact details,Key management,Telephone number,Central Property Exchange,Online right now,Chat via Skype with us,Find out more about CPx,Comments and questions,Based in Sydney and Perth,How to make contact with CPx";
	
	$rootScope.title= "Central Property Exchange | Real Estate| Contact";
	
	$rootScope.description="Central Property Exchange � Contact Page - Buy And Sell Residential And Investment Properties � Key Management in Sydney and Perth Australia.";
	
	$rootScope.loading=false;
	//$scope.contact=[];
	$scope.link= "";
	


	
	
 
	
  var checkflag = CommonShareService.getallid();
	
  if(checkflag == false){
   $scope.currid = CommonShareService.getenquireid();	
	
	if ($scope.currid != null){
		
		$scope.link	= "http://centralpropertyexchange.com.au/#!/details/"+$scope.currid;
	}
  }
	
	
  var checkflag = CommonShareService.getallid();
	
  if(checkflag == true){	
	
	
	$scope.list = ShortlistService.getProducts();
	
	
	if($scope.list != undefined){
				
		for(i=0;i<$scope.list.length;i++){
			
			$scope.link = $scope.link +"http://centralpropertyexchange.com.au/#!/details/"+$scope.list[i].id+"\n";		
		
		}
		

		}
	
	}
	
//  console.log("try1"+$rootScope.shownothing);
  
   if($rootScope.shownothing != false){
	   
	   $scope.link = '';
   }
	
   $scope.respone5 = '';
   
	 $scope.sendContactEmail=function(){
		// console.log($scope.contact);
			//console.log('trea',!$scope.contact.name || !$scope.contact.email);
			if(!$scope.contact.name || !$scope.contact.email){
				
//				console.log("kam fastay");
			}
			
			else{
		 
			 //console.log($scope.respone5);
			 if($scope.respone5.length === 0){
				    $scope.alerts = [ { type: 'danger', msg: 'Please complete the captcha.' } ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				    return;		
				    
				  }
			 
				
				else{
				 var valid;

			 ContactService.create($scope.contact).$promise.then(function(msg) {
		        $scope.msg = msg.toJSON();
		     });
			 $rootScope.loading = true;
			 $timeout(function() {
				 $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				 
				 $scope.contact.name = "";
				 $scope.contact.email = "";
				 $scope.contact.subject = "";
				 $scope.contact.message = '' ;
				 $scope.contact.dummysubject = "Contact us Enquiry";
				 grecaptcha.reset(); 
				 $rootScope.loading = false;
       }, 2000);
			 
		 }  
		 }
};
	}]);app.controller('ShortlistCtrl', ['$scope','$rootScope', 'PropertyService','ShortlistService','CommonShareService','$window','$modal','$log','getRateInfo','numberFilter','$q','$timeout', function ($scope,$rootScope, PropertyService, ShortlistService,CommonShareService,$window, $modal, $log,getRateInfo,numberFilter,$q,$timeout) {
	
	$rootScope.title = "Central Property Exchange | Real Estate| Shortlist";
	$rootScope.metakeywords = "property,shortlist,graded,standard,view,reserve,grade,cart,bucket,favourite";
	
	$scope.properties = ShortlistService.getProducts();
	
	
	$scope.defaultPI_LOANTERM = 30;
	$scope.defaultIO_LOANTERM = 5;
	$scope.defaultPI_RATE = 4.29;
	$scope.defaultIO_RATE = 4.29;
	$scope.default_costvalue = 5;
	
	$scope.caseflag = 'one';
//	$scope.short = ShortlistService.getProducts();
	
//	console.log("hello"+$scope.short);
	
//	localStorage.setItem("token", token);
	
//	$rootScope.shownothing = true;
	
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
	     	      });

	     	      
	     	      
	     	      $scope.updateValueAll = function(from, to, items, isTopconvertor) {
	     	    	  
	     	    	 $scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);
	 		    	 $scope.countrylabel = to.currency.code;
	     	    	
	 		    	angular.forEach(items, function(item, key) {
	 		    		
			    		item.short_currlabel = to.currency.code;

			    		if(to.currency.code == "AUD"){item.short_currlabel = undefined;}  
	 		    		
			    		item.short_convcpx = item.cpxprice / getRate(from.currency) * getRate(to.currency);

			    		
			    		item.series = [];
			    		item.data = [];
			    		
			    		///for all scenarios
			    		angular.forEach(item.scenarios, function(scenaitem, key) {


			    			if(!(scenaitem.caseflag == 'three') || isTopconvertor){
			    				
			    				scenaitem.conv_costprice = scenaitem.costprice / getRate(from.currency) * getRate(to.currency);

			    				scenaitem.conv_estimate = scenaitem.estimate / getRate(from.currency) * getRate(to.currency);

			    				scenaitem.conv_loanamt = scenaitem.loanamt / getRate(from.currency) * getRate(to.currency);

			    				
			    				scenaitem.conv_cashamount = scenaitem.cashamount / getRate(from.currency) * getRate(to.currency);

			    			}
			    			//repayments calculations based on interest type// cal graph data
			    			if(scenaitem.loantype == 'PI'){

			    				if(scenaitem.intrate == undefined || scenaitem.intrate == ""){

			    					scenaitem.intrate = 0; 
			    				} 

			    				scenaitem.conv_repayments = $scope.calrepayPI(scenaitem.loanterm,scenaitem.intrate,scenaitem.conv_loanamt);

			    				scenaitem.graphdata = $scope.calgraphdata(scenaitem.loanterm,scenaitem.intrate,scenaitem.conv_loanamt,scenaitem.conv_repayments);
			    			}else{
			    				scenaitem.conv_repayments = $scope.calrepayIO(scenaitem.intrate,scenaitem.conv_loanamt);
			    				scenaitem.graphdata = $scope.calgraphdata($scope.defaultIO_LOANTERM,scenaitem.intrate,scenaitem.conv_loanamt,scenaitem.conv_repayments);
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

	     	      $scope.setiscreate = function(){

	     	    	  $scope.iscreate= true;
	     	    	 $scope.editflag=null;
	     	    	$scope.editingname=null;
	     	      }

	     	      $scope.typeselected = 'IO'; 

	     	      $scope.isIOselected = function(value){

	     	    	  $scope.typeselected = value;

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
	     	    	  Base.name = 'Base IO';

	     	    	  Base.loantype = 'IO';

	     	    	  Base.intrate = $scope.defaultIO_RATE;
	     	    	  Base.loanterm = $scope.defaultIO_LOANTERM;
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

	     	    	 
	     	    	 ////base for PI
	     	    	  
	     	    	 var Base_PI = {}; 
	     	    	  Base_PI.name = 'Base PI';

	     	    	  Base_PI.loantype = 'PI';

	     	    	  Base_PI.intrate = $scope.defaultPI_RATE;
	     	    	  Base_PI.loanterm = $scope.defaultPI_LOANTERM;
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
	     	    	  
	     	    	  
	     	    	  

	     	      });		 
	     	     
	     	    
	     	     }
	     	      
	     	     ///////////function for setting default to AUD
	     	    	 
	     	     //call to set base scenario
	     	    $scope.setbasescenario($scope.properties);
	     	     
	     	   
	     	     
	     	      //////add new scenario

	     	      $scope.submitscenario = function(property,scena){

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
	     	    			 scenario.loanterm = $scope.defaultIO_LOANTERM;
	     	    			  scenario.repayments = $scope.calrepayIO(scenario.intrate,scenario.loanamt);
	     	    			 scenario.graphdata = $scope.calgraphdata($scope.defaultIO_LOANTERM,scenario.intrate,scenario.loanamt,scenario.repayments);
	     	    		  }

	     	    		  
	     	    		  



	     	    		  //check edit
	     	    		  if($scope.editflag != null){
	     	    			  
	     	    			     	    			  
	     	    			  property.scenarios[$scope.editflag] = scenario;
	     	    			 
		     	    			property.data.splice($scope.editflag, 0, scenario.graphdata[0].data);
		     	    			property.series.splice($scope.editflag, 0, scenario.name);
		     	    			
		     	    			
	     	    		  } 
	     	    		  else{
	     	    			  property.scenarios.push(scenario);
	     	    			 property.data.push(scenario.graphdata[0].data);
	     	    			property.series.push(scenario.name);

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
	     	    		  
	     	    		  
	     	    		  
	     	    		  $scope.clearscenario(property,scena);

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
app.controller('DefaultCtrl', ['$scope','$rootScope','$location', function ($scope,$rootScope,$location) {
	
	
	
	
	$scope.currenturl = $location.absUrl();
	
	if($scope.currenturl.indexOf("privacy") >= 0){
		
		$rootScope.title = "Central Property Exchange | Legals | Privacy";
		$rootScope.metakeywords = "CPx,Laws,Privacy,Security,Disclosure,Protection,Information,Third party,Privacy laws,Landlord Central,Privacy protection,Personal information,Correcting information,Central property exchange,Make an enquiry,Internet privacy policy,Apply for a job with us,Protecting your privacy,Your personal information,We will not sell or pass on your details,Information collected about visitors to our website";
		$rootScope.description="Central Property Exchange � Legals � Privacy � We Recognise The Importance Of Protecting The Privacy Of Information Collected About Visitors To Our Website.";
	}
	
	else if($scope.currenturl.indexOf("terms-and-conditions") >= 0){
		
		$rootScope.title = "Central Property Exchange | Legals | Terms & Conditions"
		$rootScope.metakeywords = "CPx,Terms,Access,Website,Material,Copyright,Disclaimer,Conditions,Third party ,Exclusive right,This agreement,Landlord Central,Property Compass,Intellectual property,Central property exchange,Use of material,Terms and conditions,For personal use only ,Termination of access,Links to other websites,Network of professionals,The legal and rightful owner of the intellectual property";
		$rootScope.description="Central Property Exchange � Legals � Terms & Conditions � Landlord Central Has Developed An Online Property Evaluation System For The Property Seller Or Buyer. The Business Process Is Also Licensed To Our Network Of Professionals.";
	}else
	{
		$rootScope.metakeywords = "CPx,Free,Order,Rental,Report,Property,Buy now,Contract,Valuation,Summary,Property Review,Central property exchange,Property Valuation,Depreciation Report,Independent Rental Estimate,Population and Capital Growth,Independent Property Review,Independent Contract Summary";
		$rootScope.description="Central Property Exchange � Reports � Order Independent Reports � Order Report, Buy Now, Free Estimate, Free Summary";
		$rootScope.title="Central Property Exchange | Reports | Order Independent Reports";
	}

}]);app.controller('fbCtrl',['$scope',function($scope){
	//  $scope.posts = [{id:1,title:"title1",content:"content1",caption:"caption1"},{id:2,title:"title2",content:"content2",caption:"caption2"}];
	  $scope.share = function(post){
	//	  console.log(post.images[0].url);
	    FB.ui(
	    {
	        method: 'feed',
	        name: ''+post.address[0].StreetNumber+''+post.address[0].street+', '+post.address[0].suburb+', '+post.address[0].city+', '+post.address[0].state+', '+post.address[0].postcode,
	        link: 'http://centralpropertyexchange.com.au/#!/details/'+post.id,
	        picture: ''+post.images[0].url,
	    //    caption: post.caption,
	        description: 'http://centralpropertyexchange.com.au/#!/details/'+post.id,
	        message: ''
	    });
	  }
	}]);


	app.controller('fbCtrlblog',['$scope',function($scope){
	//  $scope.posts = [{id:1,title:"title1",content:"content1",caption:"caption1"},{id:2,title:"title2",content:"content2",caption:"caption2"}];
	  $scope.share = function(post){
	 // console.log(post);
	    FB.ui(
	    {
	        method: 'feed',
	        name: ''+post,
	        link: ''+post,
	        picture: 'http://centralpropertyexchange.com.au/images/Logo.png',
	    //    caption: post.caption,
	    //    description: 'http://centralpropertyexchange.com.au/#!/details/'+post.id,
	        message: ''
	    });
	  }
	}]);app.controller('printCtrl', ['$scope','$rootScope','PropertyService','CommonShareService', function ($scope,$rootScope,PropertyService,CommonShareService) {

	PropertyService.success(function(data) { 
		
		$scope.properties = data.properties;	
	
		$scope.currid = CommonShareService.getid();
		
		$scope.currentpage = CommonShareService.getblogprintid();
		
		
		

			$scope.currentproperty = $scope.properties[0];
		
		
		for(i=0;i<$scope.properties.length;i++){
			
			if($scope.properties[i].id == $scope.currid){
				
			$scope.currentproperty = $scope.properties[i];	
			}
			
		}
		
		
		
		
		
		
		$scope.gradevalues = [1,2,3,4,5];
		$scope.map = { center: { latitude: $scope.currentproperty.coords.latitude, longitude: 1*$scope.currentproperty.coords.longitude + 0.0050}, zoom: 16, 

				 markersr: [
				               {
				                   id: 101,
				                   latitude:  $scope.currentproperty.coords.latitude,
				                   longitude: $scope.currentproperty.coords.longitude
				               }],
				     };
	
	
	
	
	
	
	
	});
	
	
	
	
	
	
	}]);
app.controller('producttileCtrl', ['$scope','CommonShareService','getRateInfo','numberFilter','$q', function ($scope,CommonShareService,getRateInfo,numberFilter,$q) {
	
	
	
////////////////currency filters


function getRate(currency) {
return currency && currency.rate;
}

// Grab the promises from the two calls  
var namesPromise = getRateInfo();
//var ratesPromise = getRateInfo('latest');

$scope.to = {};

$scope.from = {};

// Use the $q.all method to run code only when both promises have been resolved
$q.all([namesPromise]).then(function(responses) {

// var currencyNames = responses[0];
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
});


$scope.item.convertedcpx_home = undefined;
$scope.item.currencylabel_home = undefined;

$scope.updateValue = function(from, to, item) {

item.currencylabel_home = to.currency.code;
//	console.log(item.currencylabel);

if(to.currency.code == "AUD"){item.currencylabel_home = undefined;}  


item.convertedcpx_home = item.cpxprice / getRate(from.currency) * getRate(to.currency);


};

}]);
app.controller('currencyCtrl', ['$scope','CommonShareService','getRateInfo','numberFilter','$q', function ($scope,CommonShareService,getRateInfo,numberFilter,$q) {
	
	
	
////////////////currency filters


function getRate(currency) {
return currency && currency.rate;
}

//Grab the promises from the two calls  
var namesPromise = getRateInfo();
//var ratesPromise = getRateInfo('latest');

$scope.to = {};

$scope.from = {};

//Use the $q.all method to run code only when both promises have been resolved
$q.all([namesPromise]).then(function(responses) {

//var currencyNames = responses[0];
var currencyRates = responses[0].quotes;

//Generate the currencies array
$scope.currencies = [];


var currencyNames = CommonShareService.getcurrencyNames();

var USDrate=currencyRates['USDUSD'];
var AUDrate=currencyRates['USDAUD'];
var multiplier=USDrate/AUDrate;

console.log(USDrate);
angular.forEach(currencyNames, function(name, code) {

var rate = currencyRates['USD'+code];
$scope.currencies.push({
code: code,
label : code +" "+ name + " (" + numberFilter(rate*multiplier, 3) + " / AUD)",
rate: rate*multiplier
});

});


//set AUD as default currency
$scope.from.currency = $scope.currencies[7];
$scope.to.currency = $scope.currencies[7];
});



$scope.updateValue = function(from, to, value) {
	$scope.animatebtn = false;
$scope.convertedvalue = value / getRate(from.currency) * getRate(to.currency);

$scope.ratebase_from = (to.currency.rate / from.currency.rate).toFixed(2);

$scope.ratebase_to = (from.currency.rate / to.currency.rate).toFixed(2);

$scope.getDatetime = new Date();
};

$scope.animatebtn = false;
$scope.animate = function (value) {
   
	if(value == 'on'){	
		$scope.animatebtn = true;
	}
	
};
}]);
app.controller('SubmitPropertyRequestCtrl', ['$scope' ,'$rootScope','ContactService','vcRecaptchaService','$http','$timeout','$window', function ($scope,$rootScope,ContactService,vcRecaptchaService,$http,$timeout,$window,widgetId) {

	$rootScope.title= "Central Property Exchange| Real Estate | Submit Your Property";	
	
	
	
    $scope.respone1 = '';
 
    $scope.setResponse = function (response) {
        console.log('Response available');
        $scope.response = response;
    };


     $scope.setWidgetId = function (widgetId) {
	        console.log('Created widget ID: %s', widgetId);
	        $scope.widgetId = widgetId;
	    };
	    	
	 $scope.sendContactEmail=function(){
		 console.log($scope.contact);
			console.log('trea',!$scope.contact.name || !$scope.contact.email);
			if(!$scope.contact.name || !$scope.contact.email){
				
//				console.log("kam fastay");
			}
			
			else{
			  
			 console.log($scope.widgetId);
			 
			 console.log($scope.respone1);
			 if($scope.respone1.length === 0){
				    $scope.alerts = [ { type: 'danger', msg: 'Please complete the captcha.' } ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				    return;		
				    
				  }
			 
				
				else{
				 var valid;

		         console.log('sending the captcha response to the server');
				
			 
		       
		        
		         /* $scope.dummycontact = {};
			 angular.copy($scope.contact, $scope.dummycontact);*/
			 console.log($scope.contact);
			 //console.log($scope.contact,$scope.dummycontact);
			

			 ContactService.create($scope.contact).$promise.then(function(msg) {
		        $scope.msg = msg.toJSON();
		     });
			 $rootScope.loading = true;
			 $timeout(function() {
				 $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				 
				 $scope.contact.name = "";
				 $scope.contact.email = "";
				 $scope.contact.subject = "Property request";
				 $scope.contact.message = 'Please provide a summary of what you are looking for. Example:\nPrice range\nSMSF suitable\nHouse or unit\nLocation\nOther relevant criteria\nOr simply paste a link here' ;
				 $scope.contact.dummysubject = "Submit property request";
				 grecaptcha.reset(); 
				 $rootScope.loading = false;
             }, 2000);
			 
		 }  
		 }
};
	
	
}]);



app.controller('ListYourPropertyCtrl' , ['$scope','$rootScope','$route','ContactService','vcRecaptchaService','$http','$timeout','$window', function ($scope,$rootScope,$route,ContactService,vcRecaptchaService,$http,$timeout,$window,widgetId) {
	
	$rootScope.title= "Central Property Exchange| Real Estate | List Your Property";	

	
	 $scope.respone2 = '';
	 
	    $scope.setResponse = function (response) {
	        console.log('Response available');
	        $scope.response = response;
	    };
	  

	     $scope.setWidgetId = function (widgetId) {
		        console.log('Created widget ID: %s', widgetId);
		        $scope.widgetId = widgetId;
		    };
    
	 $scope.sendContactEmail=function(){
		 console.log($scope.contact);
			console.log('trea',!$scope.contact.name || !$scope.contact.email);
			if(!$scope.contact.name || !$scope.contact.email){
				
//				console.log("kam fastay");
			}
			
			else{
          		console.log($scope.widgetId);
			 
			 console.log($scope.respone2);
			 if($scope.respone2.length === 0){
				    $scope.alerts = [ { type: 'danger', msg: 'Please complete the captcha.' } ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				    return;		
				    
				  }
			 
				
				else{
				 var valid;

		         console.log('sending the captcha response to the server');
				
			 
		       
		        
		         /* $scope.dummycontact = {};
			 angular.copy($scope.contact, $scope.dummycontact);*/
			 console.log($scope.contact);
			 //console.log($scope.contact,$scope.dummycontact);
			

			 ContactService.create($scope.contact).$promise.then(function(msg) {
		        $scope.msg = msg.toJSON();
		     });
			 $rootScope.loading = true;
			 $timeout(function() {
				 $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				 
				 $scope.contact.name = "";
				 $scope.contact.email = "";
				 $scope.contact.subject = "List my Property on CPx";
				 $scope.contact.message = 'Please provide a summary of your property\nOr simply paste a link here' ;
				 $scope.contact.dummysubject = "List your property";
				 grecaptcha.reset(); 
				 $rootScope.loading = false;
          }, 2000);
			 
		 }  
		 }
};
	 
	    }]);





app.controller('SubmitFreeMembershipCtrl' , ['$scope','$rootScope','ContactService','vcRecaptchaService','$http','$timeout', function ($scope,$rootScope,ContactService,vcRecaptchaService,$http,$timeout) {
	
	$rootScope.title= "Central Property Exchange| Industry Professionals | Submit Free Membership Request";	
	
	$scope.respone4= '';

	 
	    $scope.setWidgetId = function (widgetId) {
	        console.info('Created widget ID: %s', widgetId);
	        $scope.widgetId = widgetId;
	    };
	
	
	 $scope.sendContactEmail=function(){
		 console.log($scope.contact);
			console.log('trea',!$scope.contact.name || !$scope.contact.email);
			if(!$scope.contact.name || !$scope.contact.email){
				
//				console.log("kam fastay");
			}
			
			else{
			  
			 console.log($scope.widgetId);
			 
			 console.log($scope.respone4);
			 if($scope.respone4.length === 0){
				    $scope.alerts = [ { type: 'danger', msg: 'Please complete the captcha.' } ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				    return;		
				    
				  }
			 
				
				else{
				 var valid;

		         console.log('sending the captcha response to the server');
				
			 
		       
		        
		         /* $scope.dummycontact = {};
			 angular.copy($scope.contact, $scope.dummycontact);*/
			 console.log($scope.contact);
			 //console.log($scope.contact,$scope.dummycontact);
			

			 ContactService.create($scope.contact).$promise.then(function(msg) {
		        $scope.msg = msg.toJSON();
		     });
			 $rootScope.loading = true;
			 $timeout(function() {
				 $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				 
				 $scope.contact.name = "";
				 $scope.contact.email = "";
				 $scope.contact.subject = "Industry professionals new membership request";
				 $scope.contact.message = '' ;
				 $scope.contact.dummysubject = "Submit free membership request";
				 grecaptcha.reset(); 
				 $rootScope.loading = false;
       }, 2000);
			 
		 }  
		 }
};
	
}]);


app.controller('SubmitServiceRequestCtrl' , ['$scope','$rootScope','ContactService','vcRecaptchaService','$http','$timeout', function ($scope,$rootScope,ContactService,vcRecaptchaService,$http,$timeout,widgetId,widgetId1) {
	
	$rootScope.title= "Central Property Exchange| CPx Marketplace | Submit Service Request";	
	
	 $scope.respone3= '';

	    
	 
	    $scope.setResponse = function (response) {
	       // console.log('Response available');
	        $scope.response = response;
	    };
	    $scope.cbExpiration = function() {
	        //console.log('Captcha expired. Resetting response object');
	        $scope.response = null;
	     };

	     $scope.setWidgetId = function (widgetId) {
		        //console.log('Created widget ID: %s', widgetId);
		        $scope.widgetId = widgetId;
		    };
   
	
	$scope.sendContactEmail=function(){
		// console.log($scope.contact);
			//console.log('trea',!$scope.contact.name || !$scope.contact.email);
			if(!$scope.contact.name || !$scope.contact.email){
				
//				console.log("kam fastay");
			}
			
			else{
			  
			 //console.log($scope.widgetId);
			 
			 //console.log($scope.respone3);
			 if($scope.respone3.length === 0){
				    $scope.alerts = [ { type: 'danger', msg: 'Please complete the captcha.' } ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				    return;		
				    
				  }
			 
				
				else{
				 var valid;

		        
			 ContactService.create($scope.contact).$promise.then(function(msg) {
		        $scope.msg = msg.toJSON();
		     });
			 $rootScope.loading = true;
			 $timeout(function() {
				 $scope.alerts = [
			   	                  { type: 'success', msg: 'Thank you for contacting us. We will reach out to you shortly.' }
			   	                ];
				    $scope.closeAlert = function(index) {
					      $scope.alerts.splice(index, 1);
					    };
				 
				 $scope.contact.name = "";
				 $scope.contact.email = "";
				 $scope.contact.subject = "Service request";
				 $scope.contact.message = '' ;
				 $scope.contact.dummysubject = "Submit service request";
				 grecaptcha.reset(); 
				 $rootScope.loading = false;
          }, 2000);
			 
		 }  
		 }
}
}]);app.controller('LogoslideCtrl' , ['$scope','$rootScope', function ($scope,$rootScope) {
	
	 $("#logoslide").flexisel({
		 
		 visibleItems: 4,
		 autoPlay: false,
  
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 1
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 2
            },
            tablet: { 
                changePoint:768,
                visibleItems: 3
            }
        }
         
    });
	 
	 
	 
	 
}]);