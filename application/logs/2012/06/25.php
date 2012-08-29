<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2012-06-25 21:11:17 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ')', expecting '{' ~ SYSPATH/tests/kohana/RouteTest.php [ 119 ]
2012-06-25 21:11:17 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected ')', expecting '{' ~ SYSPATH/tests/kohana/RouteTest.php [ 119 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-06-25 21:18:50 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '}' ~ SYSPATH/classes/kohana/route.php [ 559 ]
2012-06-25 21:18:50 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '}' ~ SYSPATH/classes/kohana/route.php [ 559 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-06-25 21:19:03 --- ERROR: ErrorException [ 1 ]: Call to undefined function is_class() ~ SYSPATH/classes/kohana/route.php [ 558 ]
2012-06-25 21:19:03 --- STRACE: ErrorException [ 1 ]: Call to undefined function is_class() ~ SYSPATH/classes/kohana/route.php [ 558 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2012-06-25 21:22:06 --- ERROR: ErrorException [ 1 ]: Call to undefined function assertArrayNotHasKey() ~ SYSPATH/tests/kohana/RouteTest.php [ 123 ]
2012-06-25 21:22:06 --- STRACE: ErrorException [ 1 ]: Call to undefined function assertArrayNotHasKey() ~ SYSPATH/tests/kohana/RouteTest.php [ 123 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}