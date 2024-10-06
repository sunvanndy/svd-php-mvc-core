<?php
/**
 * Created DateTime: 6/21/2024, 10:52 PM
 * @package app\core
 */

namespace app\core;

use app\core\db\Database;
use app\core\db\DbModel;
use app\models\User;

class Application
{
    public static string $ROOT_DIR;

    // This layout declare is optional since in case it's unknown param layout in the LayoutContent of Router Class
    public string $layout = 'main';
    public string $userClass;

    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db; // TODO Sec 2:29:00 - 2:39:00 (connect DB) - 3:04:45 finished migration
//    public DbModel $user; => UserModel
    public ?UserModel $user = null;
    public ?View $view = null;

    public static Application $app;
    // If $controller is meant to be nullable, you can declare it as:
    public ?Controller $controller = null;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];

        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->view = new View();

        $this->db = new Database($config['db']);

        // Below approach to get the user login while navigate the other pages
        $primaryValue = $this->session->get('user');

        if ($primaryValue) {
            $user = new User();
            $primaryKey = $user->primaryKey();
            $this->user = $user->findOne([$primaryKey => $primaryValue]); // where PrimaryKey => PrimaryValue
        }
    }

    public static function isGuess()
    {
        return !self::$app->user;
    }

    public function run()
    {
        try {
            $this->router->resolve();
        } catch (\Exception $e){
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @param UserModel $user
     */
    public function login(UserModel $user)
    {
        // Save user into session
        // Multiple browser login

        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}