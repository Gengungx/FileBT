<?php

 class Info {
  public $title;
  public $desc;


public function __construct(  $title,$desc) {
  $this->title = $title;
  $this->desc = $desc; 
}

public function HienThi_Info() {
  echo "<div class='GT'>
          <p>{$this->title}</p>
        </div> 
        <p>{$this->desc}</p></div>";
}
}

 class San_Pham {
  public $id;
  public $tensanpham;
  public $gia;
  public $hinhanh;
  public $thongtin;
  public $link;
  
  public function __construct($id, $tensanpham, $gia, $thongtin, $hinhanh,$link) {
    $this->id = $id;
    $this->tensanpham = $tensanpham;
    $this->gia = $gia;
    $this->hinhanh = $hinhanh; 
    $this->thongtin = $thongtin; 
    $this->link = $link;
  }
  
  public function HienThi_SanPham() {
    echo "<div class='khungsp'>
            <img src='{$this->hinhanh}' alt=''>
            <h3>{$this->tensanpham}</h3>
            <p>{$this->thongtin}</p>
            <h2><a href='{$this->link}'>{$this->gia} $ </a></h2>
            
          </div>";
  }
}
$mang_sp = array(
  array(
    'tensp' => 'Street in the rain',
    'gia' => '0.99',
    'hinhanh' => './img/street_in_the_rain_by_fel_x_dcwp9sr-414w-2x.jpg',
    'thongtin' => 'by fel x',
    'link' =>'#'
  ),
  array(
    'tensp' => 'Eclipse',
    'gia' => 'Đấu giá',
    'hinhanh' => './img/eclipse_by_stasyasky_dep2dkg.png',
    'thongtin' => 'by stasyasky',
    'link' =>'#'
  ),
  array(
    'tensp' => 'Under the full moon',
    'gia' => '10.00',
    'hinhanh' => './img/under_the_full_moon_by_aquelion_dc64h88-fullview.jpg',
    'thongtin' => 'by aquelion',
    'link' =>'#'
  )
);

class Dich_vu {
  public $tendichvu;
public $mota;
public $mota2;
public $link;
public $gia;

public function __construct(  $tendichvu,$mota,$mota2,$link,$gia) {
  $this->tendichvu = $tendichvu; 
  $this->mota =$mota;
  $this->mota2 =$mota2;
  $this->link =$link;
  $this->gia =$gia;
}

    public function HienThi_Dichvu() {
      echo "<div class='khungdichvu'>
      
      <h1><a href='{$this->link}'>{$this->tendichvu}</a></h1>
      <p>-{$this->mota}</p>
      <p>-{$this->mota2}</p>
      <h2>{$this->gia} $</h2>
    </div>";
    }
    }
    $mang_dichvu = array(
      array(
          'tendichvu' => 'THIẾT KẾ NHANH',
          'mota' => 'nhanh gọn',
          'mota2' => 'chút tâm huyết',
          'link' => '#',
          'gia' => '5.00'
        ),
        array(
          'tendichvu' => 'THIẾT KẾ CHUẨN',
          'mota' => 'kĩ càng',
          'mota2' => 'theo chuẩn ý khách hàng',
          'link' => '#',
          'gia' => '20.00'
        ),
        array(
          'tendichvu' => 'THIẾT KẾ CAO CẤP',
          'mota' => 'nào đúng ý khách hàng thì thôi',
          'mota2' => 'ok?',
          'link' => '#',
          'gia' => 'Tuỳ giá'
        ),
        array(
          'tendichvu' => 'THIẾT KẾ NHANH',
          'mota' => 'nhanh gọn',
          'mota2' => 'chút tâm huyết',
          'link' => '#',
          'gia' => '5.00'
        ),
        array(
          'tendichvu' => 'THIẾT KẾ CHUẨN',
          'mota' => 'kĩ càng',
          'mota2' => 'theo chuẩn ý khách hàng',
          'link' => '#',
          'gia' => '20.00'
        ),
        array(
          'tendichvu' => 'THIẾT KẾ CAO CẤP',
          'mota' => 'nào đúng ý khách hàng thì thôi',
          'mota2' => 'ok?',
          'link' => '#',
          'gia' => 'Tuỳ giá'
        )

      
      
      );

       // Khai báo Tin Tức
    class Tin_Tuc {
      public $tintuc;
    public $hinhanh;
    public $thongtin;
    public $link;
    
    public function __construct(  $hinhanh, $thongtin,$tintuc,$link) {
      $this->hinhanh = $hinhanh;
      $this->thongtin = $thongtin; 
      $this->tintuc =$tintuc;
      $this->link = $link;
    }
    
    public function HienThi_TinTuc() {
      echo "<div class='khungtintuc'>
      <img src='{$this->hinhanh}' alt=''>
      <h2><a href='{$this->link}'>{$this->tintuc}</a></h2>
      <p>{$this->thongtin}</p>
    </div>";
    }
  }
  $mangTin_Tuc = array(
      array(
          'hinhanh' => './img/beautiful_succulent_vases_by_digitalrevvi_dg2j5qy-375w-2x.jpg',
          'tintuc' => 'Bức tranh được đấu giá cao nhất',
          'thongtin' => 'Tháng nay bức tranh của digitalrevvi được đấu giá với 3000$',
          'link' => '#'
        ),
      array(
        'tintuc' => 'Bức tranh được yêu thích nhất',
        'hinhanh' => './img/new_morning_by_digitalrevvi_dg34d5k-375w-2x.jpg',
        'thongtin' => 'Bức tranh new morning đã được 3000 tym',
        'link' => '#'
      ),
      array(
        'tintuc' => 'Bức tranh được mua nhiều nhất',
        'hinhanh' => './img/rain_in_the_city_by_alexandreev_d8ire5f-375w-2x.jpg',
        'thongtin' => 'Gần hơn 3000 khách hàng mua',
        'link' => '#'
      )
      
      );
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>LT</title>
</head>
<body>
   <!-- phần menutop -->
   <div id="main-menu"> 
                      <?php
                      include_once('control/menu.php')
                      ?>
                </div> 

                    
 


          <div class="sanpham">
          
          <?php
        // Hiển thị sản phẩm
        foreach ($mang_sp as $item) {
        $San_Pham = new San_Pham('', $item['tensp'],$item['gia'],$item['thongtin'], $item['hinhanh'],$item['link']);
        $San_Pham->HienThi_SanPham();
        }
        ?>     
  </div>   
                         <hr></hr>
                         
                         <?php
                                $tit="Dịch vụ";
                                $des="";
                                $info=new Info($tit,$des);
                                 $info->HienThi_Info();
                                 ?>
                                 <hr></hr>
              <div class="khungdv">
              
        <?php
        
        
                    // Hiển thị dich vu
                    foreach ($mang_dichvu as $item) {
                        $Dich_vu = new Dich_vu( $item['tendichvu'],$item['mota'],$item['mota2'],$item['link'],$item['gia']);
                        $Dich_vu->HienThi_Dichvu();
                    }
                ?>         
                </div>  
                            
                            <div id="khungtintucbentrai">
                            <?php
                                $tit="Tin tức";
                                $info=new Info($tit,$des);
                                 $info->HienThi_Info();
?>
<hr></hr>
                            
                  <?php
                  
                      // Hiển thị tin tuc
                      foreach ($mangTin_Tuc as $item) {
                          $Tin_Tuc = new Tin_Tuc( $item['hinhanh'],$item['thongtin'],$item['tintuc'],$item['link']);
                          $Tin_Tuc->HienThi_TinTuc();
                      }
                  ?>    
                                       
                         </div>
                
    <!--Phần FOOTER-->
    <div id="footer">
              <?php
              include_once('control/footer.php')
              ?>
                </div>
                <!--END Phần FOOTER-->
    <!-- END khung trang web -->
</body>
</html>