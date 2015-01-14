<?php
/**
 * Maes Jerome
 * index.php, created at Jan 12, 2015
 *
 */


echo '<ul>';
if ($handle = opendir('.')) {

	while (false !== ($entry = readdir($handle))) {

		if ($entry != "." && $entry != "..") {

			echo "<li><a href='".$entry."'>" . $entry . "</a><li>";
		}
	}

	closedir($handle);
}
echo '</ul>';