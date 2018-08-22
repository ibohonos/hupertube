//https://www.youtube.com/watch?v=N2aMWdS0ANc
//https://github.com/Gryshchenko/digitalcinema/blob/2fc9e5e191dd2ec16aa12b6ae3658b816fc10002/public/torrent-stream/torrent.js

const	port = 3000;

const	express = require('express'),
		bodyParser = require('body-parser'),
		app = express();
var		torrentStream = require('torrent-stream'),
		magnetLink = require('magnet-link');



app.use(bodyParser.urlencoded({	extended: true }));
app.use(bodyParser.json());

app.get('/', function (req, res) {
	res.send("hello mazafaka");
});



app.post('/stream', function (req, res) {
	let engine = torrentStream('magnet:my-magnet-link');

	engine.on('ready', function() {
		engine.files.forEach(function(file) {
			console.log('filename:', file.name);
			var stream = file.createReadStream();
			// stream is readable stream to containing the file content
		});
	});

	// get a stream containing bytes 10-100 inclusive.
	let stream = file.createReadStream({
		start: 10,
		end: 100
	});

});

app.listen(port, function(){
	console.log('Server startet at port:' + port)
});