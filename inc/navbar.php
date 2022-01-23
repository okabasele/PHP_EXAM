<nav class="nav">
        <div class="nav-wrap d-flex w-100 h-100">
            <div class="left-nav d-flex w-30">
                <div class="icon">
                    <img src="assets\css\ARTICLE.png" style="width:45px;height:45px;" >
                </div>
                <div class="pages">
                    <div class="page__menu menu">
                        <ul class="menu__list r-list">
                            <li class="menu__group">
                                <a href="home.php" class="menu__link r-link text-underlined">Home</a>
                            </li>
                            <li class="menu__group">
                                <a href="#0" class="menu__link r-link text-underlined">Help</a>
                            </li>
                            <li class="menu__group">
                                <a href="#0" class="menu__link r-link text-underlined">About</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="right-nav d-flex w-70">
                <div class="wrap-art-search d-flex">

                    <div class="search-bar">
                        <!-- <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form> -->

                    </div>
                    <div class="new-art">
                        <a class="btn btn-dark" href="new.php">Create a new article</a>
                    </div>
                </div>
                <div class="personal">
                    <div class="position-relative dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://www.e-xpertsolutions.com/wp-content/plugins/all-in-one-seo-pack/images/default-user-image.png" class="mr-3 rounded-circle" width="50" alt="User" />
                            <div class="status user">&nbsp;</div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="account.php?u=<?php echo $_SESSION["token"]?>">My Account</a></li>
                            <li><a class="dropdown-item" href="login.php?u=<?php echo $_SESSION["token"]?>">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>