<?php
include_once "../models/db_goods.php";

$countView = (int)$_POST['count_add'];  // количество записей, получаемых за один раз
$startIndex = (int)$_POST['count_show']; // с какой записи начать выборку
 

 $goods = goods_all($link, $countView, $startIndex);

 
if(empty($goods)){
    // если новостей нет
    echo json_encode(array(
        'result'    => 'finish'
    ));
}else{
    // если новости получили из базы, то сформируем html элементы
    // и отдадим их клиенту
    $html = "";
    foreach($goods as $good){
        $html .=    '
            <div class="item">
                    <a href="item.php?id='.$good[id].'"><img src="'.$good[small_src].'" alt="'.$good[name].'" title="'.$good[name].'"></a>
                    <h3 class="item-name"><a href="item.php?id='.$good[id].'">'.$good[name].'</a></h3>
                    <p class="price">'.$good[price].'р.</p>
                    <p class="add-to-basket"><a href="#" title="Добавить в корзину">Купить</a></p>
                </div>';
    }
    echo json_encode(array(
        'result'    => 'success',
        'html'      => $html
    ));
}



/*

        $goods = goods_all($link, $countView, $startIndex);
        if($goods){
            foreach ($goods as $good){?>
                <div class="item">
                    <a href="item.php?id=<?=$good[id]?>"><img src="<?=$good[small_src]?>" alt="<?=$good[name]?>" title="<?=$good[name]?>"></a>
                    <h3 class="item-name"><a href="item.php?id=<?=$good[id]?>"><?=$good[name]?></a></h3>
                    <p class="price"><?=$good[price]?>р.</p>
                    <p class="add-to-basket"><a href="#" title="Добавить в корзину">Купить</a></p>
                </div>
            <?}
        }
     ?>