<?php

/**
 *  AkroApi simple server
 *
 *
 */

// DO NOT FORGET: "LESS IS MORE"

class Server {

    public function run() {

        header('Content-Type: text/html; charset=utf-8');
        date_default_timezone_set("Europe/Paris");

        $req = request::getPostJSON();

        if (!isset($req->token)) {
            $token = session::start();
        } else {
            $token = session::start(@$req->token);
        }

        $this->log(print_r($req,1));

        $app = new Controller();
        $app->setAction(@$req->action);
        $app->setModule(@$req->module);
        // $app->setParams(request::ut8ParamsEncode(@$req->params));

        $app->setParams(@$req->params);
        $app->setFormat("json");
        $app->assign('token', $token);

        //debug
        if ($app->getDebug()) {
            $arr = $app->getArray();
            var_dump($req);
            print_r($arr);
        } else {
            $app->renderJSON();
        }

        session::writeclose($token);

        $this->log(print_r($app->getData(),1));

    }

    public function log($data) {
        file_put_contents (LOG_FILE, print_r($data,  FILE_APPEND));
    }

}
