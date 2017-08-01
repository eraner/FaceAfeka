var Twit = require('twit');
var config = require('./config');
var fs = require('fs');
var mysql = require('mysql');

var unirest = require('unirest');
// var request = require('request');
// var http = require('http');

const NaturalLanguageUnderstandingV1 = require('watson-developer-cloud/natural-language-understanding/v1.js');
const LOGGED_USER = "Ohad Cohen";

const nlu = new NaturalLanguageUnderstandingV1({
    // note: if unspecified here, credentials are pulled from environment properties:
    // NATURAL_LANGUAGE_UNDERSTANDING_USERNAME &  NATURAL_LANGUAGE_UNDERSTANDING_PASSWORD
    username: "6fc6d8fc-68bc-4fb7-af00-c7a28251a7fb",
    password: "Hp7TAFtNSCaD",
    version_date: NaturalLanguageUnderstandingV1.VERSION_DATE_2016_01_23
});

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
    var twitText = data[0].text;
    console.log(twitID);
    var query = "SELECT * FROM Twits_id WHERE TwitID = "+twitID+";";
    con.query(query, function (err, result) {
        if(err) throw err;
        if(result != 0) {
            return;
        }else{
            console.log("Twit " + twitID + " doesn't exist, handling the new twit....");
            InsertNewTwit(twitID);
            AnalyzeNewTwit(twitText);
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
function AnalyzeNewTwit(twitText){
    var parameters = {
        'text' : twitText,
        'language': 'en',
        'features' : {
            'keywords': {
                'emotion' : true,
                'sentiment' : true
            }
        }
    };
    console.log(parameters);

    nlu.analyze(parameters, function (err, response) {
        if(err) throw err;
        else
            // console.log(JSON.stringify(response, null, 2));
        console.log(response.keywords[0]);

        /**Function to search and download apropriate image*/


        /**Upload new post to FaceAfeka.*/
        UploadBotPost("", twitText);
    })
}

function UploadBotPost(imgSrc, twitText) {
    var status = twitText;
    var privacy = "Public";
    var loggedUser = LOGGED_USER;
    var imgSrc = imgSrc;

    unirest.post('http://localhost/FaceAfeka/Feed/UploadPost.php')
        .headers({'Content-Type': 'application/x-www-form-urlencoded'}).type('form')
        .send({'status': status, 'privacy': privacy, 'loggedUser': loggedUser})
        .end(function (response) {
            console.log(response.body);
            if (response.error) {
                console.log('GET error', response.error);
            } else {
                // console.log('GET response', response.body);
            }
    });
}