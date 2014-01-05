<?php
$filenames = scandir($path);
foreach ($filenames as $filename) {
  // open an HTTP request to Flickr (returns a stream resource)
  $httpStream = fsockopen('api.flickr.com', 80, $errno, $errstr, 30);
  // send the request headers
  $out =  "POST /services/upload/ HTTP/1.1\r\n";
  $out .= "Host: api.flickr.com\r\n";
  $out .= "Content-Disposition: attachment; filename=" . $filename . "\r\n";
  $out .= "Content-Type: application/octet-stream\r\n";
  $out .= "Content-Length: " . filesize($path . '/' . $filename) . "\r\n\r\n";
  fwrite($httpStream, $out);
  // open a file stream on the local image
  $fileStream = fopen($path . '/' . $filename, 'r');
  // read from the file and write to the HTTP request
  while (!feof($fileStream)) { // while the fileStream is not finished
    // read 1024 bytes from the file and write these bytes on the Flickr http stream
    fwrite($httpStream, fread($fileStream, 1024));
  }
  fclose($fileStream);
  fclose($httpStream);
  echo "Sent file " . $filename . "\n";
}
echo "Finished!\n";