<header>
    <embed class="logoheader" src=" {{ asset ('img/Squadza.svg') }} "/>
    <input class="searchheader" name="search" placeholder="Search player or guild..." >
    <div class="buttons-space-header">

        <!-- Icons made by Freepik from https://www.flaticon.com/ -->
        <div class="media-header"> 
            <a href="#"> <img class="media-icon"    src=" {{ asset ('img/media/discord.png') }} " /> </a>
            <a href="#"> <img class="media-icon"    src=" {{ asset ('img/media/twitter.png') }} " /> </a>
            <a href="#"> <img class="media-icon"    src=" {{ asset ('img/media/facebook.png') }} " /> </a>
            <a href="#"> <img class="media-icon"    src=" {{ asset ('img/interface/notification.png') }} " /> </a>
            <img class="media-icon" id="icon-menu"  src=" {{ asset ('img/interface/menu.png') }} " />
        </div>
        
        <a class="button-header-a" href="register"> <div class="button-header"> SIGN UP </div> </a>
        <a class="button-header-a" href="login">    <div class="button-header"> LOGI IN </div> </a>

<!--
        <div class="profile-header">
            <img class="header-profile-avatar" src=" {{ asset ('uploads/avatars/default.png') }} ">
            
            <ol class="menu-ol menu-ol-header">
                <li>
                    <span class="menu-li"> Username ▼</span></a>
                    <ul>
                        <li><a href="profile">Profile</a></li>
                        <li><a href="logout">Logout</a></li>
                    </ul>
                </li>
            </ol>

            </a>
        </div>
-->
    </div>
</header>