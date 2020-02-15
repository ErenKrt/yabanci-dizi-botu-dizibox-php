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
include 'vendor/autoload.php';
include 'class.php';

use \eperen\YabanciDizi;

$yb = new YabanciDizi();
$yb->WithCookie();
//$xd= $yb->DiziSayfasi("The Witcher");
//$xd= $yb->DiziBolumleri("The Witcher");
//$xd= $yb->DiziBolumleri("The 100","2");
//$xd= $yb->Bolum("Mr. Robot","4.Sezon 13.Bölüm",6);
//$xd= $yb->Image("https://www.dizibox.pw/wp-content/uploads/afisler/macgyver-220x140.jpg");
$xd= $yb->YeniEklenen(1);

/// Anasayfadan dizi yakalayıp gösterme BASLANGİC

//$xd= $yb->PopulerSon(1)["Diziler"][2];
//$bolum= explode($yb->ConvertTitle($xd["isim"]),$xd["Title"]);
//$xd= $yb->Bolum($yb->ConvertTitle($xd["isim"]),$bolum[1]);

/// Anasayfadan dizi yakalayıp gösterme BİTİS

//$xd= $yb->Ara("mr robot"); // WithCookie

//$xd=$yb->AutoComplete("mr"); // WithCookie

print_r($xd);