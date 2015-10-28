'use strict';

var MyStores = angular.module('MyStores', []);

MyStores.controller('SearchCtrl', function ($scope, $http){

    $scope.search = function(){
        $http.get('http://ttaudit.com/SearchResults', {
            params: {dir: $scope.searchInput}
        }).success(function (data){
            $scope.stores = data;
        })
    }
    /*alert("Pruebas de busqueda");*/

} );
