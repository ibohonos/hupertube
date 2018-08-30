//https://www.youtube.com/watch?v=N2aMWdS0ANc
//https://github.com/Gryshchenko/digitalcinema/blob/2fc9e5e191dd2ec16aa12b6ae3658b816fc10002/public/torrent-stream/torrent.js
require('dotenv').config();

const	port = 3000;

const	express = require('express'),
		bodyParser = require('body-parser'),
		fs = require('fs'),
		app = express();

const	torrentStream = require('torrent-stream'),
		magnetLink = require('magnet-link');


process.on('uncaughtException', function (exception) {
	let date = new Date();
	
	console.log("\nWas error at " + date.toString());
	console.log(exception);
	console.log();
  });

// var mysql = require('mysql');
// var con = mysql.createConnection({
//   host: process.env.DB_HOST,
//   user: process.env.DB_USERNAME,
//   password: process.env.DB_PASSWORD,
//   database : process.env.DB_DATABASE
// });


//load and save downloaded films
// con.connect();
// con.query('SELECT * FROM `all_movie_ids`', function (error, results, fields) {
//   if (error) throw error;
//   console.log(results);
// });
 
// con.end();



let id = '123';
let quality = '720';

//if no film
let torrentFile = process.argv[2];

magnetLink(torrentFile, function(err, link) {
	if (err) {
		console.log(err);
		return;
	}
	console.log(link);
	let engine = torrentStream(link, { path: 'public/movies' });

	engine.on('ready', function() {
		engine.files.forEach(function (file) {
			let extension = file.name.split('.').pop();

			file.name = id + '_[' + quality + 'p]_' + file.name;
			file.path = id + '/' + file.name;

			console.log("\npath: " + file.path + "\nname: " + file.name);
			console.log('length: ' + file.length);
			console.log('format: ' + extension);
			
			if (extension == 'mp4') {
				file.select();	//скачує блоки рандомно

				//let stream = file.createReadStream();	//скачує блоки послідовно з пріоритетом над select()
				let stream = file.createReadStream({
					start: 389914225,
					end: 779828449
				});

				//http://qaru.site/questions/79725/streaming-a-video-file-to-an-html5-video-player-with-nodejs-so-that-the-video-controls-continue-to-work
			
				
				// var streamReadOpts = { start: 0, end: 2000, autoClose: true };
				// var stream = file.createReadStream(file.path, streamReadOpts)
				//     // previous 'open' & 'error' event handlers are still here
				//     .on('end', function () {
				//       console.log('stream end');
				//     })
				//     .on('close', function () {
				//       console.log('stream close');
				//     })
				
			}
		})
	})
});

//change to post
app.get('/movie/:id/:quality/:lng', function(req, res) {
		
	res.send(req.headers);
	

	// check for file in public/downloaded_films
	// if no file -> get torrent file in storage/torrents
	// return stream
});





app.listen(port, function(){
	console.log('Server startet at port:' + port)
});