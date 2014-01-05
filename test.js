var fs = require('fs');

var filenames = fs.readdirSync(path);
filenames.forEach(function(filename) {
  var postOptions = {
    host: 'api.flickr.com',
    port: '80',
    path: '/services/upload/',
    method: 'POST',
    headers: {
      'Content-Disposition': 'attachment; filename=' + $filename,
      'Content-Type': 'application/octet-stream'
    }
  };
  // open an HTTP request to Flickr (returns a stream)
  var httpStream = http.request(postOptions, function(res) {
    // dispose of the response status and body
  });
  // open a file stream on the local image
  var fileStream = fs.createReadStream(path + filename);
  // read from the file and write to the HTTP request
  fileStream.pipe(httpStream);
  fileStream.on('end', function() {
    console.log('Sent file ' + filename);
  });
});
console.log('Finished!');
