angular.module('open-exchange-rates', [])

.constant('openExchangeRatesUrl','http://openexchangerates.org/api/')


// Provide a factory function that will be called to create a singleton getRateInfo service
.provider('getRateInfo', function() {
  var self = this;

  // A placeholder for the api, which will be inserted at config time
  self.apiKey = null;

  // $get is the factory for the service
  this.$get = ['openExchangeRatesUrl', '$http', function(openExchangeRatesUrl, $http) {
	   
    return function(request) {
    	
    	
    	
    	//alert('sending the req');
    	
    	// return $http.jsonp('http://jsonrates.com/get/?%20base=AUD&apiKey=jr-4ba121559322aa8f7622511ba874a6dc&callback=JSON_CALLBACK')
      /*return $http.jsonp('http://apilayer.net/api/live?access_key=177e1790f060d8d2b03fed9b8dd17000&callback=JSON_CALLBACK')*/
    	return $http.get('./js/app/mydata.json')
        .then(function (response) { 
        	//alert('req sent');
        	//console.log(response.data);
        	return response.data; 
        	
        });
    };
  }];
});