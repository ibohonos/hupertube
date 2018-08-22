//https://www.youtube.com/watch?v=N2aMWdS0ANc
//https://github.com/Gryshchenko/digitalcinema/blob/2fc9e5e191dd2ec16aa12b6ae3658b816fc10002/public/torrent-stream/torrent.js

const	port = 3000;

const	express = require('express'),
		bodyParser = require('body-parser'),
		app = express();

app.use(bodyParser.urlencoded({	extended: true }));
app.use(bodyParser.json());

app.get('/', function (req, res) {
	res.send("hello mazafaka");
});

app.listen(port, function(){
	console.log('Server startet at port:' + port)
});