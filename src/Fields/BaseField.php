<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
namespace BlackfyreStudio\CRUD\Fields;

use Closure;
use Illuminate\Support\Str;

/**
 * Class BaseField.
 */
abstract class BaseField
{
    /**
     * Constant for the list view context.
     */
    const CONTEXT_INDEX = 'list';
    /**
     * Constant for the form view context.
     */
    const CONTEXT_FORM = 'form';
    /**
     * Constant for the filter view context.
     */
    const CONTEXT_FILTER = 'filter';

    /**
     * @var \BlackfyreStudio\CRUD\Master
     */
    protected $MasterInstance;

    /**
     * This holds the context in which the field will appear in.
     *
     * @var string
     */
    protected $context;

    /**
     * Holds the row id.
     *
     * @var int
     */
    protected $rowId;
    /**
     * Holds the field name.
     *
     * @var string
     */
    protected $name;
    /**
     * Holds the field value.
     *
     * @var string
     */
    protected $value;
    /**
     * Holds the field label.
     *
     * @var null|string
     */
    protected $label;
    /**
     * Holds the field description.
     *
     * @var null|string
     */
    protected $description;
    /**
     * Holds the field attributes.
     * As we use Twitter Bootstrap the 'form-control' class is mandatory.
     *
     * @var array
     */
    protected $attributes = [
        'class' => 'form-control',
    ];

    /**
     * Holds the container attributes.
     * As we use Twitter Bootstrap the 'form-control' class is mandatory.
     *
     * @var array
     */
    protected $containerAttributes = [];

    /**
     * Whether or not to render a "multiple" field.
     *
     * @var bool
     */
    protected $isMultiple = false;
    /**
     * Holds the multiple limit.
     *
     * @var bool
     */
    protected $multipleLimit;
    /**
     * Holds the field tab name.
     *
     * @var null|string
     */
    protected $tab;
    /**
     * Holds the field position (left|right).
     *
     * @var string
     */
    protected $position = 'left';
    /**
     * Holds the field before filter.
     *
     * @var null|callable
     */
    protected $before;
    /**
     * Holds the field after filter.
     *
     * @var null|callable
     */
    protected $after;
    /**
     * @var
     */
    protected $saving;

    /**
     * @param string                       $name
     * @param \BlackfyreStudio\CRUD\Master $master
     */
    public function __construct($name, $master)
    {
        $this->setName($name);
        $this->setMasterInstance($master);
    }

    /**
     * @return \BlackfyreStudio\CRUD\Master
     */
    public function getMasterInstance()
    {
        return $this->MasterInstance;
    }

    /**
     * @param \BlackfyreStudio\CRUD\Master $MasterInstance
     */
    public function setMasterInstance($MasterInstance)
    {
        $this->MasterInstance = $MasterInstance;
    }

    /**
     * Hook function to be run before form submitting.
     */
    public function preSubmitHook()
    {
        // intentionally left black
    }

    /**
     * Hook function to be run after form submitting.
     *
     * @param $model
     */
    public function postSubmitHook($model)
    {
        // intentionally left blank
    }

    /**
     * @return int
     */
    public function getRowId()
    {
        return $this->rowId;
    }

    /**
     * @param int $rowId
     *
     * @return $this
     */
    public function setRowId($rowId)
    {
        $this->rowId = $rowId;

        return $this;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param string $context
     *
     * @return $this
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLabel()
    {
        if ($this->label === null) {
            return Str::title($this->getName());
        }

        return $this->label;
    }

    /**
     * @param null|string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = strtolower($name);

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the specified attribute value, returns null if the value doesn't exists.
     *
     * @param $attribute
     *
     * @return null
     */
    public function getAttribute($attribute)
    {
        if ($this->hasAttribute($attribute)) {
            return $this->attributes[$attribute];
        } else {
            return;
        }
    }

    /**
     * Check if a field has the specified attribute.
     *
     * @param string $attribute
     *
     * @return bool
     */
    public function hasAttribute($attribute = '')
    {
        return array_key_exists($attribute, $this->attributes);
    }

    /**
     * Return all the field attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the field as a multiple field, can be cloned on the front-end up to the set limits.
     *
     * @param null|int $limit
     *
     * @return $this
     */
    public function setMultiple($limit = null)
    {
        $this->setAttribute('infinite', true)->isMultiple = true;

        if ($limit !== null) {
            $this->setMultipleLimit($limit);
        }

        return $this;
    }

    /**
     * Set attributes for the field, like class, id, data-*.
     *
     * @param string $attribute
     * @param string $value
     *
     * @return $this
     */
    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = (string) $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function checkIfMultiple()
    {
        return $this->isMultiple;
    }

    /**
     * @return int
     */
    public function getMultipleLimit()
    {
        return $this->multipleLimit;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setMultipleLimit($limit)
    {
        $this->setAttribute('data-multiple-limit', $limit)->multipleLimit = $limit;

        return $this;
    }

    /**
     * Get the field tab.
     *
     * @return null|string
     */
    public function getTab()
    {
        return $this->tab;
    }

    /**
     * Set the field tab.
     *
     * @param string $tab
     *
     * @return $this
     */
    public function setTab($tab)
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Get the field position.
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the field position.
     *
     * @param string $position
     *
     * @return BaseField
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Check if this field has a before filter.
     *
     * @return bool
     */
    public function hasBefore()
    {
        return $this->before !== null;
    }

    /**
     * Get the before filter.
     *
     * @return callable|null
     */
    public function getBefore()
    {
        return $this->before;
    }

    /**
     * @param Closure $callback
     *
     * @return $this
     */
    public function saving(Closure $callback)
    {
        $this->saving = $callback;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasSaving()
    {
        return $this->saving !== null;
    }

    /**
     * @return Closure
     */
    public function getSaving()
    {
        return $this->saving;
    }

    /**
     * Render the HTML attributes for blade usage outside the form generator's scope.
     *
     * @return string
     */
    public function renderContainerAttributes()
    {
        $render = [];

        foreach ($this->containerAttributes as $name => $value) {
            if (is_string($name)) {

                /* We're dealing with a regular attribute */
                $render[] = $name.'="'.$value.'"';
            } else {

                /* Special attribute, like: nowrap, disabled, ... */
                $render[] = $value;
            }
        }

        return implode(' ', $render);
    }

    /**
     * @return array
     */
    public function getContainerAttributes()
    {
        return $this->containerAttributes;
    }

    /**
     * @param array $containerAttributes
     */
    public function setContainerAttributes($containerAttributes)
    {
        $this->containerAttributes = $containerAttributes;
    }

    /**
     * Get specific container attribute.
     *
     * @param string $index Which attribute to get
     *
     * @return array
     */
    public function getContainerAttribute($index)
    {
        return $this->containerAttributes[$index];
    }

    /**
     * Set specific container attribute.
     *
     * @param string          $index
     * @param string|int|bool $value
     */
    public function setContainerAttribute($index, $value)
    {
        if ($value === null) {
            $this->containerAttributes[] = $index;
        } else {
            $this->containerAttributes[$index] = $value;
        }
    }
}
