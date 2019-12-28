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
include 'theme/header.php'; 

function strposa($haystack, $needles=array(), $offset=0) {
    $chr = array();
    foreach($needles as $needle) {
            $res = strpos($haystack, $needle, $offset);
            if ($res !== false) $chr[$needle] = $res;
    }
    if(empty($chr)) return false;
    return min($chr);
}
?>

<?php 
include '../class.php'; 
use \eperen\YabanciDizi;
$yb = new YabanciDizi();


$sayfa=1;
if(isset($_GET["dizi"]) && $_GET["dizi"]!="" && isset($_GET["isim"]) && $_GET["isim"]!=""){
    
    $player=1;
    if(isset($_GET["player"]) && $_GET["player"]!="" && ctype_digit($_GET["player"])){
        $player= $_GET["player"];
    }
    
    $bol= explode($yb->ConvertTitle(urldecode($_GET["isim"])),$yb->ConvertTitle(urldecode($_GET["dizi"])));
    
    $bolum= $yb->Bolum($yb->ConvertTitle(urldecode($_GET["isim"])),$bol[1],$player);
    
    ?>
    <div class="container">
    <div class="space-medium">
        <div class="container">
            <div class="row">
                <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12 text-center">
                    <!-- section-title -->
                    <div class="section-title">
                       <p><?php echo $bolum["dizi"]." => ".$bolum["bolum"]; ?></p>
                    </div>
                </div>
                <!-- /.section-title -->
            </div>
           
                
                <!-- video-testimonail -->
                <div class="col-md-12">
                <nav>
                     <ul class="pagination">
                     <?php
                    for ($i=0; $i <count($bolum["playerlar"]) ; $i++) {
                        $splayer= $bolum["playerlar"][$i];
                    ?>
                    <li class="page-item <?php if($bolum["cplayer"]==$splayer["id"]){ echo "active"; } ?>"><a class="page-link" href="?dizi=<?php echo urlencode(urldecode($_GET["dizi"])); ?>&isim=<?php echo urlencode(urldecode(trim($_GET["isim"]))); ?>&player=<?php echo $splayer["id"]; ?>"><?php echo $splayer["isim"]; ?></a></li>
                    <?php
                     }
                     ?>
                     </ul>
                </nav>
                    <div class="video-testimonial-block">
                       
                        <div class="video">
                            <?php
                            if(strposa($bolum["icerik"],array("embed","drive.google.com"))){
                                ?>
                                <iframe src="<?php echo $bolum["icerik"]; ?>" allowfullscreen></iframe>
                                <?php
                            }else if(strpos($bolum["icerik"],".mp4")){
                                ?>
                                
                                    

                                    <video id="player" controls>
                                        <source src="<?php echo $bolum["icerik"]; ?>" type="video/mp4" />
                                    </video>
                                    
                                <?php
                            }
                            ?>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div> 
</div>

<?php include 'theme/footer.php'; ?>

    <?php
}else{
    echo "missing ?dizi";
    exit;
}

?>



