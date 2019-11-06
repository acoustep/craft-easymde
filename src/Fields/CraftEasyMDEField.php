<?php
/**
 * EasyMDE Field plugin for Craft CMS 3.x
 *
 * @link      https://www.mitchartemis.dev
 * @copyright Copyright (c) 2019 Mitch Stanley
 */
namespace Acoustep\CraftEasyMDE\Fields;
use Craft;
use craft\base\ElementInterface;
use craft\base\PreviewableFieldInterface;
use craft\fields\PlainText;
/**
 * Incognito field type
 *
 * @author    Mats Mikkel Rummelhoff
 * @package   IncognitoField
 * @since     1.0.0
 *
 */
class CraftEasyMDEField extends PlainText implements PreviewableFieldInterface
{
    // Properties
    // =========================================================================
    public $mode = 'plain';
    public $modeOverride;
    private $_modes;
    // Static Methods
    // =========================================================================
    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return 'EasyMDE';
    }
    // Public Methods
    // =========================================================================
    public function __construct(array $config = [])
    {
        $this->_modes = [
            'plain' => Craft::t('site', 'Plain Text'),
            // 'disabled' => Craft::t('site', 'Disabled'),
            // 'hidden' => Craft::t('site', 'Hidden'),
            // 'readonly' => Craft::t('site', 'Read-only'),
        ];
        parent::__construct($config);
    }
    public function rules()
    {
        $rules = array_merge(parent::rules(), [
            [['mode'], 'string'],
            [['mode'], 'default', 'value' => 'plain'],
        ]);
        return $rules;
    }

    /**
     * @param mixed $value
     * @param ElementInterface|null $element
     *
     * @return string
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $mode = $this->_getMode($element);
        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);
        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'easymde-markdown-editor/_components/fields/_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'mode' => $mode,
            ]
        );
    }
    // Private Methods
    // =========================================================================
    /**
     * @param ElementInterface|null $element
     * @return string
     * @throws \yii\base\Exception
     */
    private function _getMode(ElementInterface $element = null): string
    {
        // Return early if there is no override set
        if (empty($this->modeOverride)) {
            return $this->mode;
        }
        $view = Craft::$app->getView();
        $oldTemplateMode = $view->getTemplateMode();
        $view->setTemplateMode($view::TEMPLATE_MODE_SITE);
        try {
            $modeOverride = $view->renderString($this->modeOverride, ['element' => $element]);
            $modeOverride = trim($modeOverride);
        } catch (\Exception $e) {
            Craft::error('Couldn’t render mode override template. '.$e->getMessage(), __METHOD__);
            $view->setTemplateMode($oldTemplateMode);
            return $this->mode;
        }
        $view->setTemplateMode($oldTemplateMode);
        // Don’t override if we got an empty string
        if ($modeOverride === '') {
            return $this->mode;
        }
        // Don’t override if we got an invalid value
        if (!array_key_exists($modeOverride, $this->_modes)) {
            Craft::error('Invalid value for mode override: '.$modeOverride, __METHOD__);
            return $this->mode;
        }
        return $modeOverride;
    }
}
