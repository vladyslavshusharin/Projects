<header> 
        <div class="navbar">
            <div class="nav-left">
                <a href="../Main Page/mainpage.php" class="text-color-black no-text-decor"><img src="../WebPics/Logo3.png" style="width: 65px; height: auto;"></a>
            </div>
    
            <div class="nav-middle">
                
                <div class="nav-button">
                <a href="../Hledani Prace/hledat_praci.php" class="box-horizontal text-color-black border-trans" style="height: 100%;"><p class="full-center oswald-Cfont weight-medium">Hledat Práci</p></a>
                </div>
                
                <div class="nav-button">
                <a href="../Hledani Pracovnika/hledat_zamestnance.php" class="box-horizontal text-color-black border-trans" style="height: 100%;"><p class="full-center oswald-Cfont weight-medium">Hledat zaměstnance</p></a>
                </div>
                
                <div class="nav-button">
                <a href="../Hodnoceni Firem/hodnoceni_firem.php" class="box-horizontal text-color-black border-trans" style="height: 100%;"><p class="full-center oswald-Cfont weight-medium">Hodnocení firem</p></a>
                </div>
                
                <div class="nav-button">
                <a href="../Hodnoceni Pracovnika/hodnoceni_zamestnancu.php" class="box-horizontal text-color-black border-trans" style="height: 100%;"><p class="full-center oswald-Cfont weight-medium">Hodnocení zaměstnanců</p></a>
                </div>

                <div class="nav-button">
                <a href="../Statistiky/statistiky.php" class="box-horizontal text-color-black border-trans" style="height: 100%;"><p class="full-center oswald-Cfont weight-medium">Statistiky</p></a>
                </div>
                
                
                
            </div>
    
            <div class="nav-right">
              <form action="../Hledat profily/hledaneprofily.php" class="box-horizontal Hpixelbox-2 Rmargin-0p1 border-trans" method="GET">
                  <input type="text" id="searchtext" name="searchtext" class="bigbox-horizontal bg-color-gray box-rounded border-black" placeholder="Hledat Profily...">
              </form>
             
              <div class="nav-buttons-coupled">
                <?php if(isset($_SESSION['user_id'])): ?>
                 <div class="nav-button">
                 <a style="width: 65px; height: 65px;" href="../Profil/profil.php" class="box-horizontal border-trans">
                  <svg fill="currentColor" class="text-color-black full-center" style="max-width: 35px; max-height: 35px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 96l576 0c0-35.3-28.7-64-64-64L64 32C28.7 32 0 60.7 0 96zm0 32L0 416c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-288L0 128zM64 405.3c0-29.5 23.9-53.3 53.3-53.3l117.3 0c29.5 0 53.3 23.9 53.3 53.3c0 5.9-4.8 10.7-10.7 10.7L74.7 416c-5.9 0-10.7-4.8-10.7-10.7zM176 192a64 64 0 1 1 0 128 64 64 0 1 1 0-128zm176 16c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16z"/></svg>
                 </a>
                 <a style="height: 100%;" href="../Profil/profil.php" class="box-horizontal text-color-black border-trans">
                 <p class="full-center oswald-Cfont weight-medium"><?php echo $_SESSION['usermail'];?></p>
                 </a>
                 </div>
                 <div class="nav-button">
                 <a href="../logout.php" class="text-color-black oswald-Cfont weight-medium Lpadding-0p1 Rpadding-0p1">Odhlásit</a>
                 </div>
                 
                 
                <?php else: ?>
                 <div class="nav-button">
                 <a href="../Vyber Uctu/vyber.php" class="box-horizontal text-color-black border-trans Lpadding-0p1 Rpadding-0p1"><p class="full-center oswald-Cfont weight-medium">Registrovat</p></a>
                 </div>
                 <div class="nav-button">
                 <a href="../Login/login.php" class="box-horizontal text-color-black border-trans Lpadding-0p1 Rpadding-0p1"><p class="full-center oswald-Cfont weight-medium">Přihlásit</p></a>
                 </div>
              
                
                <?php endif; ?>
              </div>  
              
            </div>
        </div>
</header>