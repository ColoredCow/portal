<?php
namespace OfficeSuite;

use Exception;
use OfficeSuite\Contracts\OfficeSuiteServiceContract;

class OfficeSuiteManager
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new OfficeSuite manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function resolve()
    {
        $default = config('officesuites.default');
        $config = config('officesuites')[$default];
        $service = new $config['service_class_path'];

        if ($service instanceof OfficeSuiteServiceContract) {
            return $service;
        }

        throw new Exception('Service class must implement the OfficeSuiteServiceContract');
    }
}
