<?php
	//Regular expression pattern to match url with or without http://www
    $regex = "((https?|ftp)://)?"; // SCHEME
    $regex .= "([a-z0-9+!*(),;?&=$_.-]+(:[a-z0-9+!*(),;?&=$_.-]+)?@)?"; // User and Pass
    $regex .= "([a-z0-9\-\.]*)\.(([a-z]{2,4})|([0-9]{1,3}\.([0-9]{1,3})\.([0-9]{1,3})))"; // Host or IP
    $regex .= "(:[0-9]{2,5})?"; // Port
    $regex .= "(/([a-z0-9+$_%-]\.?)+)*/?"; // Path
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+/$_.-]*)?"; // GET Query
    $regex .= "(#[a-z_.-][a-z0-9+$%_.-]*)?"; // Anchor
    //cach 2
   if(preg_match("~^$regex$~i", 'www.example.com/etcetc', $m))
      var_dump($m);

   if(preg_match("~^$regex$~i", 'http://www.example.com/etcetc', $m))
      var_dump($m);
