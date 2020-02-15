<?php
//    ________                          ___  ____         _
//   |_   __  |                        |_  ||_  _|       / |_
//   | |_ \_| _ .--.  .---.  _ .--.    | |_/ /    _ .--.`| |-'
//   |  _| _ [ `/'`\]/ /__\\[ `.-. |   |  __'.   [ `/'`\]| |
//  _| |__/ | | |    | \__., | | | |  _| |  \ \_  | |    | |,
// |________|[___]    '.__.'[___||__]|____||____|[___]   \__/
/**
 * Class Yabancı Dizi Bot PHP / Class
 * @author Eren Kurt (ErenKrt)
 * @mail kurteren07@gmail.com
 * @İnstagram Ep.Eren
 * @date 28.12.2019
 */

include 'theme/header.php'; ?>

<?php 
include '../class.php'; 
use \eperen\YabanciDizi;
$yb = new YabanciDizi();


$sayfa=1;
if(isset($_GET["sayfa"]) && $_GET["sayfa"]!="" && ctype_digit($_GET["sayfa"])){
    $sayfa= $_GET["sayfa"];
}


$anasayfa= $yb->PopulerSon($sayfa); 

?>


<div class="container">
        <div class="row">
            
            
            
            <?php 
            for ($i=0; $i <count($anasayfa["Diziler"]) ; $i++) { 
                $Sdizi= $anasayfa["Diziler"][$i];

                ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                <div class="card">
                <a href="izle.php?dizi=<?php echo urlencode($Sdizi["Title"]); ?>&isim=<?php echo urlencode($yb->ConvertTitle($Sdizi["isim"])); ?>"><img class="card-img-top" src="data:image/png;base64,<?php echo $Sdizi["img"]; ?>"></a>
                    <div class="card-block">
                         <figure class="profile profile-inline">
                            <img src="<?php echo $Sdizi["ceviri"]; ?>" class="profile-avatar" alt="">
                        </figure>
                        <h4 class="card-title mt-3"><?php echo $Sdizi["Title"]; ?></h4>
                        <div class="card-text">
                        <?php echo $Sdizi["Sezon"]." => ".$Sdizi["Bolum"]; ?>;
                        </div>
                    </div>
                    <div class="card-footer">
                        <small><?php echo $Sdizi["YayinGun"]; ?></small>
                        <a href="izle.php?dizi=<?php echo urlencode($Sdizi["Title"]); ?>&isim=<?php echo urlencode($yb->ConvertTitle($Sdizi["isim"])); ?>"><button class="btn btn-secondary float-right btn-sm">İzle</button></a>
                    </div>
                </div>
            </div>
                <?php
            }
            ?>
    
        </div>
        <br><br>
        <div class="row " >
        <nav>
            <ul class="pagination">
                <?php 
                for ($i=1; $i <$anasayfa["pagination"]["maks"] ; $i++) {
                    if($i<=20){
                    ?>
                    <li class="page-item <?php if($i==$anasayfa["pagination"]["bulunan"]){ echo "active"; } ?>"><a class="page-link" href="?sayfa=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php
                    }else{
                        echo "Toplam: ".$anasayfa["pagination"]["maks"]." (Devamı tema bozulamsın diye gösterilmiyor)";
                     break;
                    }
                }
                ?>
            </ul>
            </nav>
        </div>
</div>

<?php include 'theme/footer.php'; ?>