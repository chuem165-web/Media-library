<?php
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require_once BASE_PATH . '/vendor/autoload.php';
session_start();

try {
    Dotenv::createImmutable(BASE_PATH)->safeLoad();
} catch (InvalidPathException $e) {
    // Skip loading .env when the file is not present.
}


require_once BASE_PATH . '/inc/Database.php';
require_once BASE_PATH . '/Interface/BaseRepositoryInterface.php';
require_once BASE_PATH . '/Interface/CatalogRepositoryInterface.php';
require_once BASE_PATH . '/Interface/FormatRepositoryInterface.php';
require_once BASE_PATH . '/Repository/BaseRepository.php';
require_once BASE_PATH . '/Repository/CatalogRepository.php';
require_once BASE_PATH . '/Repository/FormatRepository.php';
require_once BASE_PATH . '/Service/BaseService.php';
require_once BASE_PATH . '/Service/CatalogService.php';
require_once BASE_PATH . '/Service/FormatService.php';
require_once BASE_PATH . '/Service/SuggestService.php';
require_once BASE_PATH . '/Service/MailService.php';
require_once BASE_PATH . '/view/ItemView.php';
require_once BASE_PATH . '/Controller/Api/ApiCatalogController.php';
require_once BASE_PATH . '/Controller/Api/ApiDetailsController.php';
require_once BASE_PATH . '/Controller/Api/ApiSuggestController.php';
require_once BASE_PATH . '/Controller/CatalogController.php';
require_once BASE_PATH . '/Controller/DetailsController.php';
require_once BASE_PATH . '/Controller/SuggestController.php';
require_once BASE_PATH . '/Interface/UserRepositoryInterface.php';
require_once BASE_PATH . '/Repository/UserRepository.php';
require_once BASE_PATH . '/Service/AuthService.php';
require_once BASE_PATH . '/Controller/AuthController.php';

$catalogService = new CatalogService();
$formatService = new FormatService();
$suggestService = new SuggestService();
$mailService = new MailService();
$authService = new AuthService();

/* =========================
   ROUTING
========================= */

$page = $_GET['page'] ?? 'home';

/* =========================
   API ROUTES (IMPORTANT FIRST)
========================= */
if (str_starts_with($page, 'api/')) {

    switch ($page) {

            case 'api/catalog':
            $controller = new ApiCatalogController($catalogService);
            $controller->index();
            exit;

        case 'api/details':
            $controller = new ApiDetailsController($catalogService);
            $controller->show();
            exit;

        case 'api/suggest':
    $controller = new ApiSuggestController($formatService);
    $controller->submit();
    exit;

        default:
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'API endpoint not found'
            ]);
            exit;
    }
}

/* =========================
   NORMAL MVC ROUTES
========================= */

switch ($page) {

    case 'details':
        $controller = new DetailsController($catalogService);
        $controller->show();
        break;

    case 'suggest':
        $controller = new SuggestController(
            $formatService,
            $suggestService,
            $mailService
        );
        $controller->index();
        break;

    case 'catalog':
        $controller = new CatalogController($catalogService , $authService);
        $controller->index();
        break;

    case 'register':
    $controller =
        new AuthController($authService);

    $controller->register();
    break;

case 'login':
    $controller =
        new AuthController($authService);

    $controller->login();
    break;

case 'logout':
    $controller =
        new AuthController($authService);

    $controller->logout();
    break;

    default:
        $controller = new AuthController($authService);
        $controller->register();
        break;
}