var landlordServices = angular.module('landlordServices', ['ngResource']);
landlordServices.factory('ContactService',['$resource', function ($resource) {
   //return $resource('http://localhost/cpx/cpx.server/Contactforms', {}, {
	 //return $resource('http://staging.api.centralpropertyexchange.com.au/Contactforms', {}, {
	return $resource(baseWebUrl  + '/Contactforms', {}, {
    	
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' }
    });
}]);

landlordServices.factory('RegisterService',['$resource', function ($resource) {
   //return $resource('http://localhost/cpx/cpx.server/Contactforms', {}, {
	 //return $resource('http://staging.api.centralpropertyexchange.com.au/Contactforms', {}, {
	return $resource(baseWebUrl  + '/Auth/register', {}, {
    	
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' }
    });
}]);

landlordServices.factory('EnquireService',['$resource', function ($resource) {
   //return $resource('http://localhost/cpx/cpx.server/Contactforms', {}, {
	 //return $resource('http://staging.api.centralpropertyexchange.com.au/Contactforms', {}, {
	return $resource(baseWebUrl  + '/Contactforms/enquire', {}, {
    	
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' }
    });
}]);

landlordServices.factory('ServiceRequestService',['$resource', function ($resource) {
   //return $resource('http://localhost/cpx/cpx.server/Contactforms', {}, {
	 //return $resource('http://staging.api.centralpropertyexchange.com.au/Contactforms', {}, {
	return $resource(baseWebUrl  + '/Contactforms/servicerequest', {}, {
    	
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' }
    });
}]);


landlordServices.factory('BuyThisPropertyService',['$resource', function ($resource) {
   //return $resource('http://localhost/cpx/cpx.server/Contactforms', {}, {
	 //return $resource('http://staging.api.centralpropertyexchange.com.au/Contactforms', {}, {
	return $resource(baseWebUrl  + '/Contactforms/buythisproperty', {}, {
    	
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' }
    });
}]);

landlordServices.factory('RequestIprService',['$resource', function ($resource) {
	
    //return $resource('http://localhost/cpx/cpx.server/requestipr', {}, {
	//return $resource('http://staging.api.centralpropertyexchange.com.au/Requestipr', {}, {
	return $resource(baseWebUrl  + '/Requestipr', {}, {
		
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' }
        
        
    });
}]);




landlordServices.factory('ShareMailService',['$resource', function ($resource) {
    //return $resource('http://localhost/cpx/cpx.server/Sharewithemail', {}, {
	//return $resource('http://staging.api.centralpropertyexchange.com.au/Sharewithemail', {}, {
	return $resource(baseWebUrl  + '/Sharewithemail', {}, {
    	
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' }
    });
}]);




app.service('CommonShareService', function() {
	  
	var CommonShareService ={};
	
	CommonShareService.id = null;
	
	CommonShareService.checkall = false;
	
	CommonShareService.gorate = false;
	
	CommonShareService.gorate2 = false;
	var printid = 0;
	
	  
	CommonShareService.currencyNames = {"AED":"Arab Emirates Dirham","AFN":"Afghanistan Afghani","ALL":"Albanian Lek","AMD":"Armenian Dram","ANG":"Netherlands Antillean Guilder","AOA":"Angolan Kwanza","ARS":"Argentine Peso","AUD":"Australian Dollar","AWG":"Aruban Guilder","AZN":"Azerbaijan New Manat","BAM":"Bosnia-Herzegovina Convertible Mark","BBD":"Barbados Dollar","BDT":"Bangladeshi Taka","BGN":"Bulgarian Lev","BHD":"Bahraini Dinar","BIF":"Burundi Franc","BMD":"Bermudian Dollar","BND":"Brunei Dollar","BOB":"Boliviano","BRL":"Brazilian Real","BSD":"Bahamian Dollar","BTN":"Bhutan Ngultrum","BWP":"Botswana Pula","BYR":"Belarussian Ruble","BZD":"Belize Dollar","CAD":"Canadian Dollar","CDF":"Congolese Franc","CHF":"Swiss Franc","CLF":"Unidad de Fomento","CLP":"Chilean Peso","CNH":"Offshore Yuan Renminbi","CNY":"Yuan Renminbi","COP":"Colombian Peso","CRC":"Costa Rican Colon","CUP":"Cuban Peso","CVE":"Cape Verde Escudo","CZK":"Czech Koruna","DJF":"Djibouti Franc","DKK":"Danish Krone","DOP":"Dominican Peso","DZD":"Algerian Dinar","EGP":"Egyptian Pound","ERN":"Eritrean Nakfa","ETB":"Ethiopian Birr","EUR":"Euro","FJD":"Fiji Dollar","FKP":"Falkland Islands Pound","GBP":"Pound Sterling","GEL":"Georgian Lari","GHS":"Ghanaian Cedi","GIP":"Gibraltar Pound","GMD":"Gambian Dalasi","GNF":"Guinea Franc","GTQ":"Guatemalan Quetzal","GYD":"Guyana Dollar","HKD":"Hong Kong Dollar","HNL":"Honduran Lempira","HRK":"Croatian Kuna","HTG":"Haitian Gourde","HUF":"Hungarian Forint","IDR":"Indonesian Rupiah","IEP":"Irish Pound (replaced by EUR)","ILS":"Israeli New Shekel","INR":"Indian Rupee","IQD":"Iraqi Dinar","IRR":"Iranian Rial","ISK":"Iceland Krona","JMD":"Jamaican Dollar","JOD":"Jordanian Dinar","JPY":"Japanese Yen","KES":"Kenyan Shilling","KGS":"Kyrgyzstani Som","KHR":"Kampuchean Riel","KMF":"Comoros Franc","KPW":"North Korean Won","KRW":"Korean Won","KWD":"Kuwaiti Dinar","KYD":"Cayman Islands Dollar","KZT":"Kazakhstan Tenge","LAK":"Lao Kip","LBP":"Lebanese Pound","LKR":"Sri Lanka Rupee","LRD":"Liberian Dollar","LSL":"Lesotho Loti","LTL":"Lithuanian Litas","LVL":"Latvian Lats","LYD":"Libyan Dinar","MAD":"Moroccan Dirham","MDL":"Moldovan Leu","MGA":"Malagasy Ariary","MKD":"Macedonian Denar","MMK":"Myanmar Kyat","MNT":"Mongolian Tugrik","MOP":"Macau Pataca","MRO":"Mauritanian Ouguiya","MUR":"Mauritius Rupee","MVR":"Maldive Rufiyaa","MWK":"Malawi Kwacha","MXN":"Mexican Nuevo Peso","MXV":"Mexican Unidad de Inversion","MYR":"Malaysian Ringgit","MZN":"Mozambique Metical","NAD":"Namibian Dollar","NGN":"Nigerian Naira","NIO":"Nicaraguan Cordoba Oro","NOK":"Norwegian Krone","NPR":"Nepalese Rupee","NZD":"New Zealand Dollar","OMR":"Omani Rial","PAB":"Panamanian Balboa","PEN":"Peruvian Nuevo Sol","PGK":"Papua New Guinea Kina","PHP":"Philippine Peso","PKR":"Pakistan Rupee","PLN":"Polish Zloty","PYG":"Paraguay Guarani","QAR":"Qatari Rial","RON":"Romanian New Leu","RSD":"Serbian Dinar","RUB":"Russian Ruble","RWF":"Rwanda Franc","SAR":"Saudi Riyal","SBD":"Solomon Islands Dollar","SCR":"Seychelles Rupee","SDG":"Sudanese Pound","SEK":"Swedish Krona","SGD":"Singapore Dollar","SHP":"St. Helena Pound","SLL":"Sierra Leone Leone","SOS":"Somali Shilling","SRD":"Surinam Dollar","STD":"S\u00e3o Tom\u00e9 and Pr\u00edncipe Dobra","SVC":"El Salvador Colon","SYP":"Syrian Pound","SZL":"Swaziland Lilangeni","THB":"Thai Baht","TJS":"Tajik Somoni","TMT":"Turkmenistani Manat","TND":"Tunisian Dollar","TOP":"Tongan Pa'anga","TRY":"Turkish Lira","TTD":"Trinidad and Tobago Dollar","TWD":"Taiwan Dollar","TZS":"Tanzanian Shilling","UAH":"Ukraine Hryvnia","UGX":"Uganda Shilling","USD":"US Dollar","UYU":"Uruguayan Peso","UZS":"Uzbekistan Sum","VEF":"Venezuelan Bolivar","VND":"Vietnamese Dong","VUV":"Vanuatu Vatu","WST":"Samoan Tala","XAF":"CFA Franc BEAC","XAG":"Silver Ounce","XAU":"Gold Ounce","XBT":"Bitcoin","XCD":"East Caribbean Dollar","XCP":"Ounces of Copper","XDR":"IMF Special Drawing Rights","XOF":"CFA Franc BCEAO","XPD":"Palladium Ounce","XPF":"CFP Franc","XPT":"Platinum Ounce","YER":"Yemeni Rial","ZAR":"South African Rand","ZMW":"Zambian Kwacha","ZWL":"Zimbabwe Dollar"};
	
	var getcurrencyNames = function() {
		  
		  return CommonShareService.currencyNames;
			   
		 }
	
	 
	
	
	
	  var passid = function(newid) {
		
		var  printid = newid;
		
		sessionStorage.CommonShareService = angular.toJson(printid); 	   
		 }
	 
	  var getid = function() {
		
		  printid = angular.fromJson(sessionStorage.CommonShareService);
		  
		  return printid;
			   
		 }
	  
	 
	  
	  
	  
	  var passenquireid = function(id) {
			
		  CommonShareService.checkall = false;
		  CommonShareService.id = id;
		 // console.log("check enq id"+CommonShareService.id);
			
		   
			 }
	  
	  
	  var getenquireid = function() {
			
		  
		  
		 // console.log("check get eng"+CommonShareService.id);
		  return CommonShareService.id;
			   
		 }
	  
	  
	  var passallid = function() {
			
		  CommonShareService.checkall = true;
			
			 }
	  
	  
	  
	  var getallid = function() {
				
		//  CommonShareService.id = null;
		//	  console.log("check all"+CommonShareService.checkall);
			  return CommonShareService.checkall;
				   
			 }
	  
	  
	  var passblogprintid = function(page) {
			
			var  blogprintid = page;
			
			sessionStorage.CommonShareService = angular.toJson(blogprintid); 	   
			 }
		 
		  var getblogprintid = function() {
			
			  blogprintid = angular.fromJson(sessionStorage.CommonShareService);
			  
			  return blogprintid;
				   
			 }
	  
	  
		  
		  var passgotorate = function() {
				
			  CommonShareService.gorate = true;
				 }
			 
			  var getgotorate = function() {
				
				  return CommonShareService.gorate;
					   
				 }
		  
			  
			  var passgotorate2 = function() {
					
				  CommonShareService.gorate2 = true;
					
				 }
				 
				  var getgotorate2 = function() {
						  
					  return CommonShareService.gorate2;
						   
					 }
                     
			  var passbuythisid = function(page) {
			
    			var  buythisid = page;
    			
    			sessionStorage.CommonShareService = angular.toJson(buythisid); 	   
    			 }
    		 
    		  var getbuythisid = function() {
    			
    			  buythisid = angular.fromJson(sessionStorage.CommonShareService);
    			  
    			  return buythisid;
    				   
    			 } 
	  
	  
   return {
	   	  getcurrencyNames: getcurrencyNames,
		  passid: passid,
		  getid: getid,
		  passenquireid: passenquireid,
		  getenquireid: getenquireid,
		  passallid: passallid,
		  getallid:getallid,
		  passblogprintid:passblogprintid,
		  getblogprintid:getblogprintid,
		  passgotorate:passgotorate,
		  getgotorate:getgotorate,
		  passgotorate2:passgotorate2,
		  getgotorate2:getgotorate2,
           passbuythisid:passbuythisid,
          getbuythisid:getbuythisid
	  };

	});

app.service('shareIdArrayService', function() {
    /*this.idArray = [];

    this.setIdArray = function(ids) {
        //this.idArray = idArray;
    	 this.idArray = ids;
    }

    this.getIdArray = function() {
        return this.idArray;
    };*/

	
	 var setIdArray = function(newids) {
			
			var  proids = newids;
			
			sessionStorage.shareIdArrayService = angular.toJson(proids); 	   
			 }
		 
		  var getIdArray = function() {
			
			  proids = angular.fromJson(sessionStorage.shareIdArrayService);
			  
			  return proids;
				   
			 }
		  
		  var clearIdArray = function(newids) {
				
			  var  proids = [];
				
				sessionStorage.shareIdArrayService = angular.toJson(proids); 
				   
			 }
		  return {
		   	 
			  setIdArray: setIdArray,
			  getIdArray: getIdArray,
			  clearIdArray: clearIdArray
		  }

});

app.service('isFeaturedService', function() {
    /*this.idArray = [];

    this.setIdArray = function(ids) {
        //this.idArray = idArray;
    	 this.idArray = ids;
    }

    this.getIdArray = function() {
        return this.idArray;
    };*/

	
	 var setAsFeatured = function(newids) {
			
			var  featuredids = newids;
			
			sessionStorage.isFeaturedService = angular.toJson(featuredids); 	   
			 }
		 
		  var getAsFeatured = function() {
			
			  featuredids = angular.fromJson(sessionStorage.isFeaturedService);
			  
			  return featuredids;
				   
			 }
		  return {
		   	 
			  setAsFeatured: setAsFeatured,
			  getAsFeatured: getAsFeatured
		  }

});




app.service('ShortlistService', function() {
	  var propertyList = [];
	  
	  
	  var addProduct = function(newObj) {
		
		  propertyList = angular.fromJson(sessionStorage.ShortlistService); 
		  
		 if(propertyList != undefined){
		  
			  
			 var flag = false;
			  for(i=0;i<propertyList.length;i++){
				  
				  if(propertyList[i].id == newObj.id){
				 
					  flag = true;
					  break;
			  }}
			 
			  if(flag == false){propertyList.push(newObj);}
			   
		 
		 }
		 else{
			 var propertyList = [];
			 propertyList.push(newObj);}
		  
		 sessionStorage.ShortlistService = angular.toJson(propertyList); 
		  
	//	 console.log(propertyList);
		 return propertyList.length;
	  }

	  var getProducts = function(){
		  
		  propertyList = angular.fromJson(sessionStorage.ShortlistService);
	     
		  return propertyList;
	  }
	  
    var removeProduct = function(index){
		  
  	//  console.log(index,propertyList);
  	  propertyList.splice(index, 1);
  	  sessionStorage.ShortlistService = angular.toJson(propertyList); 
  	  return propertyList;
    }
	  
    var clearshortlist = function(){
		  
  	  
  	  propertyList = [];
  	  sessionStorage.ShortlistService = angular.toJson(propertyList); 
  	  return propertyList;
    }
    
    var getcount = function(){
		 
  	  propertyL = angular.fromJson(sessionStorage.ShortlistService);
  	  if(propertyL == undefined){
  		 return 0; 
  	  }else
  	  
  	  return propertyL.length;
    }
    
	  

	  return {
	    addProduct: addProduct,
	    getProducts: getProducts,
	    removeProduct: removeProduct,
	    clearshortlist: clearshortlist,
	    getcount: getcount
	  };

	});

app.service('ShareStatusShortlistService', function() {
	var statusShortlist ;
	 var setStatusShortlist = function(status){
		  
   	  
    	  statusShortlist = status;
    	  sessionStorage.ShareStatusShortlistService = angular.toJson(statusShortlist); 
    	  return statusShortlist;
      }
    var getStatusShortlist = function(){
		  
    	statusShortlist = angular.fromJson(sessionStorage.ShareStatusShortlistService);
	     
		  return statusShortlist;
	  }
    
    return {
	    setStatusShortlist: setStatusShortlist,
	    getStatusShortlist: getStatusShortlist
	  };
    
});
/*landlordServices.factory('PropertyService',['$http', function($http) {
 
	// return $http.get('./js/app/realproperties.json');
	//return $http.get('./js/app/properties.json');
}]);*/

/*landlordServices.factory('SearchService',['$http', function($http) {
	 
	 //return $http.get(baseWebUrl  +'/beta/Search');
	//return $http.get('http://staging.api.centralpropertyexchange.com.au/Search');
	return $http.get('http://localhost/cpx/cpx.server/Search/searchquery');
	
	
}]);*/

landlordServices.factory('QueryService',['$resource', function ($resource) {
    //return $resource('http://localhost/cpx/cpx.server/Search', {}, {
    	 //return $resource('http://staging.api.centralpropertyexchange.com.au/Search', {}, {	
	return $resource(baseWebUrl  + '/Search', {}, {
        query: { method: 'GET', isArray: true },
        create: { method: 'POST' },
        success:{}
    });
}]);

landlordServices.factory('endorsementservice',['$resource', function ($resource) {
	return $resource(baseWebUrl  + '/Search/fetchEndorsements', {}, {
        success:{}
    });
}]);

app.service('myService', function() {
    this.myData = [];

    this.setMyData = function(myData) {
        this.myData = myData;
    };

    this.getMyData = function() {
        return this.myData;
    };
});



/*app.service('sideMenuStatus', function () {
    var showsidemenu = true;

    return {
        getShowsidemenu: function () {
            return showsidemenu;
        },
        setShowsidemenu: function(value) {
        	showsidemenu = value;
        }
    };
});
*/

