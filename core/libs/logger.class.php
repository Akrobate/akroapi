<?php


class logger {
	static function log($data) {
		file_put_contents (LOG_FILE, $data, FILE_APPEND);
	}
}
