<div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="logo-area">
                    <img src="img/logo/logo.png" alt="">
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="header-top-menu">
                    <ul class="nav navbar-nav notika-top-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                                class="nav-link dropdown-toggle"><span><i
                                        class="notika-icon notika-search"></i></span></a>
                            <div role="menu" class="dropdown-menu search-dd animated flipInX">
                                <div class="search-input">
                                    <i class="notika-icon notika-left-arrow"></i>
                                    <input type="text" />
                                </div>
                            </div>
                        </li>

                        <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                                class="nav-link dropdown-toggle"><span><i class="notika-icon notika-menus"></i></span>
                                <div class="spinner4 spinner-4"></div>
                                <div class="ntd-ctn"><span>2</span></div>
                            </a>
                            <div role="menu" class="dropdown-menu message-dd task-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2></h2>
                                </div>
                                <?php
                                if (isset($_SESSION['alumni'])) {
                                    echo '
                                    <div class="hd-message-info hd-task-info">
                                    <img src="../homepage/img/team-2.jpg" class="profile" alt="Profile Picture">
                                    <div class="profile_details">
                                        <span>' . $alumni['firstname'] . ' ' . $alumni['middlename'] . ' ' . $alumni['lastname'] . '</span>
                                        <span class="mgs-time">2 min ago</span>
                                    </div>
                                   
                                </div>
                                     <div class="button_container"> <a class="btn" id="log">Logout</button></a>
                                    ';
                                }
                                ?>
                                


                            </div>
                        </li>


                    </ul>


                </div>
            </div>
        </div>
    </div>
</div>
