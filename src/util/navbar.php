<?php

    function getGuideNavBar(string $relative_path) : string {
        $navbar = '<!-- Beginning of Navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#resNav">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="'.$relative_path.'" class="navbar-brand">Company Logo</a>
            </div>
            <div class="collapse navbar-collapse" id="resNav">
                <ul class="nav navbar-nav navbar-right">
                        <form action="'.$relative_path.'../logout.php">
                                <input type="submit" name="logout" class="btn btn-danger" value="Logout" />
                            </form>
                    </ul>    
    
                <ul class="nav navbar-nav navbar-right">
                    <div>
                        <form action="'.$relative_path.'availabletours" method="post">
                            <input type="submit" name="availabletours" class="btn btn-primary" value="Available Tours" />
                        </form>
                    </div>    
                </ul>
    
                <ul class="nav navbar-nav navbar-right">
                    <div>
                        <form action="'.$relative_path.'profile" method="post">
                             <input type="submit" name="profile" class="btn btn-secondary" value="Profile" />
                        </form>
                    </div>
                </ul>
                
    
            </div>
    
        </nav>
        <!-- End of Navbar -->';
        return $navbar;
    }
?>