<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/chat/home">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
            <?php
            if($this->isLogin())
            { ?>
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <?= $this->getName() ?>
                </a>
                <?php 
                if($this->isAdmin())
                { ?>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/chat/privileges">privileges</a></li>
                    <li><a class="dropdown-item" href="/chat/usersgroups">Users Groups</a></li>
                    <li><a class="dropdown-item" href="/chat/users">Users</a></li>
                    <li><a class="dropdown-item" href="/chat/profile">profile</a></li><li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/chat/logout">log out</a></li>                    
                    <?php  
                } 
                else 
                {   ?>
                     <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <li><a class="dropdown-item" href="/chat/profile">profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/chat/logout">log out</a></li>
                    <?php 
                }
            } else
            {
                   ?>  <li><a class="dropdown-item" href="/chat/login">log in | register</a></li>                    
                  <?php  
            }
            ?>
          </ul>
        </li>
      </ul>
      <div>
          <a href="/chat/changelang" style="color: #ccc ; text-decoration: none"><i class="fas fa-globe lang"></i><?= " ".$lang?></a>
      </div>
    </div>
  </div>
</nav>