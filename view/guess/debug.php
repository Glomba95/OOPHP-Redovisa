<?php

namespace Anax\View;

/**
 * Render debug view.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?><hr>
<pre>
SESSION
<?= var_dump($_SESSION) ?>
INDATA TILL VYN
<?= var_dump($data) ?>
POST
<?= var_dump($_POST) ?>
GET
<?= var_dump($_GET) ?>
</pre>
<hr>
