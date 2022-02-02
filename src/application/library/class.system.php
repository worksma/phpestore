<?PHP
	class System {
		static function version() {
			return conf();
		}

		static function news() {
			return json_decode(curl("https://api.worksma.ru", json_encode([
				'module'		=> 'kitdown',
				'domain'		=> $_SERVER['SERVER_NAME'],
				'type'			=> 'news'
			])));
		}

		static function is_version() {
			return json_decode(curl("https://api.worksma.ru", json_encode([
				'module'		=> 'kitdown',
				'domain'		=> $_SERVER['SERVER_NAME'],
				'type'			=> 'valid_version',
				'version'		=> conf()->version
			])));
		}

		public function get_update_file($version) {
			return json_decode(curl("https://api.worksma.ru", json_encode([
				'module'		=> 'kitdown',
				'domain'		=> $_SERVER['SERVER_NAME'],
				'type'			=> 'get_update_file',
				'version'		=> $version
			])))->file;
		}

		public function update_download($url, $version) {
			$temp		= $_SERVER['DOCUMENT_ROOT'] . "/application/modules/updates/$version.zip";

			if($a = file_get_contents($url)):
				return file_put_contents($temp, $a);
			endif;

			return false;
		}

		public function set_update($version) {
			$folder		= $_SERVER['DOCUMENT_ROOT'] . "/application/modules/updates";
			$temp		= "$folder/$version.zip";

			if(!file_exists($temp)):
				return false;
			endif;

			$zip = new ZipArchive;
			if($zip->open($temp) === true):
				$zip->extractTo($_SERVER['DOCUMENT_ROOT'] . '/');

				if($zip->close()):
					unlink($temp);

					if(file_exists("$folder/import_primary.php")):
						require_once("$folder/import_primary.php");
						unlink("$folder/import_primary.php");
					endif;

					if(file_exists("$folder/import.sql")):
						try {
							pdo()->exec(trim(file_get_contents("$folder/import.sql")));
							unlink("$folder/import.sql");
						}
						catch (PDOException $e) {
							return false;
						}
					endif;

					try {
						pdo()
						->prepare("UPDATE `configs` SET `version`=:version,`date`=:date WHERE 1")
						->execute([
							':version'		=> $version,
							':date'			=> date("Y-m-d H:i:s")
						]);
						
						if(file_exists("$folder/import_secondary.php")):
							require_once("$folder/import_secondary.php");
							unlink("$folder/import_secondary.php");
						endif;

						return true;
					}
					catch (PDOException $e) {
						return false;
					}
				endif;
			endif;
		}
	}