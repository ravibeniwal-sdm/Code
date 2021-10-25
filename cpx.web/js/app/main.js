
var app = angular.module('landlordWebApp', ['ngRoute', 'landlordServices', 'uiGmapgoogle-maps', 'ui.bootstrap', 'digitalfondue.dftabmenu', 'angular.filter','ngSanitize', 'open-exchange-rates','decimal-places','ngMap','chart.js','nsPopover','angulartics','angulartics.google.analytics','vcRecaptcha','angularFileUpload','pascalprecht.translate']);

/**
 * Configure the Routes
 */

app.config(['$translateProvider', function ($translateProvider) {
$translateProvider.useStaticFilesLoader({
    prefix: 'js/locale-',
    suffix: '.json'
});
$translateProvider.preferredLanguage('en');
}]);


app.config(['$routeProvider','$locationProvider', function ($routeProvider,$locationProvider) {
  $routeProvider
    // Home

   
    .when("/", {templateUrl: "views/home.html", controller: "HomePageCtrl"})
    
    .when("/view-graded-properties/", {templateUrl: "views/properties.html", controller: "PropertiesCtrl"})
    .when("/view-graded-properties/:type", {templateUrl: "views/properties.html", controller: "PropertiesCtrl"})
    .when("/view-graded-properties/:type/:searchid", {templateUrl: "views/properties.html", controller: "PropertiesCtrl"})
    
    .when("/list-your-property-on-cpx/:pid", {templateUrl: "views/submitproperty.html", controller: "ListCtrl"})
    .when("/order-independent-reports", {templateUrl: "views/orderreports.html", controller: "DefaultCtrl"})
    .when("/details/:id", {templateUrl: "views/details.html", controller: "DetailsCtrl"})
    .when("/details/:id/:subid", {templateUrl: "views/details.html", controller: "DetailsCtrl"})
    .when("/industry/:pid", {templateUrl: "views/industry_professional.html", controller: "AboutCtrl"})
    .when("/cpx", {templateUrl: "views/cpx.html", controller: "AboutCtrl"})
    .when("/contact", {templateUrl: "views/contact_us.html", controller: "ContactCtrl"})
    .when("/enquire", {templateUrl: "views/enquire.html", controller: "EnquireCtrl"})
    .when("/about/:pid", {templateUrl: "views/cpx.html", controller: "AboutCtrl"})
    .when("/shortlist", {templateUrl: "views/shortlist.html", controller: "ShortlistCtrl"})
    .when("/service_request", {templateUrl: "views/service_request.html", controller: "ServiceRequestCtrl"})
    .when("/buy_this_property", {templateUrl: "views/buy_this_property.html", controller: "BuyThisPropertyCtrl"})
    .when("/buy_this_property/:pid", {templateUrl: "views/buy_this_property_email.html", controller: "BuyThisPropertyCtrl"})
    .when("/submit_property_request", {templateUrl: "views/submit_property_request.html", controller: "SubmitPropertyRequestCtrl"})
     .when("/list_ur_property", {templateUrl: "views/list_ur_property_form.html", controller: "ListYourPropertyCtrl"})
     .when("/submit-free-membership-form", {templateUrl: "views/sumbit_free_membership_request.html", controller: "SubmitFreeMembershipCtrl"})
     .when("/submit-service-request", {templateUrl: "views/submit_service_request.html", controller: "SubmitServiceRequestCtrl"})
     
     .when("/request-free-ipr/", {templateUrl: "views/request-free-ipr.html", controller: "RequestFreeIprCtrl"})
     
    .when("/terms-and-conditions", {templateUrl: "views/terms_and_condition.html", controller: "DefaultCtrl"})
    .when("/response-to-ipr-request/:pid", {templateUrl: "views/response-to-ipr-request.html", controller: "DefaultCtrl"})
    .when("/privacy", {templateUrl: "views/privacy.html", controller: "DefaultCtrl"})

    .when("/blog/:pid/:subid", {templateUrl: "views/blog.html", controller: "AboutCtrl"})
    
    .when("/public-speaking-profiles/:pid", {templateUrl: "views/public_speaking_profiles.html", controller: "AboutCtrl"})

    .when("/marketplace/:pid", {templateUrl: "views/cpxmarketplace.html", controller: "AboutCtrl"})
    .when("/freesummary", {templateUrl: "views/freesummary.html", controller: "DefaultCtrl"})
    .when("/list-Login", {templateUrl: "views/list_ur_property_login.html", controller: "ListUrPropertyLoginCtrl"})
    .when("/dashboard_list_ur_property", {templateUrl: "views/Admin/dashboard_logged_in_user.html", controller: "dashBoardCtrl"})
    .when("/:searchid", {templateUrl: "views/properties.html", controller: "PropertiesCtrl"})
    .otherwise("/404", {templateUrl: "views/404.html", controller: "ErrorPageCtrl"});

    
  
  
  
  
  
  
  $locationProvider.hashPrefix('!');
  
}]);


	
	





app.run(['$rootScope','$location','$anchorScroll','$routeParams' , function($rootScope, $location, $anchorScroll, $routeParams) {
	  $rootScope.$on('$routeChangeSuccess', function(newRoute, oldRoute) {
	    $location.hash($routeParams.scrollTo);
	   $anchorScroll();  
	  });
	  
            
	  
	  $rootScope.gotoLocation= function(){
			if($routeParams.scrollTo == "iptag"){
			$location.hash($routeParams.scrollTo);
			$anchorScroll(); 
			}
		 };
	}]);





app.config(['getRateInfoProvider', function(getRateInfoProvider) {
	  getRateInfoProvider.apiKey = 'cdc2e1b0f06c4250af77c691bf51106d';
	}])

	
	app.config(['ChartJsProvider', function (ChartJsProvider) {
    // Configure all charts
    ChartJsProvider.setOptions({
      colours: ['#FF5252', '#FF8A80'],
      responsive: true
    });
    // Configure all line charts
    ChartJsProvider.setOptions('Line', {
      datasetFill: false
    });
  }])
	
  
  app.factory('Utils', function($q) {
    return {
        isImage: function(src) {
        
            var deferred = $q.defer();
        
            var image = new Image();
            image.onerror = function() {
                deferred.resolve(false);
            };
            image.onload = function() {
                deferred.resolve(true);
            };
            image.src = src;
        
            return deferred.promise;
        }
    };
});
  

  
/*app.factory('sideMenuStatus', function(){

	var sideMenuStatus = false;
	
});  */
  
  
  
  /* app.config(['reCAPTCHAProvider',(function (reCAPTCHAProvider) {
            // required: please use your own key :)
            reCAPTCHAProvider.setPublicKey('6LeeeAoTAAAAADJtB95fd7tDeXLMk1kajrFd6d37');
            
            // optional: gets passed into the Recaptcha.create call
            reCAPTCHAProvider.setOptions({
                theme: 'clean'
            });
        }])  */