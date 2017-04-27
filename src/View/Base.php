<?php

namespace Phpbox\View;

abstract class Base
{/*{{{*/
    abstract public function assign($key, $value, $secureFilter = true);
    abstract public function render($viewFile, $appendViewSuffix = true, array $assignData = array());

    protected $viewRoot = '';
    protected $viewSuffix = '';

    public function __construct($viewRoot, $viewSuffix)
    {
        $this->setViewRoot($viewRoot);
        $this->setViewSuffix($viewSuffix);
    }

    public function setViewRoot($viewRoot)
    {
        $this->viewRoot = rtrim($viewRoot, '/') . '/';

        return $this;
    }

    public function getViewRoot()
    {
        return $this->viewRoot;
    }

    public function setViewSuffix($viewSuffix)
    {
        $this->viewSuffix = $viewSuffix;

        return $this;
    }

    public function getViewSuffix()
    {
        return $this->viewSuffix;
    }

    protected function getViewFileWithViewRoot($viewFile, $appendViewSuffix)
    {
        $viewFile = $this->viewRoot . ltrim($viewFile, '/');
        if ($appendViewSuffix) {
            $viewFile .= '.' . $this->viewSuffix;
        }

        if (!file_exists($viewFile)) {
            throw new \Exception('view file ' . $viewFile . ' not exists');
        }

        return $viewFile;
    }

    protected function secureFilter(&$value)
    {
        if (is_array($value)) {
            array_walk_recursive($value, 'secureFilterSimpleValue');
        } else {
            $this->secureFilterSimpleValue($value);
        }
    }

    private function secureFilterSimpleValue(&$value)
    {
        if (is_string($value)) {
            htmlspecialchars($value);
        }
    }
}
