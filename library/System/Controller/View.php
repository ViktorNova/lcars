<?php
namespace System\Controller;
/**
 * @author xerox
 * @abstract
 */
abstract class View extends \System\Controller\Model
{
    /**
     * @return \System\View\Model
     */
    public function getView()
    {
        return $this->_view;
    }

    /**
     * @param \System\View\Model $view
     */
    public function setView(\System\View\Model $view)
    {
        $this->_view = $view;
    }

    /**
     * @param string $action
     */
    public function registerView()
    {
        $action = $this->_route->getAction(true);
        $viewModuleNamespace = $this->_module->getNamespace();
        $viewModuleName = $this->_module->getName();

        $viewName = strtolower($action);

        if (!empty($viewModuleNamespace) && empty($this->_controllerName))
        {
            $this->_controllerName = ucfirst($this->_controllerDefault);
        }

        if (!empty($viewModuleNamespace) && empty($viewName))
        {
            $viewName = strtolower($this->_actionDefault);
            // set if a rest route called
            if (!empty($this->_action))
            {
                $viewName = $this->_action;
            }
        }

        if (empty($viewModuleName))
        {
            $viewModuleName = $this->_moduleDefault;
            $viewModuleNamespace = $viewModuleNamespace . $viewModuleName;
        }

        $viewPath = $viewModuleNamespace . '\\' . $this->_viewPath . '\\'
            . $this->_controllerName . '\\' . $viewName;

        if (!empty($viewName) && $this->_viewEnabled)
        {
            $viewFilePath = APPLICATION_PATH
                . preg_replace('/\\\/', '/', $viewPath) . $this->_viewFileType;

            if (file_exists($viewFilePath))
            {
                if (is_object($this->_model))
                {
                    $this->_view->data = $this->getData();
                }
                $this->_view->content = (string) file_get_contents(
                    $viewFilePath);
            }
            else
            {
                throw new \Exception(
                    'View at "' . $viewPath . $this->_viewFileType
                        . '" not found');
            }
        }
    }
}
