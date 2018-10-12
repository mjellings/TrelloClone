<?php

echo '<pre>'; print_r($_POST); echo '</pre>';
file_put_contents('log.txt', print_r($_POST, true));

