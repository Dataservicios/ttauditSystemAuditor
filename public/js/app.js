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
        $('#codclient').val(DirrPassedFromNgClick);


        $('#codclient').css({"display":"block","color":"red"});

    }

    $scope.clickId = function(DirrPassedFromNgClick){
        //alert ('holaaa');
        $scope.searchId = DirrPassedFromNgClick;

        $('#store_id').val(DirrPassedFromNgClick);

    }


} );

var MyStoresN = angular.module('MyStoresN', []);

MyStoresN.controller('SearchCtrl' , function ($scope, $http, $element){

    $scope.search = function(){
        var company = $('#company_id').val();
        $http.get('http://ttaudit.com/SearchResultsForCompany', {
            params: {dir: $scope.searchInput + '|' + company}
        }).success(function (data){
            $scope.stores = data;
        })
    }

    $scope.clickSimple = function(DirrPassedFromNgClick){
        //alert ('holaaa');
        $scope.searchResult = DirrPassedFromNgClick;
        //console.log($element.find('.list-group-item').text());

        //console.log(DirrPassedFromNgClick);
        $('#codclient').val(DirrPassedFromNgClick);


        $('#codclient').css({"display":"block","color":"red"});
        $scope.menuState = {}
        $scope.menuState.show = false;
        $scope.cambiarMenu = function() {
            $scope.menuState.show = !$scope.menuState.show;
        };

    }

    $scope.clickId = function(DirrPassedFromNgClick){
        //alert ('holaaa');
        $scope.searchId = DirrPassedFromNgClick;

        $('#store_id').val(DirrPassedFromNgClick);

    }


} );

var MyStores1 = angular.module('MyStores1', []);

MyStores1.controller('SearchCtrl1' , function ($scope, $http, $element){

    $scope.search = function(){
        $http.get('http://ttaudit.com/SearchResults0', {
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
        $('#codclient').val(DirrPassedFromNgClick);


        $('#codclient').css({"display":"block","color":"red"});

    }

    $scope.clickId = function(DirrPassedFromNgClick){
        //alert ('holaaa');
        $scope.searchId = DirrPassedFromNgClick;

        $('#store_id').val(DirrPassedFromNgClick);

    }


} );


