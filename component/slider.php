<?php
include_once ("../entities/slide.class.php");
$slides = Slide::list_slides();
?>

<link rel="stylesheet" href="../css/slider.css">
<div id="carouselExampleControls" class="carousel slide wrapper" data-ride="carousel">
  <div class="carousel-inner" style="border-radius: 10px">
    <?php
    $first = true;
    foreach ($slides as $slide) {
      $activeClass = $first ? 'active' : '';
      echo "<div class='carousel-item $activeClass'>
              <img src='" . $slide["FILE"] . "' class='d-block w-100' alt='Slide Image'>
            </div>";
      $first = false;
    }
    ?>
  </div>
  <button class="carousel-control-prev button" type="button" data-target="#carouselExampleControls"
    data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </button>
  <button class="carousel-control-next button" type="button" data-target="#carouselExampleControls"
    data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </button>
</div>