<?php
/**
 * Simple Categories plugin for Craft CMS
 *
 * SimpleCategories_SimpleCategories FieldType
 *
 * @author    Tim Kelty
 * @copyright Copyright (c) 2016 Tim Kelty
 * @link      http://fusionary.com/
 * @package   SimpleCategories
 * @since     1.0.0
 */

namespace Craft;

class SimpleCategories_SimpleCategoriesFieldType extends CategoriesFieldType
{
    /**
     * Returns the name of the fieldtype.
     *
     * @return mixed
     */
    public function getName()
    {
        return Craft::t('Simple Categories');
    }

    /**
     * Returns the field's input HTML.
     *
     * @param string $name
     * @param mixed  $value
     * @return string
     */
    public function getInputHtml($name, $criteria)
    {
        craft()->templates->includeCssResource('simplecategories/css/input.css');

		// Make sure the field is set to a valid category group
		$sourceKey = $this->getSettings()->source;

		if ($sourceKey)
		{
			$source = $this->getElementType()->getSource($sourceKey, 'field');
		}

		if (empty($source))
		{
			return '<p class="error">'.Craft::t('This field is not set to a valid category group.').'</p>';
		}

        $vars = $this->getInputTemplateVariables($name, $criteria);
        $vars['values'] = $criteria->ids();
        $groupCriteria = craft()->elements->getCriteria(ElementType::Category);
        $groupCriteria->groupId = $source['criteria']['groupId'];
        $vars['elements'] = $groupCriteria;

        return craft()->templates->render('simplecategories/input', $vars);
    }
}