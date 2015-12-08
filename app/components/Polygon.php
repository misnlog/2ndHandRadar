<?php

/**
 * This file is part of the Gmaps.
 *
 * Copyright (c) 2012 Vaclav Bohac
 */

namespace Gmaps;

use InvalidArgumentException,
    Gmaps,
    Nette;



/**
 * Polygon is shape covering area on map.
 *
 * @author     Vaclav Bohac
 *
 * @property   Coordinates[] $coords
 * @property   string $fillColor
 * @property   string $strokeColor
 * @property   float $fillOpacity
 * @property   float $strokeOpacity
 * @property   int $strokeWeight
 */
class Polygon extends Nette\ComponentModel\Component
{

    /** @var array  coordination points */
    private $coords = array();

    /** @var string  color of the poly's fill */
    private $fillColor =  '#FF0000';

    /** @var string  color of the poly's stroke */
    private $strokeColor = '#FF0000';

    /** @var float  fill opacity - number between zero and one */
    private $fillOpacity = .35;

    /** @var float  stroke opacity - number between zero and one */
    private $strokeOpacity = .8;

    /** @var int  stroke weight in pixels */
    private $strokeWeight = 2;



    /**
     * @param  array|Coordinates  array of points on map or point itself
     */
    public function __construct($coords = NULL)
    {
        if ($coords !== NULL) {
            $this->setCoords($coords);
        }
    }



    /**
     * @return array
     */
    public function getOptions()
    {
        $paths = array();
        foreach ($this->getCoords() as $path) {
            array_push($paths, $path->toArray());
        }

        $options = array (
            'paths' => $paths,
            'strokeColor' => $this->strokeColor,
            'strokeOpacity' => $this->strokeOpacity,
            'strokeWeight' => $this->strokeWeight,
            'fillColor' => $this->fillColor,
            'fillOpacity' => $this->fillOpacity
        );

        return $options;
    }



    /**
     * @param  array|Coordinates
     * @throws InvalidArgumentException
     * @return Polygon  provides a fluent interface
     */
    public function setCoords($coords)
    {
        if (!(is_array($coords) || (is_object($coords) && $coords instanceof Coordinates))) {
            throw new \InvalidArgumentException('Coords must be an array or Gmaps\Coordinates.');
            return;
        }

        if (is_object($coords)) {
            $coords = array($coords);
        }

        foreach ($coords as $point) {
            if ($point instanceof Coordinates) {
                $this->coords[] = $point;
            }
        }

        return $this;
    }



    /**
     * @return Coordinates[]
     */
    public function getCoords()
    {
        return (array) $this->coords;
    }



    /**
     * @param  string
     * @throws InvalidArgumentException
     * @return Polygon  provides a fluent interface
     */
    public function setStrokeColor($color)
    {
        if (!is_string($color)) {
            throw new InvalidArgumentException('Stroke color must be string.');
        }

        if (!Nette\Utils\Strings::match($color, '/^#(([0-9a-f]{2}){3}|([0-9a-f]{1}){3})$/i')) {
            throw new InvalidArgumentException("Stroke color '$color' is not valid.");
        }

        $this->strokeColor = $color;

        return $this;
    }



    /**
     * @return string
     */
    public function getStrokeColor()
    {
        return (string) $this->strokeColor;
    }



    /**
     * @param  float
     * @return Polygon  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setStrokeOpacity($opacity)
    {
        if (!is_numeric($opacity)) {
            throw new InvalidArgumentException('Stroke opacity must be numeric.');
        }

        if (!(0.0 <= $opacity && $opacity <= 1.0)) {
            throw new InvalidArgumentException('Stroke must be in range from 0 to 1');
        }

        $this->strokeOpacity = (float) $opacity;

        return $this;
    }



    /**
     * @return float
     */
    public function getStrokeOpacity()
    {
        return (float) $this->strokeOpacity;
    }



    /**
     * @param  int
     * @throws InvalidArgumentException
     * @return Polygon  provides a fluent interface
     */
    public function setStrokeWeight($weight)
    {
        if (!is_numeric($weight)) {
            throw new InvalidArgumentException('Stroke width must be numeric.');
        }

        if ($weight < 0) {
            throw new InvalidArgumentException('Stroke must be positive number.');
        }

        $this->strokeWeight = (int) $weight;

        return $this;
    }



    /**
     * @return int
     */
    public function getStrokeWeight()
    {
        return (int) $this->strokeWeight;
    }



    /**
     * @param  string
     * @throws InvalidArgumentException
     * @return Polygon  provides a fluent interface
     */
    public function setFillColor($color)
    {
        if (!is_string($color)) {
            throw new InvalidArgumentException('Fill color must be string.');
        }

        if (!Nette\Utils\Strings::match($color, '/^#(([0-9a-f]{2}){3}|([0-9a-f]{1}){3})$/i')) {
            throw new InvalidArgumentException("Stroke color '$color' is not valid.");
        }

        $this->fillColor = $color;

        return $this;
    }



    /**
     * @return string
     */
    public function getFillColor()
    {
        return (string) $this->fillColor;
    }



    /**
     * @param  float
     * @return Polygon  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setFillOpacity($opacity)
    {
        if (!is_numeric($opacity)) {
            throw new InvalidArgumentException('Fill opacity must be numeric.');
        }

        if (!(0.0 <= $opacity && $opacity <= 1.0)) {
            throw new InvalidArgumentException('Fill opacity must be in range from 0 to 1');
        }

        $paths = array();
        foreach ($coords as $path) {
            array_push($paths, $path->toArray());
        }

        $this->fillOpacity = (float) $opacity;

        return $this;
    }



    /**
     * @return float
     */
    public function getFillOpacity()
    {
        return (float) $this->fillOpacity;
    }

}
