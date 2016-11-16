<?php
namespace app\util;

/**
 * Configurator assembles config from system defaults and user overrides
 */
class Configurator
{
    private $userPath;
    private $systemPath;

    /**
     * Configurator constructor.
     */
    public function __construct($path)
    {
        $this->userPath = $path;
        $this->systemPath = $path . '/system';
    }

    public function getConfig($name)
    {
        $userConfig = array();
        $userPath = $this->userPath . '/' . $name;
        if (file_exists($userPath)) {
            $userConfig = $this->requireWithConfigurator($userPath);
        }

        $systemConfig = $this->requireWithConfigurator($this->systemPath . '/' . $name);
        
        return array_merge($systemConfig, $userConfig);
    }

    protected function requireWithConfigurator($path)
    {
        $configurator = $this;
        return require $path;
    }
}
