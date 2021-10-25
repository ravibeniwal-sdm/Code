app.controller('DetailsCtrl', ['$scope','$rootScope','$routeParams','$location','$rootScope','$window','$filter','QueryService','ShortlistService','CommonShareService','$modal', '$log','$timeout','getRateInfo','numberFilter','$q','$anchorScroll','myService','shareIdArrayService','isFeaturedService','ShareStatusShortlistService',function ($scope,$rootScope, $routeParams, $location, $rootScope, $window, $filter ,QueryService, ShortlistService,CommonShareService,$modal, $log, $timeout,getRateInfo,numberFilter,$q,$anchorScroll,myService,shareIdArrayService,isFeaturedService,ShareStatusShortlistService) {
	
	
	$rootScope.metakeywords = "graded,propell,details,observation,grade,beds,bath,car,size,rent,lease,cpx price,ipr,rental,review,free,estimate,report,contract,summary,independent,valuation,Depreciation,Population,capital,growth";
	
		//$scope.properties = PropertyService;
	$scope.id = $routeParams.id;
	
    $scope.subid = $routeParams.subid;
    $scope.baseWebUrl = baseWebUrl;
    $scope.baseAmazonUrl = baseAmazonUrl;
    $scope.selectedmenu=[{id:0,selected:true},{id:1,selected:false},{id:2,selected:false},{id:3,selected:false},{id:4,selected:false},{id:5,selected:false}];
        
	$scope.searchcriteria={};
    $scope.serverPath = baseWebUrl;
    
	var imgUrls = [];
	Object.size = function(obj) {
	    var size = 0, key;
	    for (key in obj) {
	        if (obj.hasOwnProperty(key)) size++;
	    }
	    return size;
	};
    
    
            
	 var idArray = shareIdArrayService.getIdArray();
	// Get the size of an object
		var size = Object.size(idArray);
		if (size != 0){
			$scope.searchcriteria = shareIdArrayService.getIdArray();	
            
		}
       	console.log("first"); 
    	console.log(idArray);
    
    
    
        
        
	var featured = isFeaturedService.getAsFeatured();
	//console.log(featured);
	//var size = Object.size(featured);
	
		$scope.searchcriteria.getonlyfeatured = featured;
		console.log($scope.searchcriteria.getonlyfeatured);
	
		
	$scope.shareCriteria = function(){
		//$scope.setpropertyIds = function (proids) {
			   
	    	shareIdArrayService.setIdArray($scope.searchcriteria);
		  // };
		//$scope.setpropertyIds($scope.propertyIds);   
		   
	}
	
	
	
	$scope.searchcriteria.id = $scope.id;
	
	//console.log( $scope.searchcriteria);
	
	
	
	//console.log($scope.shorlistedproperties);
	
	
	 $scope.shortListStatus = ShareStatusShortlistService.getStatusShortlist();
	// console.log("STATUS =>" + $scope.shortListStatus);
	 
	 
	 
	 $scope.shorlistedproperties = ShortlistService.getProducts();
	$scope.shorlistedPropIds = [];
	$scope.shorlistedPropIds.ids = [];
    angular.forEach($scope.shorlistedproperties, function(property, index) {
          $scope.shorlistedPropIds.ids.push(property.id);
        });
   
    $scope.shorlistedPropIds.status = $scope.shortListStatus;
   console.log($scope.shorlistedPropIds);
   
   
	
	//$scope.searchcriteria.shorlistedPropertyids = $scope.shorlistedPropIds;
   $scope.searchcriteria.shorlistedPropertyids = $scope.shorlistedPropIds.ids;
   $scope.searchcriteria.shorlistedPropertyStatus = $scope.shorlistedPropIds.status;
   
   
  /* $scope.checkIfStatusIsUndefined = function(){
	   if($scope.shortListStatus == undefined){
		   console.log("Shortlist status: UnDefined");
	   }
   }
	
   $scope.checkIfStatusIsUndefined();*/


  $scope.to = {};
//     $scope.currency2 = {};
  $scope.from = {}; 
  var searchaffordable = '';
    searchaffordable = shareIdArrayService.getIdArray();

    //console.log('here');
    //console.log(searchaffordable);
    
    if(searchaffordable != undefined && searchaffordable != '' ) 
        {
              
                $scope.to.currency = searchaffordable.tocurrency;
                          
    	     	$scope.countryflag = searchaffordable.tocurrency.code.toLowerCase().substr(0, 2);
                
               	$scope.countrylabel = searchaffordable.tocurrency.code;
        }
   
	QueryService.create($scope.searchcriteria).$promise.then(function(data) {
			 
		//console.log($scope.searchcriteria);
	$scope.properties = data.properties;	
			
	if(searchaffordable != undefined && searchaffordable != '' ) 
        {
              
                $scope.currencyObj = $scope.to.currency;

                var currentCurrencyIndex = _.findIndex($scope.currencies, {code: $scope.currencyObj.code})
                        
                $scope.to.currency = $scope.currencies[currentCurrencyIndex];
               
                           
    	     	
        }   	
		
	console.log($scope.properties);
	
	//$scope.properties = data.properties;	
		
	$scope.navigationState = 'tab-review';
	$rootScope.count = ShortlistService.getcount();
    //	$scope.preid = 0;
	$scope.propertieslength = $scope.properties.length;
	//var xyx = $filter('get-property-filter')($scope.properties, $scope.id);
	var current_index = $filter('get-property-filter')($scope.properties, $scope.id);
	//console.log(xyx);
	 	
	$scope.absurl = $location.absUrl();
	$scope.currentproperty = $scope.properties[current_index];
	
	$rootScope.imgurl = "https://propertycompass.s3.amazonaws.com/properties/5c7471a9-333f-4d73-a184-aafa57b5ba7c/images/image (1)4.jpg";
	$rootScope.des = "This is prop image";

	$scope.contactexist = false;
    $scope.ownerexist = false;
    angular.forEach($scope.currentproperty.contact, function(contact_arr, i) {
         if(contact_arr.display_val == undefined || contact_arr.display_val)
            $scope.contactexist = true;     
            
        if(contact_arr.type =='vendorDetails')
        {
            if(contact_arr.display_val !== undefined && contact_arr.display_val)
                $scope.ownerexist = true;     
        }                
    });             
    
   console.log("contactexist");	
   console.log($scope.contactexist);	 
   console.log("ownerexist");	
   console.log($scope.ownerexist);	   
     
	
	//console.log($scope.currentproperty.contact);
	//$scope.currentproperty = xyx;
	//console.log($scope.currentproperty.id);
	
	/*if($scope.currentproperty.gradestatus==2){
		$scope.navigationState = 'tab-review';
		console.log("graded" + $scope.navigationState);
	}
	else{
		$scope.navigationState = 'tab-notgraded';
		console.log("nongraded" + $scope.navigationState);
	}*/
	
	//myService.setMyData($scope.currentproperty.contact);
	CommonShareService.passid($scope.currentproperty);
	  //console.log( $scope.currentproperty);

    console.log("currentporpperty");	
    console.log( $scope.currentproperty);
    
    $scope.gradevalues = [1,2,3,4,5];
    $scope.grade_table_status=[{id:0,isopen:true}];	
    $scope.ipr_history = [];
    
    if($scope.currentproperty.gradestatus > 0)
    {
        angular.forEach($scope.currentproperty.iprs, function(iprs_arr, i) {
    
            var score = 0;
            
            grade_table_arr = [];
                                            
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
                                                                            
                grade_table_arr.push({ attr_name: grade.name, attr_score: grade.score, attr_val: attr_val});
                                                                                     
            });
            
            score = iprs_arr.results['0'].score;
            
            grade = iprs_arr.results['0'].grade;
                                    
            price_assessed = 'AUD $ '+iprs_arr.property.price;
            
            weekly_rent  = 'AUD $ '+iprs_arr.property.weeklyRent;
            
            publish_date = moment(iprs_arr.publishedAt,'YYYY-MM-DDThh:mm').format('DD MMM YYYY');
            
            days_old = iprs_arr.numberof_days_old;
        
            bed = iprs_arr.property.beds;
            bath = iprs_arr.property.baths;
            cars = iprs_arr.property.cars;                
            
            document_url = iprs_arr.downloadUri;

            if(i>0)
                $scope.grade_table_status.push({id:i,isopen:false});
            
            $scope.ipr_history.push({id:i, grade: grade, score: score, price_assessed: price_assessed, weekly_rent: weekly_rent, publish_date : publish_date, days_old : days_old, bed:bed, bath:bath, cars:cars, document_url:document_url,grade_table_arr:grade_table_arr});
        });
        
        console.log("ipr history");
        console.log( $scope.ipr_history);
        console.log("gradetablestatus");
        console.log( $scope.grade_table_status);
        
    }        

    $scope.show_grade_table = function(id){
        angular.forEach($scope.grade_table_status, function(grade_table_status, i) {
            
            if(i != id)
            {
                $scope.grade_table_status[i].isopen = false;
            }
            else
            {
                $scope.grade_table_status[i].isopen = true;
            }                           
            
        });    
        
        console.log("gradetablestatus");
        console.log( $scope.grade_table_status);
           
    }

	/*$scope.countryflag = 'au';
    $scope.countrylabel = 'AUD';*/
   
    $scope.defaultPI_LOANTERM = 30;
	$scope.defaultIO_LOANTERM = 5;
	$scope.defaultPI_RATE = 4.29;
	$scope.defaultIO_RATE = 4.29;
	$scope.default_costvalue = 5;
	
	$scope.currentproperty.short_currlabel = undefined;
	$scope.currentproperty.short_convcpx = undefined;
    $scope.currentproperty.short_convlisted = undefined;
    $scope.currentproperty.short_convsaving = undefined;
	
	$scope.caseflag = 'one';
	
	//title tag for html 
	
	$scope.flagset="|";
	if($scope.currentproperty.smsf == true){
		
		$scope.flagset=$scope.flagset+" SMSF |";
	}
   if($scope.currentproperty.domacom == true){
		
		$scope.flagset=$scope.flagset+" DomaCom |";
	}
	
	$rootScope.title= $scope.currentproperty.name+" | "+$scope.currentproperty.beds+" Beds | "+$scope.currentproperty.category+" | "+$scope.currentproperty.address[0].street+" | "+$scope.currentproperty.address[0].suburb.text+" | "+$scope.currentproperty.address[0].state+" | "+$scope.currentproperty.address[0].postcode+" | Australia "+$scope.flagset+" CPx";
	
   //$rootScope.title= $scope.currentproperty.name+" | "+$scope.currentproperty.beds+" Beds | "+$scope.currentproperty.category+" | "+$scope.currentproperty.address.street+" | "+$scope.currentproperty.address.suburb+" | "+$scope.currentproperty.address.state+" | "+$scope.currentproperty.address.postcode+" | Australia "+$scope.flagset+" CPx";
	
	
	
	if($scope.currentproperty.areaunit == 'squareMeter'){
		$scope.currentproperty.areaunit = 'm2';
	}
	else if($scope.currentproperty.areaunit == 'acre'){
		$scope.currentproperty.areaunit = 'acre';
	}
	else if($scope.currentproperty.areaunit == 'Hectare'){
		$scope.currentproperty.areaunit = 'ha';
	}
	else if($scope.currentproperty.areaunit == 'squareFeet'){
		$scope.currentproperty.areaunit = 'Sq Ft';
	}
	 
	
		 
		 $scope.nextid = data.nextpropIds;
		
		 //console.log("NEXT IS -> " +  $scope.nextid);
		
		
		 
		 $scope.preid = data.previouspropIds;
		
		 //console.log("PREVIOUS IS -> " +  $scope.preid);
		
	
	 
	
	/*//nextid
	
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
*/

	
	
	
//console.log($scope.currentproperty.floorplans.length);	   

	
   
 //default tab on details page
   
   if(!($scope.currentproperty.gradestatus && $scope.currentproperty.iprs.gradestatus>0)){
	   $scope.navigationState = 'tab-loan-cal';
	   $scope.refreshmap();
   }
   else{
	   
       if($scope.currentproperty.iprs.gradestatus==1)
            $scope.navigationState = 'tab-beinggraded';
       else if($scope.currentproperty.iprs.gradestatus==2)
           $scope.navigationState = 'tab-review'; 
	   $scope.refreshmap();
   }
   
   
   if($rootScope.scrolltoloan){
	   $scope.navigationState = 'tab-loan-cal';
	   $location.hash('loan-details');

		 $timeout(function() {
      	 $anchorScroll();     
     }, 2000);
   }
   
   $scope.gotoGradetab = function(status){
	   if(status == 1){$scope.navigationState = 'tab-beinggraded';}
	   else{ $scope.navigationState ='tab-review';}
	   
	   $scope.refreshmap();
   }
   
   $scope.gotoNotGradedtab = function(){
    
    
        if($scope.subid == 'gradeinfo')
        {
            $scope.navigationState = 'tab-notgraded';
            
            $location.hash('tab-notgraded');
            
            	 $timeout(function() {
              	 $anchorScroll();     
             }, 2000);
        }
   }
   
   /////////map
   
   
   //$scope.currentimages = $scope.currentproperty.images;
   $scope.currentimages = $scope.currentproperty.validImages;
   $scope.refreshslider();
   
	
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
			
			
		  //var urld = "https:\/\/propertycompass.s3.amazonaws.com\/properties\/a371de63-3c01-465e-8b4d-56e08f6d9909\/documents\/CPx Governance-Selling_Advertising Properties Brochure9SEPT5.pdf";
			
			$scope.getDocNameFromUrl = function(url) {
			   $scope.parts = url.split("/");
			    return (url.lastIndexOf('/') !== url.length - 1 ? $scope.parts[$scope.parts.length - 1] : $scope.parts[$scope.parts.length - 2]);
			}
			$scope.getDocExtension = function(url) {
				   $scope.parts = url.split(".");
				    return (url.lastIndexOf('.') !== url.length - 1 ? $scope.parts[$scope.parts.length - 1] : $scope.parts[$scope.parts.length - 2]);
				}
			
			//$scope.checkDocsUrl = $scope.getLastPart2($scope.getLastPart(urld));
			//console.log($scope.checkDocsUrl);
			 /*$scope.mydocsurl = [];
		      angular.forEach($scope.currentproperty.documents, function(doc, index) {
		    	 $scope.givenTitle = doc.title;
		    	  $scope.title = /[^/]*$/.exec(doc.url)[0];
		    	  $scope.mydocsurl.push({title: $scope.title, url:doc.url });
		      });
		      console.log( $scope.mydocsurl);	*/
		      			 
		      $scope.mydocsurl = [];
		      angular.forEach($scope.currentproperty.documents, function(doc, index) {
		    	  //$scope.givenTitle = doc.title;
                  console.log('url==> '+doc.url);
                  if(doc.url != "" && doc.url != null)
                  {
    		    	  $scope.docExtension = $scope.getDocNameFromUrl($scope.getDocExtension(doc.url));
    		    	  $scope.titleFromUrl = $scope.getDocNameFromUrl(doc.url);
                  
    		    	  if(doc.title != ""){
    		    		  $scope.givenTitle = doc.title;
    		    	  }
    		    	  else if($scope.docExtension == 'pdf' || $scope.docExtension == 'doc' || $scope.docExtension == 'docx'){
    		    		  $scope.givenTitle = $scope.getDocNameFromUrl(doc.url);
    		    	  }
    		    	  else{
    		    		  $scope.givenTitle = "Document " + (index + 1);
    		    	  }
    		    	  $scope.mydocsurl.push({ title: $scope.givenTitle , url:doc.url , urlTitle: $scope.titleFromUrl});
		    	  }
		      });
		      console.log( $scope.mydocsurl);
		  
			//call to set base scenario
    	    $scope.setbasescenario($scope.currentproperty);   
		  
	       $scope.currentproperty.scena.loanterm = 5;
          
            //var searchaffordable = '';
            //searchaffordable = angular.fromJson(sessionStorage.searchAffordableVal);
            
            //console.log('se');
            //console.log(searchaffordable);
            //console.log($scope.currentproperty);
            //console.log('se1');
                
                if(searchaffordable != '' ) 
                {
                                
                    $scope.updateValueAll($scope.from, $scope.to, $scope.currentproperty);
                    
                }
          
          
          
          
		  //console.log(($scope.currentproperty.inspectionTimes[0].inspection).slice(12));
		  
    	    //console.log($scope.currentproperty.auction_date.length!=0);
    	    //$scope.format = 'M/d/yy h:mm:ss a';
    	    
    	    //.format('dddd DD MMM YYYY')
    	    
    	   // moment(currentproperty.inspectionTimes.inspection.slice(0,11), "YYYY-MM-DD HH:mm");
    	   var inspect = [];
    	   
    	   
    	   if($scope.currentproperty.inspectionTimes.length!=0){
    		   //console.log($scope.currentproperty.inspectionTimes.length);
    	    angular.forEach($scope.currentproperty.inspectionTimes, function(inspector, index) {
    	    	//inspect.push(inspector.inspection.slice(0,11));
    	    	//inspect.push(moment(inspector.inspection.slice(0,11)));
    	    	var str = inspector.inspection.slice(0,11);
    	       var res = str.replace(/-/g, "/");
    	       var formattedinspect = moment(res , 'DD/MMM/YYYY').format('MM/DD/YYYY')
    	       //console.log(res);
    	       //console.log(formattedinspect);
    	    	inspect.push({label :moment(formattedinspect), time : inspector.inspection.slice(12)});
  	        });
    	   }
    	   inspect.sort(function(a, b){

    	       if(a.label > b.label){
    	        return 1;
    	       }
    	        else if(a.label < b.label){
    	        return -1;
    	       } 
    	       return 0;
    	       });
    	   //console.log(inspect);
    	   
    	  
    	    
    	     var inspect3 = [];
    	    angular.forEach(inspect , function(dateobj , index) {
    	    	inspect3.push({label : moment(dateobj.label).format('dddd DD MMM YYYY') , time : dateobj.time});
  	        });
    	    
    	    $scope.inspect3 = inspect3;
    	    //$scope.currentproperty.auction_date  = "2017-02-22";
			 if($scope.currentproperty.auction_date.length!=0){
			 var s =  $scope.currentproperty.auction_date;
			    $scope.parsedDate = {            
			        DDt: Date.parse(s)
			    }
			    var df = 'MM/DD/YYYY'
			    var d1 = moment($scope.currentproperty.auction_date , "YYYY-MM-DD-hh:mm:ss");

			    var d2 =  moment();
			  
			    var days1 = Math.round(moment.duration(d1.diff(d2)).asDays());
			  
			    $scope.days = days1;
			    console.log("auction days to go "+$scope.days);
			    if($scope.days > 0){
			    	$scope.auctionstatus = 'yes';
			    }
			    else if($scope.days < 0){
			    	$scope.auctionstatus = 'no';
			    }
			    else if($scope.days == 0){
			    	$scope.auctionstatus = 'today';
			    }
                console.log("auction status "+$scope.auctionstatus);
			    //console.log(days1);
			    
			    
			 }
			 if($scope.currentproperty.auction_date.length!=0){
				 var auction_dateformatted =  $scope.currentproperty.auction_date;
				 
				 var newauct = moment(auction_dateformatted , "YYYY-MM-DD-hh:mm:ss").format('DD MMM YYYY h:mm A');
				 
				 //console.log(newauct);
				 
				 $scope.auctionDate = newauct;
				 
				 }
			 
			 /*$scope.newSlides = [];
			 $scope.imgurls = ['https://www.google.co.in/images/nav_logo242.png' ,
			                   'http://cdn.sstatic.net/stackoverflow/img/sprites.svg?v=a7723f5f7e59 ' ,
			                   'iuiui/djdjd.png'];
			                   
			                  $scope.tp = function(){
			                   
			                     angular.forEach($scope.currentproperty.images, function(image, index) {
			                     
			                   
			                         Utils.isImage(image.url).then(function(result) {
			                             $scope.result = result;
			                             if(result === true){
			                               $scope.newSlides.push({id : image.id , url : image.url});
			                             }
			                             console.log(result);
			                         });
			                        
			                         
			                          return $scope.result;
			                     
			                     
			                   });
			                   $timeout(function() {
			                          console.log($scope.newSlides);
			                          
			                          if($scope.newSlides.length == 0){
					                	   $scope.newSlides = [{id : 0 , url :'images/nophotoavailable.png'}];
					                   }
			                     }, 9000);
			                  
			                  
			                   
			                   
			                  }
			                  $scope.tp();*/
			                   
			 
			
			 $scope.$broadcast('dataloaded');
		     
             
              		
			 
	});
   
	
	
	
	
	
	$scope.goToNextProperty = function () {
		Object.size = function(obj) {
		    var size = 0, key;
		    for (key in obj) {
		        if (obj.hasOwnProperty(key)) size++;
		    }
		    return size;
		};

		
		
		var idArray = [];
		 
		 var idArray = shareIdArrayService.getIdArray();
		
		//$scope.propertyIds = shareIdArrayService.getIdArray();
		
		// Get the size of an object
			var size = Object.size(idArray);
		   
		 console.log(idArray);		
		 
		 
		 QueryService.create(idArray).$promise.then(function(data) {
			 
			$scope.nexrprops = data.properties;
			
			console.log($scope.nexrprops);
		 });
		
	}
	
	
   
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
				    
                    
                    $scope.toggle_enquire_servicerequest = function (val) {
						  sessionStorage.toggle_val = angular.toJson(val);

					  };

				  //pass enquiry 	  
					  
					  $scope.passenquiry = function (printid) {
							
						$rootScope.shownothing = false;
						//  console.log(printid);
						  CommonShareService.passenquireid(printid);
					  };
					   $scope.passbuythis = function (printid) {
							
						$rootScope.shownothing = false;
						// console.log(printid);
						  CommonShareService.passbuythisid(printid);
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
															
						   $scope.testiframe =function(){
							   $scope.iframevisible = true	;
						   }
						   
							
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
		  
   	  $scope.changeCurrency = function(){
   		if($scope.searchcriteria.tocurrency){
	   		$scope.currencyObj = $scope.searchcriteria.tocurrency;
	     	 var currentCurrencyIndex = _.findIndex($scope.currencies, {code: $scope.currencyObj.code})   		  
	   		  //console.log($scope.currencies[currentCurrencyIndex]);
	     	$scope.to.currency = $scope.currencies[currentCurrencyIndex];
	     	$scope.countryflag = $scope.to.currency.code.toLowerCase().substr(0, 2);
	     	$scope.countrylabel = $scope.to.currency.code;
	     	//console.log("IN IF");
   		}
   		else{
   		 $scope.countryflag = 'au';
		  $scope.countrylabel = 'AUD';
   			$scope.from.currency = $scope.currencies[7];
   	     $scope.to.currency = $scope.currencies[7];
   	  //console.log("In else");
   		}
   	  }
     
   	 
			
			    
			   $scope.dollarflag = true;
	     	      function getRate(currency) {
	     	        return currency && currency.rate;
	     	      }

	     	      // Grab the promises from the two calls  
                  var namesPromise = getRateInfo();
                  //var ratesPromise = getRateInfo('latest');
	     	      

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
	     	    	          
	     	    	          //$scope.copycurr = $scope.currencies;
	     	    	          
	     	    	          //console.log(rate*multiplier);
	     	    	        });
	     	    	      
	     	    	        
	     	    	       
	     	    	       //console.log($scope.copycurr);
	     	    	        
	     	    	         // set default currency as AUD
	     	    	       /* $scope.from.currency = $scope.currencies[7];
	     	    	        $scope.to.currency = $scope.currencies[7];*/
	     	    	      $scope.from.currency = $scope.currencies[7];
	     	    	        
                      //console.log($scope.searchcriteria);
                      $scope.changeCurrency();
                     /* window.onload = function() {
                    	  $scope.changecurr();
                    	};*/
                      
                   
                      //$scope.chnageCurrency();
	     	        
	     	      });

	     	      
	     	      
	     	      $scope.updateValueAll = function(from, to, item, isTopconvertor) {
	     	    	  
	     	    	 //console.log(from, to); 	
	     	    	 $scope.countryflag = to.currency.code.toLowerCase().substr(0, 2);
	 		    	 $scope.countrylabel = to.currency.code;
	     	    	
	 		  
	 		    		
			    		item.short_currlabel = to.currency.code;

			    		if(to.currency.code == "AUD"){item.short_currlabel = undefined;}  
	 		    		
			    		item.short_convcpx = item.cpxprice / getRate(from.currency) * getRate(to.currency);
                        
                          
                        item.short_convlisted = item.listedprice / getRate(from.currency) * getRate(to.currency);
                        
                        item.short_convsaving = item.saving / getRate(from.currency) * getRate(to.currency);
			    		console.log(item);
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
			    		
			    		
	               
			    
	     	      
	     	      };   

			
			
		////////////loan-view
     	     
     	     
     	     
     	     
 	     	//////loan view table data
    	      

    	      $scope.isCollapsedflag = false;   

    	      $scope.setiscreate = function(){

    	    	  $scope.iscreate= true;
    	    	 $scope.editflag=null;
    	    	$scope.editingname=null;
                
                $scope.currentproperty.scena.loanterm = 5;                                
    	      }

    	      $scope.typeselected = 'IO'; 
    	      
              $scope.isIOselected = function(value){

    	    	  $scope.typeselected = value;
                    
                    if(value == 'IO')
                    {
                        $scope.currentproperty.scena.loanterm = 5;
                    }
                    else if(value == 'PI')
                    {
                        $scope.currentproperty.scena.loanterm = 30;
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

    	    	 // console.log(graph);
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
    	    	  console.log("sponsor");
                  console.log(prop.sponsors.IO)
                        	    	 
                 
                    //base IO
    	    	  var Base = {}; 
                  
                  if(prop.sponsors.IO !=undefined)
                 {
                  
    	    	  //Base.name = '<div display="flex">Base IO, jidhuegiowshhgeuiiehhyei</div>';
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
   	    		  
   	    		  
   	    		  
   	    		 // $scope.clearscenario(property,scena);

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
    	    
	     
	      $scope.myModel = {
	              Url: 'http://jasonwatmore.com/post/2014/08/01/AngularJS-directives-for-social-sharing-buttons-Facebook-Like-GooglePlus-Twitter-and-Pinterest.aspx',
	              Name: "AngularJS directives for social sharing buttons - Facebook, Google+, Twitter and Pinterest | Jason Watmore's Blog", 
	              ImageUrl: 'http://www.jasonwatmore.com/pics/jason.jpg'
	          };
	      

	     
		    	 
	 

}]);