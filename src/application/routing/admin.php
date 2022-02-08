<?PHP
	Routing::get("/admin", function() {
		if(!usr()->access($_SESSION['id'], "a")):
			return redirect("/404");
		endif;

		tpl()
		->set_template("admin")
		->run()
		->title("Основные настройки")
		->set("{content}", tpl()->get("main/index"))
		->set("{nav}", tpl()->nav("left-vertical"))
		->set("{sells}", Admin::sells())
		->set("{income}", Admin::income())
		->set("{products}", Admin::products())
		->set("{users}", Admin::users())
		->set("{pre_title}", conf()->title)
		->set("{pre_description}", conf()->description)
		->set("{pre_keywords}", conf()->keywords)
		->set("{apps_vk_id}", Apps::get_vk('1')->app_id)
		->set("{apps_vk_secret}", Apps::get_vk('1')->app_secret)
		->set("{apps_vk_service}", Apps::get_vk('1')->app_service)
		->end();
	});

	Routing::get("/admin/users", function() {
		if(!usr()->access($_SESSION['id'], "a")):
			return redirect("/404");
		endif;

		tpl()
		->set_template("admin")
		->run()
		->title("Пользователи")
		->set("{content}", tpl()->get("main/users"))
		->set("{nav}", tpl()->nav("left-vertical"))
		->end();
	});

	Routing::get("/admin/wallet", function() {
		if(!usr()->access($_SESSION['id'], "a")):
			return redirect("/404");
		endif;

		tpl()
		->set_template("admin")
		->run()
		->title("Платёжные системы")
		->set("{content}", tpl()->get("main/wallet"))
		->set("{nav}", tpl()->nav("left-vertical"))
		->end();
	});

	Routing::get("/admin/product", function() {
		if(!usr()->access($_SESSION['id'], "a")):
			return redirect("/404");
		endif;

		tpl()
		->set_template("admin")
		->run()
		->title("Управление товарами")
		->set("{content}", tpl()->get("main/product"))
		->set("{nav}", tpl()->nav("left-vertical"))
		->set("{category}", Product::get_select_groups())
		->end();
	});

	Routing::get("/admin/dev", function() {
		if(!usr()->access($_SESSION['id'], "a")):
			return redirect("/404");
		endif;

		tpl()
		->set_template("admin")
		->run()
		->title("Уголок разработчика")
		->set("{content}", tpl()->get("main/dev"))
		->set("{nav}", tpl()->nav("left-vertical"))
		->end();
	});
	
	Routing::get("/admin/category", function() {
		if(!usr()->access($_SESSION['id'], "a")):
			return redirect("/404");
		endif;

		tpl()
		->set_template("admin")
		->run()
		->title("Управление категориями")
		->set("{content}", tpl()->get("main/category"))
		->set("{nav}", tpl()->nav("left-vertical"))
		->set("{groups}", Product::get_groups())
		->set("{category}", Product::get_category())
		->set("{options}", Product::get_select_groups())
		->end();
	});