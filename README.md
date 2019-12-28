# Yabancı Dizi Botu / Dizibox Botu / Dizibox Dizi Botu | PHP

Botun çalışma prensibi bir kullanıcı gibi  **dizibox.pw** adresine girerek **HtmlParser** mantığında alanları (**div**/**section**/**vb..**) parçalıyor ve size **array** olarak döndürüyor

---
- [Bilgilendirme](#bilgilendirme)
- [Kurulum](#kurulum)
---

# Bilgilendirme
> php >= 5.X
# Kurulum
Composer;
```
   composer install
```
   > spatie/regex [https://github.com/spatie/regex]
   php-curl-class/php-curl-class [https://github.com/php-curl-class/php-curl-class]
   campo/random-user-agent[https://github.com/joecampo/random-user-agent]
   ---

Php;
```php
   require 'class.php';
```

## Kod Kullanımları
```php
   $yb = new YabanciDizi();
   $yb->ConvertTitle("dizi ismi"); // Args: Array dönütü olan titleleri baş harfaları büyük olmak üzere değiştirir.
   $yb->DiziSayfasi("The Witcher"); // Args: Dizi Adı
   $yb->DiziBolumleri("The Witcher"); // Args: Dizi Adı
   $yb->DiziBolumleri("The 100","2"); // Args: Dizi Adı , Sayfa
   $yb->Bolum("Mr. Robot","4.Sezon 13.Bölüm",6); // Args: Dizi Adı, Sezon bölüm, Player[boş olabilir]
   $yb->PopulerSon(2); // Args: Sayfa
   $yb->YeniEklenen(1); // Args: Sayfa

  // Cookie komutlar
   $yb->WithCookie(); // Cookieler dahil edilir
   $yb->Ara("mr robot");
   $yb->AutoComplete("mr");
```

## Kod Örneği

Ana sayfadan dizi çekip player ile gösterme.
```php
$xd= $yb->PopulerSon(1)["Diziler"][2];
$bolum= explode($yb->ConvertTitle($xd["isim"]),$xd["Title"]);
$xd= $yb->Bolum($yb->ConvertTitle($xd["isim"]),$bolum[1]);
```
Popüler dizileri çekme
```php
$xd= $yb->PopulerSon(2); // 2.sayfa
print_r(json_encode($xd));
```

```json

{"Diziler":[{ //Dizi tekil dönüt
"Title":"The Flash 6.Sezon 8.B\u00f6l\u00fcm",
"isim":"THE FLASH",
"Sezon":"6.SEZON ",
"Bolum":"8.B\u00d6L\u00dcM",
"YayinGun":"04 Ara",
"ceviri":"https:\/\/www.dizibox.pw\/altyazi.png",
"img":"https:\/\/www.dizibox.pw\/wp-content\/uploads\/afisler\/the-flash-220x140.jpg"}
],
"pagination":{"bulunan":"2","maks":"97"}} // Sayfalama sistemi için ek dönüt
```

Kullanım detayları için [Ornekler](https://github.com/ErenKrt/yabanci-dizi-botu-dizibox-php/ornekler) sayfasına bakabilirsiniz.

---
Geliştirci: &copy; [ErenKrt](https://www.instagram.com/ep.eren/)
