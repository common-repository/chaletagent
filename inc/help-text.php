<?php

// This file is simply used to separate out the help text HTML content from the main PHP file.

?>

<h3>Usage</h3>

Currently you can publish the following information:

<table cellpadding="5">
	<thead>
		<tr>
			<th>Data Type</th>
			<th>Shortcode</th>
			<th>Template Tag</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Your prices and availability for a specified season</td>
			<td><code>[chaletagent_availability season=1]</code></td>
			<td><code>&lt;?php echo chaletagent_availability(1); ?&gt;</code></td>
		</tr>
		<tr>
			<td>Your prices and availability for a specified season, with specific properties shown</td>
			<td><code>[chaletagent_availability season=1 properties=1,2]</code></td>
			<td><code>&lt;?php echo chaletagent_availability(1, '1,2'); ?&gt;</code></td>
		</tr>
		<tr>
			<td>Your guide prices for airport transfers for a specified season</td>
			<td><code>[chaletagent_transfers season=1]</code></td>
			<td><code>&lt;?php echo chaletagent_transfers(1); ?&gt;</code></td>
		</tr>
		<tr>
			<td>Publishable guest feedback testimonials</td>
			<td><code>[chaletagent_testimonials]</code></td>
			<td><code>&lt;?php echo chaletagent_testimonials(); ?&gt;</code></td>
		</tr>
        <tr>
            <td>Publishable guest feedback testimonials for self-catered bookings only</td>
            <td><code>[chaletagent_testimonials_self_catered]</code></td>
            <td><code>&lt;?php echo chaletagent_testimonials_self_catered(); ?&gt;</code></td>
        </tr>
        <tr>
            <td>Publishable guest feedback testimonials for catered bookings only</td>
            <td><code>[chaletagent_testimonials_catered]</code></td>
            <td><code>&lt;?php echo chaletagent_testimonials_catered(); ?&gt;</code></td>
        </tr>
        <tr>
			<td>The list of your seasons</td>
			<td><code>[chaletagent_seasons]</code></td>
			<td><code>&lt;?php echo chaletagent_seasons(); ?&gt;</code></td>
		</tr>
		<tr>
			<td>The list of your properties<br />(format can be 'table' or 'list')</td>
			<td><code>[chaletagent_properties format=list]</code></td>
			<td><code>&lt;?php echo chaletagent_properties('list'); ?&gt;</code></td>
		</tr>
		<tr>
			<td>Details of a specified property</td>
			<td><code>[chaletagent_properties property=1]</code></td>
			<td><code>&lt;?php echo chaletagent_properties(1); ?&gt;</code></td>
		</tr>
	</tbody>
</table>
