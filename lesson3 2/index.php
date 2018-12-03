<?php

//к сожалению не было возможности воспользоваться git
// подгружаем и активируем авто-загрузчик Twig-а
require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

function create_thumbnail($path, $save, $width, $height) {
$info = getimagesize($path); //получаем размеры картинки и ее тип
$size = array($info[0], $info[1]); //закидываем размеры в массив
//В зависимости от расширения картинки вызываем соответствующую функцию
if ($info['mime'] == 'image/png') {
$src = imagecreatefrompng($path); //создаём новое изображение из файла
} else if ($info['mime'] == 'image/jpeg') {
$src = imagecreatefromjpeg($path);
} else if ($info['mime'] == 'image/gif') {
$src = imagecreatefromgif($path);
} else {
return false;
}
$thumb = imagecreatetruecolor($width, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера
$src_aspect = $size[0] / $size[1]; //отношение ширины к высоте исходника
$thumb_aspect = $width / $height; //отношение ширины к высоте аватарки
if($src_aspect < $thumb_aspect) { //узкий вариант (фиксированная ширина) $scale = $width / $size[0]; $new_size = array($width, $width / $src_aspect); $src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2); //Ищем расстояние по высоте от края картинки до начала картины после обрезки } else if ($src_aspect > $thumb_aspect) {
//широкий вариант (фиксированная высота)
$scale = $height / $size[1];
$new_size = array($height * $src_aspect, $height);
$src_pos = array(($size[0] * $scale - $width) / $scale / 2, 0); //Ищем расстояние по ширине от края картинки до начала картины после обрезки
} else {
//другое
$new_size = array($width, $height);
$src_pos = array(0,0);
}
$new_size[0] = max($new_size[0], 1);
$new_size[1] = max($new_size[1], 1);

imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);
//Копирование и изменение размера изображения с ресемплированием

if($save === false) {
echo "<hr>выводим изображение<hr>";
return imagepng($thumb); //Выводит JPEG/PNG/GIF изображение
} else {
//echo "<hr>сохраняем изображение<hr>";
//return imagepng($thumb , $save);//Сохраняет JPEG/PNG/GIF изображение
return imagejpeg($thumb , $save);
}
}



  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader);
  $template = $twig->loadTemplate('gallery.tmpl');
  $content = $template->render(array());
    

  echo $content;



//действия при загрузке файла
if(isset($_REQUEST['submit'])){
$path = "images/".$_FILES[photo][name];
if(copy($_FILES[photo][tmp_name],$path)){
  echo "Файл успешно загружен!<br>";
}
else{
  die("Ошибка загрузки файла!");  
  }
}

  $dir = 'images/'; // Путь к папке с изображениями
  $m_dir = 'm_images/'; // Путь к папке с миниатюрами
  $files = scandir($dir); // Берём всё содержимое директории
  $width = 200; //желаемые размеры миниатюр
  $height = 200;

  // Перебираем все файлы
  for ($i = 0; $i < count($files); $i++) {
    if (($files[$i] != ".") && ($files[$i] != "..")) { // Текущий каталог и родительский пропускаем
      $path = $dir.$files[$i]; // Получаем путь к картинке
      
      // делаем миниатюрю изображений используя ползовательскую функцию  
      $save = $m_dir.$files[$i];
        
        
        create_thumbnail($path, $save, $width, $height);
        $template2 = $twig->loadTemplate('gallery_all.tmpl');
        $content2 = $template2->render(array(
        'path' => $path,
        'save' => $save,
        ));
        echo $content2;

    }
      
  }
?>