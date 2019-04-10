<?php error_reporting( - 1 );

include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config_db.php' );
include( $_SERVER['DOCUMENT_ROOT'] . '/meta_config.php' );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Продавшие ключевые слова на Шаттерстоке</title>
    <meta name="Description"
          content=""/>
    <meta name="Keywords"
          content=""/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link href="/css/meta.css"
          rel="stylesheet"
          type="text/css">
    <link href="/css/meta_sell_kws.css"
          rel="stylesheet"
          type="text/css">
    <link rel="shortcut icon"
          href="http://<?php echo $site_domain_name ?>/favicon.ico"
          type="image/ven.microsoft.ico">

    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/yandex_metric_meta.php' ); ?>

</head>
<body>
<div class="page">
    <div id="up-button-block"
         class="up-block">
        <div class="up-center-block content-right">
            <a class="link-button up-button"
               href="#top"
               title="Наверх">[Наверх]</a>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <h1 class="bold">Продавшие ключевые слова на Шаттерстоке</h1>
    <br>
    <br>
    <br>
    <br>
    <a name="top"></a>
    <div id="variants-queries-list">Без вариантов.</div>
    <br>
    <br>
    <div class="content-left">
        <span title="Число уровней повторяемости вариантов запросов">Уровней <select size="1" id="level">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option selected value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select></span>
        <label>(<input type="checkbox"
                       name="only-all"
                       value=""
                       checked> только со всеми)</label>
    </div>
    <div class="content-right">
        <a id="create-variants-queries-button"
           class="link-button"
           href="#"
           title="Создатть варианты запросов">[Создать варианты]</a>
        <a id="delete-variants-queries-button"
           class="link-button"
           href="#"
           title="Удалить варианты запросов">[x]</a>
    </div>
    <br>
    <br>
    <input type="text"
           id="autor"
           class="textarea-autor"
           maxlength="26">
    <span class="hover-invert">andreikorzhyts</span>
    <span class="hover-invert">vaselenka</span>
    <a id="delete-autor-button"
       class="link-button"
       href="#"
       title="Удалить автора">[x]</a>
    <br>
    <br>
    <textarea id="keyword"
              class="textarea-keywords"
              wrap="soft"
              rows="8"
              placeholder=""
              autofocus></textarea>
    <br>
    <br>
    <div class="content-right">
        <a id="clear-keyword-button"
           class="link-button"
           href="#"
           title="Очистить поле запроса">[x]</a>
    </div>
    <br>
    <label><input type="checkbox"
                  name="use-variant-queries"
                  value=""> На основе вариантов</label>
    <br>
    <br>
    <label><input type="radio"
                  name="image_type"
                  value="all"> Все</label>
    <label><input type="radio"
                  name="image_type"
                  value="photo"
                  checked> Фото</label>
    <label><input type="radio"
                  name="image_type"
                  value="vector"> Вектор</label>
    <label><input type="radio"
                  name="image_type"
                  value="illustration"> Иллюстрации</label>
    <br>
    <br>
    <input id="get-selling-keywords-button"
           name="get-selling-keywords-button"
           type="submit"
           value="Получить продавшие ключевые слова">
    <br>
    <br>
    <span id="status"></span>
    <br>
    <br>
    <div class="content-right">
        <span id="count-keywords"
              class="counter">0</span>
        <a id="delete-keywords-objects-array-button"
           class="link-button"
           href="#"
           title="Удалить текущую строку результата">[x]</a>
    </div>
    <br>
    <br>
    <div id="selling-keywords-string">Строка результата пуста.</div>
    <br>
    <br>
    <br>
    <br>
    <div id="works-list">Список произведений пуст.</div>

    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>

</div>
<script src="/libs/lodash.js"></script>
<script src="/selling_keywords/selling_keywords.js"></script>
</body>
</html>
