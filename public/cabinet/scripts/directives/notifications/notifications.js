'use strict';

/**
 * @ngdoc directive
 * @name izzyposWebApp.directive:adminPosHeader
 * @description
 * # adminPosHeader
 */
angular.module('sbAdminApp')
	.directive('notifications',function(){
		return {
            templateUrl: 'scripts/directives/notifications/notifications.html',
            restrict: 'E',
            replace: true,
            scope: {},
            controller: function ($scope, $http) {
                if (localStorage.user) {
                    $scope.userData = JSON.parse(localStorage.user);
                } else {
                    $scope.userData = null;
                }
            }
        }
	});


