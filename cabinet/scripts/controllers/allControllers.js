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
        $http.get('../cabinet/scripts/json/user_data.json').success(function (response) {
            $scope.data = response;
        });

        $scope.vacancies = [
            {name: 'JS'},
            {name: 'C++'},
            {name: 'Повар'}
        ];
    }])
    .controller('testCtrl', ['$scope', '$http', function ($scope, $http) {

    }])