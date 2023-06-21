<?php
// model.php

require_once 'config.php';

function openConex() {
    $conex = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

    return $conex;
}

function getPosts() {
    $mysqli = openConex();

    $result = $mysqli->query('SELECT id, title, description, date FROM post ORDER BY id desc');

    if ($result->num_rows > 0) {
        $posts = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
        return $posts;
    } else {
        return array();
    }
}
?>