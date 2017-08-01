var Twit = require('twit');
var config = require('./config');
var fs = require('fs');
var mysql = require('mysql');
// var path = require('path');

var dateFormat = require('dateformat');

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
        console.log("Table Created/Existed!");
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
            //InsertNewTwit(twitID);
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

        // console.log(JSON.stringify(response, null, 2));
        var keyWords = "";
        for(var i=0 ; i < response.keywords.length ; i++)
            keyWords += response.keywords[i].text + " ";

        console.log("Looking for image according to keywords: "+keyWords);
        /**Function to search and download apropriate image*/
        var imgDownloader = require('./ImageDownloader');
        var path = imgDownloader.downloadImageByString(keyWords);
        console.log(path);


        /**Upload new post to FaceAfeka.*/
        UploadBotPost(path, twitText);
    })
}

function UploadBotPost(imgSrc, twitText) {
    var status = twitText;
    var privacy = "Public";
    var loggedUser = LOGGED_USER;
    var imgSrc = imgSrc;

    var easyImage = require('easyimage');
    var now = new Date();
    var temp = imgSrc.split(".");
    var len = temp.length;
    var name = dateFormat(now, 'yyyymmddHHMMss') + "." + temp[len-1];
    console.log(name);
    console.log(dest);
    console.log(imgSrc);
    var dest = '..\\Resources\\UploadedImgs\\'+name;
    fs.rename(imgSrc,dest);
    var src = dest;

    dest = '..\\Resources\\Thumbs\\'+name ;
    easyImage.resize({src: src, dst: dest,
                        width: 100, height: 100})
        .then(
            function (image) {
                console.log("resized success");
            }
        ,
        function (err) {

    });
    status = addslashes(status);
    var query = "INSERT INTO Posts (Status, ImgSrc, Publisher, Privacy, Date) VALUES "
    + "('" + status +"', '"+ name +"', '" + loggedUser + "', '"+ privacy + "', now());";
    console.log(query);
    con.query(query, function (err, result) {
        if(err) throw err;
        console.log("Inserted new Post");
    });
}

function addslashes(string) {
    return string.replace(/\\/g, '\\\\').
    replace(/\u0008/g, '\\b').
    replace(/\t/g, '\\t').
    replace(/\n/g, '\\n').
    replace(/\f/g, '\\f').
    replace(/\r/g, '\\r').
    replace(/'/g, '\\\'').
    replace(/"/g, '\\"');
}
