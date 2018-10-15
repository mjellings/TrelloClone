<?php

// Use in the "Post-Receive URLs" section of your GitHub repo.
if ( $_POST['payload'] ) {
  shell_exec( 'cd c:\xampp\htdocs\trello.jello.me.uk && git reset --hard HEAD && git pull' );
}
?>Test

