const dbConfig = {
	host     : 'localhost',
	user     : 'letsolnx_neervana_user',
	password : '6JE=HZlVHNls',
	database : 'letsolnx_neervana'
};

const cors      =   require('cors');
const mysql     =	require('mysql');
const http      =	require('http');
const bodyParser=	require('body-parser');
const express   =   require('express');

const app       =   express();

app.use(cors());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

app.use(express.static('public'));

const server    =	http.createServer(app).listen();

/* Routes */

//test route
app.get('/neervana/neervana_node/test', function(req, res){
	res.set('Access-Control-Allow-Origin', '*');
	res.send("<h1>It's Working</h1>");
	return res.end();
});


/* Socket Code Below */

const io		=	require('socket.io')({
	path: '/neervana/neervana_node/socket.io'
}).listen(server);

io.on('connection', function(socket){

	//console.log('User Connected');

	// For testing
	// io.emit('test_emit','rakesh');
	/*
        socket.on('test_save', function(data,client_callback){
            client_callback(data);
            io.emit('test_emit', data.date);
        });
    */


	socket.on('save_coordinates', function(data,client_callback){

		//io.emit('test_emit', "Coordinates Recieved"); //For testing

		var inser_query = "INSERT INTO `coordinates` (`lat`, `lng`, `user_id`, `created_at`, `created_by`) VALUES ('"+data.lat+"', '"+data.lng+"', '"+data.user_id+"', '"+get_date()+"', '"+data.user_id+"');";

		var db = mysql.createConnection(dbConfig);

		db.query(inser_query, function (error, results, fields) {
			if (error) {
				client_callback(data);
				return;
				// throw error;
			}else{
				data.id = results.insertId;
				client_callback(data);
				io.emit('push_coordinates', data);
				db.end();
			}
		});
	});

	socket.on('disconnect', function(){
		console.log('User Disonnected');
	});
});

// API route
app.post('/neervana/neervana_node/api/save_user_coordinates', function(req, res){

	if(req.body.lat && req.body.lng && req.body.user_id){

		let data = {
			lat     :   req.body.lat,
			lng     :   req.body.lng,
			user_id :   req.body.user_id
		};

		var inser_query = "INSERT INTO `coordinates` (`lat`, `lng`, `user_id`, `created_at`, `created_by`) VALUES ('"+data.lat+"', '"+data.lng+"', '"+data.user_id+"', '"+get_date()+"', '"+data.user_id+"');";

		var db = mysql.createConnection(dbConfig);

		db.query(inser_query, function (error, results, fields) {
			if (error) {
				res.json({status:false,message:'Coordinates not saved successfully'});
				return;
				// throw error;
			}else{

				data.id = results.insertId;
				io.emit('push_coordinates', data);
				db.end();
				res.json({status:false,message:'Coordinates saved successfully'}).end();
			}
		});

	}else{
		res.json({status:false,message:'lat, lng and user_id are required params.'}).end();
	}
});

function get_date(){

	let date_ob = new Date();
	// adjust 0 before single digit date

	let date = ("0" + date_ob.getDate()).slice(-2);	// current date

	let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);	// current month

	let year = date_ob.getFullYear();	// current year

	let hours = date_ob.getHours();	// current hours

	let minutes = date_ob.getMinutes();	// current minutes

	let seconds = date_ob.getSeconds();	// current seconds

	return (year + "-" + month + "-" + date + " " + hours + ":" + minutes + ":" + seconds);	// return date in YYYY-MM-DD H:i:s format
}