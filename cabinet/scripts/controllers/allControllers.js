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
    .controller('adminCtrl', ['$scope', '$http', '$state','$location', '$q', function ($scope, $http, $state, $location, $q) {
        $scope.vacanciesList = function(data) {
            var promise = $http({
                method: 'get',
                url: basePath + 'vacancies',
                params: {user_id:1}
            }).then(function successCallback(response) {
                return response.data.vacancies.length?response.data.vacancies.length:0;
            }, function errorCallback(response) {
                console.log(response);
            });
            return promise;
        };

        $scope.questionsList = function(data) {
            var promise = $http({
                method: 'get',
                url: basePath + 'questions',
                params: {user_id:1}
            }).then(function successCallback(response) {
                return response.data.questions?response.data.questions.length:0;
            }, function errorCallback(response) {
                console.log(response);
            });
            return promise;
        };

        $q.all([
            $scope.vacanciesList(),
            $scope.questionsList(),
        ]).then(function (response) {
            $scope.vacanciesCount=response[0];
            $scope.questionsCount=response[1];
        });
    }])
    .controller('adminVacanciesCtrl', ['$scope', '$http', '$state','$stateParams', function ($scope, $http, $state, $stateParams) {
        $scope.vacanciesList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'vacancies',
                params: {user_id:1}
            }).then(function successCallback(response) {
                console.log(response.data.vacancies);
                $scope.vacancies = response.data.vacancies;
            }, function errorCallback(response) {
                console.log(response);
            });
        };
        $scope.vacanciesList();

        $scope.removeVacancy = function(id){
            bootbox.confirm('Дійсно видалити вакансію?', function(result) {
                if(result){
                    $http({
                        method: 'DELETE',
                        url: basePath+'vacancies/'+id,
                        params: {user_id:1},
                    }).then(function successCallback(response) {
                        $scope.vacanciesList();
                    }, function errorCallback(response) {
                        console.log(response);
                    });
                }
            });
        }
    }])
    .controller('adminVacancyCtrl', ['$scope', '$http', '$state','$stateParams', function ($scope, $http, $state, $stateParams) {
        $scope.vacancy = {};

        if($stateParams.id){
            $http({
                method: 'get',
                url: basePath + 'vacancies',
                params: {user_id:$stateParams.id}
            }).then(function successCallback(response) {
                $scope.vacancies = response.data;
            }, function errorCallback(response) {
                console.log(response);
            });
        }

        $scope.createVacancy = function(data) {
            $http({
                method: 'post',
                url: basePath + 'vacancies',
                data: data
            }).then(function successCallback(response) {
                console.log(response)
                $state.go("admin.vacancies", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        };
    }])
    .controller('adminQuestionsCtrl', ['$scope', '$http', '$state','$stateParams', function ($scope, $http, $state, $stateParams) {
        $scope.questionsList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'questions',
                params: {user_id:1}
            }).then(function successCallback(response) {
                console.log(response.data.questions);
                $scope.questions = response.data.questions;
            }, function errorCallback(response) {
                console.log(response);
            });
        };
        $scope.questionsList();

        $scope.removeQuestion = function(id){
            bootbox.confirm('Дійсно видалити тест?', function(result) {
                if(result){
                    $http({
                        method: 'DELETE',
                        url: basePath+'questions/'+id,
                        params: {user_id:1},
                    }).then(function successCallback(response) {
                        $scope.questionsList();
                    }, function errorCallback(response) {
                        console.log(response);
                    });
                }
            });
        }
    }])
    .controller('adminQuestionCtrl', ['$scope', '$http', '$state','$stateParams', function ($scope, $http, $state, $stateParams) {
        $scope.question = {};
        $scope.question.answers = [
            {name:'',status:1},
            {name:'',status:1},
            {name:'',status:1},
            {name:'',status:1},
            {name:'',status:1},
        ];

        $http({
            method: 'get',
            url: basePath + 'vacancies',
            params: {user_id:1}
        }).then(function successCallback(response) {
            $scope.vacancies = response.data.vacancies;
        }, function errorCallback(response) {
            console.log(response);
        });

        if($stateParams.id){
            $http({
                method: 'get',
                url: basePath + 'question',
                // params: data
            }).then(function successCallback(response) {
                $scope.question = response.data;
            }, function errorCallback(response) {
                console.log(response);
            });
        }

        $scope.createQuestion = function(data) {
            console.log(data)
            $http({
                method: 'post',
                url: basePath + 'questions',
                data: data
            }).then(function successCallback(response) {
                console.log(response)
                $state.go("admin.questions", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        };
    }])