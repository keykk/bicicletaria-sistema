<?php
/**
 * Front Controller - Sistema de Gestão de Bicicletaria
 * Ponto de entrada único da aplicação
 */

// Configurações iniciais
error_reporting(E_ALL);
ini_set('display_errors', 1);

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$script_name = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . $host . $script_name);
define('PUBLIC_URL', BASE_URL . '/public');

// Definir constantes do sistema
define('APP_ROOT', dirname(dirname(__FILE__)));
define('ROOT_PATH', dirname(__FILE__));
define('APP_PATH', APP_ROOT . '/app');
define('CONFIG_PATH', APP_ROOT . '/config');
define('PUBLIC_PATH', ROOT_PATH . '/public');



// Autoload das classes
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/controllers/' . $class . '.php',
        APP_PATH . '/models/' . $class . '.php',
        CONFIG_PATH . '/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Iniciar sessão
session_start();

// Roteamento básico
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// Remover a pasta do projeto da URL se necessário
$basePath = dirname($_SERVER['SCRIPT_NAME']);
if ($basePath !== '/') {
    $path = str_replace($basePath, '', $path);
}

// Limpar a URL
$path = trim($path, '/');

// Definir rota padrão
if (empty($path)) {
    $path = 'dashboard/index';
}

// Separar controlador e ação
$segments = explode('/', $path);
$controllerName = ucfirst($segments[0]) . 'Controller';
$action = isset($segments[1]) ? $segments[1] : 'index';

//echo $path;

// Verificar se o controlador existe
$controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        
        if (method_exists($controller, $action)) {
            // Passar parâmetros adicionais se existirem
            $params = array_slice($segments, 2);
            call_user_func_array([$controller, $action], $params);
        } else {
            // Ação não encontrada
            http_response_code(404);
            echo "Ação '$action' não encontrada no controlador '$controllerName'";
        }
    } else {
        // Classe do controlador não encontrada
        http_response_code(404);
        echo "Classe '$controllerName' não encontrada";
    }
} else {
    // Controlador não encontrado
    http_response_code(404);
    echo "Controlador '$controllerName' não encontrado ";
}
?>


