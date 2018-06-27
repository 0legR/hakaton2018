#------------------API routes with Request instances


#-----------User------------
#----------store------------
var data = {
    name: 'miha',
    phone: '8(342)23412342',
    password: '123123',
    email: 'miha@gmail.com',
    role: 2
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
    isHR / isUser: bool
}};


#----------Vacanies-----
#------------index------
url = 'vacancies';
baseUrl = 'http://php_server.ua/api/' + url;
method = 'get';
return = json {vacancy: {
	id: 1,
	name: 'asdf',
	status: bool
}};
#----------store--------

var data = {
    userId:5,
    name:'fotographer',
    status:1
};
method = 'post';
var url = 'vacancies';
baseUrl = 'http://php_server.ua/api/' + url;
return json status;

#-----------update--------
var data = {
    userId:5,
    name:'fotographer-todo',
    status:0
};
method: 'PUT';
var id = 4;
var url = 'vacancies/'+id;
baseUrl = 'http://php_server.ua/api/' + url;
return json status;
#-----------Destroy---------
var data = {
    userId:5
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
	userId: 5,
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
	userId: 5,
};

return json {
    questions(all): {

    },
    vacancies(all): {

    }
};







