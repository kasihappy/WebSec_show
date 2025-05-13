<?php
// doBeforePageStartsWithoutLogin.php

// start session
session_start();

// connect to database
require_once('dbConnect.php');

// get all functions
require_once('functions.php');