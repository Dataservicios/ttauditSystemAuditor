'use strict';

var MyStores = angular.module('MyStores', []);

MyStores.controller('SearchCtrl' , function ($scope, $http, $element){

    $scope.search = function(){
        $http.get('http://ttaudit.com/SearchResults', {
            params: {dir: $scope.searchInput}
        }).success(function (data){
            $scope.stores = data;
        })
    }

    $scope.clickSimple = function(DirrPassedFromNgClick){
        //alert ('holaaa');
        $scope.searchResult = DirrPassedFromNgClick;
        //console.log($element.find('.list-group-item').text());

        //console.log(DirrPassedFromNgClick);

        $('#search').text(DirrPassedFromNgClick);
        $('#txtDir').css({"display":"block","color":"red"});

    }


} );


