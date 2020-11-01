<?php

require "config/connection.php";
require "config/loader.php";

use Config\Router;

(new Router)->makeRoutes();