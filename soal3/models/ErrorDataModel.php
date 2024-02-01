<?php
class ErrorDataModel {
    public $code;
    public $type;
    public $message;

    public function __construct($data) {
        $this->code = $data['code'];
        $this->type = $data['type'];
        $this->message = $data['message'];
    }
}
