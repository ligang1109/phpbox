<?php

namespace Phpbox\View;

class Php extends Base
{
    private $assignData = array();

    public function __get($name)
    {
        return isset($this->assignData[$name]) ? $this->assignData[$name] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function assign($key, $value, $secureFilter = true)
    {
        if ($secureFilter) {
            $this->secureFilter($value);
        }

        $this->assignData[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function render($viewFile, $withViewSuffix = false, array $assignData = array())
    {
        foreach ($assignData as $key => $value) {
            $this->assign($key, $value);
        }

        $viewFile = $this->getViewFileWithViewRoot($viewFile, $withViewSuffix);
        ob_start();
        require($viewFile);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}