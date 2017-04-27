<?php

namespace Phpbox\View;

class Php extends Base
{
    private $assignData = array();

    public function __get($name)
    {
        return isset($this->assignData[$name]) ? $this->assignData[$name] : null;
    }

    public function assign($key, $value, $secureFilter = true)
    {
        if ($secureFilter) {
            $this->secureFilter($value);
        }

        $this->assignData[$key] = $value;

        return $this;
    }

    public function render($viewFile, $appendViewSuffix = true, array $assignData = array())
    {
        foreach ($assignData as $key => $value) {
            $this->assign($key, $value);
        }

        $viewFile = $this->getViewFileWithViewRoot($viewFile, $appendViewSuffix);

        ob_start();
        require($viewFile);
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }
}