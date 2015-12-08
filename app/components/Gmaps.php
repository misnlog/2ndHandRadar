<?php

/**
 * This file is part of the Gmaps.
 *
 * Copyright (c) 2012 Vaclav Bohac
 */

namespace Gmaps;

use Nette;


/**
 * Gmaps makes creating Google Maps easy.
 *
 * @author     Vaclav Bohac
 *
 * @property   string $maptype
 */
class Gmaps extends Nette\ComponentModel\Container implements \ArrayAccess
{

    /** Type of map. */
    const TYPE_ROAD = 'ROADMAP',
        TYPE_SAT = 'SATELLITE',
        TYPE_HYB = 'HYBRID',
        TYPE_TER = 'TERRAIN';

    /** @var string */
    private $mapType = self::TYPE_ROAD;

    /** @var int */
    private $zoom = 8;

    /** @var string */
    private $center = 'Brno';

    /** @var bool */
    private $controls = FALSE;

    /* @var int */
    private $width = 600;

    /* @var int */
    private $height = 600;



    /**
     * @param  string
     * @return Gmaps - provides a fluent interface
     */
    public function setMapType($mapType)
    {
        $this->mapType = (string) $mapType;

        return $this;
    }



    /** @return string */
    public function getMapType()
    {
        return $this->mapType;
    }



    /**
     * @param int
     * @return Gmaps - provides fluent interface
     */
    public function setZoom($zoom)
    {
        $this->zoom = (int) $zoom;

        return $this;
    }



    /** @return int */
    public function getZoom()
    {
        return $this->zoom;
    }



    /**
     * @param string|array
     * @return Gmaps - provides fluent interface
     */
    public function setCenter($center)
    {
        if (func_num_args() === 2) {
            $center = func_get_args();
        }

        if (is_array($center))  {
            list($lat, $lng) = $center;
            $center = new Coordinates($lat, $lng);
        }

        $this->center = $center;

        return $this;
    }



    /** @return string|array */
    public function getCenter()
    {
        return $this->center;
    }



    /**
     * @param bool
     * @return Gmaps - provides fluent interface
     */
    public function setControls($controls)
    {
        $this->controls = $controls;

        return $this;
    }



    /** @return bool */
    public function getControls()
    {
        return $this->controls;
    }



    /**
     * @param int
     * @return Gmaps - provides fluent interface
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }



    /** @return int */
    public function getWidth()
    {
        return $this->width;
    }



    /**
     * @param int
     * @return Gmaps - provides fluent interface
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }



    /** @return int */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param  string
     * @param  string|array
     * @param  string
     * @param  string|Html|Template
	 * @param  Gmaps\MarkerImage
     * @return Gmaps  provides a fluent interface
     */
    public function addMarker($name, $destination, $title = NULL, $info = NULL, $markerImage = NULL)
    {
        $this[$name] = new Marker($destination, $title, $info, $markerImage);
        return $this;
    }



    /** @return Nette\Iterators\InstanceFilter */
    public function getMarkers()
    {
        return $this->getComponents(True, '\Gmaps\Marker');
    }



    /**
     * @param  string
     * @param  string
     * @param  string
     * @param  string
     * @return Gmaps  provides a fluent interface
     */
    public function setDirections($name, $origin, $destination, $travelMode = NULL)
    {
        $this[$name] = new Directions($origin, $destination, $travelMode);
        return $this;
    }



    /** @return Nette\Iterators\InstanceFilter */
    public function getDirections()
    {
        return $this->getComponents(True, '\Gmaps\Directions');
    }



    /**
     * @param  string
     * @param  array
     * @return Gmaps  provides a fluent interface
     */
    public function addPolygon($name, array $points = array())
    {
        $this[$name] = new Polygon($points);
        return $this;
    }



    /** @return Nette\Iterators\InstanceFilterIterator */
    public function getPolygons()
    {
        return $this->getComponents(True, '\Gmaps\Polygon');
    }



    /** @return Nette\Templating\FileTemplate */
    public function getTemplate()
    {
        $template = new Nette\Templating\FileTemplate;

        $template->registerFilter(new Nette\Latte\Engine);
        $template->registerHelper('json', function ($array) {
            return json_encode($array);
        });
        $template->registerHelper('toArray', function ($array) {
            if ($array instanceof \Traversable) {
                $array = iterator_to_array($array);
            }

            return array_map(function ($object) {
                return $object->toArray();
            }, $array);
        });

        $template->setFile(__DIR__ . '/template.latte');
        $template->basePath = Nette\Environment::getHttpRequest()->getUrl()->basePath;

        return $template;
    }



    /** @return array */
    public function getOptions()
    {
        $center = $this->center;

        if (is_object($center)) {
            $center = $center->toArray();
        }

        return array(
            'type' => $this->mapType,
            'zoom' => $this->zoom,
            'center' => $center,
            'controls' => $this->controls,
            'width' => $this->width,
            'height' => $this->height,
        );
    }



    /** @param  array */
    public function render($params = array())
    {
        $options = array_merge($this->getOptions(), $params);

        $template = $this->getTemplate();

        // Create shortcuts for width and height.
        foreach (array('width', 'height') as $dimension) {
            $template->$dimension = $options[$dimension];
            unset($options[$dimension]);
        }

        $template->markers = $this->getMarkers();

        $template->options = $options;

        $template->render();
    }



    /**
     * Implementing ArrayAccess setter.
     * @param  string
     * @param  Nette\ComponentModel\IComponent
     */
    public function offsetSet($name, $component)
    {
        $this->addComponent($component, $name);
    }



    /**
     * Implementing ArrayAccess getter.
     * @return Nette\ComponentModel\IComponent
     */
    public function offsetGet($name)
    {
        return $this->getComponent($name, True);
    }



    /**
     * Tests if component exists.
     * @param  string
     * @return bool
     */
    public function offsetExists($name)
    {
        return $this->getComponent($name, False) !== NULL;
    }



    /**
     * Remove component.
     * @param  string
     */
    public function offsetUnset($name)
    {
        $component = $this->getComponent($name, False);
        if ($component !== NULL) {
            $this->removeComponent($component);
        }

    }

}
