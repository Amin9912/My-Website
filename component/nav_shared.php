<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Epico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home">Home</a>
                </li>
                <?php 
                if(!empty($user)){ ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="true">Setup</a>
                        <div class="dropdown-menu mt-2" data-bs-popper="static">
                            <?php 
                                if(!empty($user)&&$user->role == 1){
                                    echo '<a class="dropdown-item" href="dashboard-config">Dashboard</a>';
                                }
                            ?>
                            <a class="dropdown-item" href="resume-setup">Resume</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="true">Accessment</a>
                        <div class="dropdown-menu mt-2" data-bs-popper="static">
                            <a class="dropdown-item" href="utm-travel-record">UTM Travel Record</a>
                            <a class="dropdown-item" href="<?php echo GLOB_BASE_URL; ?>fyp" target="blank">FYP project</a>
                            <a class="dropdown-item" href="<?php echo GLOB_BASE_URL; ?>wad-final-project/login.php"
                                target="blank">WAD
                                project</a>
                            <a class="dropdown-item" href="tic-tac-toe">Tic tac toe</a>
                        </div>
                    </li>

                <?php 
                }
                ?>
            </ul>
            <form class="d-flex">
                <?php if (isset($user->username)) { ?>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Welcome, <?php echo $user->username; ?></a>
                    </li>
                </ul>
                <a class="btn btn-danger my-2 my-sm-0" href="logout">Logout</a>
                <?php } else { ?>
                <a class="btn btn-info my-2 mr-2 my-sm-0" href="login">Login</a>
                <a class="btn btn-info my-2 my-sm-0" href="register">Register</a>
                <?php } ?>
            </form>
        </div>
    </div>
</nav>