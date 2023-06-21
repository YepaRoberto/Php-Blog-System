<?php
// index.php

require_once 'model.php'; 

$posts = getPosts();

require 'blog/blogs.php';

?>
