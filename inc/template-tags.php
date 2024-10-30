<?php

/**
 * Function centralises calls to template method in class
 *
 * @param string $name  The name of the API method to call
 * @param array  $attrs The parameter to pass to the API
 *
 * @return string
 */
function chaletagent_template_wrapper($name, $attrs)
{
	global $chaletAgent;

	return $chaletAgent->chaletops_template($name, $attrs);
}

/**
 * Call the availability method
 *
 * @param int    $season_id  The id of the season to get the availability for
 * @param string $properties Optional comma separated list of property ids
 */
function chaletagent_availability($season_id, $properties = '')
{
	echo chaletagent_template_wrapper('availability', ['season' => $season_id, 'properties' => $properties]);
}

/**
 * Call the transfers method
 *
 * @param int $season_id The id of the season to get the availability for
 */
function chaletagent_transfers($season_id)
{
	echo chaletagent_template_wrapper('transfers', ['season' => $season_id]);
}

/**
 * Call the testimonials method
 */
function chaletagent_testimonials()
{
	echo chaletagent_template_wrapper('testimonials', []);
}

/**
 * Call the seasons method
 */
function chaletagent_seasons()
{
	echo chaletagent_template_wrapper('seasons', []);
}

/**
 * Call the properties method
 *
 * @param int|null $property_id Optional id to specify single property instead of list of properties
 */
function chaletagent_properties($property_id = null)
{
	$attrs = $property_id ? ['property' => $property_id] : [];

	echo chaletagent_template_wrapper('properties', $attrs);
}
