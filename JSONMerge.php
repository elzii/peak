<?php 

// 5 source numbers, don't have to be consecutive
$sources = array(1,2,3,4,5);
// Output array to be encoded as JSON
$output = array();

// Loop over all the source files, retrieve them and add tracks onto the output    
foreach ($sources as $sourcenum) {
  $source = "http://www.jakedup.com/_/source$sourcenum";
  $source_json = file_get_contents($source);

  // Decode it as an associative array, passing TRUE as second param
  $source_array = json_decode($source_json, TRUE);

  // Now loop over the tracks (which are an array) and append each to the output
  // the original key looks like a timestamp
  foreach ($source_array['tracks'] as $timestamp => $ts) {
    foreach ($ts as $track) {
      // Add the track id to $output as a key
      // This doesn't check if the id already exists...
      // if it does, it will just be overwritten with this one
      $output[$track['id']] = $track;
      // Optionally, save the original timestamp key into the track array
      // Maybe you don't care about this
      $output[$track['id']]['timestamp'] = $timestamp;
    }
  }
}

// Look over your array
var_dump($output);

// Finally, re-encode the whole thing back to JSON
// using JSON_FORCE_OBJECT (even though it shouldn't be necessary)
$output_json = json_encode($output, JSON_FORCE_OBJECT);

 ?>