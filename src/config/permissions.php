<?php
/**
 * A list of available permissions
 */	
 
return array(

	'admin' => array(

		'users' => array(

			'index',
			'edit', 
			'create', 
			'delete'
		
		),

		'groups' => array(

			'index',
			'edit', 
			'create', 
			'delete',
			'add_users'
		
		)

	)

);