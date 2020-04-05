<?php

namespace connections;

use mysqli;
use mysqli_stmt;
use SimpleXMLElement;

class Database
{
    private string $host = 'localhost';
    private string $user = 'root';
    private string $password = '';
    private string $database = 'weeblist';
    public function __construct()
    {
        $this->dbConnect();
    }

    private function dbConnect(): mysqli
    {
        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);
        return $this->mysqli;
    }
    public function getTotalAnimeInDatabase()
    {
        $result = $this->mysqli->query('SELECT COUNT(DISTINCT anime_id) FROM animelist;');
        return $result->fetch_row()[0];
    }
    public function getTopTenWatchedAnime()
    {
        $result = $this->mysqli->query('SELECT * FROM animelist');
        $result->fetch_all();
        $animeListString = "";
        $test_array = array(
            'bla' => 'blub',
            'foo' => 'bar',
            'another_array' => array(
                'stack' => 'overflow',
            ),
        );
        $xml = new SimpleXMLElement('<root/>');
        array_walk_recursive($test_array, array($xml, 'addChild'));
        print $xml->asXML();
        header('contentType: text/html');
        return $animeListString;
    }
    public function getXML()
    {
        $xml = new SimpleXMLElement("<xml/>");
        for ($i = 1; $i <= 8; ++$i) {
            $track = $xml->addChild('track');
            $track->addChild('path', "song$i.mp3");
            $track->addChild('title', "Track $i - Track Title");
            Header('Content-type: xml');
        }
        return $xml->asXML();
    }
    public function getLimitedTopWatchedAnime(int $limit)
    {
        // $sql = ('SELECT anime_id, COUNT(user_id)AS userCount FROM `ratinglist` GROUP BY anime_id ORDER BY userCount DESC LIMIT ?');
       
        // $stmt = $this->mysqli->prepare($sql);
        // $stmt->bind_param("i", $limit);
        // $stmt->execute();
        // $result = $stmt->get_result()->fetch_all(\MYSQLI_ASSOC);


        $sql = ("SELECT count(user_id) AS Total, (SELECT Count(gender)FROM userlist WHERE gender = 'Male') AS Male, (SELECT Count(gender) FROM userlist WHERE  gender = 'Female') AS Female FROM `userlist` GROUP BY Male, Female");
        $stmt = $this->mysqli->prepare($sql);
        // $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(\MYSQLI_ASSOC);





        // $rowCount = $result->num_rows;
        // $result = $result->fetch_all(\MYSQLI_ASSOC);
        // echo $stmt->store_result();

        // echo "<pre>";var_dump($result); echo "</pre>";

        // $xml = new SimpleXMLElement("<watched/>");
        // for ($beginRowCount = 0; $beginRowCount < count($result); $beginRowCount++) {
        //     $node = $xml->addChild("Anime");
        //     $node->addChild("animeId", $result[$beginRowCount][0]);
        //     $node->addChild("watchCount", $result[$beginRowCount][1]);
        //     Header('Content-type: text/xml');
        // }
        // echo $xml->asXML();







        $result_json = $result;

        // headers for not caching the results
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

        // headers to tell that result is JSON
        header('Content-type: application/json');

        // send the result now
        echo json_encode($result_json);
        // return $stmt;
    }
}
