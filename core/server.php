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
        //session_start();
        $rq = request::getPostJSON();

        //	print_r(@$rq);

        if (!isset($rq->token)) {
            $token = session::start();
        } else {
            $token = session::start(@$rq->token);
        }

        $this->log(print_r($rq,1));
        $ctr = new Controller();
        $ctr->setAction(@$rq->action);
        $ctr->setModule(@$rq->module);
        // $ctr->setParams(request::ut8ParamsEncode(@$rq->params));

        $ctr->setParams(@$rq->params);
        $ctr->setFormat("json");
        $ctr->assign('token', $token);

        //debug
        if ($ctr->getDebug()) {
            $arr = $ctr->getArray();
            var_dump($rq);
            print_r($arr);
        } else {
            $ctr->renderJSON();
        }

        //print_r(session::$data);
        session::writeclose($token);

        $this->log(print_r($ctr->getData(),1));

    }

    public function log($data) {
        file_put_contents (LOG_FILE, print_r($data,  FILE_APPEND));
    }

}
