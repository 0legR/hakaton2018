angular.module('sbAdminApp')
    .controller('userCtrl', ['$rootScope', '$http', function ($rootScope, $http) {
        $http.get('../cabinet/scripts/json/user_data.json').success(function (response) {
            $rootScope.data = response;
        });
    }])