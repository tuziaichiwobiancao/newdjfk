<?php

if (isset($_FILES['file'])) {
	echo $_FILES['file']['name'] . '|' . $_FILES['file']['type'] . '|' . $_FILES['file']['size'];
}
