//https://www.youtube.com/watch?v=N2aMWdS0ANc
//https://github.com/Gryshchenko/digitalcinema/blob/2fc9e5e191dd2ec16aa12b6ae3658b816fc10002/public/torrent-stream/torrent.js
'use strict'

require('dotenv').config();

const	port = 3000;

const	express = require('express'),
		bodyParser = require('body-parser'),
		fs = require('fs'),
		app = express();

const	torrentStream = require('torrent-stream'),
		magnetLink = require('magnet-link');

const	cors = require('cors'),
		https = require('https'),
		axios = require('axios'),
		Iconv  = require('iconv').Iconv,
		srt2vtt = require('srt-to-vtt');

const OpenSubtitles = require('opensubtitles-api');
const OS = new OpenSubtitles({
	useragent:process.env.OPEN_SUBTITLES_USERAGENT,
	username: process.env.OPEN_SUBTITLES_USERNAME,
	password: process.env.OPEN_SUBTITLES_PASSWORD,
	ssl: true
});

app.use(cors({
	origin: process.env.APP_URL,
	credentials: true
}));

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
process.on('uncaughtException', function (exception) {
	let date = new Date();
	
	console.log("\nWas error at " + date.toString());
	console.log(exception);
	console.log();
  });

let download = function(url, dest, enc) {
  let file = fs.createWriteStream(dest + '.srt');

  let request = https.get(url, function(response) {
	let iconv = new Iconv(enc, 'UTF-8');
	response.pipe(iconv).pipe(file);
	fs.createReadStream(dest + '.srt').pipe(srt2vtt()).pipe(fs.createWriteStream(dest + '.vtt'));
	// fs.unlink(dest + '.srt');
	file.on('finish', function() {
	  file.close(function(){});  // close() is async, call cb after close completes.
	});
  }).on('error', function(err) { // Handle errors
	// fs.unlink(dest); // Delete the file async. (But we don't check the result)
  });
};

let insertUpdateFilm = function($imdb_id, $path) {
	//add/update film info in DB
	console.log('path to API: ' + process.env.APP_URL + '/api/v2/insert-to-db');
	axios.post(process.env.APP_URL + '/api/v2/insert-to-db', {
		imdb_id: $imdb_id,
		video_path: $path
	})
	.then(function (resp){
		console.log('db insert: ' + $imdb_id);
		// console.log(resp);
	}).
	catch(function(err){
		console.log('can\'t update film info: ' + $imdb_id);
		console.log(err);
		throw (err);
		// return; 
		});

};

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

function sleep (time) {
	return new Promise((resolve) => setTimeout(resolve, time));
}

//change to post
app.post('/movie/:id/:init', function(req, res) {
	let subtitles_arr = [];
	console.log(req.body.torrent_link);

	axios.post(process.env.APP_URL + '/api/v2/get-video-info', {
		imdb_id: req.params.id
	})
	.then(function (resp){
		
		if (resp.data.success){
			let data = resp.data.data[0];

			console.log(data);
			insertUpdateFilm(req.params.id, data.video);
			
			res.setHeader('Content-Type', 'application/json');
			//add check for subtitles
				res.send(JSON.stringify({
					src: data.video,
					subtitles: subtitles_arr,
				}));

			if (data.downloaded)
				return;
		}
	})
	.catch(function (err){
		console.log(err);
	});

	magnetLink(req.body.torrent_link, function(err, link) {
		if (err) {
			console.log(err);
			return;
		}
		console.log("link: " + link);

		let path = 'movies/' + req.params.id;
		let engine = torrentStream(link, { path: 'public/' + path });

		engine.on('ready', function() {
			engine.files.forEach(function (file) {
				let extension = file.name.split('.').pop();

				console.log("\npath: " + file.path + "\nname: " + file.name);
				console.log('length: ' + file.length);
				if (extension === 'mp4') {
					let subtitle_path = 'public/' + path + '/';

					OS.search({
						imdbid: req.params.id
					}).then(subtitles => {
						if (subtitles['en']) {
							download(subtitles['en'].url, subtitle_path + 'en', subtitles['en'].encoding);
							subtitles_arr.push({'code': 'en', 'title': subtitles['en'].lang});
						}
						if (subtitles['ru']) {
							download(subtitles['ru'].url, subtitle_path + 'ru', subtitles['ru'].encoding);
							subtitles_arr.push({'code': 'ru', 'title': subtitles['ru'].lang});
						}
						if (subtitles['uk']) {
							download(subtitles['uk'].url, subtitle_path + 'uk', subtitles['uk'].encoding);
							subtitles_arr.push({'code': 'uk', 'title': subtitles['uk'].lang});
						}
					}).catch(console.error);

					console.log('format: ' + extension);
					file.select();	//скачує блоки рандомно

					let stream = file.createReadStream();	//скачує блоки послідовно з пріоритетом над select()
					// let stream = file.createReadStream({
					// 	start: 0,
					// 	end: 10485760 //10Mb
					// });

					stream.on('readable', function(){
						if (req.params.init){
							let src = '/' +path + '/' + encodeURI(file.path);

							insertUpdateFilm(req.params.id, src);
							
							// sleep time expects milliseconds
							sleep(10000).then(() => {
								// Do something after the sleep!
								console.log('init request');
								res.setHeader('Content-Type', 'application/json');
								res.send(JSON.stringify({
									src: src,
									subtitles: subtitles_arr,
								}));

								return;
							});

						}
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

				} else {
					file.deselect();
				}
			})
		})
	});



	// check for file in public/downloaded_films
	// if no file -> get torrent file in storage/torrents
	// return stream
});

app.listen(port, function(){
	console.log('Server startet at port:' + port)
});