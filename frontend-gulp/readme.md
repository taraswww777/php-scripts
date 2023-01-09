#Frontend сборщик / frontend-gulp

ver: https://bitbucket.org/teamTaraswww777/frontend-gulp/commits/9f5a445b642e7936b5d50c24ec6c2d870b8e497d


Данный сборщик предназначен для сборки blade шаблонов , sass|scss стилей и js скриптов 

~ - корень сборщика (папка frontend-gulp)

##Требования
 - PHP >= 7.2
 - Composer
 - Yarn/NPM
 

##Установка

- загрузить сборщик к себе в проект любым подходящим для вас способом (желательно в папку не доступную по http)
- перейти в папку frontend-gulp ``` cd ./frontend-gulp ```
- выполнить команды ``` yarn install && composer install ``` или ``` npm install && composer install ```
- подключить в проекте файл ``` ~/vendor/autoload.php ``` см пример ``` demo.www/index.php ```

##Структура TODO:Структура

##Стили TODO:Стили

##Скрипты TODO:Скрипты

| command | params | description |
|---|---|---|
|`gulp create --b=demo-block -d=common`| b - название блока; d - (необязательный) путь для сохранения блока относительно `src/block`| Создаст новый компонент|

##Шаблонизатор (Blade)
Сборщик за основу использует шаблонизатор Blade поэтому изначально рекомендуется ознакомиться со следующей документацией 
- [Blade github] - Репозиторий
- [Blade laravel] - Документация

Для рендеринга шаблона используется команда ``` FrontendGulp::getInst()->render() ```
первым параметром передаётся путь (без слеша в начале) к шаблону относительно ~/src/block
вторым параметром передаётся ассоциативный массив параметров к переданным параметрам в шаблоне можно получить используя $ключ
```php
<?php use FrontendGulp\Api\FrontendGulp; ?>
<?php $bHeader = FrontendGulp::getInst()->render('common/b-header', ['logo' => 'val-logo', 'name' => 'Any name', 'text' => 'val-text']) ?>
<?php $bFooter = FrontendGulp::getInst()->render('common/b-footer', ['logo' => 'val-logo', 'name' => 'Any name', 'text' => 'val-text']) ?>
<?=FrontendGulp::getInst()->render('common/b-page', ['header' => $bHeader, 'footer' => $bFooter])?>
```

Как видно в примере описанном выше, рендеринг производится заранее и результат уже передаётся в виде уже готовой строки через параметры.
Это сделано в первую очередь для того чтобы облегчить отслеживание используемых шаблонов и увеличить скорость работы кешированого кода шаблонов.

###Шаблонизатор (Blade) - BEM
При использовании сборщика рекомендуется (нужно) использовать паттерн [BEM].

Для этого в шаблонах используются следующие директивы (КАВЫЧКИ ОБЯЗАТЕЛЬНЫ):

- ``` @block('block-name') ``` - инициализация блока
- ``` @blockName(['mod-name'[,'mod-value']]) ``` - вывод названия блока ``` block-name[--modifier-name[_modifier-value] ``` (параметры не обязательны)
- ``` @blockElem('element-name',['mod-name'[,'mod-val']]) ```  - вывод названия элемента блока ``` block-name__element-name[--modifier-name[_modifier-value] ``` (параметры не обязательны, кроме первого)

Ниже приведён пример кода в шаблоне
```blade
@block('news-list')
@if(isset($newsList))
	<div class="@blockName()">
		@foreach($newsList as $newsItem)
			<div class="@blockElem('item', 'id',$newsItem['id'])">
				<div class="@blockElem('item-name')">{{$newsItem['name']}}</div>
				<img class="@blockElem('item-img')" src="{{$newsItem['preview_img']['src']}}" alt="{{$newsItem['preview_img']['alt']}}" title="{{$newsItem['preview_img']['title']}}">
				<div class="@blockElem('item-text')">{{$newsItem['preview_text']}}</div>
			</div>
		@endforeach
	</div>
@endif
```

###Шаблонизатор (Blade) - Директивы
Для сохранения динамичности кода используются следущие директивы:

- ``` @dump($variable) ``` или ``` @xp($variable) ``` - красивый print_r 
- ``` @img(путь до нужного файла) ``` - вернёт полный http путь до указаного файла относительно ~/dist/img
- ``` @assets(путь до нужного файла) ``` - вернёт полный http путь до указаного файла относительно ~/dist/assets



[BEM]: <https://habr.com/post/203440/>
[Blade github]: <https://github.com/jenssegers/blade>
[Blade laravel]: <https://laravel.com/docs/5.1/blade>
