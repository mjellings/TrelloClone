<?php

// Use in the "Post-Receive URLs" section of your GitHub repo.
//if ( $_POST['payload'] ) {
  shell_exec( 'cd c:\xampp\htdocs\trello.jello.me.uk && git reset --hard HEAD && git pull' );
  //shell_exec( 'cd c:\xampp\htdocs\trello.jello.me.uk && composer update && composer install' );
  shell_exec( 'cd c:\xampp\htdocs\trello.jello.me.uk && php artisan migrate' );
//}
?>Test 7

