app.controller("fbCtrl", ['$scope',function($scope){
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




app.controller("fbCtrlblog" , ['$scope',function($scope){
	//  $scope.posts = [{id:1,title:"title1",content:"content1",caption:"caption1"},{id:2,title:"title2",content:"content2",caption:"caption2"}];
	  $scope.share = function(post){
	  console.log(post);
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
	}]);