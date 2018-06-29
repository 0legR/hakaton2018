#------------------API routes with Request instances


#-----------User------------
#----------store------------
var data = {
    name: 'miha',
    phone: '8(342)23412342',
    password: '123123',
    email: 'miha@gmail.com',
    role: 2,
    user_ip: '192.168.0.1',
};
method = 'post';
var url = 'auth';
baseUrl = 'http://php_server.ua/api/' + url;
return json status;
#----------loggin----------
data= {
	password: '123123',
	email: 'serg@gmail.com',
};
method = 'get';
url = 'loggin';
baseUrl = 'http://php_server.ua/api/' + url;
return json {user : {
	name: 'miha',
    phone: '8(342)23412342',
    email: 'miha@gmail.com',
    isHR / isUser: bool,
    user_ip: '192.168.0.1',
    is_cheater: 0,
}};


#----------Vacanies-----
#------------index------
url = 'vacancies';
baseUrl = 'http://php_server.ua/api/' + url;
method = 'get';
return = json {vacancy: {
	id: 1,
	name: 'asdf',
	status: bool,
    test_time: 60
}};
#---------index by HR -------------------
var data = {
    user_id:5
};
url = 'vacancies';
baseUrl = 'http://php_server.ua/api/' + url;
method = 'get';
return = json {"vacancies":
    [{
        "id":7,
        "name":"chef",
        "status":1,
        "test_time":60,
        "created_by":5},
    {
        "id":8,
        "name":"attorney",
        "status":1,
        "test_time":60,
        "created_by":5
    }]
};
#----------store--------

var data = {
    user_id:5,
    name:'fotographer',
    status:1,
    test_time: 60
};
method = 'post';
var url = 'vacancies';
baseUrl = 'http://php_server.ua/api/' + url;
return json status;
#------------edit-----------------
var data = {
    user_id:5,
};
method = 'get';
var vacancy_id = 7;
var url = 'vacancies/'+ vacancy_id +'/edit';
var baseUrl = 'http://php_server.ua/api/' + url;
return json 
    vacancy:
        {id: 7, name: "chef", status: 1, test_time: 60, created_by: 5}
#-----------update--------
var data = {
    user_id:5,
    name:'fotographer-todo',
    status:0,
    test_time: 60
};
method = 'PUT';
var id = 4;
var url = 'vacancies/'+id;
baseUrl = 'http://php_server.ua/api/' + url;
return json status;
#-----------Destroy---------
var data = {
    user_id:5
};
method: 'DELETE';
var id = 4;
var url = 'vacancies/'+id;
baseUrl = 'http://php_server.ua/api/' + url;
return json status;

#--------Questions-----------------
#--------index-------------------
url = 'questions';
baseUrl = 'http://php_server.ua/api/' + url;
method = 'get';
data = {
	user_id: 5,
	vacancy_id: 4,
};
return json {
    questions(byVacancy): {

    },
    vacancies(all): {

    }
}
or
data = {
	user_id: 5,
};

return json {
    questions(all): {

    },
    vacancies(all): {

    }
};
#----------store-----------------------

url = 'questions';
baseUrl = 'http://php_server.ua/api/' + url;
method = 'post';
var data = {
    user_id:5,
    name:'what is photographer',
    vacancy_id: '4',
    status:1,
    answers: [
        {
            name: 'animal', 
            status: 0,
        },
        {
            name: 'thing', 
            status: 0,
        },
        {
            name: 'persone', 
            status: 1,
        },
        {
            name: 'vechicle', 
            status: 0,
        },
    ]
};

return json status;
#---------edit------------------

var data = {
    user_id:5,
};
var question_id = 31;
var url = 'questions/'+ question_id +'/edit';
method = 'get';
var baseUrl = 'http://php_server.ua/api/' + url;
return json 
question:
        {id: 31, vacancy_id: 1, name: "what is a php forever", status: 1,…}
answers:
        0:{id: 41, question_id: 31, name: "planguage", status: 0}
        1:{id: 42, question_id: 31, name: "humanLanguage", status: 0}
        2:{id: 43, question_id: 31, name: "book", status: 1}
        3:{id: 44, question_id: 31, name: "technique", status: 0}
#---------update----------------------------
var id = 21;
var url = 'questions/' + id;
baseUrl = 'http://php_server.ua/api/' + url;
method = 'PUT';
var data = {
    user_id:5,
    name:'what is photographer',
    vacancy_id: '4',
    status:1,
    answers: [
        {
            name: 'animalOPA', 
            status: 1,
            id: 1,
        },
        {
            name: 'thing', 
            status: 0,
            id: 2,
        },
        {
            name: 'persone', 
            status: 0,
            id: 3,
        },
        {
            name: 'vechicle', 
            status: 0,
            id: 4,
        },
    ]
};

return json status;

#----------destroy------------------------------
var data = {
    user_id:5,
};
var id = 21;
var url = 'questions/' + id;
var baseUrl = 'http://php_server.ua/api/' + url;
method = 'DELETE';
return json status;

#-----------Results-------------------
#----------store from user------------
var data = {
    question_id: 22,
    user_id: 1,
    answer_id: 1,
    vacancy_id: 1,
};
method = 'post';
var url = 'results';
var baseUrl = 'http://php_server.ua/api/' + url;
return json status;
#-----------index-from user- all of his tests--------------------

data = {
    user_id: 1
}
method = 'get';
var url = 'results';
var baseUrl = 'http://php_server.ua/api/' + url;
return json {
    results: [
            'vacancy' => $vacancy,
            'user' => $user,
            'result' => $persentageResult,
            ],
            [
                'vacancy' => $vacancy,
                'user' => $user,
                'result' => $persentageResult,
            ]
};

#-----------index from user by vacancy id after the end of the test

data = {
    user_id: 1,
    vacancy_id: 6,
}
method = 'get';
var url = 'results';
var baseUrl = 'http://php_server.ua/api/' + url;
return json {
    results: {
            'vacancy' => $vacancy,
            'user' => $user,
            'result' => $persentageResult,
    }
};

#------------index from hr -------
data = {
    user_id: 1
}
method = 'get';
var url = 'results';
var baseUrl = 'http://php_server.ua/api/' + url;

return json {result:[[{vacancy: {id: 6, name: "fotographer", status: 1,…},…},…]]
0:[{vacancy: {id: 6, name: "fotographer", status: 1,…},…},…]
0:{vacancy: {id: 6, name: "fotographer", status: 1,…},…}
result:16.666666666666668
user:{id: 1, name: "0leg", phone: "8(342)23412342", email: "qwert@gmail.com", role: 1}
vacancy:{id: 6, name: "fotographer", status: 1,…}
1:{vacancy: {id: 1, name: "developer", status: 1,…},…}
result:20
user:{id: 1, name: "0leg", phone: "8(342)23412342", email: "qwert@gmail.com", role: 1}
vacancy:{id: 1, name: "developer", status: 1,…}}

#-----------------Company------------------
#--------------store----------------
var data = {
    user_id:5,
    name: 'roshen',
    phone: '8(342)23412342',
    address: 'sldfj434884lasdfj',
    email: 'roshen@gmail.com',
    web_link: 'www.roshen.com',
};

method = 'post';
var url = 'companies';
var baseUrl = 'http://php_server.ua/api/' + url;
return json status;

#-----------------index-----------------
data = {
    user_id: 1
}

method = 'get';
var url = 'companies';
var baseUrl = 'http://php_server.ua/api/' + url;
return json 
company:[{
  address:"sldfj434884lasdfj"
    email: "roshen@gmail.com"
    id:1
    image:null
    name:"roshen"
    phone:"8(342)23412342"
    user_id:5
    web_link:"www.roshen.com"  
}]

