<?php
	function block_odev_mathematics_get_context($context, $id = null, $flags = null) 
	{
		if ($context == CONTEXT_COURSE) 
		{
			if (class_exists('context_course'))
			{
				return context_course::instance($id, $flags);
			 } 
			 else 
			 {   
				return get_context_instance($context, $id, $flags);
			 }
		}
	}
	
	
	
?>