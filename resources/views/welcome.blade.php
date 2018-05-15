<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="demoApp">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel-Material Datatable</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        
        <!-- style sheet -->
        <link href="bower_components/angular-material/angular-material.min.css" rel="stylesheet" type="text/css"/>
        <link href="bower_components/angular-material-data-table/dist/md-data-table.min.css" rel="stylesheet" type="text/css"/>
        
    </head>

    <body>

        <md-toolbar class="md-whiteframe-1dp">
            <div class="md-toolbar-tools">
                <div class="md-title">Laravel-AngularJS Material Data Table</div>
            </div>
        </md-toolbar>
                
        <md-content laout="column" flex ng-controller="ProductController">
        
            <md-card>
                
                <md-toolbar class="md-table-toolbar md-default">

                    <div class="md-toolbar-tools">
                        
                        <span>Products</span>
                        
                        <div flex></div>

                        <md-input-container>
                            <label> Search Table </label>
                            <input ng-model="query.search"> 
                        </md-input-container>

                        <md-button class="md-raised md-primary" 
                                   ng-click="searchFilter()"
                                   ng-disabled="!query.search">
                            <md-icon>search</md-icon>
                        </md-button>

                        <md-button class="md-icon-button" ng-click="loadStuff()">
                            <md-icon>refresh</md-icon>
                        </md-button>

                    </div>

                </md-toolbar>
                
                <md-table-container>
                
                    <table md-table 
                           md-row-select="false" 
                           multiple="false" 
                           md-progress="promise">

                        <thead md-head >
                            <tr md-row>
                                <th md-column ><span>Name</span></th>
                                <th md-column ><span>Category</span></th>
                                <th md-column ><span>Price</span></th>
                                <th md-column ><span>Description</span></th>
                            </tr>
                        </thead>

                    <tbody md-body>

                        <tr md-row ng-repeat="product in products.data">
                            
                            <td md-cell>@{{product.name}}</td>

                            <td md-cell>@{{product.category}}</td>

                            <td md-cell>@{{product.price}}</td>

                            <td md-cell>@{{product.description }}</td>
                        
                        </tr>

                    </tbody>

                </table>

                </md-table-container>
        
                <md-table-pagination md-limit="query.limit" 
                                     md-limit-options="limitOptions" 
                                     md-page="query.page" 
                                     md-total="@{{products.total}}" 
                                     md-page-select="true" 
                                     md-boundary-links="false" 
                                     md-on-paginate="logPagination">
                </md-table-pagination>
            </md-card>

        </md-content>

        <script type="text/javascript" src="bower_components/angular/angular.js"></script>
        <script type="text/javascript" src="bower_components/angular-animate/angular-animate.js"></script>
        <script type="text/javascript" src="bower_components/angular-aria/angular-aria.js"></script>
        <script type="text/javascript" src="bower_components/angular-material/angular-material.js"></script>
        <script type="text/javascript" src="bower_components/angular-material-data-table/dist/md-data-table.min.js"></script>

        <script>

            angular.module('demoApp', ['ngMaterial','md.data.table'])
            .config(['$mdThemingProvider', function ($mdThemingProvider) 
            {
                'use strict';
                
                $mdThemingProvider.theme('default')
                .primaryPalette('blue');
            }])
            .controller('ProductController', ['$mdEditDialog','$http', '$q', '$scope', '$timeout', function ($mdEditDialog, $http, $q, $scope, $timeout) 
            {
                'use strict';
                
                var searchDefer = null;

                initcontroller();

                function initcontroller()
                {
                    $scope.products = {};

                    $scope.limitOptions = [5, 10, 15];

                    $scope.query = {
                        order: 'name',
                        limit: 5,
                        page: 1,
                        search: ''
                    };

                    getPageResults( 1 , 5 )
                    .then(function(data) 
                    {
                        $scope.products =  data; 
                    }); 
                }
                
                function getPageResults( pageNumber = 1 , limit = 5, searchText = '' )
                {
                    searchDefer = $q.defer();

                    var url = window.location.href + "?";

                    url = url + '&page='+ pageNumber;

                    url = url + '&limit=' + limit;
                    
                    if(searchText)
                        url = url + '&searchText=' + searchText;

                    $http.get(url)
                        .then(function(data) 
                        {
                            searchDefer.resolve(data.data);
                        }, function(response) 
                        {
                            console.log('Something Went Wrong!', response);
                        });

                    return searchDefer.promise;

                }
                
                //Refresh
                $scope.loadStuff = function () 
                {
                    $scope.promise = $timeout(function () 
                    {
                        initcontroller();
                    }, 2000);
                }
                
                $scope.logPagination = function (page, limit) 
                {
                    var searchInput =  $scope.query.search;
                    getPageResults( page , limit, searchInput )
                    .then(function ( data )
                    {
                        $scope.products = data;
                    });
                }
                
                $scope.searchFilter = function()
                {
                    var page = $scope.query.page;
                    var limit = $scope.query.limit;
                    var searchInput =  $scope.query.search;

                    getPageResults( page , limit, searchInput )
                    .then(function ( data )
                    {
                        $scope.products = data;
                    });
                }
                
                //For doing search we can watch & iterate over the Products object in client side too!!
                // $scope.$watch('filter.search', function(newValue, oldValue) 
                // {
                //     if(newValue != undefined)
                //     {
                //         function getKey(obj, prop, val) 
                //         {
                //             var keys = [];

                //             for (var key in obj) {
                //                 if (obj[key].hasOwnProperty(prop) && obj[key][prop] === val) {
                //                     keys.push(key);                
                //                 }            
                //             }

                //             return keys;
                //         }
                //     }
                // })
                
                
            }]);

        </script>

    </body>

</html>