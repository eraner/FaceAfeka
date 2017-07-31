var Twit = require('twit');
var config = require('./config');
var fs = require('fs');
var mysql = require('mysql');

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "faceafeka"
});

con.connect(function(err) {
    if (err) throw err;
    console.log("Connected to Database!");
    var query = "CREATE TABLE IF NOT EXISTS Twits_id(" +
        "TwitID BIGINT," +
        "PRIMARY KEY (TwitID)" +
        "); ";
    con.query(query, function (err, result) {
        if(err) throw err;
        console.log("Table Created!");
    });
});


var Twit = new Twit(config);

Repost();

function Repost() {
    Twit.get('statuses/user_timeline', {screen_name: "@OhadCcc", count: 1}, FoundTwit);
}

function FoundTwit(err, data, response) {
    //q: 'banana since:2011-11-11', count: 100
    var twitID = data[0].id;
    console.log(twitID);
    var query = "SELECT * FROM Twits_id WHERE TwitID = "+twitID+";";
    con.query(query, function (err, result) {
        if(err) throw err;
        if(result != 0) {
            return;
        }else{
            InsertNewTwit(twitID);
        }

    });

}

function InsertNewTwit(twitID) {
    var query = "INSERT INTO Twits_id (TwitID) VALUES ("+twitID+");";
    con.query(query, function (err, result) {
        if(err) throw err;
        console.log("Inserted to DB new TwitID!");
    });
}