<?php
use App\Config;
/**
 * Permet d'afficher une vue et de lui passer des paramètres
 * @param string $view La vue à affichier
 * @param array $params Les paramètres à renvoyer
 * @throws Exception
 */
function render($view, $params = []){

}


/**
 * Affiche les variables et protège des failles XSS
 * @param string $variable
 */
function html_safe($variable){
    echo htmlspecialchars($variable);
}

/**
 * @param string $method
 * @param string $url
 * @param bool|array $data
 * @return mixed
 */
function callAPI($method, $url, $data = false) {
    $curl = curl_init();
    $rest = Config::$PATH_REST;
    switch ($method) {

        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) {
                $data = json_encode($data);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;

        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            if ($data) {
                $data = json_encode($data);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        default:
            if ($data)
                $rest .= "%s?%s" . http_build_query($data);
            break;
    }

    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    curl_setopt($curl, CURLOPT_URL, $rest.$url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);
    return json_decode($result);
}