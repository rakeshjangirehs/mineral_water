var http	=	require('http').createServer();
var io		=	require('socket.io')(http);
var mysql	=	require('mysql');
var user_count = 0;


var dbConfig = {
	host     : '172.16.3.124',
	user     : 'root',
	password : '',
	database : 'mineral_water'
};

io.on('connection', function(socket){
	
	user_count++;
	console.log('User Connected '+ user_count);

	socket.on('save_coordinates', function(data,client_callback){

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
		if(user_count>0) user_count--;
		console.log('User Disonnected '+ user_count);
	});
});

http.listen(3000, '172.16.3.123',function(){
	console.log('listening on http://172.16.3.123:3000');
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