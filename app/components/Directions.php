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
 * Gmaps Directions finds path between origin and destinaton through waypoints.
 *
 * @author     Vaclav Bohac
 *
 * @property   string $origin
 * @property   string $destination
 * @property   string $travelMode
 * @property   array $waypoints
 */
class Directions extends Nette\ComponentModel\Component
{

    /** Transport type. */
    const DRIVING = 'driving',
        WALKING = 'walking',
        BIKE = 'bicycling';

    /** @var string  path starting point */
    private $origin;

    /** @var string  path destination point */
    private $destination;

    /** @var string  way of transport */
    private $travelMode;

    /** @var array */
    private $waypoints = array();



    /**
     * @param  string  path starting point
     * @param  string  path destination point
     * @param  string  type of transport
     */
    public function __construct($origin = NULL, $destination = NULL, $travelMode = NULL)
    {
        if ($origin !== NULL) {
            $this->setOrigin($origin);
        }

        if ($destination !== NULL) {
            $this->setDestination($destination);
        }

        if ($travelMode !== NULL) {
            $this->setTravelMode($travelMode);
        }
    }



    /**
     * @param  string
     * @return Directions  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setOrigin($origin)
    {
        if (!is_string($origin)) {
            throw new InvalidArgumentException("Origin must be string.");
        }

        $this->origin = $origin;

        return $this;
    }



    /**
     * @return string
     */
    public function getOrigin()
    {
        return (string) $this->origin ?: '';
    }



    /**
     * @param  string
     * @return Directions  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setDestination($destination)
    {
        if (!is_string($destination)) {
            throw new InvalidArgumentException("Destination must be string.");
        }

        $this->destination = $destination;

        return $this;
    }



    /**
     * @return string
     */
    public function getDestination()
    {
        return (string) $this->destination ?: '';
    }



    /**
     * @param  string
     * @return Directions  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setTravelMode($travelMode)
    {
        if (!is_string($travelMode)) {
            throw new InvalidArgumentException("Travel mode must be string.");
        }

        $this->travelMode = $travelMode;

        return $this;
    }



    /**
     * @return string
     */
    public function getTravelMode()
    {
        return $this->travelMode ?: self::DRIVING;
    }



    /**
     * @param  string|array  location of waypoint
     * @return Directions  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function addWaypoint($waypoint)
    {
        if (!is_string($waypoint) && !is_array($waypoint)) {
            throw new InvalidArgumentException("Way point must be string.");
        }

        foreach ((array) $waypoint as $location) {
            $this->waypoints[] = $location;
        }

        return $this;
    }



    /**
     * @param  array
     */
    public function getWaypoints()
    {
        return (array) $this->waypoints;
    }

}
