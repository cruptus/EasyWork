<?php

namespace App\Helper;

use App\Config;

class Captcha {

    private $private;
    private $website;

    /**
     * Captcha constructor.
     */
    public function __construct() {
        $this->private = Config::$CAPTCHA_PRIVATE;
        $this->website = Config::$CAPTCHA_WEBSITE;
    }


    /**
     * Retourne le code html du captcha
     * @return string
     */
    public function html(){
        return "<div class='g-recaptcha' data-sitekey='{$this->website}'></div>";
    }

    /**
     * Retourne si le code captcha est valide
     * @param $code
     * @return bool
     */
    public function isValid($code){
        if (empty($code)) {
            return false; // Si aucun code n'est entré, on ne cherche pas plus loin
        }
        $params = [
            'secret'    => $this->private,
            'response'  => $code
        ];

        $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);

        } else {
            $response = file_get_contents($url);
        }

        if (empty($response) || is_null($response)) {
            return false;
        }

        $json = json_decode($response);
        return $json->success;
    }



}