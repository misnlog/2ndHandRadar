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
 * Marker represents a point on the map.
 *
 * @author     Vaclav Bohac
 *
 * @property   string|Coordinates $destination
 * @property   string $label
 * @property   string|Html|Template $info
 * @property   Gmaps\MarkerImage
 */
class Marker extends Nette\ComponentModel\Component
{

    /** var string|Coordinates */
    private $destination;

    /** @var string */
    private $label = '';

    /** @var string|Html|Template*/
    private $info = '';

	/** @var Gmaps\MarkerImage */
	private $markerImage;


    /**
     * @param  string|array|Coordinates
     * @param  string
     * @param  string|Html|Template
     */
    public function __construct($destination = NULL, $label = NULL, $info = NULL, $markerImage = NULL)
    {
        if ($destination !== NULL) {
            $this->setDestination($destination);
        }

        if ($label !== NULL) {
            $this->setLabel($label);
        }

        if ($info !== NULL)  {
            $this->setInfo($info);
        }
		
		if ($markerImage !== NULL) {
			$this->setMarkerImage($markerImage);
		}
    }



    /**
     * @param  string|array|Coordinates
     * @return Marker  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setDestination($destination)
    {
        if (!is_string($destination) && !is_array($destination) && !($destination instanceof Coordinates)) {
            throw new InvalidArgumentException("Destination '$destination' is not string.");
        }

        if (is_array($destination)) {
            list($lat, $lng) = $destination;
            $destination = new Coordinates($lat, $lng);
        }

        $this->destination = $destination;

        return $this;
    }



    /**
     * @return string|Array
     */
    public function getDestination()
    {
        return $this->destination;
    }



    /**
     * @param  string
     * @return Marker  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setLabel($label)
    {
        if (!is_string($label)) {
            throw new InvalidArgumentException("Label '$label' is not string.");
        }

        $this->label = $label;

        return $this;
    }



    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }



    /**
     * @param  string|Html|Template
     * @return Marker  provides a fluent interface
     * @throws InvalidArgumentException
     */
    public function setInfo($info)
    {
        if (!is_string($info) && (is_object($info) && !($info instanceof \Nette\Web\Html || $info instanceof \Nette\Templates\Template))) {
            throw new \InvalidArgumentException("Info must be of type string, Html or Template.");
        }

        $this->info = $info;

        return $this;
    }



    /**
     * @return string|Html|Template
     */
    public function getInfo()
    {
        return $this->info;
    }
	
	
	
	/** 
	 * @param Gmaps\MarkerImage $markerImage
	 */
	public function setMarkerImage(MarkerImage $markerImage) 
	{
		$this->markerImage = $markerImage;
	}
	
	
	
	/** 
	 * @return Gmaps\MarkerImage
	 */
	public function getMarkerImage() 
	{
		return $this->markerImage;
	}



    /** @return array */
    public function toArray()
    {
        $label = $this->label;
        if (!$label && strlen($this->destination)) {
            $label = $this->destination;
        }

        $destination = $this->destination;
        if (is_object($destination)) {
            $destination = $destination->toArray();
        }
		
		$icon = NULL;
		if(isset($this->markerImage)) {
			$icon = array(
				'url' => $this->markerImage->url,
				'size' => $this->markerImage->size,
				'origin' => $this->markerImage->origin,
				'tip' => $this->markerImage->tip,
			);
		}
		
        return array(
            'destination' => $destination,
            'label' => $label,
            'info' => $this->info,
			'icon' => $icon,
        );
    }

}
