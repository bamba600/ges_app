<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style2.css">
    <title>Document</title>
</head>
<body>
    <div class="son">
        <div>
            <img src="/assets/images/son.png" alt="" srcset="">
        </div>
        <div class="text">
            <div>Bienvenue sur</div>
            <div class="text1">Ecole du code Sonatel Academy</div>
        </div>
        <div class="tcon">Se connecter</div>
        <div class="form">
                 <form action="index.php?page=login" method="post">
                    <div class="in">
                        <label for="login">login</label>
                        <input type="text" id="login"  name="login" placeholder="     Matricule ou email" >
                    </div>
                     <div class="in">
                         <label for="password">Mot de passe</label>
                         <input type="text" id="password"  name="password"  placeholder="     Mot de passe">
                     </div> 
                     <div>
                          <button type="submit" name="submit">Se connecter</button>
                     </div>  
                 </form>
        </div>
    </div>
    <a href="index.php?page=mdp_oublie" class="forg">Mot de passe oublié ?</a>
</body>
</html>