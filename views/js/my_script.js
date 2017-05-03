/**
 * Created by oem on 30.04.17.
 */

//AngularJS модуль
var messageApp = angular.module('messageApp', [])

    //AngularJS контроллер
    .controller('Messages', function ($scope, $http) {

        //Обьявление переменных
        $scope.errorMes = false;
        $scope.errorComm = false;
        $scope.errorCommEdit = false;
        $scope.errorMessEdit = false;
        $scope.allComments = false;

        $scope.getMessage = '';
        $scope.getComment = '';
        $scope.dataEditComment ='';
        $scope.dataEditMessage ='';

        $scope.commentsShow = [];
        $scope.editComments = [];
        $scope.editMessages = [];

        var page =1;

        //Запрос данных о пользователе
        $http.post('../../ajax/ajax_user_is_login.php', []).then(function (data) {
            $scope.user = data.data;
            $scope.login = data.data.id ? true : false;
        });

        //Post запрос
        $scope.postGet = function (url) {
            $http.post(url, []).then(function (data) {
                $scope.messages = data.data;
            });
        };

        //Функция данных сообщений
        $scope.getContent = function () {
            var url = '../../ajax/message_ajax.php?type=get&page='+page;
            $scope.postGet(url);
        };

        $scope.getContent();

        //Добавить новое сообщение
        $scope.submitMes = function () {
            if(this.getMessage.length>5){
                $scope.errorMes = false;
                var getMessage = this.getMessage;
                this.getMessage = '';

                var url = '../../ajax/message_ajax.php?type=add&page='+page+'&message='+getMessage;
                $scope.postGet(url);
            } else {
                $scope.errorMes = true;
            }
        };

        //Редактировать сообщение
        $scope.submitEditMess = function (message_id) {
            if(this.dataEditMessage.length>5){
                $scope.errorMessEdit = false;
                var dataEditMessage = this.dataEditMessage;

                var url = '../../ajax/message_ajax.php?type=edit&page='+page+'&message='+dataEditMessage+'&message_id='+message_id;
                $scope.postGet(url);

                $scope.editMessages=[];
            }else if(this.dataEditMessage.length != 0){
                $scope.errorMessEdit = true;
            }
        };

        //Удалить сообщение
        $scope.deleteMessage = function (message_id) {
            console.log(message_id);
            if (confirm('Вы уверенны?')){

                var url = '../../ajax/message_ajax.php?type=delete&page='+page+'&message_id='+message_id;
                $scope.postGet(url);
            }
        };

        //Добавить новый коментарий
        $scope.submitComment = function (message_id) {
            if(this.getComment.length>5){
                $scope.errorComm = false;
                var getComment = this.getComment;
                this.getComment = '';

                var url = '../../ajax/comment_ajax.php?type=add&page='+page+'&comment='+getComment+'&message_id='+message_id;
                $scope.postGet(url);
            } else {
                $scope.errorComm = true;
            }
        };

        //Редактировать коментарий
        $scope.submitEditComm = function (comment_id) {
            if(this.dataEditComment.length>5){
                $scope.errorCommEdit = false;
                var dataEditComment = this.dataEditComment;

                var url = '../../ajax/comment_ajax.php?type=edit&page='+page+'&comment='+dataEditComment+'&comment_id='+comment_id;
                $scope.postGet(url);

                $scope.editComments=[];
            }else if(this.dataEditComment.length != 0){
                $scope.errorCommEdit = true;
            }
        };

        //Удалить коментарий
        $scope.deleteComment = function (comment_id) {
            console.log(comment_id);
            if (confirm('Вы уверенны?')){

                var url = '../../ajax/comment_ajax.php?type=delete&page='+page+'&comment_id='+comment_id;
                $scope.postGet(url);
             }
        };

        // infinite scrolling
        var scrollHeight = 0;

        window.onscroll = function() {
            var scrolled = window.pageYOffset || document.documentElement.scrollTop,
                scrollHeightLocal = document.getElementById('scroll').offsetHeight;

            if( scrolled > ( scrollHeightLocal * 0.7 ) && scrollHeightLocal > scrollHeight ){
                scrollHeight =document.getElementById('scroll').offsetHeight;
                page++;

                $scope.getContent();
            }
        };
    });