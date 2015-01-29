<?php

namespace nexxes\widgets;

trait PageTrait
{

    /**
     * @var array<\nexxes\widgets\StyleSheetInterface>
     */
    private $PageTraitStyles = [];

    /**
     * @implements \nexxes\widgets\PageInterface
     */
    public function addStyleSheet(\nexxes\widgets\StyleSheetInterface $style)
    {
        $this->PageTraitStyles[] = $style;
        return $this;
    }

    /**
     * @implements \nexxes\widgets\PageInterface
     */
    public function getStyleSheets()
    {
        return $this->PageTraitStyles;
    }

    /**
     * @var array<\nexxes\widgets\ScriptInterface>
     */
    private $PageTraitScripts = [];

    /**
     * @implements \nexxes\widgets\PageInterface
     */
    public function addScript(\nexxes\widgets\ScriptInterface $script)
    {
        $this->PageTraitScripts[] = $script;
        return $this;
    }

    /**
     * @implements \nexxes\widgets\PageInterface
     */
    public function getScripts()
    {
        return $this->PageTraitScripts;
    }

    /**
     * @var \nexxes\widgets\ParameterRegistry
     */
    private $PageTraitParameterRegistry;

    /**
     * Silently initializes the parameter registry with the provided default implementation on first access
     * @implements \nexxes\widgets\PageInterface
     */
    public function getParameterRegistry()
    {
        if (is_null($this->PageTraitParameterRegistry)) {
            $this->initParameterRegistry();
        }

        return $this->PageTraitParameterRegistry;
    }

    /**
     * @implements \nexxes\widgets\PageInterface
     */
    public function initParameterRegistry(\nexxes\widgets\ParameterRegistry $newParameterRegistry = null)
    {
        if (!is_null($this->PageTraitParameterRegistry)) {
            throw new \RuntimeException("Can not replace existing parameter registry!");
        }

        if (is_null($newParameterRegistry)) {
            $this->PageTraitParameterRegistry = new \nexxes\widgets\ParameterRegistry();
        } else {
            $this->PageTraitParameterRegistry = $newParameterRegistry;
        }

        return $this;
    }

    public function __wakeup()
    {

    }

    public $remoteActions = [];

    public function executeRemote($action, $parameters = [])
    {
        $this->remoteActions[] = [$action, $parameters];
    }

    ######################################################################
    # Widget ID registration
    ######################################################################

    /**
     * A list of all IDs that are used by widgets.
     * Stored to prevent ID clashes for new widgets.
     *
     * @var array<string>
     */
    protected $takenWidgetIdList = [];

    /**
     * Generate a new ID for a widget
     *
     * @param integer $length
     * @return string
     */
    public function generateID($length = 5)
    {
        $newID = 'w_' . (new \nexxes\common\RandomString($length));

        if (!\in_array($newID, $this->takenWidgetIdList)) {
            $this->takenWidgetIdList[] = $newID;
            return $newID;
        }

        // If new ID is not unique, create a new one that is one char longer
        return $this->generateId($length + 1);
    }

    /**
     * Register the supplied ID.
     * Returns whether the ID was free and is registered now or not.
     *
     * @param string $newID
     * @return boolean
     */
    public function registerID($newID)
    {
        if (!\in_array($newID, $this->takenWidgetIdList)) {
            $this->takenWidgetIdList[] = $newID;
            return true;
        } else {
            return false;
        }
    }

}
