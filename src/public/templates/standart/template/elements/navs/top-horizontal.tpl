            <nav class="navbar navbar-expand-lg container navbar-light bg-light">
                <a class="navbar-brand" href="/">
                    <img src="{assets}img/code.svg" width="30" height="30" class="d-inline-block align-top" alt="KitDown" title="KitDown">
                    KitDown
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item {home:active}">
                            <a class="nav-link" href="/">Главная</a>
                        </li>

                        <li class="nav-item {contact:active}">
                            <a class="nav-link" href="/contact">Контакты</a>
                        </li>

                        <li class="nav-item {garant:active}">
                            <a class="nav-link" href="/garant">Гарантии</a>
                        </li>

                        <li class="nav-item {reviews:active}">
                            <a class="nav-link" href="/reviews">Отзывы</a>
                        </li>

                        <?if(isset($_SESSION['id'])):?>
                        <li class="nav-item">
                            <a class="nav-link palka">|</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <?=usr()->formate_name($_SESSION['id']);?>
                            </a>

                            <div class="dropdown-menu">
                                <?if(usr()->access($_SESSION['id'], "a")):?>
                                <a class="dropdown-item" href="/admin">Панель управления</a>
                                <?endif;?>

                                <a class="dropdown-item" href="/wallet">Мой кошелёк</a>
                                <a class="dropdown-item" href="/purchases">Мои покупки</a>
                                <a class="dropdown-item" href="/support" target="_blank">Помощь</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/wallet">
                                Баланс: <span id="balance"><?=usr()->get_balance($_SESSION['id']);?></span> &#8381;</i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Выйти</a>
                        </li>
                        <?else:?>
                        
                        <li class="nav-item {login:active}">
                            <a class="nav-link" href="/login">Войти на сайт</a>
                        </li>
                        <?endif;?>
                    </ul>
                </div>
            </nav>