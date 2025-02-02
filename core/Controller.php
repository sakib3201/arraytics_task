<?php

namespace Core;

class Controller {
    public function render($view, $data = []) {
        extract($data);
        require "../app/views/$view.php";
    }
}
