app.directive('aboutmenu', function() {
	return {
	    templateUrl: "templates/aboutmenu.html",
	    controller: "AboutCtrl"
	};
});
app.directive('aboutmenucollapsed', function() {
	return {
	    templateUrl: "templates/aboutmenucollapsed.html",
	    controller: "AboutCtrl"
	};
});

app.directive('listpropertymenu', function() {
	return {
	    templateUrl: "templates/listpropertymenu.html",
	    controller: "AboutCtrl"
	};
});
app.directive('listpropertymenucollapsed', function() {
	return {
	    templateUrl: "templates/listpropertymenucollapsed.html",
	    controller: "AboutCtrl"
	};
});


app.directive('producttile', function() {

    
    return {
		restrict: "E",
	    templateUrl: "templates/product_tile.html",
	    controller: "producttileCtrl",
	    
	    scope:{
	       	'showgrade': "=showgrade",
	    	'item': '= item',
	    	'formap': '= formap',
	    	'ishomepage': '= ishomepage',
            'countryflag': '= countryflag',
	    },
	    
	    
	      
	};
});

app.directive('producttilelist', function() {

    
    return {
		restrict: "E",
	    templateUrl: "templates/product_tile_list.html",
	    controller: "producttileCtrl",
	    
	    scope:{
	       	'showgrade': "=showgrade",
	    	'item': '= item',
	    	'formap': '= formap',
	    	'ishomepage': '= ishomepage',
            'countryflag': '= countryflag',
            'countrylabel': '= countrylabel',
	    },
	    
	    
	      
	};
});



app.directive('homelogoslider', function() {
	return {
		restrict: "E",
	    templateUrl: "templates/logoslider.html",
	    
	    scope:{
	    	item: '=item'
	    },
	    controller: ['$scope','$rootScope', function ($scope, $rootScope) {
	    	  $scope.myInterval = 5000;
              //$(".scrollable").scrollable();  
	    }]
	    
	      
	};
});


app.directive('onErrorSrc', function() {
	  return {
	    link: function(scope, element, attrs) {
	      element.bind('error', function() {
	        if (attrs.src != attrs.onErrorSrc) {
	          attrs.$set('src', attrs.onErrorSrc);
	        }
	      });
	    }
	  }
	});

app.directive('propertygrade', function() {
	return {
		restrict: "E",
	    templateUrl: "templates/property_grade.html",
	    
	    scope:{
	    	item: '=item'
	    		
	    },
	controller: ['$scope', function ($scope) {
	    	
	    	$scope.selectgradecolor= function(someValue){
	    	     return someValue + "circle";
	    		
	    	    };
	    }],
	};
});




app.directive('listslider', function() {
	return {
		restrict: "E",
	    templateUrl: "templates/listslider.html",
	    
	    scope:{
	    	item: '=item',
            inmap: '=inmap'
	    },
	    controller: ['$scope','$rootScope', function ($scope, $rootScope) {
	    	  $scope.myInterval = 5000;
	    }]
	    
	      
	};
});


app.directive('workingcpxmenu', function() {
	return {
	    templateUrl: "templates/workingcpx_menu.html",
	    controller: "AboutCtrl"
	};
});
app.directive('workingcpxmenucollapsed', function() {
	return {
	    templateUrl: "templates/workingcpx_menucollapsed.html",
	    controller: "AboutCtrl"
	};
});

app.directive('blogmenu', function() {
	return {
	    templateUrl: "templates/blogmenu.html",
	    controller: "AboutCtrl"
	};
});
app.directive('blogmenucollapsed', function() {
	return {
	    templateUrl: "templates/blogmenucollapsed.html",
	    controller: "AboutCtrl"
	};
});

app.directive('marketplacemenu', function() {
	return {
	    templateUrl: "templates/marketplacemenu.html",
	    controller: "AboutCtrl"
	};
});
app.directive('marketplacemenucollapsed', function() {
	return {
	    templateUrl: "templates/marketplacemenucollapsed.html",
	    controller: "AboutCtrl"
	};
});


app.directive('header2', function() {

    
    return {
		restrict: "E",
	    templateUrl: "templates/header_inner.html",
	    controller: ['$scope', '$rootScope','$window','CommonShareService', function ($scope, $rootScope ,$window,CommonShareService) {
	        
	    	$scope.reloadRoute = function() {
	    		   $window.location.reload();
	    		}
	    	
	    	
	    	$scope.ViewGradedClicked = null;     
	    	$scope.ListClicked = null;
	    	$scope.OrderClicked = null;
	    	$scope.BlogClicked = null;
	    	$scope.AboutClicked = null;
	    	
            $scope.clearPropertyID = function () {
                           
                //console.log("function  clicked ssss");
                sessionStorage.toggle_val = angular.toJson('');
                CommonShareService.passenquireid(null);
                 
            };
	    	$scope.goToServiceRequest = function () {
                           
               // console.log("function  clicked ssss");                
                $window.location.href='#!/service_request'; 
            };
            
	    	function checkClicked1() {
	    		
		    	
	    		$scope.ViewGradedClicked = true;
    		    $scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
		    	
		    	$scope.$emit('someEvent', [$scope.ViewGradedClicked]);
	         }

	    	$scope.checkClicked1 = checkClicked1;
	     
	    	
	    	function checkClicked2() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = true;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
		    	$scope.AboutClicked = null;
	         }

	    	$scope.checkClicked2 = checkClicked2;
	    
	    	
	    	function checkClicked3() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = true;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
		    	$scope.AboutClicked = null;
	         }

	    	$scope.checkClicked3 = checkClicked3;
	    	
	    	
	    	
	    	function checkClicked4() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
	         }

	    	$scope.checkClicked4 = checkClicked4;
	    	
	    	function checkClicked5() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = true;
		    	$scope.AboutClicked = null;
	
	         }

	    	$scope.checkClicked5 = checkClicked5;
	    	
	    	
	    	function checkClicked6() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = true;
	
	         }

	    	$scope.checkClicked6 = checkClicked6;
	    	
        
            function checkClicked7() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
	
	         }

	    	$scope.checkClicked7 = checkClicked7;
        	    	 
	    	$scope.$on('viewEvent', function(event) { 
	    		
	    	    $scope.checkClicked1();
	    		
	    		
	    	});	
	    	
	    	$scope.$on('listEvent', function(event) { 
	    		
	    		$scope.checkClicked2();
	    		
	    	});	
	    	
	    	
            $scope.$on('orderEvent', function(event) { 
	    		
	    		$scope.checkClicked3();
	    		
	    	});
            
            $scope.$on('blogEvent', function(event) { 
	    		
	    		$scope.checkClicked5();
	    		
	    	});
            
            $scope.$on('aboutEvent', function(event) { 
	    		
	    		$scope.checkClicked6();
	    		
	    	});
	    	
	    	 
	    	 
	    }],
	    
	    scope:{
	       	'ishomepage': '= ishomepage',
            'selectedmenu': '= selectedmenu',
	    },
	    
	    
	      
	};
});







app.directive('header', function() {
	  return {
	    templateUrl: "templates/header.html",
	 
	    controller: ['$scope', '$rootScope','$window','CommonShareService', function ($scope, $rootScope ,$window,CommonShareService) {
	        
	    	$scope.reloadRoute = function() {
	    		   $window.location.reload();
	    		}
	    	
	    	
	    	$scope.ViewGradedClicked = null;     
	    	$scope.ListClicked = null;
	    	$scope.OrderClicked = null;
	    	$scope.BlogClicked = null;
	    	$scope.AboutClicked = null;
	    	
            $scope.clearPropertyID = function () {
                           
                //console.log("function  clicked ssss");
                sessionStorage.toggle_val = angular.toJson('');
                CommonShareService.passenquireid(null);
                 
            };
	    	$scope.goToServiceRequest = function () {
                           
               // console.log("function  clicked ssss");                
                $window.location.href='#!/service_request'; 
            };
	    	
	    	function checkClicked1() {
	    		
		    	
	    		$scope.ViewGradedClicked = true;
    		    $scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
		    	
		    	$scope.$emit('someEvent', [$scope.ViewGradedClicked]);
	         }

	    	$scope.checkClicked1 = checkClicked1;
	     
	    	
	    	function checkClicked2() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = true;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
		    	$scope.AboutClicked = null;
	         }

	    	$scope.checkClicked2 = checkClicked2;
	    
	    	
	    	function checkClicked3() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = true;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
		    	$scope.AboutClicked = null;
	         }

	    	$scope.checkClicked3 = checkClicked3;
	    	
	    	
	    	
	    	function checkClicked4() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
	         }

	    	$scope.checkClicked4 = checkClicked4;
	    	
	    	function checkClicked5() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = true;
		    	$scope.AboutClicked = null;
	
	         }

	    	$scope.checkClicked5 = checkClicked5;
	    	
	    	
	    	function checkClicked6() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = true;
	
	         }

	    	$scope.checkClicked6 = checkClicked6;
	    	
        
            function checkClicked7() {
		           
	    		$scope.ViewGradedClicked = null;
	    		$scope.ListClicked = null;
		    	$scope.OrderClicked = null;
		    	$scope.BlogClicked = null;
		    	$scope.AboutClicked = null;
	
	         }

	    	$scope.checkClicked7 = checkClicked7;
        	    	 
	    	$scope.$on('viewEvent', function(event) { 
	    		
	    	    $scope.checkClicked1();
	    		
	    		
	    	});	
	    	
	    	$scope.$on('listEvent', function(event) { 
	    		
	    		$scope.checkClicked2();
	    		
	    	});	
	    	
	    	
            $scope.$on('orderEvent', function(event) { 
	    		
	    		$scope.checkClicked3();
	    		
	    	});
            
            $scope.$on('blogEvent', function(event) { 
	    		
	    		$scope.checkClicked5();
	    		
	    	});
            
            $scope.$on('aboutEvent', function(event) { 
	    		
	    		$scope.checkClicked6();
	    		
	    	});
	    	
	    	 
	    	 
	    }]
	  };
	});


app.directive('footer', function() {
	  return {
		  templateUrl: "templates/footer.html",
		  
		    controller: ['$scope', '$rootScope', '$window', '$timeout','CommonShareService', function ($scope, $rootScope,$window, $timeout,CommonShareService) {
		    	
		    	
                   $scope.clearPropertyID = function () {
                                   
                        //console.log("function  clicked ssss");
                        sessionStorage.toggle_val = angular.toJson('');
                        CommonShareService.passenquireid(null);
                         
                    };
        	    	$scope.goToServiceRequest = function () {
                                   
                       // console.log("function  clicked ssss");                
                        $window.location.href='#!/service_request'; 
                    };
                
                
                $scope.reloadRoute = function() {
		    		   $window.location.reload();
		    		}
		    	
		    	
		    	$scope.registrationForm = {
		    		    'email'     : ''
		    		};
		     
		     $scope.resetform = function (){
		    	 
		    	 
		    	 
		    	 $timeout(function() {
		    		 $scope.registrationForm.email = '';      
	           }, 3000);
		    
		    	 
		     }  
	             
		    	 
		    	function checkClickedview() {
		    		
		    	     $scope.$emit('viewEvent');
			    	
		    	}
		    	
                    function checkClickedlist() {
                    	
                    	$scope.$emit('listEvent');
			    	}
		    	
                    
                    function checkClickedorder() {
    		    		
   		    	     $scope.$emit('orderEvent');
   			    	
   		    	}   
                    function checkClickedblog() {
    		    		
      		    	     $scope.$emit('blogEvent');
      			    	
      		    	}   
                    
                    function checkClickedabout() {
    		    		
     		    	     $scope.$emit('aboutEvent');
     			    	
     		    	}   
                    
                    
		    	$scope.checkClickedview = checkClickedview;
		    	$scope.checkClickedlist = checkClickedlist;
		    	$scope.checkClickedorder = checkClickedorder;
		    	$scope.checkClickedblog = checkClickedblog;
		    	$scope.checkClickedabout = checkClickedabout; 
		    	
		    }]
	  };
	});



app.directive('myslider', function() {
	  return {
		  
		  templateUrl: "templates/myslider.html",

		    controller: ['$scope','$rootScope','$timeout', function ($scope, $rootScope,$timeout) {
		    	
		    	  //$scope.myInterval = 5000;
		    	  var slides = $scope.slides = $scope.currentimages;
		    	  var property = $scope.property = $scope.currentproperty;
                   $scope.$on('dataloaded', function () {
                         $timeout((function() { $('#_mg_listing_gallery .slick-frame').slick({
                			    centerMode: true,
                			    slidesToShow: 1,
                			    arrows: false,
                			    dots: true,
                			    variableWidth: true,
                                 responsive: [
                                        {
                                          breakpoint: 480,
                                          settings: {
                                            centerMode: false,
                                            
                                          }
                                        }
                                        // You can unslick at a given breakpoint now by adding:
                                        // settings: "unslick"
                                        // instead of a settings object
                                      ]
                
                			}); 
                            $scope.gotoNotGradedtab();
                            
                            }), 1000) 
                            })
                
                
                
                  
                                                    
		}]
	  };
	});




/** directive for image resize*/
app.directive('resizeimg', ['$window' , function ($window) {
    return function ($scope, $element) {
        var w = angular.element($window);
        $scope.getWindowDimensions = function () {
        	//console.log({ 'h': $element.height(), 'w': $element.width() });
        	//console.log('new height: ' + Math.round($element.width()*1.33));
            return {'h':Math.round($element.width()*0.66), 'w':$element.width()};
        	
        	//return { 'h': w.height(), 'w': w.width() };
        };
        $scope.$watch($scope.getWindowDimensions, function (newValue, oldValue) {
        	$scope.windowHeight = newValue.h;
        	$scope.windowWidth = newValue.w;
        	
        	$scope.styleHeight = function () {
                return { 
                    'height': newValue.h + 'px'
                };
            };
            
            $scope.styleMaxHeight = function () {
                return { 
                    'max-height': newValue.h + 'px'
                };
            };

        }, true);

        w.bind('resize', function () {
        	$scope.$apply();
        });
    };
}]);






app.directive('shareLinks', ['$location', function ($location) {
    return {
      link: function (scope, elem, attrs) {
        var i,
            sites = ['twitter', 'facebook', 'linkedin', 'google-plus'],
            theLink,
            links = attrs.shareLinks.toLowerCase().split(','),
            pageLink = encodeURIComponent($location.absUrl()),
            pageTitle = attrs.shareTitle,
            pageTitleUri = encodeURIComponent(pageTitle),
            shareLinks = [],
            square = '';

        elem.addClass('td-easy-social-share');

        // check if square icon specified
        square = (attrs.shareSquare && attrs.shareSquare.toString() === 'true') ? '-square' : '';

        // assign share link for each network
        angular.forEach(links, function (key) {
          key = key.trim();

          switch (key) {
            case 'twitter':
              theLink = 'http://twitter.com/intent/tweet?text=' + pageTitleUri + '%20' + pageLink;
              break;
            
          }

          if (sites.indexOf(key) > -1) {
            shareLinks.push({network: key, url: theLink});
          }
        });

        for (i = 0; i < shareLinks.length; i++) {
          var anchor = '';
          anchor += '<a href="'+ shareLinks[i].url + '"';
          anchor += ' class="btn btn-social-icon btn-twt top-icon" target="_blank"';
          anchor += '></a>';
          elem.append(anchor);
        }
      }
    };
  }]);



	app.directive('logoslider', function() {
		
				return {
			restrict: "E",
		    templateUrl: "views/logo_slider.html",
		    controller: "LogoslideCtrl",
		    
		    scope:{
		    	visibleItems: "=visibleItems",
		    	animationSpeed: '=animationSpeed',
		    	autoPlay: '=autoPlay',
		    	autoPlaySpeed: '=autoPlaySpeed',
		    	pauseOnHover:'=pauseOnHover',	
		    	enableResponsiveBreakpoints:'=enableResponsiveBreakpoints'
		    },
		    
		    
		      
		};
	});

	app.directive('flexCarousel', function () {
	    return {
	        restrict: 'E',
	        transclude : true,
	        template : "<ng-transclude></ng-transclude>",
	         controller: "LogoslideCtrl",
	        scope: {
	        	visibleItems: "=visibleItems",
		    	animationSpeed: '=animationSpeed',
		    	autoPlay: '=autoPlay',
		    	autoPlaySpeed: '=autoPlaySpeed',
		    	pauseOnHover:'=pauseOnHover',	
		    	enableResponsiveBreakpoints:'=enableResponsiveBreakpoints'
	        },
	        link: function (scope, element, attrs) {
	           
	            $('#flexisel').flexisel(scope.options);
	            
	           
	        }
	    };
	});
	
	
	
	app.directive('ngThumb', ['$window', function($window) {
        var helper = {
                support: !!($window.FileReader && $window.CanvasRenderingContext2D),
                isFile: function(item) {
                    return angular.isObject(item) && item instanceof $window.File;
                },
                isImage: function(file) {
                    var type =  '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
                    return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
                }
            };

            return {
                restrict: 'A',
               // template: '<canvas style="z-index:1"></canvas><button style="float:right;position:relative; top:-28px;z-index:2;background-color:#F97A07;border-color:black;color:#fff;" type="button" class="btn btn-xs" ng-click="item.remove()"><span class="glyphicon glyphicon-trash"></span></button><input type="radio"/>',
                templateUrl: "views/Admin/canvas-preview.html",
          
                link: function(scope, element, attributes) {
                    
                	               	
                	if (!helper.support) return;

                    var params = scope.$eval(attributes.ngThumb);

                    scope.index = params.index; 
                    //console.log(params);
                    if (!helper.isFile(params.file)) return;
                    if (!helper.isImage(params.file)) return;

                    var canvas = element.find('canvas');
                    var reader = new FileReader();

                    reader.onload = onLoadFile;
                    reader.readAsDataURL(params.file);

                    function onLoadFile(event) {
                        var img = new Image();
                        img.onload = onLoadImage;
                        img.src = event.target.result;
                    }

                    function onLoadImage() {
                        var width = params.width || this.width / this.height * params.height;
                        var height = params.height || this.height / this.width * params.width;
                        canvas.attr({ width: width, height: height });
                        canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
                    }
                },
                
 controller: ['$scope','$rootScope', function ($scope, $rootScope ,scope) {
    		    	
    		    	$scope.data = {selectedOption: 'den0'};
    		    	
    		    	/*console.log(scope.index);*/
    		    	
    		    	}],
            };
        }]);

	
	
	app.directive('sidemenu', function() {
		return {
			
		    templateUrl: "views/Admin/sidemenu.html",
		   
		    controller: ['$scope','$rootScope','$window', function ($scope, $rootScope ,$window) {
		    
		    	$rootScope.showMenu = false;
		    	
		    }]
		      
		};
	});	
	
	app.directive('fallbackImages', function() {
	    return {
	        scope: {
	            fallbackImages: '='
	        },
	        link: function(scope, element, attrs) {

	            var loadElement = angular.element(document.createElement('img'));

	            scope.$watch('image()', function(newImage, oldImage) {
	                if (newImage) {
	                    loadElement.attr('src', newImage);
	                }
	            });

	            loadElement.bind('error', function() {
	                scope.$apply(function() {
	                    scope.imageFailed(loadElement.attr('src'));
	                });
	            });

	            loadElement.bind('load', function() {
	                element.attr('src', loadElement.attr('src'));
	            });

	        },
	        controller: function($scope) {

	            $scope.badImages = [];

	            $scope.imageFailed = function(image) {
	                $scope.badImages.push(image);
	            };

	            $scope.image = function() {
	                var potentialNextImage = $scope.fallbackImages.filter(function(image) {
	                    return $scope.badImages.indexOf(image) === -1;
	                });

	                if (potentialNextImage.length > 0) {
	                    return potentialNextImage[0];
	                }
	            };
	        }
	    };
	});
	
	
	app.directive('back', ['$window', function($window) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs) {
                elem.bind('click', function () {
                    $window.history.back();
                });
            }
        };
    }]);
	app.directive( 'backButton', function() {
    return {
        restrict: 'A',
        link: function( scope, element, attrs ) {
            element.on( 'click', function () {
                history.back();
                scope.$apply();
            } );
        }
    };
	
	} );
	
	/*app.directive('googlePlus', [
	                             '$window', function ($window) {
	                                 return {
	                                     restrict: 'A',
	                                     scope: {
	                                         googlePlus: '=?'
	                                     },
	                                     link: function (scope, element, attrs) {
	                                         if (!$window.gapi) {
	                                             // Load Google SDK if not already loaded
	                                             $.getScript('//apis.google.com/js/platform.js', function () {
	                                                 renderPlusButton();
	                                             });
	                                         } else {
	                                             renderPlusButton();
	                                         }

	                                         var watchAdded = false;
	                                         function renderPlusButton() {
	                                             if (!!attrs.googlePlus && !scope.googlePlus && !watchAdded) {
	                                                 // wait for data if it hasn't loaded yet
	                                                 watchAdded = true;
	                                                 var unbindWatch = scope.$watch('googlePlus', function (newValue, oldValue) {
	                                                     if (newValue) {
	                                                         renderPlusButton();

	                                                         // only need to run once
	                                                         unbindWatch();
	                                                     }

	                                                 });
	                                                 return;
	                                             } else {
	                                                 element.html('<div class="g-plusone"' + (!!scope.googlePlus ? ' data-href="' + scope.googlePlus + '"' : '') + ' data-size="medium"></div>');
	                                                 $window.gapi.plusone.go(element.parent()[0]);
	                                             }
	                                         }
	                                     }
	                                 };
	                             }
	                         ]);*/
	
	
	