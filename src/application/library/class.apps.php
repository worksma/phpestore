<?PHP
	class Apps {
		static function get_vk($id) {
			return pdo()->query("SELECT * FROM `apps__vk` WHERE `id`='$id' LIMIT 1")->fetch(PDO::FETCH_OBJ);
		}
	}