//https://www.youtube.com/watch?v=N2aMWdS0ANc
//https://github.com/Gryshchenko/digitalcinema/blob/2fc9e5e191dd2ec16aa12b6ae3658b816fc10002/public/torrent-stream/torrent.js
require('dotenv').config();

const	port = 3000;

const	express = require('express'),
		bodyParser = require('body-parser'),
		fs = require('fs'),
		// bencode = require('bencode'),
		// download = require('./node_server/download'),
		// torrentParser = require('./node_server/torrent-parser'),
		app = express();

const	torrentStream = require('torrent-stream'),
		magnetLink = require('magnet-link');


var mysql = require('mysql');
var con = mysql.createConnection({
  host: process.env.DB_HOST,
  user: process.env.DB_USERNAME,
  password: process.env.DB_PASSWORD,
  database : process.env.DB_DATABASE
});

let torrentFile = process.argv[2];

//load and save downloaded films
// con.connect();
// con.query('SELECT * FROM users', function (error, results, fields) {
//   if (error) throw error;
//   console.log('The solution is: ', results);
// });
 
// con.end();


magnetLink(torrentFile, (err, link) => {
		var engine = torrentStream(link, {
				path: 'public/downloaded_movies'
			}
		);

engine.on('ready', () => {
			engine.files.forEach((file) => {
				console.log('filepath:', file.path);
				let format = file.name.split('.').pop();
				// if (format === 'mp4' || format === 'webm' || format === 'ogg' || format === 'mkv') {
					let stream = file.createReadStream();
					moviePath = 'public/downloaded_movies/' + file.path;
					//moviesArr[requestId] = moviePath;
					// request.post(
					// 	{
					// 		url:'http://localhost:8100/movie/add-film-to-db',
					// 		form: {
					// 			path: moviePath,
					// 			timeToDelete: Math.floor(new Date / 1000) + 2592000
					// 		}
					// 	},
					// 	function(err,httpResponse,body) {

					// 		// console.log(err);
					// 		// console.log(body);
					// 	}
					// )
					// moviesArr[requestId][deleteDate] = Math.floor(date / 1000) + 2592000;
				// }
			})
		})
	});



// app.get('/', function (req, res) {
// 	res.send("hello mazafaka");
// });



// app.post('/stream', function (req, res) {
// 	let engine = torrentStream('magnet:my-magnet-link');

// 	engine.on('ready', function() {
// 		engine.files.forEach(function(file) {
// 			console.log('filename:', file.name);
// 			var stream = file.createReadStream();
// 			// stream is readable stream to containing the file content
// 		});
// 	});

// 	// get a stream containing bytes 10-100 inclusive.
// 	let stream = file.createReadStream({
// 		start: 10,
// 		end: 100
// 	});

// });

app.listen(port, function(){
	console.log('Server startet at port:' + port)
});