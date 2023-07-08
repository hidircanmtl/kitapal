## kitapal

## İçerikler

*   Proje Açıklaması
*   Kullanım
    *   Kullanıcı Kayıt
    *   Ürünleri Sepete Ekleme
    *   Kampanya Seçimi
    *   Sipariş Verme
*   Admin Paneli
    *   Giriş
    *   Kullanıcılar
    *   Ürünler
    *   Siparişler
*   Kurulum
*   Katılım
*   Lisans

## Proje Açıklaması

Bu proje, kullanıcıların ürünleri sepete ekleyebileceği ve sipariş verebileceği gerekli kampanyaların otomatik uygulanacağı bir uygulamayı içerir. Aynı zamanda, bir admin paneli üzerinden kullanıcıları, ürünleri ve siparişleri yönetebilirsiniz.

## Kullanım

Projeyi kullanmak için aşağıdaki adımları takip edin:

1\. Kullanıcı Kayıt

*   login.php sayfasına giderek giriş yapabilir veya bir girişiniz yok ise register.php veya login.php alt kısmında bulunan kayıt ol kısmından kayıt olabilirsiniz.
*   Kayıt olduktan sonra tekrardan login.php ile giriş yapabilirsiniz

2\. Ürünleri Sepete Ekleme

*   Giriş yaptığınızda karşınıza ürünler çıkacak ve navbar kısmında ise profiliniz ve sepetinizin ikonları mevcut olacaktır
*   Ana sayfadaki ürünlerin sağ alt kısmındaki sepet ikonuna basarak sepete ekleme işlemi gerçekleştirebilirsiniz.

3\. Kampanya Seçimi

*   Sepete eklediğiniz ürünlerden yola çıkılarak var olan kampanyalara uygun olarak kullanıcı lehine olan kampanya otomatik seçilir.
*   Bu kampanyayı bir defa kullanma hakkınız var.
*   Kampanyalarınızı ve kullanıp kullanmadığınızı profil ikonuna basarak, sol sekmedeki kampanyalarım kısmından görüntüleyebilirsiniz.

Sipariş Verme

*   Otomatik olarak seçili kampanya ile siparişiniz sipariş et butonuna bastığınızda oluşacaktır.
*   Eğer kampanyanız yok ise herhangi bir kampanyanız bulunamamaktadır yazısı çıkacaktır.
*   Siparişi verdikten sonra siparişlerinizin olduğu sayfaya yönlendirilecek olup bu kısımdan siparişlerinizi görüntüleyebilir ve siparişinizin ayrıntılarını inceleyebilirsiniz.
*   Vermiş olduğunuz siparişin indirimsiz halini üstü çizili bir şekilde görebilirsiniz.
*   Sipariş verdiğiniz and o ürünün stok adedinde düşüş yaşanacaktır.

## Adminpanel

1\. Giriş

*   Adminpanel kısmına erişebilmeniz için login.php sayfasından kullanıcı adı yazan yere 'admin@kitapal', şifre yazan yere ise 'Kitapal99..' yazarak admin sayfasına erişebilirsiniz.
*   Burada üç kısım sizi karşılayacak olup bunlar sırasıyla ürünler, siparişler, kullanıcılar bölümleridir.

2\. Kullanıcılar

*   Kullanıcılar bölümünde kayıt plan kullanıcıları id, isim, telefon ve e-posta adreslerini görebiliyoruz.
*   Bu kısımdan İstediğimiz kullanıcıların kaydını sistemden silebiliriz.

3\. Ürünler

*   Bu sekmeden ürün ekleme işlemini `.json` uzantılı dosya ile yapabilirsiniz. 
*   Dikkat edilmesi gereken husus `.json` dosyasındaki verilerin şu anda sistemde bulunan format göre yapılmış olmasıdır.
*   Eğer eklenen ürünlerin id numaralarında çakışma durum olursa o ürünün eklemesi yapılmayacaktır.
*   Eklenen ürünlerin listesi bu sayfada listelenir ve istediğiniz zama ürünün slime işlemini yapabilirsiniz.

4\. Siparişler

*   Verilen siparişleri bu sekmeden görebilirsiniz.
*   Siparişlerin indirimli-indirimsiz fiyatlarını, kullandığı kampanya ve sipariş numarasını görebilirsiniz.
*   Siparişlerin detayını görmek isterseniz ‘siparişe git’ butonuna basarak siparişte bulunan ürünleri ve kaç adet alındığını görüntüleyebilirsiniz.

## Kurulum

*   Dosyaları bird hosting veya local sunucu yardımı ile (wampp, xampp) dizininize ekleyin.
*   Mysql veritabanına giriniz ve dosyalarda bulunan kitapal.sql dosyasını içe aktarma seçeneği ile içe aktarınız.
*   adminpanel/utilities/connect.php dosyasında bulunan veritabanı ismini, şifresini kendi kaydetmiş olduğunuz ishim lie değiştiriniz.

## Lisans

  
Yukarıdaki örnekte, projenin kullanımını, adımları, admin panelini ve kurulumu daha ayrıntılı bir şekilde açıkladım. Bu açıklamaları kendi projenize göre güncelleyebilir ve uygun şekilde düzenleyebilirsiniz.
