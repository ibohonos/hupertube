//https://www.youtube.com/watch?v=N2aMWdS0ANc
//https://github.com/Gryshchenko/digitalcinema/blob/2fc9e5e191dd2ec16aa12b6ae3658b816fc10002/public/torrent-stream/torrent.js
'use strict'

require('dotenv').config();

const port = 3000;

const express = require('express'),
	bodyParser = require('body-parser'),
	fs = require('fs'),
	app = express();

const torrentStream = require('torrent-stream'),
	magnetLink = require('magnet-link');

const cors = require('cors'),
	https = require('https'),
	axios = require('axios'),
	Iconv = require('iconv').Iconv,
	srt2vtt = require('srt-to-vtt');

const OpenSubtitles = require('opensubtitles-api');
const OS = new OpenSubtitles({
	useragent: process.env.OPEN_SUBTITLES_USERAGENT,
	username: process.env.OPEN_SUBTITLES_USERNAME,
	password: process.env.OPEN_SUBTITLES_PASSWORD,
	ssl: true
});

app.use(cors({
	origin: process.env.APP_URL,
	credentials: true
}));

app.use(bodyParser.urlencoded({extended: true}));
app.use(bodyParser.json());

// schedule.
process.on('uncaughtException', function (exception) {
	let date = new Date();

	console.log("\nWas error at " + date.toString());
	console.log(exception);
	console.log();
});

let download = function (url, dest, enc) {
	let file = fs.createWriteStream(dest + '.srt');

	let request = https.get(url, function (response) {
		let iconv = new Iconv(enc, 'UTF-8');
		response.pipe(iconv).pipe(file);
		fs.createReadStream(dest + '.srt').pipe(srt2vtt()).pipe(fs.createWriteStream(dest + '.vtt'));
		file.on('finish', function () {
			file.close(function () {
			});  // close() is async, call cb after close completes.
		});
	}).on('error', function (err) { // Handle errors
	});
};

let insertUpdateFilm = function (imdb_id, path, quality) {
	//add/update film info in DB
	console.log('path to API: ' + process.env.APP_URL + '/api/v1/insert-to-db');
	axios.post(process.env.APP_URL + '/api/v1/insert-to-db', {
		imdb_id: imdb_id,
		video_path: path,
		quality: quality
	})
		.catch(function (err) {
		console.log('can\'t update film info: ' + imdb_id);
		console.log(err);
		throw (err);

	});

};

function getSubtitles(imdb_id) {
	let subtitle_path = 'public/movies/' + imdb_id + '/';
	let subtitles_arr = [];

	return new Promise((resolve, reject) => {
		OS.search({
			imdbid: imdb_id
		}).then(subtitles => {
			if (subtitles['en']) {
				if (!fs.existsSync(subtitle_path + 'en.vtt')) {
					download(subtitles['en'].url, subtitle_path + 'en', subtitles['en'].encoding);
				}
				subtitles_arr.push({'code': 'en', 'title': subtitles['en'].lang});
			}
			if (subtitles['ru']) {
				if (!fs.existsSync(subtitle_path + 'ru.vtt')) {
					download(subtitles['ru'].url, subtitle_path + 'ru', subtitles['ru'].encoding);
				}
				subtitles_arr.push({'code': 'ru', 'title': subtitles['ru'].lang});
			}
			if (subtitles['uk']) {
				if (!fs.existsSync(subtitle_path + 'uk.vtt')) {
					download(subtitles['uk'].url, subtitle_path + 'uk', subtitles['uk'].encoding);
				}
				subtitles_arr.push({'code': 'uk', 'title': subtitles['uk'].lang});
			}
			resolve(subtitles_arr);
		}).catch(console.error);
	});

}

function sleep(time) {
	return new Promise((resolve) => setTimeout(resolve, time));
}

app.post('/movie/:id/:quality', function (req, res) {
	let subtitles_arr = [];
	let data;

	console.log(req.body.torrent_link);

	axios.post(process.env.APP_URL + '/api/v1/get-video-info', {
		imdb_id: req.params.id,
		quality: req.params.quality
	}).then(function (resp) {

		console.log(resp.data);
		if (resp.data.success && resp.data && resp.data.data) {
			getSubtitles(req.params.id).then(function (result) {
				subtitles_arr = result;
				data = resp.data.data;
				console.log("--------------------------");
				console.log(data);
				console.log("--------------------------");
				insertUpdateFilm(req.params.id, data.video, req.params.quality);

				res.setHeader('Content-Type', 'application/json');
				res.send(JSON.stringify({
					src: data.video,
					subtitles: subtitles_arr,
				}));
			});
		}

			magnetLink(req.body.torrent_link, function (err, link) {
				if (err) {
					console.log(err);
					return;
				}
				console.log("link: " + link);

				let path = 'movies/' + req.params.id;
				let engine = torrentStream(link, {path: 'public/' + path});

				engine.on('ready', function () {
					engine.files.forEach(function (file) {
						let extension = file.name.split('.').pop();

						console.log("\npath: " + file.path + "\nname: " + file.name);
						console.log('length: ' + file.length);
						console.log('extension');
						console.log(extension);
						if (extension === 'mp4') {

							console.log('extension2');
							console.log(extension);
							getSubtitles(req.params.id).then(function (result) {
								subtitles_arr = result;

								// file.select();	//скачує блоки рандомно

								let stream = file.createReadStream();	//скачує блоки послідовно з пріоритетом над select()

								if (!data) {
									stream.on('readable', function () {
										let src = '/' + path + '/' + encodeURI(file.path);

										insertUpdateFilm(req.params.id, src, req.params.quality);

										// sleep time expects milliseconds
										sleep(10000).then(() => {
											// Do something after the sleep!
											console.log('init request');
											res.setHeader('Content-Type', 'application/json');
											res.send(JSON.stringify({
												src: src,
												subtitles: subtitles_arr,
											}));

										});
									});
								}

							});

						} else {
							file.deselect();
						}
					})
				});
			});
	})
		.catch(function (err) {
			console.log(err);
		});
});

app.listen(port, function () {
	console.log('Server startet at port:' + port)
});