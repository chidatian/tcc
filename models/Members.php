<?php

use Tc\Mvc\Model;

class Members extends Model {
    public function find() {
        return $this->request->get();
    }
}