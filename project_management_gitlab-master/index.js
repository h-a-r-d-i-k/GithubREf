var app = require('express')();
var haml = require('hamljs');
const fs = require('fs');
const readline = require('readline');
const {google} = require('googleapis');


var http = require('http').Server(app);
var querystring = require('querystring');

var user_id = '3270682';
http.listen(9991, function() {
	 console.log('listening on localhost:9991');
});

app.get('/', function(req, res) {
	 console.log('----> listening on localhost:9991');
	 res.sendfile(__dirname + '/index.html');
});

// start google
const SCOPES = ['https://www.googleapis.com/auth/drive'];
// The file token.json stores the user's access and refresh tokens, and is
// created automatically when the authorization flow completes for the first
// time.
const TOKEN_PATH = 'token.json';

/**
 * Create an OAuth2 client with the given credentials, and then execute the
 * given callback function.
 * @param {Object} credentials The authorization client credentials.
 * @param {function} callback The callback to call with the authorized client.
 */
function authorize(credentials, callback, apiRes ,req = null) {
	const {client_secret, client_id, redirect_uris} = credentials.installed;
	const oAuth2Client = new google.auth.OAuth2(
			client_id, client_secret, redirect_uris[0]);

	// Check if we have previously stored a token.
	fs.readFile(TOKEN_PATH, (err, token) => {
		if (err) return getAccessToken(oAuth2Client, callback);
		oAuth2Client.setCredentials(JSON.parse(token));
		callback(oAuth2Client, apiRes, req);
	});
}

/**
 * Get and store new token after prompting for user authorization, and then
 * execute the given callback with the authorized OAuth2 client.
 * @param {google.auth.OAuth2} oAuth2Client The OAuth2 client to get token for.
 * @param {getEventsCallback} callback The callback for the authorized client.
 */
function getAccessToken(oAuth2Client, callback) {
	const authUrl = oAuth2Client.generateAuthUrl({
		access_type: 'offline',
		scope: SCOPES,
	});
	console.log('Authorize this app by visiting this url:', authUrl);
	const rl = readline.createInterface({
		input: process.stdin,
		output: process.stdout,
	});
	rl.question('Enter the code from that page here: ', (code) => {
		rl.close();
		oAuth2Client.getToken(code, (err, token) => {
			if (err) return console.error('Error retrieving access token', err);
			oAuth2Client.setCredentials(token);
			// Store the token to disk for later program executions
			fs.writeFile(TOKEN_PATH, JSON.stringify(token), (err) => {
				if (err) console.error(err);
				console.log('Token stored to', TOKEN_PATH);
			});
			callback(oAuth2Client);
		});
	});
}
/**
 * Lists the names and IDs of up to 10 files.
 * @param {google.auth.OAuth2} auth An authorized OAuth2 client.
 */
function listFiles(auth, apiRes) {
	const drive = google.drive({version: 'v3', auth});
	drive.files.list({
		pageSize: 50,
		q: 'mimeType = \'application/vnd.google-apps.folder\'',
		fields: 'nextPageToken, files(id, name, mimeType)',
	}, (err, res) => {
		if (err) return console.log('The API returned an error: ' + err);
		const files = res.data;
		// if (files.length) {
			apiRes.end(JSON.stringify(files));

			// files.map((file) => {
			// 	// console.log(`${file.name} (${file.id})`);
			// });
		// } else {
		// 	console.log('No files found.');
		// }
	});
}
app.get('/google', function(req, res) {
	 // Load client secrets from a local file.
	fs.readFile('credentials.json', (err, content) => {
		if (err) return console.log('Error loading client secret file:', err);
		// Authorize a client with credentials, then call the Google Drive API.
		authorize(JSON.parse(content), listFiles, res);
	});
});

function createdrive(auth, apiRes, req) {
	const drive = google.drive({version: 'v3', auth});
	var fileMetadata = {
		'name': req,
		'mimeType': 'application/vnd.google-apps.folder'
	};
	drive.files.create({
		resource: fileMetadata,
		fields: 'id'
	}, function (err, file) {
		if (err) {
			// Handle error
			console.error(err);
		} else {
			apiRes.end('1');
			console.log('Folder Id: ', file.id);
		}
	});
}

// end google

app.get('/new', function(req, res) {
	 console.log('----> listening on localhost:9991');
	 res.sendfile(__dirname + '/new.html');
});

var project_V = '';
app.get('/detail', function(req, res) {
	 console.log('----> Detail called');
	 project_V = req.query.id;
	 res.sendfile(__dirname + '/detail.html');
 //   	var hamlView = fs.readFileSync('detail.haml', 'utf8');
	// res.end( haml.render(hamlView, {id :'123'}) );
});

app.get('/projectsDetail', function(req, res){
	var http = require('follow-redirects').http;
	const options = {
		host: 'www.gitlab.com',
		port: 80,
		path: '/api/v4//projects/'+project_V,
		method: 'GET',
		headers: {
			'Content-Type': 'application/json; charset=utf-8',
			'Private-Token':'y_DXXXXXXXXXXXXXX'
		}
	};
	var reqs = http.request(options, function(response) {
		console.log('STATUS: ' + response.statusCode);
		console.log('HEADERS: ' + JSON.stringify(response.headers));
		response.setEncoding('utf8');
		var chunk1 = '';
		response.on('data', (chunk) => {
			chunk1 = chunk1 + chunk;
		});
		response.on('end', () => {
			res.end(chunk1);
			console.log('No more data in response.');
		});
	}).end();
	console.log('Bye: ');
});
app.get('/projects', function(req, res){

	var http = require('follow-redirects').http;
	const options = {
		host: 'www.gitlab.com',
		port: 80,
		path: '/api/v4/users/'+user_id+'/projects',
		method: 'GET',
		headers: {
			'Content-Type': 'application/json; charset=utf-8',
			'Private-Token':'y_DRXXXXXXXXXXXXXXXX'
		}
	};
	var reqs = http.request(options, function(response) {
		console.log('STATUS: ' + response.statusCode);
		console.log('HEADERS: ' + JSON.stringify(response.headers));
		response.setEncoding('utf8');
		var chunk1 = '';
		response.on('data', (chunk) => {
			chunk1 = chunk1 + chunk;
		});
		response.on('end', () => {
			res.end(chunk1);
			console.log('No more data in response.');
		});
	}).end();
	console.log('Bye: ');
});

app.post('/create', function(req, res){
	console.log(req.body);
	 var body='';
		req.on('data', function (data) {
				body +=data;
		});
		req.on('end',function(){
				var POST =  querystring.parse(body);
				projectname = POST.name;

		var http = require('follow-redirects').http;

		const axios = require('axios')


		axios({
			url: 'https://gitlab.com/api/v4/projects',
			method: 'POST',
			data: {
				name:projectname,
				user_id:user_id
			},
			headers: {
				// 'Content-Type':'application/x-www-form-urlencoded',
				'Private-Token':'y_DRXXXXXXXXXXXXXXXX'
			}
		}).then((resp) => {
			fs.readFile('credentials.json', (err, content) => {
				if (err) return console.log('Error loading client secret file:', err);
				// Authorize a client with credentials, then call the Google Drive API.
				authorize(JSON.parse(content), createdrive, res, projectname);
			});
			console.log(`statusCode: ${resp.statusCode}`)
			console.log(resp.data);
			// res.end('1');
		})
		.catch((error) => {
			res.end('2');
			console.log(`statusCode: ${error}`)
			// console.error(error)
		})

		// var post_data = querystring.stringify({
		// 	'compilation_level' : 'ADVANCED_OPTIMIZATIONS',
		// 	'output_format': 'json',
		// 	'output_info': 'compiled_code',
		// 	'warning_level' : 'QUIET',
		// 	'js_code' : {
		// 		name:projectname,
		// 		user_id:user_id
		// 	}
		// });

		// const options = {
		// 	host: 'www.gitlab.com',
		// 	port: 80,
		// 	path: '',
		// 	method: 'POST',
		// 	data : {
		// 		name:projectname,
		// 		user_id:user_id
		// 	},
		// 	headers: {
		// 		'Content-Type': 'application/x-www-form-urlencoded',
		// 		// 'Content-Length': Buffer.byteLength(post_data),
		// 		'Private-Token':'y_DRXXXXXXXXXXXXXXXX'
		// 	}
		// };
		// // Set up the request
		// var post_req = http.request(options, function(APIresponse) {
		// 	APIresponse.setEncoding('utf8');
		// 	var chunk1 = '';
		// 	APIresponse.on('data', function (chunk) {
		// 	  	console.log('..........APIResponseponse: ' + chunk);
		// 		chunk1 = chunk1 + chunk;
		// 	});
		// 	APIresponse.on('end', () => {
		// 		console.log('No more data in response.');
		// 	});
		// });

		// post the data
		// resp = post_req.write(post_data);
		// console.log(resp);

		// var reqs = http.request(options, function(response) {
		// 	console.log('STATUS: ' + response.statusCode);
		// 	console.log('HEADERS: ' + JSON.stringify(response.headers));
		// 	response.setEncoding('utf8');
		// 	response.on('data', (chunk) => {
		// 	});
		// 	response.on('end', () => {
		// 		console.log('No more data in response.');
		// 	});
		// }).end();
		// console.log('Bye: ');
		});
});