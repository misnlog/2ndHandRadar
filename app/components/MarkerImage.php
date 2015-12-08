<?php

/**
 * This file is part of the Gmaps.
 *
 * Copyright (c) 2012 Vaclav Bohac
 */

namespace Gmaps;

use Nette;



/**
 * Marker image
 *
 * @author Pavel Plzák
 *
 * @property string $url
 * @property array $size size of image (width,height)
 * @property array $origin top left point (x,y)
 * @property array $tip bottom right point (x,y), attached to coordinates 
 */
class MarkerImage extends Nette\ComponentModel\Component
{

	/** @var string */
	private $url;
	
	/** @var array */
	private $size;
	
	/** @var array */
	private $origin;
	
	/** @var array */
	private $tip;

	
    /**
     * @param string $url
	 * @param array $size
	 * @param array $origin
	 * @param array $tip
     */
    public function __construct($url, $size, $origin, $tip)
    {
        $this->setUrl($url);
		$this->setSize($size);
		$this->setOrigin($origin);
		$this->setTip($tip);
    }


	public function getUrl() 
	{
		return $this->url;
	}

	public function setUrl($url) 
	{
		$this->url = $url;
	}

	
	public function getSize() 
	{
		return $this->size;
	}

	public function setSize(array $size) 
	{
		list($width, $height) = $size;
		$this->size = array(
			'width' => $width,
			'height' => $height
		);
	}
	

	public function getOrigin()
	{
		return $this->origin;
	}

	public function setOrigin(array $origin) 
	{
		list($x,$y) = $origin;
		$this->origin = array(
			'x' => $x,
			'y' => $y,
		);
	}

	
	public function getTip() 
	{
		return $this->tip;
	}

	public function setTip(array $tip) 
	{
		list($x,$y) = $tip;
		$this->tip = array(
			'x' => $x,
			'y' => $y,
		);
	}



}
