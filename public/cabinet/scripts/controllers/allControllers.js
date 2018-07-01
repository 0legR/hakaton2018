'use strict';
/**
 * @ngdoc function
 * @name sbAdminApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the sbAdminApp
 */
angular.module('sbAdminApp')
    .controller('testCtrl', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {

    }])
    .controller('registrationCtrl', ['$scope', '$http', '$state','$location', '$rootScope', function ($scope, $http, $state, $location, $rootScope) {
        $scope.auth_data = {};
        $scope.loggin = function(data){
            $http({
                method: 'get',
                url: basePath+'loggin',
                params: data
            }).then(function successCallback(response) {
                $scope.logginHelper(response.data);
            }, function errorCallback(response) {
                console.log(response);
            });
        }
        
        $scope.logginHelper = function(data) {
            localStorage.setItem("user", JSON.stringify(data));
            var userData = JSON.parse(localStorage.user);
            if(localStorage.user){
                $rootScope.userData = JSON.parse(localStorage.user);
            }else{
                $rootScope.userData = null;
            }
            if (userData.user.hasOwnProperty('isHR') || userData.user.hasOwnProperty('isAdmin')) {
                location.href="#admin/dashboard";
            } else if (userData.user.hasOwnProperty('isApplicant')) {
               location.href="#applicant/vacancies";
            }
        }

        $scope.loggout = function() {
            var userData = JSON.parse(localStorage.user);
            if (userData !== null) {
                localStorage.removeItem("user");
                if(localStorage.user){
                    $rootScope.userData = JSON.parse(localStorage.user);
                }else{
                    $rootScope.userData = null;
                }
                location.href="#applicant/vacancies"
            }
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
        $scope.companyProfile = function() {
            location.href="#admin/settings"
        }
    }])

    //admin controllers
    .controller('adminCtrl', ['$scope', '$http', '$state','$location', '$q','$rootScope', function ($scope, $http, $state, $location, $q, $rootScope) {
        $scope.vacanciesList = function(data) {
            var promise = $http({
                method: 'get',
                url: basePath + 'vacancies',
                params: {user_id:$rootScope.userData.user.id}
            }).then(function successCallback(response) {
                return response.data.vacancies?response.data.vacancies.length:0;
            }, function errorCallback(response) {
                console.log(response);
            });
            return promise;
        };

        $scope.questionsList = function(data) {
            var promise = $http({
                method: 'get',
                url: basePath + 'questions',
                params: {user_id:$rootScope.userData.user.id}
            }).then(function successCallback(response) {
                return response.data.questions?response.data.questions.length:0;
            }, function errorCallback(response) {
                console.log(response);
            });
            return promise;
        };

        $scope.ordersList = function(data) {
            var promise = $http({
                method: 'get',
                url: basePath + 'orders',
                params: {user_id:$rootScope.userData.user.id}
            }).then(function successCallback(response) {
                return response.data.orders ? response.data.orders.length : 0;
            }, function errorCallback(response) {
                console.log(response);
            });
            return promise;
        };

        $scope.resultsList = function(data) {
            var promise = $http({
                method: 'get',
                url: basePath + 'results',
                params: {user_id:$rootScope.userData.user.id}
            }).then(function successCallback(response) {
                return response.data.results?response.data.results.length:0;
            }, function errorCallback(response) {
                console.log(response);
            });
            return promise;
        };

        $scope.companiesList = function(data) {
            var promise = $http({
                method: 'get',
                url: basePath + 'companies',
                params: {user_id:$rootScope.userData.user.id}
            }).then(function successCallback(response) {
                return response.data.companies ? response.data.companies.length : 0;
            }, function errorCallback(response) {
                console.log(response);
            });
            return promise;
        };

        $q.all([
            $scope.vacanciesList(),
            $scope.questionsList(),
            $scope.ordersList(),
            $scope.companiesList(),
            $scope.resultsList(),
        ]).then(function (response) {
            $scope.vacanciesCount=response[0];
            $scope.questionsCount=response[1];
            $scope.ordersCount=response[2];
            $scope.companiesCount=response[3];
            $scope.resultsCount=response[4];
        });
    }])
    .controller('adminVacanciesCtrl', ['$scope', '$http', '$state','$stateParams','$rootScope', function ($scope, $http, $state, $stateParams,$rootScope) {
        $scope.vacanciesList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'vacancies',
                params: {user_id:$rootScope.userData.user.id}
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
                        params: {user_id:$rootScope.userData.user.id},
                    }).then(function successCallback(response) {
                        $scope.vacanciesList();
                    }, function errorCallback(response) {
                        console.log(response);
                    });
                }
            });
        }
    }])
    .controller('adminVacancyCtrl', ['$scope', '$http', '$state','$stateParams','$rootScope', function ($scope, $http, $state, $stateParams,$rootScope) {
        $scope.vacancy = {};
        var method = 'post';

        if($stateParams.id){
            $http({
                method: 'get',
                url: basePath + 'vacancies/'+ $stateParams.id +'/edit',
                params: {user_id: $rootScope.userData.user.id}
            }).then(function successCallback(response) {
                $scope.vacancy = response.data.vacancy;
            }, function errorCallback(response) {
                console.log(response);
            });
        }

        $scope.sendVacancy = function(data) {
            if($stateParams.id){
                $scope.updateVacancy($stateParams.id, data);
            }else{
                $scope.createVacancy(data);
            }
        };
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

        $scope.updateVacancy = function(id, data) {
            $http({
                method: 'put',
                url: basePath + 'vacancies/'+id,
                params: data
            }).then(function successCallback(response) {
                console.log(response);
                $state.go("admin.vacancies", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        };
    }])
    .controller('adminQuestionsCtrl', ['$scope', '$http', '$state','$stateParams','$rootScope', function ($scope, $http, $state, $stateParams,$rootScope) {
        $scope.questionsList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'questions',
                params: {user_id:$rootScope.userData.user.id}
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
                        params: {user_id:$rootScope.userData.user.id},
                    }).then(function successCallback(response) {
                        $scope.questionsList();
                    }, function errorCallback(response) {
                        console.log(response);
                    });
                }
            });
        }
    }])
    .controller('adminQuestionCtrl', ['$scope', '$http', '$state','$stateParams','$rootScope', function ($scope, $http, $state, $stateParams,$rootScope) {
        $scope.question = {};
        $scope.question.answers = [
            {name:'',status:1},
            {name:'',status:0},
            {name:'',status:0},
            {name:'',status:0},
        ];

        $scope.setDefault = function(answer) {
            angular.forEach($scope.question.answers, function(a) {
                a.status = 0; //set them all to false
            });
            answer.status = 1; //set the clicked one to true
        };

        $http({
            method: 'get',
            url: basePath + 'vacancies',
            params: {user_id:$rootScope.userData.user.id}
        }).then(function successCallback(response) {
            $scope.vacancies = response.data.vacancies;
            if($stateParams.id){
                $scope.getQuestion();
            }
        }, function errorCallback(response) {
            console.log(response);
        });

        $scope.getQuestion = function() {
            $http({
                method: 'get',
                url: basePath + 'questions/' + $stateParams.id + '/edit',
                params: {user_id: $rootScope.userData.user.id}
            }).then(function successCallback(response) {
                $scope.question = response.data.question;
                $scope.question.user_id = $rootScope.userData.user.id;
            }, function errorCallback(response) {
                console.log(response);
            });
        }

        $scope.sendQuestion = function(data) {
            if($stateParams.id){
                $scope.updateQuestion($stateParams.id, data);
            }else{
                $scope.createQuestion(data);
            }
        };
        $scope.createQuestion = function(data) {
            $http({
                method: 'post',
                url: basePath + 'questions',
                data: data
            }).then(function successCallback(response) {
                $state.go("admin.questions", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        };
        $scope.updateQuestion = function(id, data) {
            console.log(data);
            $http({
                method: 'put',
                url: basePath + 'questions/'+id,
                data: data
            }).then(function successCallback(response) {
                $state.go("admin.questions", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        };
    }])
    .controller('adminResultCtrl', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {
        $scope.resultsList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'results',
                params: {user_id:$rootScope.userData.user.id}
            }).then(function successCallback(response) {
                $scope.results = response.data.results;
            }, function errorCallback(response) {
                console.log(response);
            });
        };
        $scope.resultsList();

        $scope.getRandomSpan = function(){
            console.log(Math.random());
            return Math.floor((Math.random()*100));
        };
    }])
    // companies controller
    .controller('adminSettingsCtrl', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {
        $scope.companies = {};
        // var method = 'post';
        $scope.companyList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'companies',
                params: {user_id:$rootScope.userData.user.id}
            }).then(function successCallback(response) {
                $scope.companies = response.data.companies;
            }, function errorCallback(response) {
                console.log(response);
            });
        };
        $scope.companyList();
        $scope.removeCompany = function(id){
            bootbox.confirm('Дійсно видалити компанію?', function(result) {
                if(result){
                    $http({
                        method: 'DELETE',
                        url: basePath+'companies/'+id,
                        params: {user_id:$rootScope.userData.user.id},
                    }).then(function successCallback(response) {
                        $scope.companyList();
                    }, function errorCallback(response) {
                        console.log(response);
                    });
                }
            });
        }
    }])
    .controller('adminCompanyCtrl', ['$scope', '$http', '$state','$stateParams','$rootScope', function ($scope, $http, $state, $stateParams,$rootScope) {
        $scope.company = {};
        var method = 'post';

        if($stateParams.id){
            $http({
                method: 'get',
                url: basePath + 'companies/'+ $stateParams.id +'/edit',
                params: {user_id: $rootScope.userData.user.id}
            }).then(function successCallback(response) {
                $scope.company = response.data.company;
            }, function errorCallback(response) {
                console.log(response);
            });
        }

        $scope.sendCompany = function(data) {
            if($stateParams.id){
                $scope.updateCompany($stateParams.id, data);
            }else{
                $scope.createCompany(data);
            }
        };
        $scope.createCompany = function(data) {
            $http({
                method: 'post',
                url: basePath + 'companies',
                data: data
            }).then(function successCallback(response) {
                $state.go("admin.settings", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        };

        $scope.updateCompany = function(id, data) {
            $http({
                method: 'put',
                url: basePath + 'companies/'+id,
                params: data
            }).then(function successCallback(response) {
                console.log(response);
                $state.go("admin.settings", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        };
    }])

    // orders controller
    .controller('adminOrdersCtrl', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {
        $scope.orders = {};
        // var method = 'post';
        $scope.ordersList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'orders',
                params: {user_id:$rootScope.userData.user.id}
            }).then(function successCallback(response) {
                $scope.orders = response.data.orders;
            }, function errorCallback(response) {
                console.log(response);
            });
        };
        // if ($rootScope.userData.user.hasOwnProperty('isAdmin')) {
            $scope.ordersList();
        // }
        $scope.removeOrder = function(id){
            bootbox.confirm('Дійсно видалити замовлення?', function(result) {
                if(result){
                    $http({
                        method: 'DELETE',
                        url: basePath+'orders/'+id,
                        params: {user_id:$rootScope.userData.user.id},
                    }).then(function successCallback(response) {
                        $scope.ordersList();
                    }, function errorCallback(response) {
                        console.log(response);
                    });
                }
            });
        }

        $scope.isHR = function() {
            return $rootScope.userData.user.hasOwnProperty('isHR');
        }
    }])

    .controller('adminOrderCtrl', ['$scope', '$http', '$state','$stateParams','$rootScope', function ($scope, $http, $state, $stateParams,$rootScope) {
        $scope.order = {};
        var method = 'post';

        if($stateParams.id){
            $http({
                method: 'get',
                url: basePath + 'orders/'+ $stateParams.id +'/edit',
                params: {user_id: $rootScope.userData.user.id}
            }).then(function successCallback(response) {
                $scope.order = response.data.order;
            }, function errorCallback(response) {
                console.log(response);
            });
        }

        $scope.sendOrder = function(data) {
            if($stateParams.id){
                $scope.updateOrder($stateParams.id, data);
            }else{
                $scope.createOrder(data);
            }
        };
        $scope.createOrder = function(data) {
            $http({
                method: 'post',
                url: basePath + 'orders',
                data: data
            }).then(function successCallback(response) {
                $state.go("admin.orders", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        };

        $scope.updateOrder = function(id, data) {
            $http({
                method: 'put',
                url: basePath + 'orders/'+id,
                params: data
            }).then(function successCallback(response) {
                $state.go("admin.orders", {}, {reload: true});
            }, function errorCallback(response) {
                console.log(response);
            });
        };
    }])

    //applicant controllers
    .controller('applicantVacanciesCtrl', ['$scope', '$http','$rootScope', function ($scope, $http,$rootScope) {
        $scope.vacanciesList = function(data) {
            $http({
                method: 'get',
                url: basePath + 'vacancies',
            }).then(function successCallback(response) {
                console.log(response)
                $scope.vacancies = response.data.vacancies;
            }, function errorCallback(response) {
                console.log(response);
            });
        };
        $scope.vacanciesList();
    }])
    .controller('applicantTestCtrl', ['$scope', '$http','$rootScope','$stateParams','$timeout', function ($scope, $http,$rootScope,$stateParams,$timeout) {
        $scope.isStart = false;
        $scope.isFinished = false;
        $scope.selectedAnswer = null;
        var timer;
        $scope.stopCounter = function() {
            $timeout.cancel(timer);
        };
        var updateCounter = function() {
            if($scope.counter>1){
                $scope.counter--;
            }else{
                $scope.counter = 'Час вийшов';
                $scope.getFinalResult();
                $scope.stopCounter();
            }
            timer = $timeout(updateCounter, 1000);
        };

        if($rootScope.userData){
            $http({
                method: 'get',
                url: basePath + 'vacancies/'+$stateParams.id,
                params: {user_id: $rootScope.userData.user.id}
            }).then(function successCallback(response) {
                $scope.vacancy = response.data.vacancy;
                $scope.counter = $scope.vacancy.test_time*60;
            }, function errorCallback(response) {
                console.log(response);
            });
        }

        $scope.isStartByUser = function() {
            $http({
                method: 'get',
                url: basePath + 'passed_result',
                params: {user_id: $rootScope.userData.user.id, vacancy_id: $stateParams.id}
            }).then(function successCallback(response) {
                if(response.data.result.length){
                    $scope.isFinished = true;
                    $scope.getFinalResult();
                }
            }, function errorCallback(response) {
                console.log(response);
            });
        };

        if($rootScope.userData){
            $scope.isStartByUser();
        }

        $scope.startTest = function() {
            $scope.isStart = true;
            updateCounter();
            $scope.getTest();
        };

        $scope.getTest = function() {
            $http({
                method: 'get',
                url: basePath + 'questions',
                params: {user_id: $rootScope.userData.user.id, vacancy_id: $stateParams.id}
            }).then(function successCallback(response) {
                $scope.vacancies = response.data.vacancies;
                $scope.questions = response.data.questions;
                //todo get empty status from api
                angular.forEach($scope.questions, function(value, key) {
                    angular.forEach(value.answers, function(value_a, key_a) {
                        value_a.status = 0;
                    });
                });
                $scope.currentQuestion = $scope.questions[0];
                $scope.questionIndex = 0;
            }, function errorCallback(response) {
                console.log(response);
            });
        };

        $scope.setAnswer = function(answer) {
            $scope.selectedAnswer = answer.id;
        };

        $scope.sendAnswer = function(data, index) {
            $http({
                method: 'post',
                url: basePath + 'results',
                data:{
                    question_id: data.id,
                    user_id: $rootScope.userData.user.id,
                    answer_id: $scope.selectedAnswer,
                    vacancy_id: data.vacancy_id,
                }
            }).then(function successCallback(response) {
                $scope.questionIndex++;
                if($scope.questionIndex<$scope.questions.length){
                    $scope.currentQuestion = $scope.questions[$scope.questionIndex];
                    $scope.selectedAnswer = false;
                }else{
                    $scope.getFinalResult();
                }
            }, function errorCallback(response) {
                console.log(response);
            });
        };

        $scope.getFinalResult = function() {
            $http({
                method: 'get',
                url: basePath + 'results',
                params: {user_id: $rootScope.userData.user.id, vacancy_id: $stateParams.id}
            }).then(function successCallback(response) {
                $http({
                    method: 'get',
                    url: basePath + 'questions',
                    params: {user_id: $rootScope.userData.user.id, vacancy_id: $stateParams.id}
                }).then(function successCallback(data) {
                    var questionsCount = data.data.questions.length;
                    var myAnswers = 0;
                    angular.forEach(response.data.results.vacancy.results, function(value, key) {
                        if(value.user_id==$rootScope.userData.user.id){
                            myAnswers++;
                        }
                    });
                    //recalculate result with not answered questions
                    $scope.result = ($scope.result*myAnswers)/questionsCount;
                }, function errorCallback(response) {
                    console.log(response);
                });
                $scope.result = response.data.results.result;
                $scope.isFinished = true;
                $scope.stopCounter();
            }, function errorCallback(response) {
                console.log(response);
            });

        }

        $scope.$watch('isFinished', function(value) {
            $scope.isStart = false;
        });
    }])