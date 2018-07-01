'use strict';
/**
 * @ngdoc function
 * @name sbAdminApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the sbAdminApp
 */
angular.module('sbAdminApp')
  .controller('ChartCtrl', ['$scope', '$timeout','$rootScope','$http', function ($scope, $timeout,$rootScope,$http) {
      $scope.resultsList = function(data) {
          $http({
              method: 'get',
              url: basePath + 'results',
              params: {user_id:$rootScope.userData.user.id}
          }).then(function successCallback(response) {
              $scope.results = response.data.results;
              $scope.low = 0;
              $scope.middle = 0;
              $scope.high = 0;
              angular.forEach($scope.results, function(value, key) {
              	if(value[0].result<50)  $scope.low++;
              	if(value[0].result>=50 && value[0].result<70)  $scope.middle++;
              	if(value[0].result>=70)  $scope.high++;
              });
              $scope.pie = {
                  labels : ["Успішність менше 50%", "Успішність 50-70%", "Усрішність більше 70%"],
                  data : [$scope.low, $scope.middle, $scope.high]
              };
          }, function errorCallback(response) {
              console.log(response);
          });
      };
      $scope.resultsList();
}]);