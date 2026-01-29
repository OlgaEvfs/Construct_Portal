<?php
class controllerAdminNews {

    // list News
    public static function NewsList() {
        $arr = modelAdminNews::getNewsList();
        $jobs = Job::getAllJobs();
        include_once 'viewAdmin/newsList.php';
    }
    //----add
    // news
    public static function newsAddForm() {
        $arr = modelAdminCategory::getCategoryList();
        include_once('viewAdmin/newsAddForm.php');
    }
    public static function newsAddResult() {
        $test = modelAdminNews::getNewsAdd();
        include_once('viewAdmin/newsAddForm.php');
    }

    //jobs
    public static function jobsAdd() {
        $arr = modelAdminCategory::getCategoryList();
        include_once('viewAdmin/jobsAdd.php');
    }
    public static function jobsAddResult() {
        $test = modelAdminNews::getJobsAdd();
        include_once('viewAdmin/jobsAdd.php');
    }
    //------edit
    //news
    public static function newsEditForm($id) {
        $arr = modelAdminCategory::getCategoryList();
        $detail = modelAdminNews::getNewsDetail($id);
        include_once('viewAdmin/newsEditForm.php');
    }
    public static function newsEditResult($id) {
        $test = modelAdminNews::getNewsEdit($id);
        include_once('viewAdmin/newsEditForm.php');
    }

    //jobs
    public static function jobEdit($id) {
        $arr = modelAdminCategory::getCategoryList();
        $detail = modelAdminNews::getJobDetail($id);
        include_once('viewAdmin/jobEdit.php');
    }
    public static function jobEditResult($id) {
        $test = modelAdminNews::getJobEdit($id);
        include_once('viewAdmin/jobEdit.php');
    }
    //---------delete
    //news
    public static function newsdeleteForm($id) {
        $arr = modelAdminCategory::getCategoryList();
        $detail = modelAdminNews::getNewsDetail($id);
        include_once('viewAdmin/newsDeleteForm.php');
    }
    public static function newsDeleteResult($id) {
        $test = modelAdminNews::getNewsDelete($id);
        include_once('viewAdmin/newsDeleteForm.php');
    }

    //jobs
    public static function jobDelete($id) {
        $arr = modelAdminCategory::getCategoryList();
        $detail = modelAdminNews::getJobDetail($id);
        include_once('viewAdmin/jobDelete.php');
    }
    public static function jobDeleteResult($id) {
        $test = modelAdminNews::getJobDelete($id);
        include_once('viewAdmin/jobDelete.php');
    }
}// class
?>