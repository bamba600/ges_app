<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/style7.css">
    <link rel="stylesheet" href="/assets/css/style5.css">


    <title>Document</title>
</head>
<body>
    <div class="cont">
        <div class="conta">
            <div class="conta1">
                    <img src="/assets/images/son.png" alt="" srcset="">
                    <div class="promo">Promotion - 2025</div>
                    <div class="t"></div>
           </div> 
           <div class="conta2"> 
                    <a href="index.php?page=tab"><div class="tab"><span><img src="/assets/images/tab.png" alt="" srcset=""></span><span>Tableau de bord</span></div></a>
                    <a href="index.php?page=prom"><div class="tab"><span><img  class="im1" src="/assets/images/prom5.svg" alt="" srcset=""></span><span>Promotions</span></div></a>
                    <a href="index.php?page=ref"><div class="ref"><span><img src="/assets/images/ref.png" alt="" srcset=""></span><span>Référentiels</span></div></a>
                    <a href="index.php?page=appr"><div class="tab"><span><img src="/assets/images/ap.png" alt="" srcset=""></span><span>Aprenants</span></div></a>
                    <a href=""><div class="tab"><span><img src="/assets/images/ges.png" alt="" srcset=""></span><span>Gestion des présences</span></div></a>
                    <a href=""><div class="tab"><span><img src="/assets/images/kit.png" alt="" srcset=""></span><span>Kits et laptops</span></div></a>
                    <a href=""><div class="tab"><span><img src="/assets/images/rap.png" alt="" srcset=""></span><span>Rapports & Stats</span></div></a>
          </div>
         <div class="conta3">
            <div class="t2"></div>
            <a href="page=deconnexion"><div class="dec"><span><img src="/assets/images/dec.svg" alt="" srcset=""></span><span>Déconnexion</span></div></a>
         </div>       
                   
           
             
        </div>
        <div  class="contb">
            <img class="s" src="/assets/images/search.svg" alt="" srcset="">
            <div class="contb1"><input type="text" name=""  placeholder="            Rechercher...." id="">
                <div class="c">
                    <div><img class="notif"  src="/assets/images/notif.svg" alt="" srcset=""></div>
                    <div class="c1">
                        <div class="ca">A</div>
                        <div class="c2">
                            <div>admin@sonatel-academy.sn</div>
                            <div>Administrateur</div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div  class="contb2">
                  <?=$contenu?>
            </div>
        </div>
    </div>
</body>
</html>