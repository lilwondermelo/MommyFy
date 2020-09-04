<?php

Class Articles {

// Вывод субменю (т.е. подменю по одному из главных разделов) -(сейчас поа только по новостям, по логике его надо модернизировать подл все разделы )
    function getAboutSubmenu($groupId = '') {
        require_once '_dataSource.class.php';
        $data = new DataSource('select id, name from dir_category');
        $data->getData();
        $html = '<div class="page aboutMenu aboutSubmenu">'
                . '<ul class="aboutMenuList aboutSubmenuList">'
                . '<li class="newsCategoryMenu aboutSubmenuListItem aboutMenuListItem ' . ($groupId=='' ? 'aboutMenuListItemActive' : '') .
                ' " onclick="return location.href=\'index.php?page=news\'" data-page="articles" data-id="">Последние</li>';
        for ($i = 0; $i < $data->getRowsCount(); $i++) {
            $html .= '<li class="newsCategoryMenu aboutMenuListItem aboutSubmenuListItem ' . ($data->getValue('id', $i) == $groupId ? 'aboutMenuListItemActive' : '') . '" onclick="return location.href=\'?page=news&cat=' . $data->getValue('id', $i) . '\'" data-page="articles" data-id="' . $data->getValue('id', $i) . '" >' . $data->getValue('name', $i) . '</li>';
        }
        $html .= '</ul> </div>';
        return $html;
    }

//ФУНКЦИИ ОТОБРАЖЕНИЯ БЛОКОВ

    function getMainHalfBlock($group) {
        require_once '_dataSource.class.php';
        $data = new DataSource('select g.id as groupId, a.article_date as articleDate, a.name as articleName, a.header, a.def_image as defImage, a.uid, g.name as groupName from articles a join articles_group g where a.group_id = g.id and g.id = ' . $group . ' order by article_date desc limit 3');
        $data->getData();

        $html = '';
        $html = $html . '<div class="column column_1_2">
            <h4 class="box_header">' . $data->getValue('groupName', 0) . '</h4>
            <ul class="blog">';


        $html = $html . $this->getMainArticle($data->getValue('groupId', 0), $data->getValue('articleName', 0), $data->getValue('header', 0), $data->getValue('groupName', 0), $data->getValue('uid', 0), $data->getValue('defImage', 0), $data->getValue('articleDate', 0))
                . '</ul>

<ul class="blog small clearfix">';

        for ($i = 0; $i < 2; $i++) {

            if ($data->getRowsCount() < $i + 1) {
                break;
            } else {
                $html = $html . $this->getSmallArticle($data->getValue('groupId', $i), $data->getValue('articleName', $i), $data->getValue('groupName', $i), $data->getValue('uid', $i), $data->getValue('defImage', $i), $data->getValue('articleDate', $i));
            }
        }

        $html = $html . '</ul>

<a class="more page_margin_top" href="#">Читать еще</a>
</div>';
        return $html;
    }

    function getMainStandartBlock($group) {

        require_once '_dataSource.class.php';
        $data = new DataSource('select g.id as groupId, a.article_date as articleDate, a.name as articleName, a.header, a.def_image as defImage, a.uid, g.name as groupName from articles a join articles_group g where a.group_id = g.id ' . (($group == '') ? '' : 'and g.id = ' . $group) . ' order by article_date desc limit 5');
        $data->getData();

        $html = '<div class="row ' . (($group == '') ? 'page_margin_top_section' : '') . '">
<h4 class="box_header">' . $data->getValue('groupName', 0) . '</h4>

<div class="row">
<ul class="blog column column_1_2">';



        $monthNum = date('m', strtotime($data->getValue('articleDate', 0)));

        $html = $html . $this->getMainArticle($data->getValue('groupId', 0), $data->getValue('articleName', 0), $data->getValue('header', 0), $data->getValue('groupName', 0), $data->getValue('uid', 0), $data->getValue('defImage', 0), $data->getValue('articleDate', 0));

        $html = $html . '</ul>
<div class="column column_1_2">
<ul class="blog small clearfix">';
        for ($i = 1; $i < $data->getRowsCount(); $i++) {
            $html = $html . $this->getSmallArticle($data->getValue('groupId', $i), $data->getValue('articleName', $i), $data->getValue('groupName', $i), $data->getValue('uid', $i), $data->getValue('defImage', $i), $data->getValue('articleDate', $i));
        }

        $html = $html . '</ul><a class="more page_margin_top" href="#">ЧИТАТЬ ДАЛЕЕ</a> </div></div></div>';
        return $html;
    }

    function getPreviousCarousel() {
        $html = $html . '<div class="row page_margin_top_section">
<h4 class="box_header">Предыдущие</h4>

<div class="horizontal_carousel_container page_margin_top">
<ul class="blog horizontal_carousel autoplay-1 scroll-1 navigation-1 easing-easeInOutQuint duration-750">';


        require_once '_dataSource.class.php';
        $data = new DataSource('select g.id as groupId, a.article_date as articleDate, a.name as articleName, a.header, a.def_image as defImage, a.uid, g.name as groupName from articles a join articles_group g where a.group_id = g.id order by article_date desc limit 15');
        $data->getData();
        for ($i = 0; $i < $data->getRowsCount(); $i++) {
            $monthNum = date('m', strtotime($data->getValue('articleDate', $i)));
            $html = $html . '
    <li class="post"> 
      <a href="post.php" title=""> 
        <img src="images/articles/' . $data->getValue('uid', $i) . '/' . $data->getValue('defImage', $i) . '" alt="img"> 
      </a>
      <h5>
        <a href="post.php" title="' . $data->getValue('articleName', $i) . '">"' . $data->getValue('articleName', $i) . '</a>
      </h5>
      <ul class="post_details simple">
        <li class="category"><a href="index.php?group=' . $data->getValue('groupId', $i) . '" title="">' . $data->getValue('groupName', $i) . '</a></li>
        <li class="date">' . date('j ' . $this->getMonth($monthNum) . ' Y', strtotime($data->getValue('articleDate', $i))) . '</li>
      </ul>
    </li>';
        }
        $html = $html . '
</ul>

</div></div>';
        return $html;
    }

    function getMainBigBlock() {
        $html = '
<h4 class="box_header">Новые</h4>
<div class="row">
<ul class="blog column column_1_2">';

        require_once '_dataSource.class.php';
        $data = new DataSource('select g.id as groupId, a.article_date as articleDate, a.name as articleName, a.header, a.def_image as defImage, a.uid, g.name as groupName from articles a join articles_group g where a.group_id = g.id and g.id != 2 and g.id != 3 order by article_date desc limit 4');
        $data->getData();
        for ($i = 0; $i < $data->getRowsCount(); $i++) {
            if ($i % 2 == 0) {

                $html = $html . $this->getMainArticle($data->getValue('groupId', $i), $data->getValue('articleName', $i), $data->getValue('header', $i), $data->getValue('groupName', $i), $data->getValue('uid', $i), $data->getValue('defImage', $i), $data->getValue('articleDate', $i));
            }
        }

        $html = $html . '</ul>
<ul class="blog column column_1_2">';

        for ($i = 0; $i < $data->getRowsCount(); $i++) {
            if ($i % 2 == 1) {
                $monthNum = date('m', strtotime($data->getValue('articleDate', $i)));
                $html = $html . $this->getMainArticle($data->getValue('groupId', $i), $data->getValue('articleName', $i), $data->getValue('header', $i), $data->getValue('groupName', $i), $data->getValue('uid', $i), $data->getValue('defImage', $i), $data->getValue('articleDate', $i));
            }
        }
        $html = $html . '</ul></div>';
        return $html;
    }

    function getMainSlider() {
        $html = '<div class="caroufredsel_wrapper caroufredsel_wrapper_slider">
<ul class="slider">';

        require_once '_dataSource.class.php';
        $data = new DataSource('select g.id as groupId, a.article_date as articleDate, a.id as articleId, a.name as articleName, a.header, a.def_image as defImage, a.uid, g.name as groupName from articles a join articles_group g where a.group_id = g.id and g.id != 2 and g.id != 3 order by article_date desc limit 3');
        $data->getData();
        for ($i = 0; $i < $data->getRowsCount(); $i++) {

            $html = $html . $this->getSlide($data->getValue('articleId', $i), $data->getValue('groupId', $i), $data->getValue('articleName', $i), $data->getValue('header', $i), $data->getValue('groupName', $i), $data->getValue('uid', $i), $data->getValue('defImage', $i), $data->getValue('articleDate', $i));
        }

        $html = $html . '</ul></div>';
        return $html;
    }

    function getAuthorList() {
        $html = '';
        require_once '_dataSource.class.php';
        $data = new DataSource('select au.name, au.uid, count(ar.id) as count from authors au join articles ar where au.id = ar.author group by au.id order by count desc limit 4');
        $data->getData();
        for ($i = 0; $i < $data->getRowsCount(); $i++) {
            $html = $html . $this->getAuthor($data->getValue('name', $i), $data->getValue('uid', $i), $data->getValue('count', $i));
        }
        return $html;
    }

//Блок с подсчетом просмотров (На главной и в post.php)
    function getCountedBlock() {
        $html = '';
        require_once '_dataSource.class.php';
        $data = new DataSource('select g.id as groupId, a.article_date as articleDate, a.name as articleName, a.header, a.def_image as defImage, a.uid, g.name as groupName from articles a join articles_group g where a.group_id = g.id order by article_date limit 3');
        $data->getData();
        for ($i = 0; $i < $data->getRowsCount(); $i++) {

            $html = $html . $this->getCountedArticle($data->getValue('groupId', $i), $data->getValue('articleName', $i), $data->getValue('groupName', $i), $data->getRowsCount() - $i);
        }
        return $html;
    }

    //Слайдер в post.php
    function getPostSlider() {
        $html = '';
        require_once '_dataSource.class.php';
        $data = new DataSource('select g.id as groupId, a.article_date as articleDate, a.name as articleName, a.header, a.def_image as defImage, a.uid, g.name as groupName from articles a join articles_group g where a.group_id = g.id order by article_date desc limit 4');
        $data->getData();

        for ($i = 0; $i < $data->getRowsCount(); $i++) {
            $html = $html . $this->getPostSlide($data->getValue('groupId', $i), $data->getValue('articleName', $i), $data->getValue('groupName', $i), $data->getValue('uid', $i), $data->getValue('defImage', $i), $data->getValue('articleDate', $i));
        }
        return $html;
    }

    //Наполнение статьи в post.php (Изображение, заголовок, текст статьи, блок автора справа)
    function getPostMain($postId) {
        require_once '_dataRowSource.class.php';
        $rowData = new DataRowSource('select au.name as authorName, au.uid as authorUid, a.data as data, a.article_date as articleDate, a.name as articleName, a.header, a.def_image as defImage, a.uid, g.name as groupName from articles a join articles_group g join authors au where a.group_id = g.id and au.id = a.author and a.id = ' . $postId);
        $rowData->getData();

        $html = $rowData->getValue('articleName') .
                '</h1>
                  <ul class="post_details clearfix">
                    <li class="detail category"><a href="index.php?group=' . $rowData->getValue('groupId') . '" title="">' . $rowData->getValue('groupName') .
                '</a></li>
                <li class="detail date">'
                . date('j ' . $this->getMonth($monthNum) . ' Y', strtotime($rowData->getValue('articleDate')))
                . '</li>

          <li class="detail author"><a href="author.html" title="' . $rowData->getValue('authorName') . '">' . $rowData->getValue('authorName') . '</a></li>
                    <li class="detail views">1945 просмотров</li>
                    
                  </ul>
                  <a href="#" class="post_image page_margin_top prettyPhoto" title="Britons are never more comfortable than when talking about the weather.">
                    <img src="images/articles/' . $rowData->getValue('uid') . '/' . $rowData->getValue('defImage') . '" alt="img">
                  </a>
                  <div class="sentence">
                    <span class="text">Britons are never more comfortable than when talking about the weather.</span>
                    <span class="author">John Smith, Flickr</span>
                  </div>
                  <div class="post_content page_margin_top_section clearfix">
                    <div class="content_box">
                      <h3 class="excerpt">' . $rowData->getValue('header') . '</h3>
                      <div class="text">
                        <p>' . $rowData->getValue('data') . '</p>
                        
                      </div>
                    </div>
                    <div class="author_box animated_element">
                      <div class="author">
                        <a title="' . $rowData->getValue('authorName') . '" href="author.html" class="thumb">
                          <img alt="img" src="images/authors/' . $rowData->getValue('authorUid') . '.jpg">
                        </a>
                        <div class="details">
                          <h5><a title="' . $rowData->getValue('authorName') . '" href="author.html">' . $rowData->getValue('authorName') . '</a></h5>
                          <h6>Автор статей</h6>
                          <a href="author.html" class="more highlight margin_top_15">Профиль</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>';

        return $html;
    }

    function getFooterCategories() {
        $html = '<div class="column column_3_4"><ul class="footer_menu">';
        require_once '_dataSource.class.php';
        $data = new DataSource('select * from articles_group');
        $data->getData();
        for ($i = 0; $i < $data->getRowsCount(); $i++) {

            $html = $html . '<li>
    <h4><a href="index.php?group=' . $data->getValue('id', $i) . '" title="' . $data->getValue('name', $i) . '">' . $data->getValue('name', $i) . '</a></h4>

  </li>';
        }
        $html = $html . '</ul></div>';
        return $html;
    }

    function getTradePost($articleName, $uid, $defImage, $articleDate) {
        $monthNum = date('m', strtotime($articleDate));
        return '
  <li class="post"> <a href="post_gallery.html" title="Nuclear Fusion Closer to Becoming a Reality"> <span class="icon small gallery"></span> <img src="images/articles/' . $uid . '/' . $defImage . '" alt="img">  </a>
    <div class="post_content">
    <h5> <a href="post_gallery.html" title="'
                . $articleName
                . '">'
                . $articleName
                . '</a> </h5>

    <ul class="post_details simple">

      <li class="date">'
                . date('j ' . $this->getMonth($monthNum) . ' Y', strtotime($articleDate))
                . '</li>

    </ul>

    </div>

  </li>';
    }

    function getAuthor($name, $uid, $count) {
        return '
    <li class="author"> <a class="thumb" href="author.html" title="Heather Dale"> <img src="images/authors/' . $uid . '.jpg" alt="img">
    <span class="number animated_element" data-value="' . $count . '"></span></a>
    <div class="details">
    <h5><a href="author.html" title="Heather Dale">'
                . $name
                . '</a></h5>

    <h6>Автор статей</h6>

    </div>

  </li>';
    }

    function getCountedArticle($groupId, $articleName, $groupName, $num) {
        return '

  <li class="post">
    <div class="post_content"> <span class="number animated_element" data-value="' . rand($num * 1000 + 1000, $num * 1000 + 1900) . '"></span>
    <h5><a href="post.php" title="">'
                . $articleName
                . '</a></h5>

    <ul class="post_details simple">

      <li class="category"><a href="index.php?group=' . $groupId . '" title="">'
                . $groupName
                . '</a></li>

    </ul>

    </div>

  </li>';
    }

    function getSlide($articleId, $groupId, $articleName, $header, $groupName, $uid, $defImage, $articleDate) {
        $monthNum = date('m', strtotime($articleDate));
        return '  

  <li class="slide"> <img src="images/articles/' . $uid . '/' . $defImage . '" alt="img">
    <div class="slider_content_box">
    <ul class="post_details simple">

      <li class="category"><a href="index.php?group=' . $groupId . '" title="'
                . $groupName
                . '">'
                . $groupName
                . '</a></li>

      <li class="date">'
                . date('j ' . $this->getMonth($monthNum) . ' Y', strtotime($articleDate))
                . '</li>

    </ul>

    <h2><a href="post.php?postId=' . $articleId . '" title="'
                . $articleName
                . '">'
                . $articleName
                . '</a></h2>

    <p class="clearfix">'
                . $header
                . '</p>

    </div>

  </li>';
    }

    function getMainArticle($groupId, $articleName, $header, $groupName, $uid, $defImage, $articleDate) {
        $monthNum = date('m', strtotime($articleDate));
        return '
      <li class="post mainPost"> 
        <a href="post.php" title="Nuclear Fusion Closer to Becoming a Reality"> 
          <img src="images/articles/' . $uid . '/' . $defImage . '" alt="img"> 
        </a>
        <h2 class="with_number"> 
          <a href="post.php" title="Nuclear Fusion Closer to Becoming a Reality">'
                . $articleName
                . '</a>'
                /*  УДАЛИЛ СЧЕТЧИК КОММЕНТОВ (upd)
                  . '<a class="comments_number" href="post.php#comments_list" title="2 comments">2<span class="arrow_comments"></span></a>' */
                . '</h2>
        <ul class="post_details">
          <li class="category">
            <a href="index.php?group=' . $groupId . '" title="WORLD">'
                . $groupName
                . '</a>
          </li>
          <li class="date">'
                . date('j ' . $this->getMonth($monthNum) . ' Y', strtotime($articleDate))
                . '</li>
        </ul>
        <p>'
                . $header
                . '</p>
        <a class="read_more" href="post.php" title="Read more"><span class="arrow"></span><span>Подробнее</span></a> 
      </li>';
    }

    function getSmallArticle($groupId, $articleName, $groupName, $uid, $defImage, $articleDate) {
        $monthNum = date('m', strtotime($articleDate));
        return '
  <li class="post"> 
    <a href="post.php" title="Study Linking Illnes and Salt Leaves Researchers Doubtful">
      <img src="images/articles/' . $uid . '/' . $defImage . '" alt="img">
    </a>
    <div class="post_content">
      <h5><a href="post.php" title="Study Linking Illnes and Salt Leaves Researchers Doubtful">' . $articleName . '</a></h5>
      <ul class="post_details simple">
        <li class="category"><a href="index.php?group=' . $groupId . '" title="HEALTH">' . $groupName . '</a></li>
        <li class="date">'
                . date('j ' . $this->getMonth($monthNum) . ' Y', strtotime($articleDate))
                . '</li>
      </ul>
    </div>
  </li>';
    }

    function getMonth($monthNumber) {
        $monthList = array('', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
        return $monthList[intval($monthNumber)];
    }

    function getPostSlide($groupId, $articleName, $groupName, $uid, $defImage, $articleDate) {
        $monthNum = date('m', strtotime($articleDate));

        return '<li class="post"><a href="post_small_image.html" title="Built on Brotherhood, Club Lives Up to Name"><img src="images/articles/' . $uid . '/' . $defImage . '" alt="img">
										</a>
										<h5><a href="post_small_image.html" title="'
                . $articleName
                . '">'
                . $articleName
                . '</a></h5>
										<ul class="post_details simple">
											<li class="category"><a href="index.php?group=' . $groupId . '" title="HEALTH">'
                . $groupName
                . '</a></li>
											<li class="date">'
                . date('j ' . $this->getMonth($monthNum) . ' Y', strtotime($articleDate))
                . '</li>
										</ul>
									</li>';
    }

}

?>