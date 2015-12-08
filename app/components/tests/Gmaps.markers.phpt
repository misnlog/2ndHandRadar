<?php

require __DIR__ . '/bootstrap.php';

use Tester\Assert;



$gmaps = new Gmaps\Gmaps;

// Attach some markers.

$gmaps->addMarker('marker1', 'Brno');
$gmaps->addMarker('marker2', 'Prague');
$gmaps->addMarker('marker3', 'Ostrava');


// Fluent interface.

Assert::same($gmaps, $gmaps->addMarker('marker4', 'Plzeň'));


// Retrieving markers.

Assert::equal(4, count($gmaps->markers));
Assert::equal(4, count($gmaps->getComponents(True, '\Gmaps\Marker')));


// Array-like behaviour.

Assert::equal('Brno', $gmaps['marker1']->destination);


// Removing marker.

unset($gmaps['marker1']);

Assert::equal(3, count($gmaps->markers));
