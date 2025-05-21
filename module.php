<?php


use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\DebugBarException;

class IlluminateDatabaseLibModule extends Module
{
    public const NAME = 'IlluminateDatabaseLib';
    public const VERSION = '1.0.0';
    public const NML_VER = '2.2.2';
    public const AUTHOR = '<a href="https://github.com/GIGABAIT93" target="_blank" rel="nofollow noopener">GIGABAIT</a>';

    private Capsule $capsule;

    public function __construct()
    {
        parent::__construct($this, self::NAME, self::AUTHOR, self::VERSION, self::NML_VER, load_after: ['Core']);
        $this->initDatabase();
        $this->initDebugBar();
    }

    private function initDatabase(): void
    {
        $dbConfig = [
            'driver' => Config::get('mysql.driver', 'mysql'),
            'host' => Config::get('mysql.host', '127.0.0.1'),
            'port' => Config::get('mysql.port', 3306),
            'database' => Config::get('mysql.db', ''),
            'username' => Config::get('mysql.username', ''),
            'password' => Config::get('mysql.password', ''),
            'charset' => Config::get('mysql.charset', 'utf8'),
            'collation' => Config::get('mysql.collation', 'utf8_unicode_ci'),
            'prefix' => Config::get('mysql.prefix', ''),
        ];

        $this->capsule = new Capsule;
        $this->capsule->addConnection($dbConfig);
        // Set the event dispatcher before running Eloquent
        $this->capsule->setEventDispatcher(new Dispatcher(new Container()));
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    private function initDebugBar(): void
    {
        if (!DEBUGGING or !class_exists('DebugBar\DebugBar')) {
            return;
        }

        $helper = DebugBarHelper::getInstance();
        try {
            $collector = $helper->getDebugBar()->getCollector('pdo');
            $connection = $this->capsule->getConnection();
            $traceable = new TraceablePDO($connection->getPdo());

            $connection->setPdo($traceable);
            $collector->addConnection($traceable, self::NAME);
            $collector->setRenderSqlWithParams(true, "'");
        } catch (DebugBarException $e) {
            // DebugBar is not available
        }
    }

    public function onInstall(): void
    {
        $this->log('installed successfully');
    }

    public function onEnable(): void
    {
        $this->log('enabled successfully');
    }

    public function onDisable(): void
    {
        $this->log('disabled successfully');
    }

    public function onUninstall(): void
    {
        $this->log('uninstalled successfully');
    }

    private function log(string $action): void
    {
        Log::getInstance()->log(self::NAME, "Lib {$action}.");
    }

    public function getDebugInfo(): array
    {
        return [];
    }

    public function onPageLoad(User $user, Pages $pages, Cache $cache, $smarty, iterable $navs, Widgets $widgets, TemplateBase $template)
    {
        // Not used
    }
}
