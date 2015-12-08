<?php

/**
 * This file is part of the Gmaps.
 *
 * Copyright (c) 2012 Vaclav Bohac
 */

namespace Gmaps;

use InvalidArgumentException,
    Nette;



/**
 * Coordinates on earth defined by latitude and longitude.
 *
 * @author     Vaclav Bohac
 *
 * @property   float $latitude
 * @property   float $longitude
 */
class Coordinates extends Nette\Object
{

    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;



    /**
     * @param  float  coordinate latitude
     * @param  float  coordinate longitude
     */
    public function __construct($lat = NULL, $lng = NULL)
    {
        if ($lat !== NULL) {
            $this->setLatitude($lat);
        }

        if ($lng !== NULL) {
            $this->setLongitude($lng);
        }
    }



    /**
     * @param  float
     * @return Coordinates  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setLatitude($lat)
    {
        if (!is_numeric($lat)) {
            throw new InvalidArgumentException('Latitude must a numeric type.');
        }

        $this->latitude = (float) $lat;

        return $this;
    }



    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }



    /**
     * @param  float
     * @return Coordinates  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setLongitude($lng)
    {
        if (!is_numeric($lng)) {
            throw new InvalidArgumentException('Longitude must a numeric type.');
        }

        $this->longitude = (float) $lng;

        return $this;
    }



    /**
     * @return float
     */
    public function getLongitude()
    {
        return (float) $this->longitude;
    }



    /**
     * @return array
     */
    public function toArray()
    {
        return array('lat' => $this->latitude, 'lng' => $this->longitude);
    }

}
