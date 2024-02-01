<?php
class SuccessDataModel {
    public $code;
    public $type;
    public $message;
    public $data;

    public function __construct($data) {
        $this->code = $data['code'];
        $this->type = $data['type'];
        $this->message = $data['message'];
        $this->data = $data['data'];
    }
}
