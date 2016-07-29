<?php

namespace App\Controller;

class Controller {

    protected $template = "default";

    /**
     * Render a view
     * @param string $view
     * @param array $variables
     * @throws \App\Router\RouterException
     */
    public function render($view, $variables = []){
        ob_start();
        extract($variables);
        if(file_exists(__DIR__."/../../view/html/$view.php")){
            require __DIR__."/../../view/html/{$view}.php";
        }else {
            throw new \App\Router\RouterException("View not found");
        }
        $content = ob_get_clean();
        require __DIR__."/../../view/template/{$this->template}.php";
    }

    public function error($code){
        ob_start();
        require __DIR__."/../../view/html/error/{$code}.php";
        $content = ob_get_clean();
        require __DIR__."/../../view/template/error.php";
    }

    /**
     * Send email in html and text
     * @param string $mail
     * @param array $variables
     * @return array
     */
    public function mail($mail, $variables = []){
        ob_start();
        extract($variables);
        if(file_exists(__DIR__."/../../view/mail/text/$mail.php")){
            require __DIR__."/../../view/mail/text/{$mail}.php";
        }
        $result[0] = ob_get_clean();

        ob_start();
        extract($variables);
        if(file_exists(__DIR__."/../../view/mail/html/$mail.php")){
            require __DIR__."/../../view/mail/html/{$mail}.php";
        }
        $result[1] = ob_get_clean();
        return $result;
    }

    /**
     * Request is ajax ?
     * @return bool
     */
    public function isAjax(){
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;
        return false;
    }


}