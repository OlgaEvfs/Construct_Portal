<?php

class Controller {
    public static function StartSite() {
        $arr = News::getLast5News();
        include_once 'view/start.php';
    }

    public static function AllCategory() {
        $arr = Category::getAllCategory();
        include_once 'view/category.php';
    }

    public static function AllNews() {
        $arr = News::getAllNews();
        include_once 'view/allnews.php';
    }

    public static function NewsByCatID($id) {
        $arr = News::getNewsByCategoryID($id);
        include_once 'view/catnews.php';
    }

    public static function NewsByID($id) {
        $n = News::getNewsByID($id);
        include_once 'view/readnews.php';
    }

    public static function AllJobCategory() {
        $arr = News::getAllJobCategory();
        include_once 'view/jobcategory.php';
    }
    // список вакансий по категории
    public static function JobsByCategoryID($category_id) {
        $jobs = Job::getJobsByCategoryID($category_id);
        include_once 'view/jobslist.php';
    }

    // просмотр одной вакансии
    public static function JobByID($id) {
        $job = Job::getJobByID($id);
        include_once 'view/jobdetails.php';
    }

    public static function error404() {
        include_once 'view/error404.php';
    }
    
    public static function InsertComment($c,$id) {
        Comments::InsertComment($c,$id);
        //self::NewsByID($id);
        header('Location:news?id='.$id.'#ctable');
        // $c-текст комментария, $id-номер новости, для которой добавлен комментарий
    }

    // список комментариев
    public static function Comments($newsid) {
        $arr = Comments::getCommentByNewsID($newsid);
        ViewComments::CommentsByNews($arr);

    }
    // количество комментариев к новости
    public static function CommentsCount($newsid) {
        $arr = Comments::getCommentsCountByNewsID($newsid);
        ViewComments::CommentsCount($arr);

    }
    // ссылка - переход к списку комментариев
    public static function CommentsCountWithAncor($newsid) {
        $arr = Comments::getCommentsCountByNewsID($newsid);
        ViewComments::CommentsCountWithAncor($arr);

    }
    // Регистрация
    public static function registerForm() {
        include_once('view/formRegister.php');
    }
    public static function registerUser() {
        $result = Register::registerUser();
        include_once('view/answerRegister.php');
    }


}//end class