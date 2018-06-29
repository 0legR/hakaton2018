'use strict';
/**
 * @ngdoc function
 * @name sbAdminApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the sbAdminApp
 */
angular.module('sbAdminApp')
    .controller('vacancyCtrl', ['$scope', '$http', function ($scope, $http) {
        $scope.vacancies = [
            {name: 'JS'},
            {name: 'C++'},
            {name: 'Повар'}
        ];
    }])
    .controller('testCtrl', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {

    }])
    .controller('registrationCtrl', ['$scope', '$http', '$state','$location', function ($scope, $http, $state, $location) {
        $scope.auth_data = {};
        $scope.loggin = function(data){
            $http({
                method: 'get',
                url: basePath+'loggin',
                params: data
            }).then(function successCallback(response) {
                $state.go("dashboard.test", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        }

        $scope.auth = function(data){
            console.log(data);
            $http({
                method: 'post',
                url: basePath+'auth',
                data: data,
            }).then(function successCallback(response) {
                $state.go("dashboard", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        }
    }])
    .controller('adminCtrl', ['$scope', '$http', '$state','$location', function ($scope, $http, $state, $location) {
        $scope.auth_data = {};
        $scope.loggin = function(data){
            $http({
                method: 'get',
                url: basePath+'loggin',
                params: data
            }).then(function successCallback(response) {
                $state.go("dashboard.test", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        }

        $scope.auth = function(data){
            console.log(data);
            $http({
                method: 'post',
                url: basePath+'auth',
                data: data,
            }).then(function successCallback(response) {
                $state.go("dashboard", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        }
    }])
    .controller('adminVacanciesCtrl', ['$scope', '$http', '$state','$stateParams', function ($scope, $http, $state, $stateParams) {
        $scope.vacanciesList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'vacancies',
                // params: data
            }).then(function successCallback(response) {
                $scope.vacancies = response.data;
            }, function errorCallback(response) {
                console.log(response);
            });
        };
        $scope.vacanciesList();

        $scope.removeVacancy = function(id){
            $http({
                method: 'DELETE',
                url: basePath+'vacancies',
                params: {id:id},
            }).then(function successCallback(response) {
                $scope.vacanciesList();
            }, function errorCallback(response) {
                console.log(response);
            });
        }
    }])
    .controller('adminVacancyCtrl', ['$scope', '$http', '$state','$stateParams', function ($scope, $http, $state, $stateParams) {
        if($stateParams.id){
            $http({
                method: 'get',
                url: basePath + 'vacancies',
                // params: data
            }).then(function successCallback(response) {
                $scope.vacancies = response.data;
            }, function errorCallback(response) {
                console.log(response);
            });
        }else{
            alert(2);
        }
        $scope.vacanciesList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'vacancies',
                // params: data
            }).then(function successCallback(response) {
                $scope.vacancies = response.data;
            }, function errorCallback(response) {
                console.log(response);
            });
        };
        $scope.vacanciesList();

        $scope.removeVacancy = function(id){
            $http({
                method: 'DELETE',
                url: basePath+'vacancies',
                params: {id:id},
            }).then(function successCallback(response) {
                $scope.vacanciesList();
            }, function errorCallback(response) {
                console.log(response);
            });
        }
    }])