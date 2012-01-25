<?php

	
	// Samples
	
	// Return Timestamp
	$result_1 = remote_file_last_modified( 'http://www.google.co.uk/logos/classicplus.png' );
	
	// Return Human Readable Date (Default)
	$result_2 = remote_file_last_modified( 'http://www.google.co.uk/logos/classicplus.png' , false );
	
	// Return Human Readable Date (Modified)
	$result_3 = remote_file_last_modified( 'http://www.google.co.uk/logos/classicplus.png' , false , 'jS F Y H:ia' );
	
	
	/*	Function Name: remote_file_last_modified
	 *
	 *	Inputs: 
	 *		$url = The URL to retreive
	 *		$timestamp = Return a UNIX timestamp or human readable date - defaulted to Timestamp
	 *		$date_format = Standard PHP data format string (http://php.net/manual/en/function.date.php)
	 *
	 *	Output:
	 *		On success the date/time when the url was last modified.
	 *		On failure boolean False.
	 */
	function remote_file_last_modified( $url , $timestamp = true, $date_format = 'd-m-Y H:i:s' ) {
    
    	$curl = curl_init();
    	curl_setopt( $curl , CURLOPT_URL , $url );
    	curl_setopt( $curl , CURLOPT_HEADER , 1 ); 			// Include Header In Output
    	curl_setopt( $curl , CURLOPT_NOBODY , 1 );			// Set to HEAD & Exclude body
    	curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );	// No Echo/Print
    	curl_setopt( $curl , CURLOPT_TIMEOUT , 5 );			// 5 seconds max, to get the HEAD header.
    	$curl_result = curl_exec( $curl );				// Execute
    
    	// Check for curl result
    	if ( $curl_result !== FALSE ) {
    		
    		// Separate the header into it's individual lines
    		$headers = explode( "\n" , $curl_result );
    		
    		// Extract the last modified date from the headers
    		$last_modified = explode( 'Last-Modified: ' , $headers[3] );
    		
    		// Return the data in the required format
    		if ( $timestamp ) {
    			return strtotime( $last_modified[1] );
    		} else {
    			return date( $date_format , strtotime( $last_modified[1] ) );
    		}
    		
    	}
 		
 		// Return false on error
		return FALSE;
	
	}