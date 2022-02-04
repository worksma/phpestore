<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{title}</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
    <link href="{assets}plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="{assets}plugins/font-awesome/css/all.min.css" rel="stylesheet">
    <link href="{assets}plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">

    <link href="{assets}css/main.min.css" rel="stylesheet">
    <link href="{assets}css/custom.css" rel="stylesheet">
  </head>
  <body>
  	<input type="hidden" id="token" value="{token}">
  	
    <div class='loader'>
      <div class='spinner-grow text-primary' role='status'>
        <span class='sr-only'>Loading...</span>
      </div>
    </div>

    <div class="page-container">
      <div class="page-header">
        <nav class="navbar navbar-expand-lg d-flex justify-content-between">
          <div class="" id="navbarNav">
            <ul class="navbar-nav" id="leftNav">
              <li class="nav-item">
                <a class="nav-link" id="sidebar-toggle" href="javascript:void(0);"><i data-feather="arrow-left"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/">Вернуться на сайт</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
      {nav}
      <div class="page-content">
        <div class="main-wrapper">
          {content}
        </div>
      </div>
    </div>
            
    <script src="{assets}plugins/jquery/jquery-3.4.1.min.js?v={cache}"></script>
    <script src="{assets}js/popper.js?v={cache}"></script>
    <script src="{assets}plugins/bootstrap/js/bootstrap.js?v={cache}"></script>
    <script src="{assets}js/feather.js?v={cache}"></script>
    <script src="https://kit.fontawesome.com/4e87f26727.js" crossorigin="anonymous"></script>
    <script src="{assets}plugins/perfectscroll/perfect-scrollbar.min.js?v={cache}"></script>
    <script src="{assets}js/main.min.js?v={cache}"></script>
    <script src="{sitehost}application/performers/compressed/engine.min.js?v={cache}"></script>
    <script src="{sitehost}application/performers/compressed/acp.min.js?v={cache}"></script>
    <script src="{assets}js/primary.js?v={cache}"></script>
  </body>
</html>