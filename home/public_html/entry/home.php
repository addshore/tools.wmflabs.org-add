<?php
// 2468 indicates a dev env (with docker)
if( $_SERVER['SERVER_PORT'] == 2468 ) {
	$baseUrl = "http://localhost:3333/add";
} else {
	$baseUrl = "https://tools.wmflabs.org/add";
}

echo "<html>";
echo "<body>";
echo "<h1>Welcome Home!</h1>";

echo "<ul>";
echo "<li><a href='{$baseUrl}/swagger/' >Swagger</a> (with API sandbox)</li>";
echo "<li><a href='{$baseUrl}/api' >API Base</a> (you'll get a 404)</li>";
echo "<li><a href='{$baseUrl}/api/spec' >Open API Spec</a></li>";
echo "<li><a href='https://github.com/addshore/tools.wmflabs.org-add' >Github code</a></li>";
echo "</ul>";


echo "<p>More to come...</p>";

echo "</body>";
echo "</html>";
