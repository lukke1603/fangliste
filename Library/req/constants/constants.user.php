<?php

namespace MVC\req\constants;

use MVC\Model\User;

define('PATH_USER', PATH_ROOT.'user'.DIRECTORY_SEPARATOR.$user->id.DIRECTORY_SEPARATOR);
define('PATH_USER_REL', '.'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR.$user->id.DIRECTORY_SEPARATOR);
define('PATH_USER_IMAGES', PATH_ROOT.'user'.DIRECTORY_SEPARATOR.$user->id.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR);
define('PATH_USER_IMAGES_REL', '.'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR.$user->id.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR);