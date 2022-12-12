<?php
header("Content-Type: text/html;charset=utf-8");
require_once './model/news.php';
class newsController {
    public function getOneNews($idNew) {
        $news = new News();
        $oneNews = $news->getOneNews($idNew);
        if ($oneNews) {
            $parrafos = $news->getParrafos($idNew);
            //var_dump($parrafos);
            echo json_encode(array("header" => $oneNews, "parrafos" => $parrafos), JSON_UNESCAPED_UNICODE);
            return true;
        }
        echo json_encode(array("error" => true));
    }
}